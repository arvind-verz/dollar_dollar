<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function create_permission($role_type_id, $module_id)
    {
        $CheckCreatePermission = \DB::table('role_type_access')->where(['role_type_id' => $role_type_id, 'module_id' => $module_id])->select('create')->get();
        if (!empty($CheckCreatePermission[0])) {
            if ($CheckCreatePermission[0]->create == 1) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    protected function edit_permission($role_type_id, $module_id)
    {
        $CheckEditPermission = \DB::table('role_type_access')->where(['role_type_id' => $role_type_id, 'module_id' => $module_id])->select('edit')->get();
        if (!empty($CheckEditPermission[0])) {
            if ($CheckEditPermission[0]->edit == 1) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    protected function delete_permission($role_type_id, $module_id)
    {
        $CheckDeletePermission = \DB::table('role_type_access')->where(['role_type_id' => $role_type_id, 'module_id' => $module_id])->select('delete')->get();
        if (!empty($CheckDeletePermission[0])) {
            if ($CheckDeletePermission[0]->delete == 1) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    protected function import_permission($role_type_id, $module_id)
    {
        $CheckDeletePermission = \DB::table('role_type_access')->where(['role_type_id' => $role_type_id, 'module_id' => $module_id])->select('import')->get();
        if (!empty($CheckDeletePermission[0])) {
            if ($CheckDeletePermission[0]->import == 1) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    protected function export_permission($role_type_id, $module_id)
    {
        $CheckDeletePermission = \DB::table('role_type_access')->where(['role_type_id' => $role_type_id, 'module_id' => $module_id])->select('export')->get();
        if (!empty($CheckDeletePermission[0])) {
            if ($CheckDeletePermission[0]->export == 1) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    protected function view_permission($role_type_id, $module_id)
    {
        $CheckViewPermission = \DB::table('role_type_access')->where(['role_type_id' => $role_type_id, 'module_id' => $module_id])->select('view')->get();

        if (!empty($CheckViewPermission[0])) {
            if ($CheckViewPermission[0]->view == 1) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    protected function view_all_permission($role_type_id, $module_id)
    {
        $CheckLayoutPermission = \DB::table('role_type_access')
            ->join('modules', 'role_type_access.module_id', '=', 'modules.id')
            ->where(['role_type_access.role_type_id' => $role_type_id, 'role_type_access.view' => 1, 'role_type_access.module_id' => $module_id])
            ->select('role_type_access.module_id', 'role_type_access.view', 'role_type_access.create', 'role_type_access.edit', 'role_type_access.delete', 'role_type_access.import', 'role_type_access.export', 'modules.name', 'modules.label')->get();

        return $CheckLayoutPermission;

        // print_R($$CheckViewMenuPermission);
        // echo count($CheckViewMenuPermission);
        /*        if(!empty($CheckViewPermission[0]))
                {
                    if($CheckViewPermission[0]->view==1)
                    {
                        return 1;
                    }
                    return 0;
                }
                return 0;*/
    }
}
