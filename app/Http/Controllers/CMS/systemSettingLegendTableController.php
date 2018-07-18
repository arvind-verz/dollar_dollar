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
            'icon' => 'required|image|max:1999'
        ]);
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/legends')) {
            mkdir('uploads/legends');
        }
        $destinationPath = 'uploads/legends'; // upload path
        $legendIcon = '';
        if ($request->hasFile('icon')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('icon')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('icon')->getClientOriginalExtension();
            // Filename to store
            $legendIcon = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('icon')->move($destinationPath, $legendIcon);
        }
        $legend = new systemSettingLegendTable;
        $legend->page_type = $request->page_type;
        $legend->title = $request->title;
        $legend->icon = $destinationPath . "/" .$legendIcon;
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
            'icon' => 'image|nullable|max:1999',
        ]);

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/legends')) {
            mkdir('uploads/legends');
        }
        $destinationPath = 'uploads/legends'; // upload path
        $legendIcon = '';
        if ($request->hasFile('icon')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('icon')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('icon')->getClientOriginalExtension();
            // Filename to store
            $legendIcon = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('icon')->move($destinationPath, $legendIcon);
        }
        if ($request->hasFile('icon')) {
            if (!$legend->icon ) {
                \File::delete($legend->icon);
            }
            $legend->icon = $destinationPath . '/' . $legendIcon;
        }
        
        $legend->page_type = $request->page_type;
        $legend->title = $request->title;
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
