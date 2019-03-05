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
        //dd($request->all());
        $systemSetting = systemSettingLegendTable::where('delete_status', 0)
            ->get();

        $this->validate($request, [
            'page_type' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'icon_background' => 'required',
        ]);
        
        $legend = new systemSettingLegendTable;
        $legend->page_type = $request->page_type;
        $legend->title = $request->title;
        $legend->icon = $request->icon;
        $legend->icon_background = $request->icon_background;
        $legend->status = $request->status;
        $legend->created_at = Carbon::now()->toDateTimeString();
        $legend->save();
        //store activity log
        activity()
            ->performedOn($legend)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => SYSTEM_SETTING_LEGEND_MODULE,
                'msg' => strip_tags($legend->title) . ' ' . ADDED_ALERT,
                'old' => $legend,
                'new' => null
            ])
            ->log(CREATE);
        return redirect()->back()->with('success', strip_tags($legend->title) . ' ' . ADDED_ALERT);
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
        $legend = systemSettingLegendTable::where('delete_status', 0)
            ->where('id',$id)->first();
        $oldLegend = $legend;
        $this->validate($request, [
            'page_type' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'icon_background' => 'required',
        ]);

        
        
        $legend->page_type = $request->page_type;
        $legend->title = $request->title;
        $legend->icon = $request->icon;
        $legend->icon_background = $request->icon_background;
        $legend->status = $request->status;
        $legend->updated_at = Carbon::now()->toDateTimeString();

        $legend->save();

        activity()
            ->performedOn($legend)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => SYSTEM_SETTING_LEGEND_MODULE,
                'msg' => strip_tags($legend->title) . ' ' . UPDATED_ALERT,
                'old' => $oldLegend,
                'new' => $legend
            ])
            ->log(UPDATE);
        return redirect('admin/system-setting-legend-table')->with('success', strip_tags($legend->title) . ' ' . UPDATED_ALERT);
    }

    public function destroy($id)
    {
        $systemSetting = systemSettingLegendTable::where('id', $id)->first();
        $systemSetting->delete_status = 1;
        $systemSetting->save();

        return redirect('admin/system-setting-legend-table')->with('success', "Legend Table Setting" . DELETED_ALERT);
    }
}
