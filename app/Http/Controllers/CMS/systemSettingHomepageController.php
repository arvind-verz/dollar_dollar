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
        dd($request);
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required'
        ]);

        $oldSystemSetting = new systemSettingHomepage;
        $oldSystemSetting->company_name = $request->title;
        $oldSystemSetting->contact_phone = $request->description;
        $oldSystemSetting->contact_email = $request->link;
        $oldSystemSetting->created_at = Carbon::now()->toDateTimeString();

        $oldSystemSetting->save();

        return redirect()->back()->with('success', "System setting" . UPDATED_ALERT);


    }
}
