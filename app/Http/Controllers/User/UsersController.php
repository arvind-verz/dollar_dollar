<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\InvestmentEnquiry;
use App\LoanEnquiry;
use App\User;
use App\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\ProductManagement;
use App\AdsManagement;
use App\ContactEnquiry;
use App\systemSettingLegendTable;
use App\HealthInsuranceEnquiry;
use App\LifeInsuranceEnquiry;
use App\PromotionProducts;
use App\Brand;
use Illuminate\Support\Facades\DB;
use App\Mail\UpdateDetailNotify;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Tag;
use App\UserLog;
use App\SystemSetting;
use Illuminate\Support\Facades\Hash;
use App\CustomerUpdateDetail;

class UsersController extends Controller
{
    private $systemSetting;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            $systemSetting = new SystemSetting();
            $systemSetting->email_sender_name = env('MAIL_FROM_NAME');
            $systemSetting->admin_email = env('ADMIN_EMAIL');
            $systemSetting->auto_email = env('MAIL_FROM_ADDRESS');
        }
        $this->systemSetting = $systemSetting;
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
        $data = [];
        $oldData = [];
        $newData = [];
        $updated = false;
        $systemSetting = $this->systemSetting;
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

            if (!Hash::check($request->password, $user->password)) {
                $data['password'] = $request->password;
            }
            $user->password = bcrypt($request->password);
        }
        if (User::where('email', $request->email)->where('delete_status', 0)
            ->whereNotIn('id', [$id])
            ->exists()
        ) {
            $fields = array_add($fields, 'email', "required|email|max:255|unique:users");
        } else {
            $fields = array_add($fields, 'email', "required|email|max:255");
        }
        $this->validate($request, $fields);

        $data['old_first_name'] = $oldUser->first_name;
        $data['old_last_name'] = $oldUser->last_name;
        if ($oldUser->salutation != $request->salutation) {
            $newData['salutation'] = $data['salutation'] = $request->salutation;
            $oldData['salutation'] = $oldUser->salutation;
            $updated = true;
        }
        if ($oldUser->first_name != $request->first_name) {
            $newData['first_name'] = $data['first_name'] = $request->first_name;
            $oldData['first_name'] = $oldUser->first_name;
            $updated = true;
        }
        if ($oldUser->last_name != $request->last_name) {
            $newData['last_name'] = $data['last_name'] = $request->last_name;
            $oldData['last_name'] = $oldUser->last_name;
            $updated = true;
        }
        if ($oldUser->email != $request->email) {
            $newData['email'] = $data['email'] = $request->email;
            $oldData['email'] = $oldUser->email;
            $updated = true;
        }
        if ($oldUser->tel_phone != $request->tel_phone) {
            $newData['tel_phone'] = $data['tel_phone'] = $request->tel_phone;
            $oldData['tel_phone'] = $oldUser->tel_phone;
            $updated = true;
        }
        if ($oldUser->status != $request->status) {
            $newData['status'] = $data['status'] = $request->status;
            $oldData['status'] = $oldUser->status;
            $updated = true;
        }
        if (is_null($request->email_notification)) {
            $request->email_notification = 0;
        }
        if (is_null($request->adviser)) {
            $request->adviser = 0;
        }
        if ($oldUser->email_notification != $request->email_notification) {
            $newData['email_notification'] = $data['email_notification'] = $request->email_notification;
            $oldData['email_notification'] = $oldUser->email_notification;
            $updated = true;
        }
        if ($oldUser->adviser != $request->adviser) {
            $newData['adviser'] = $data['adviser'] = $request->adviser;
            $oldData['adviser'] = $oldUser->adviser;
            $updated = true;
        }

        if ($updated) {
            $status = $user->status;
            // update Post
            $user->salutation = $request->input('salutation');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->tel_phone = $request->input('tel_phone');
            $user->status = $request->input('status');
            $user->email_notification = isset($request->email_notification) ? $request->email_notification : 0;
            $user->adviser = isset($request->adviser) ? $request->adviser : 0;
            $user->updated_at_admin = Carbon::now()->toDateTimeString();
            $user->updated_by = ADMIN_USER;
            $user->save();

            $customerDetailUpdate = new CustomerUpdateDetail();
            $customerDetailUpdate->user_id = $id;
            $customerDetailUpdate->first_name = $user->first_name;
            $customerDetailUpdate->last_name = $user->last_name;
            $customerDetailUpdate->old_detail = json_encode($oldData);
            $customerDetailUpdate->updated_detail = json_encode($newData);
            $customerDetailUpdate->updated_by = ADMIN_USER;
            $customerDetailUpdate->save();

            if ($request->status == 0 && $status != 0) {
                $userLog = New UserLog();
                $userLog->user_id = $id;
                $userLog->status = DEACTIVATED;
                $userLog->updated_by_id = Auth::user()->id;
                $userLog->updated_by = ADMIN_USER;
                $userLog->updated_on = Carbon::now()->toDateTimeString();
                $userLog->save();
            }


            $newUser = User::find($id);
            if ($newUser) {

                $data['updated_at_admin'] = $newUser->updated_at_admin;
                $data['profile_url'] = url('/') . '/account-information';
                $data['sender_email'] = $systemSetting->auto_email;
                $data['sender_name'] = $systemSetting->email_sender_name;
                $data['updated_by'] = ADMIN_USER;

                try {
                    Mail::to($newUser->email)->send(new UpdateDetailNotify($data));
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }
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
        }
        return redirect(route('users.index'))->with('success', $user->email . ' ' . UPDATED_ALERT);
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


            $userLog = New UserLog();
            $userLog->user_id = $id;
            $userLog->first_name = $user->first_name;
            $userLog->last_name = $user->last_name;
            $userLog->country_code = $user->country_code;
            $userLog->tel_phone = $user->tel_phone;
            $userLog->email = $user->email;
            $userLog->status = DELETED;
            $userLog->updated_by_id = Auth::user()->id;
            $userLog->updated_by = ADMIN_USER;
            $userLog->updated_on = Carbon::now()->toDateTimeString();
            $userLog->save();
            User::destroy($id);
            DB::table('product_managements')->where('user_id', '=', $id)->delete();
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

    public function productView($id)
    {
        DB::enableQueryLog();
        $product_reports = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->join('users', 'product_managements.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->get();
        //dd(DB::getQueryLog());
        return view('backend.reports.product-report.index', [
            'product_reports' => $product_reports
        ]);
    }

    public function bulkRemove(Request $request)
    {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, CUSTOMER_MODULE_ID);
        $ids = isset($request->id) ? $request->id : [];
        $type = isset($request->type) ? $request->type : '';
        $select_type = isset($request->select_type) ? $request->select_type : '';
        //return $ids;
        if (count($ids)) {
            if ($type == 'bulk_customer_update_detail_clear_remove') {
                CustomerUpdateDetail::destroy($ids);
            } else {
                foreach ($ids as $id) {
                    if ($type == 'bulk_customer_remove') {
                        $users = User::find($id);
                        $users->updated_at_admin = Carbon::now()->toDateTimeString();
                        $users->updated_by = "Admin";
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_user_remove') {
                        $users = Admin::find($id);
                        $users->updated_at = Carbon::now()->toDateTimeString();
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_user_status_update') {
                        $users = User::find($id);
                        if ($select_type == 'active') {
                            $users->status = 1;
                        } else {
                            $users->status = 0;
                        }
                        $users->updated_at_admin = Carbon::now()->toDateTimeString();
                        $users->updated_by = "Admin";

                    } elseif ($type == 'bulk_product_remove') {
                        $users = PromotionProducts::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_product_status_update') {
                        $users = PromotionProducts::find($id);
                        if ($select_type == 'active') {
                            $users->status = 1;
                        } else {
                            $users->status = 0;
                        }
                    } elseif ($type == 'bulk_brand_remove') {
                        $users = Brand::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_brand_status_update') {
                        $users = Brand::find($id);
                        if ($select_type == 'active') {
                            $users->display = 1;
                        } else {
                            $users->display = 0;
                        }
                    } elseif ($type == 'bulk_ads_remove') {
                        $users = AdsManagement::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_ads_status_update') {
                        $users = AdsManagement::find($id);
                        if ($select_type == 'active') {
                            $users->display = 1;
                        } else {
                            $users->display = 0;
                        }
                    } elseif ($type == 'bulk_enquiry_remove') {
                        $users = ContactEnquiry::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_loan_enquiry_remove') {
                        $users = LoanEnquiry::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_health_insurance_remove') {
                        $users = HealthInsuranceEnquiry::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_life_insurance_remove') {
                        $users = LifeInsuranceEnquiry::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_investment_remove') {
                        $users = InvestmentEnquiry::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_tag_remove') {
                        $users = Tag::find($id);
                        $users->delete_status = 1;
                    } elseif ($type == 'bulk_tag_status_update') {
                        $users = Tag::find($id);
                        if ($select_type == 'active') {
                            $users->status = 1;
                        } else {
                            $users->status = 0;
                        }
                    } elseif ($type == 'bulk_user_clear_remove') {
                        $users = UserLog::find($id);
                        $users->delete_status = 1;

                    } elseif ($type == 'bulk_legend_remove') {
                        $users = systemSettingLegendTable::find($id);
                        $users->delete_status = 1;

                    }
                    //return $users;

                    $users->save();
                }
            }

            echo "success";
        }
    }

}
