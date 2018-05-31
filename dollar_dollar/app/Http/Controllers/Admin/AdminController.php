<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Module;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Validator;


class AdminController extends Controller
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, USER_MODULE_ID);


        $RoleNames = \DB::table('role_type_access')
            ->join('role_type', 'role_type_access.role_type_id', '=', 'role_type.id')
            ->select('role_type.name', 'role_type.id')
            ->distinct()
            ->get(['role_type_id']);

        $RoleModules = \DB::table('role_type_access')
            ->join('modules', 'role_type_access.module_id', '=', 'modules.id')->orderby('role_type_access.id')
            ->select('role_type_access.id as id1', 'modules.label as module_labels', 'role_type_access.role_type_id as role_type_id', 'role_type_access.view', 'role_type_access.create', 'role_type_access.edit', 'role_type_access.delete', 'role_type_access.import', 'role_type_access.export')
            ->get();


        $role_array = Array();
        /*

                print_R($RoleNames);
                echo "<br>";echo "<br>";
                print_R($RoleModules);
                exit;*/
        foreach ($RoleNames as $key1 => $value1) {

            foreach ($RoleModules as $value) {
                //$role_array[$value1->id][]= $value->module_names;
                if ($value1->id == $value->role_type_id) {
                    $role_array[$value1->name]['modules'][] = $value->module_labels;
                    $role_array[$value1->name]['id'][] = $value1->id;
                    // echo $value->create;
                    if ($value->view == 1) {
                        $role_array[$value1->name]['Access'][] = "View";
                    }
                    if ($value->create == 1) {
                        $role_array[$value1->name]['Access'][] = "Create";
                    }
                    if ($value->edit == 1) {
                        $role_array[$value1->name]['Access'][] = "Edit";
                    }
                    if ($value->delete == 1) {
                        $role_array[$value1->name]['Access'][] = "Delete";
                    }
                    if ($value->import == 1) {
                        $role_array[$value1->name]['Access'][] = "Import";
                    }
                    if ($value->export == 1) {
                        $role_array[$value1->name]['Access'][] = "Export";
                    } else {
                        $role_array[$value1->name]['Access'][] = "";
                    }
                }


            }


            $role_array[$value1->name]['modules'] = array_unique($role_array[$value1->name]['modules']);
            $role_array[$value1->name]['Access'] = array_unique(array_filter($role_array[$value1->name]['Access']));
            $role_array[$value1->name]['id'] = array_unique($role_array[$value1->name]['id']);

            //print_R($role_array[$value1->name]['Access']);
        }

        $admins = Admin::leftJoin('role_type', 'admins.role_type_id', '=', 'role_type.id')
            ->where('delete_status', 0)
            ->select('admins.*', 'role_type.name as role')
            ->orderBy('admins.id', 'DESC')
            ->get();

        return view("backend.admin.index", compact("admins", "role_array", "CheckLayoutPermission"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->edit_permission(@Auth::user()->role_type_id, USER_MODULE_ID) == 0) {
            return redirect()->back()->with('doneMessage', 'You dont have Permission to Create Users ');
        }

        $RoleNames = \DB::table('role_type')
            ->select('id', 'name')
            ->get();

        return view("backend.admin.create", compact("RoleNames"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = [
            'first_name' => 'required',
            'password' => 'required|min:8|confirmed'

        ];

        $account = Admin::where('email', $request->email)->where('delete_status')->first();
        if ($account) {
            $fields['email'] = 'required|email|unique:admins,email';
        } else {
            $fields['email'] = 'required|email';
        }
        $validator = Validator::make($request->all(), $fields);
        if ($request->role_type_id == "null") {

            $validator->getMessageBag()->add('role_type', 'Role type' . ' ' . SELECT_ALERT);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $admin = new Admin();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role_type_id = $request->role_type_id;

        $admin->save();

        activity()
            ->performedOn($admin)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => $admin->email . ' ' . ADDED_ALERT,
                'old' => null,
                'new' => $admin
            ])
            ->log(CREATE);
        return redirect()->action('Admin\AdminController@index')->with('success', $admin->email . ' ' . ADDED_ALERT);

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
        if ($this->edit_permission(@Auth::user()->role_type_id, USER_MODULE_ID) == 0) {
            return redirect()->back()->with('doneMessage', 'You dont have Permission to Edit Users Module');
        }
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);
        }


        $RoleNames = \DB::table('role_type')
            ->select('id', 'name')
            ->get();

        return view("backend.admin.edit", compact("admin", "RoleNames"));
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
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);
        }

        $validatorFields = [
            'first_name' => 'required',

        ];
        if (Admin::where('email', $request->email)->where('delete_status', 0)->exists()) {
            $validatorFields = array_add($validatorFields, 'email', "required|email|max:255|unique:admins");
        } else {
            $validatorFields = array_add($validatorFields, 'email', "required|email|max:255");
        }

        if ($request->password) {
            $validatorFields = array_add($validatorFields, 'password', 'required|min:8|confirmed');
        }

        $validator = Validator::make($request->all(), $validatorFields);
        if ($request->role_type_id == "null") {

            $validator->getMessageBag()->add('role_type', 'Role type' . ' ' . SELECT_ALERT);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }


        $admin = Admin::find($id);
        $oldAdmin = $admin;
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->role_type_id = $request->role_type_id;

        if ($request->has('password')) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        $newAdmin = Admin::find($id);

        activity()
            ->performedOn($admin)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => $newAdmin->email . ' ' . UPDATED_ALERT,
                'old' => $oldAdmin,
                'new' => $newAdmin
            ])
            ->log(UPDATE);
        return redirect()->action('Admin\AdminController@index')->with('success', $newAdmin->email . ' ' . UPDATED_ALERT);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->delete_permission(@Auth::user()->role_type_id, USER_MODULE_ID) == 0) {
            return redirect()->back()->with('doneMessage', 'You dont have Permission to Delete Users ');
        }

        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);
        }

        $admin->delete_status = 1;
        $admin->save();
        activity()
            ->performedOn($admin)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => $admin->email . ' ' . DELETED_ALERT,
                'old' => null,
                'new' => $admin
            ]);
        return redirect()->action('Admin\AdminController@index', $id)->with('success', $admin->email . ' ' . DELETED_ALERT);

    }

    public function permissions_create()
    {


        if ($this->create_permission(@Auth::user()->role_type_id, USER_MODULE_ID) == 0) {
            return redirect()->back()->with('doneMessage', 'You dont have Permission to Create Users Module');
        }

        $Modules = Module::get(array("id", "label"));
        return view("backend.admin.permissions.create", compact("Modules"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function permissions_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'module' => 'required',
        ]);


        $Insert_role_type = \DB::table('role_type')->insertGetId(['name' => $request->name, 'created_by' => Auth::user()->id, 'created_at' => Carbon::now()->toDateTimeString()]);

        foreach ($request->module as $key => $value) {

            $Insert_role_type_access = \DB::table('role_type_access')->insertGetId(['module_id' => $key, 'view' => $request->module[$key]["'view'"][0], 'create' => $request->module[$key]["'create'"][0], 'edit' => $request->module[$key]["'edit'"][0], 'delete' => $request->module[$key]["'delete'"][0], 'import' => $request->module[$key]["'import'"][0], 'export' => $request->module[$key]["'export'"][0], 'role_type_id' => $Insert_role_type, 'created_by' => Auth::user()->id, 'created_at' => Carbon::now()->toDateTimeString()]);

        }
        $newRoleTypeAccess = \DB::table('role_type_access')->where('role_type_id', $Insert_role_type)->get();

        activity()
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => PERMISSION_MODULE,
                'msg' => $request->name . ' ' . ADDED_ALERT,
                'old' => null,
                'new' => $newRoleTypeAccess
            ])
            ->log(CREATE);

        return redirect()->action('Admin\AdminController@index')->with('success', $request->name . ' ' . ADDED_ALERT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissions_edit($id)
    {

        if ($this->edit_permission(@Auth::user()->role_type_id, USER_MODULE_ID) == 0) {
            return redirect()->back()->with('error', 'You dont have Permission to Edit Users Module');
        }

        $Modules = Module::get(array("id", "label"));

        $UserRoleTypeId = @Auth::user()->role_type_id;


        $role_array = \DB::table('role_type_access')
            ->join('role_type', 'role_type.id', '=', 'role_type_access.role_type_id')
            ->join('modules', 'role_type_access.module_id', '=', 'modules.id')
            ->orderby('role_type_access.id')
            ->select('role_type.name as role_name', 'role_type_access.id as id1', 'modules.name as module_names', 'role_type_access.module_id as module_id', 'role_type_access.view', 'role_type_access.create', 'role_type_access.edit', 'role_type_access.delete', 'role_type_access.import', 'role_type_access.export')
            ->where('role_type_access.role_type_id', $id)
            ->get();
        if (!$role_array->count()) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);

        }
        return view("backend.admin.permissions.edit", compact("role_array", "Modules", "id"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissions_update(Request $request, $id)
    {


        $this->validate($request, [
            'name' => 'required',
            'module' => 'required',
        ]);
        $UpdateRoleType = \DB::table('role_type')->where('id', $id)->first();
        if (!$UpdateRoleType) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);

        }
        $oldRoletypeAcess = \DB::table('role_type_access')->where('role_type_id', $id)->get();

        $Update_role_type = \DB::table('role_type')->where('id', $id)->update(['name' => $request->name, 'updated_by' => Auth::user()->id, 'updated_at' => Carbon::now()->toDateTimeString()]);

        $delete_role_type_access = \DB::table('role_type_access')->where('role_type_id', $id)->delete();

        foreach ($request->module as $key => $value) {

            $Insert_role_type_access = \DB::table('role_type_access')->insertGetId(['module_id' => $key, 'view' => $request->module[$key]["'view'"][0], 'create' => $request->module[$key]["'create'"][0], 'edit' => $request->module[$key]["'edit'"][0], 'delete' => $request->module[$key]["'delete'"][0], 'delete' => $request->module[$key]["'delete'"][0], 'import' => $request->module[$key]["'import'"][0], 'export' => $request->module[$key]["'export'"][0], 'role_type_id' => $id, 'created_by' => Auth::user()->id, 'created_at' => Carbon::now()->toDateTimeString()]);

        }
        $newInsertRoleTypeAccess = \DB::table('role_type_access')->where('role_type_id', $id)->get();
        activity()
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => PERMISSION_MODULE,
                'msg' => $request->name . ' ' . UPDATED_ALERT,
                'old' => $oldRoletypeAcess,
                'new' => $newInsertRoleTypeAccess
            ])
            ->log(UPDATE);

        return redirect()->action('Admin\AdminController@index')->with('success', $request->name . ' ' . UPDATED_ALERT);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function permissions_destroy($id)
    {
        if ($this->delete_permission(@Auth::user()->role_type_id, USER_MODULE_ID) == 0) {
            return redirect()->back()->with('doneMessage', 'You dont have Permission to Delete Users Module');
        }
        $roleType = \DB::table('role_type')->where('id', $id)->first();
        $roleTypeAccess = \DB::table('role_type_access')->where('role_type_id', $id)->get();
        if (!$roleType) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);

        }
        $delete_role_type_access = \DB::table('role_type_access')->where('role_type_id', $id)->delete();
        $delete_role_type = \DB::table('role_type')->where('id', $id)->delete();

        activity()
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => PERMISSION_MODULE,
                'msg' => $roleType->name . ' ' . DELETED_ALERT,
                'old' => null,
                'new' => $roleTypeAccess
            ])
            ->log(DELETE);

        return redirect()->action('Admin\AdminController@index')->with('success', $roleType->name . ' ' . DELETED_ALERT);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProfile($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);
        }
        $RoleNames = \DB::table('role_type')
            ->select('id', 'name')
            ->get();

        return view("backend.admin.updateProfile", compact("admin", "RoleNames"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->action('Admin\AdminController@index')->with('error', OPPS_ALERT);
        }
        $validatorFields = [
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . $id,

        ];

        if ($request->password) {
            $validatorFields = array_add($validatorFields, 'password', 'required|min:8|confirmed');
        }

        $this->validate($request, $validatorFields);


        $oldAdmin = $admin;
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        //$admin->email = $request->email;
        //$admin->role_type_id = $request->role_type_id;

        if ($request->has('password')) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        $newAdmin = Admin::find($id);

        activity()
            ->performedOn($admin)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => "Update  profile by  " . $newAdmin->email,
                'old' => $oldAdmin,
                'new' => $newAdmin
            ])
            ->log(UPDATE);

        return redirect(route('update-profile', ['id' => Auth::user()->id]))->with('success', 'Profile has been successfully updated');
    }
}
