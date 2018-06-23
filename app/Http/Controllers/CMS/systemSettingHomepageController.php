<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\systemSettingHomepage;
use Carbon\Carbon;

class systemSettingHomepageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {

        $systemSetting = systemSettingHomepage::where('delete_status', 0)
            ->get();
        return view("backend.cms.systemSetting.homepage", compact("systemSetting"));
    }

    public function store(Request $request)
    {
        $systemSetting = systemSettingHomepage::where('delete_status', 0)
            ->get();

        $this->validate($request, [
            'homepage_link_title' => 'required',
            'homepage_link_description' => 'required',
            'homepage_link' => 'required'
        ]);

        if($systemSetting->count()==4) {
            return redirect()->back()->with('error', "System setting" . ' limit cannot be exceeded.');
        }
        
        $oldSystemSetting = new systemSettingHomepage;
        $oldSystemSetting->title = $request->homepage_link_title;
        $oldSystemSetting->description = $request->homepage_link_description;
        $oldSystemSetting->link = $request->homepage_link;
        $oldSystemSetting->created_at = Carbon::now()->toDateTimeString();

        $oldSystemSetting->save();

        return redirect()->back()->with('success', "System setting" . ADDED_ALERT);
    }

    public function edit(Request $request, $id)
    {
        $systemSetting = systemSettingHomepage::where('delete_status', 0)
            ->find($id);
            //dd($systemSetting);
        return view("backend.cms.systemSetting.homepage_edit", compact("systemSetting"));
    }

    public function update(Request $request, $id)
    {
        $oldSystemSetting = systemSettingHomepage::where('delete_status', 0)
            ->find($id);

        $this->validate($request, [
            'homepage_link_title' => 'required',
            'homepage_link_description' => 'required',
            'homepage_link' => 'required'
        ]);
        
        $oldSystemSetting->title = $request->homepage_link_title;
        $oldSystemSetting->description = $request->homepage_link_description;
        $oldSystemSetting->link = $request->homepage_link;
        $oldSystemSetting->created_at = Carbon::now()->toDateTimeString();

        $oldSystemSetting->save();

        return redirect('admin/system-setting-homepage')->with('success', "System setting" . UPDATED_ALERT);
    }
}
