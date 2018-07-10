<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\systemSettingLegendTable;
use Carbon\Carbon;

class systemSettingLegendTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {

        $systemSetting = systemSettingLegendTable::where('delete_status', 0)
            ->orderBy('system_setting_legend_table.page_type', 'ASC')
            ->get();
        return view("backend.cms.systemSetting.legend-table", compact("systemSetting"));
    }

    public function store(Request $request)
    {
        $systemSetting = systemSettingLegendTable::where('delete_status', 0)
            ->get();

        $this->validate($request, [
            'page_type' => 'required',
            'title' => 'required'
        ]);
        
        $oldSystemSetting = new systemSettingLegendTable;
        $oldSystemSetting->page_type = $request->page_type;
        $oldSystemSetting->title = $request->title;
        $oldSystemSetting->icon = $request->icon;
        $oldSystemSetting->created_at = Carbon::now()->toDateTimeString();
        $oldSystemSetting->save();

        return redirect()->back()->with('success', "System setting" . ADDED_ALERT);
    }

    public function edit(Request $request, $id)
    {
        $systemSetting = systemSettingLegendTable::where('delete_status', 0)
            ->find($id);
            //dd($systemSetting);
        return view("backend.cms.systemSetting.legend-table-edit", compact("systemSetting"));
    }

    public function update(Request $request, $id)
    {
        $oldSystemSetting = systemSettingLegendTable::where('delete_status', 0)
            ->find($id);

        $this->validate($request, [
            'page_type' => 'required',
            'title' => 'required'
        ]);
        
        $oldSystemSetting->page_type = $request->page_type;
        $oldSystemSetting->title = $request->title;
        $oldSystemSetting->icon = $request->icon;
        $oldSystemSetting->updated_at = Carbon::now()->toDateTimeString();

        $oldSystemSetting->save();

        return redirect('admin/system-setting-legend-table')->with('success', "Legend Table Setting" . UPDATED_ALERT);
    }
}
