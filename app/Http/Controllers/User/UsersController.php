<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Auth;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, CUSTOMER_MODULE_ID);

        //get all users

        $users = User::where('delete_status', 0)
            ->get();
        //dd($products);
        return view("backend.user.index", compact("users", "CheckLayoutPermission"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->action('User\UsersController@index')->with('error', OPPS_ALERT);
        }
        return view("backend.user.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $user = User::find($id);
        if (!$user) {
            return redirect()->action('User\UsersController@index')->with('error', OPPS_ALERT);
        }
        $oldUser = $user;

        $fields = [
            'first_name' => 'required',
        ];
        if (isset($request->password)) {
            $fields = array_add($fields, 'password', 'min:8|confirmed');
            $user->password = bcrypt($request->password);
        }
        if (User::where('email', $request->email)->where('delete_status', 0)->exists()) {
            $fields = array_add($fields, 'email', "required|email|max:255|unique:users");
        } else {
            $fields = array_add($fields, 'email', "required|email|max:255");
        }
        $this->validate($request, $fields);

        // update Post
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->tel_phone = $request->input('tel_phone');
        $user->status = $request->input('status');
        $user->updated_at_admin = Carbon::now()->toDateTimeString();
        $user->save();

        $newUser = User::find($id);
        activity()
            ->performedOn($newUser)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => $newUser->email . ' ' . UPDATED_ALERT,
                'old' => $oldUser,
                'new' => $newUser
            ])
            ->log(UPDATE);
        return redirect(route('users.index'))->with('success', $newUser->email . ' ' . UPDATED_ALERT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->action('User\UsersController@index')->with('error', OPPS_ALERT);
        }

        if ($user) {

            User::where('id', $id)
                ->update(['delete_status' => 1]);

            //store log of activity
            activity()
                ->performedOn($user)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => USER_MODULE,
                    'msg' => $user->email . ' ' . DELETED_ALERT,
                    'old' => $user,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('users.index'))->with('success', $user->email . ' ' . DELETED_ALERT);
        } else {
            return redirect(route('users.index'));
        }
    }

    public function usersImport()
    {
        return view("backend.user.import");
    }

    public function usersImportIntoDB(Request $request)
    {
        $this->validate($request, [
            'csv_file' => 'required|mimes:csv,txt',
        ]);
        if ($request->hasFile('csv_file')) {
            $error_msg = [];
            $path = $request->file('csv_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if ($data->count()) {
                $lineNo = 1;

                //get all priceLists
                $priceLists = Pricelist::all();

                foreach ($data as $key => $value) {
                    $error = false;

                    $error_fields = $this->checkValidation($value);
                    if (count($error_fields)) {
                        $error_msg[] = "Line No " . $lineNo . " " . implode(", ", $error_fields) . "  column please check";
                        $error = true;
                    }
                    //dd($error_fields);
                    if (!$error) {
                        $priceListId = '';
                        if ($priceLists->count() && (!empty($value->price_list))) {
                            $priceList = $priceLists->where('label', $value->price_list)->first();
                            $priceListId = $priceList->id;
                        }
                        $contact_id = $this->split_name($value->contact_id);
                        $created_at = null;
                        $updated_at = null;
                        if ($value->created_at != null) {

                            $created_at = date("Y-m-d h:i:s", strtotime($value->created_at));
                        }
                        if ($value->updated_at != null) {
                            $updated_at = date("Y-m-d h:i:s", strtotime($value->updated_at));
                        }


                        $userDetail = [
                            'first_name' => $contact_id['first_name'],
                            'last_name' => $contact_id['last_name'],
                            'email' => $value->email,
                            'price_list' => $priceListId,
                            'customer_code' => $value->customer_code,
                            'shipping_address' => $value->ship_to_address_id,
                            'billing_address' => $value->bill_to_address_id,
                            'tel_phone' => $value->tel_1,
                            'company' => $value->name,
                            'web_login' => $value->web_login,
                            'subscribe' => 1,
                            'delete_status' => 0,
                            'created_at' => $created_at,
                            'updated_at' => $updated_at,
                            'updated_at_admin' => Carbon::now()->toDateTimeString()
                        ];
                        $user = User::where('email', $value->email)->first();
                        if ($user) {

                            $update = User::where('email', $value->email)
                                ->update($userDetail);
                        } else {
                            $userDetail = array_add($userDetail, 'password', bcrypt($value->email));
                            $insert = User::where('email', $value->email)
                                ->insert($userDetail);
                        }
                    }
                    $lineNo++;
                }
                //dd($arr);

                // activity log store

                activity()
                    ->withProperties([
                        'ip' => \Request::ip(),
                        'module' => USER_MODULE,
                        'msg' => 'Users' . IMPORTED_ALERT,
                        'old' => null,
                        'new' => null
                    ])
                    ->log(IMPORT);

                if (count($error_msg)) {
                    return redirect(route('users.index'))->with('success', 'Users' . IMPORTED_ALERT)
                        ->with('error', implode(" <br/> ", $error_msg));
                } else {
                    return redirect(route('users.index'))->with('success', 'Users' . IMPORTED_ALERT);

                }
            }
        }
    }

    /**
     * Check validation for user
     * @param $product
     * @return array
     */
    public function checkValidation($user)
    {
        $priceLists = Pricelist::all();
        $priceListsLabel = [];
        if ($priceLists->count()) {
            $priceListsLabel = $priceLists->pluck('label')->all();
        }
        $error_fields = [];
        if (empty($user->customer_code)) {
            $error_fields[] = "Customer Code";
        }
        if (empty($user->contact_id)) {
            $error_fields[] = "Contact id";
        }
        if (empty($user->email) || (!filter_var($user->email, FILTER_VALIDATE_EMAIL))) {
            $error_fields[] = "Email";
        }
        if (!in_array($user->price_list, $priceListsLabel) && (!empty($user->price_list))) {
            $error_fields[] = "Price list";
        }

        /*
        if (empty($user->ship_to_address_id)) {
            $error_fields[] = "ship_to_address_id";
        }
        if (empty($user->bill_to_address_id)) {
            $error_fields[] = "bill_to_address_id";
        }
        if (empty($user->tel_1)) {
            $error_fields[] = "tel-1";
        }
        if (empty($user->name)) {
            $error_fields[] = "name";
        }*/


        return $error_fields;
    }

    // uses regex that accepts any word character or hyphen in last name
    public function split_name($contactId)
    {
        $name = trim($contactId);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array('first_name' => $first_name, 'last_name' => $last_name);
    }

    /**
     * Download user in CSV format
     * @param $type
     * @return mixed
     */
    public function userExport(Request $request, $type)
    {
        $user = User::find($request->id);
        if (!$user) {
            return redirect()->action('User\UsersController@index')->with('error', OPPS_ALERT);
        }

        activity()
            ->performedOn($user)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => $user->email . ' ' . EXPORT_ALERT,
                'old' => $user,
                'new' => null
            ])
            ->log(EXPORT);

        return \Excel::create('User', function ($excel) use ($user) {

            $export_user_details = [];
            $export_user_detail = [];
            $export_user_detail['First_Name'] = $user->first_name;
            $export_user_detail['Last_Name'] = $user->last_name;
            $export_user_detail['Email'] = $user->email;
            $export_user_detail['Tel_Phone'] = $user['tel_phone'];
            $export_user_detail['Company'] = $user['company'];
            $export_user_details[] = $export_user_detail;
            //dd($export_user_details);

            $excel->sheet('sheet name', function ($sheet) use ($export_user_details) {
                $sheet->fromArray($export_user_details);
            });
        })->download($type);
    }

    //all user data export to csv
    public function usersExport(Request $request, $type)
    {
        $users = User::leftJoin('price_lists', 'users.price_list', '=', 'price_lists.id')
            ->select('users.*', 'price_lists.label')
            ->get()
            ->toArray();
        if (!count($users)) {
            return redirect()->action('User\UsersController@index')->with('error', OPPS_ALERT);
        }
        activity()
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => "Users detail" . ' ' . EXPORT_ALERT,
            ])
            ->log(EXPORT);

        return \Excel::create('users', function ($excel) use ($users) {

            //dd($products);
            $export_user_details = [];
            foreach ($users as $user) {


                $export_user_detail = [];
                $export_user_detail['Customer_Code'] = $user['customer_code'];
                $export_user_detail['Contact_ID'] = $user['first_name'] . ' ' . $user['last_name'];
                $export_user_detail['Email'] = $user['email'];
                $export_user_detail['Price_List'] = $user['label'];
                $export_user_detail['Ship_To_Address_ID'] = $user['shipping_address'];
                $export_user_detail['Bill_To_Address_ID'] = $user['billing_address'];
                $export_user_detail['Tel_1'] = $user['tel_phone'];
                $export_user_detail['Name'] = $user['company'];
                $export_user_detail['Web_Login'] = $user['web_login'];
                $export_user_detail['Created_At'] = date(" Y-m-d H:i:s ", strtotime($user['created_at']));
                $export_user_detail['Updated_At'] = date(" Y-m-d H:i:s ", strtotime($user['updated_at']));

                $export_user_details[] = $export_user_detail;
            }
            //dd($export_user_details);

            $excel->sheet('sheet name', function ($sheet) use ($export_user_details) {
                $sheet->fromArray($export_user_details);
            });
        })->download($type);
    }

}
