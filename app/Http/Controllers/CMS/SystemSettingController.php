<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * BrandController constructor.
     */
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

        $systemSetting = SystemSetting::where('delete_status', 0)
            ->orderBy('id', 'desc')
            ->first();
        if (!$systemSetting) {
            return back()->with('error', "Opps! System setting not found.");
        } else {
            if ($systemSetting->contact_addresses != null) {
                $systemSetting->contact_addresses = unserialize($systemSetting->contact_addresses);
            } else {
                $systemSetting->contact_addresses = [];
            }
        }
        return view("backend.cms.systemSetting.edit", compact("systemSetting"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $this->validate($request, [
            'logo' => 'image|nullable|max:1999',
            'footer' => 'required',
            'email_sender_name' => 'required',
            'admin_email' => 'required | email',
            'auto_email' => 'required | email',
            //'company_name' => 'required ',
            //'contact_phone' => 'required ',
            //'contact_email' => 'required | email ',
        ]);

        $systemSetting = SystemSetting::find($id);
        if (!$systemSetting) {
            return redirect('/admin')->with('error', OPPS_ALERT);
        }
        $oldSystemSetting = $systemSetting;
        $oldSystemSetting->email_sender_name = ucfirst($request->email_sender_name);
        $oldSystemSetting->admin_email = $request->admin_email;
        $oldSystemSetting->auto_email = $request->auto_email;
        $oldSystemSetting->company_name = $request->company_name;
        $oldSystemSetting->contact_phone = $request->contact_phone;
        $oldSystemSetting->contact_email = $request->contact_email;
        $oldSystemSetting->footer = $request->footer;
        $oldSystemSetting->contact_us_section = $request->contact_us_section;
        $oldSystemSetting->offer_section = $request->offer_section;
        $oldSystemSetting->footer3 = $request->footer_3;
        $oldSystemSetting->footer4 = $request->footer_4;
        $oldSystemSetting->created_at = Carbon::now()->toDateTimeString();
        if (isset($request->contact_addresses) && ($request->contact_addresses != null)) {
            $oldSystemSetting->contact_addresses = serialize(array_filter($request->contact_addresses));
        }
        //set folder
        $path_array = [];
        $destinationPath = 'frontend/images';
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }
        if (isset($request->logo)) {

            $image = $request->logo;
            // Get filename with the extension
            $filenameWithExt = $image->getClientOriginalName();
            // Get just filename
             $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $image->getClientOriginalExtension();
            // Filename to store
            $imageName = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $image->move($destinationPath, $imageName);
            $oldSystemSetting->logo = $destinationPath . '/' . $imageName;


        }

        $oldSystemSetting->save();
        $newSystemSetting = SystemSetting::find($id);
        //store activity log
        activity()
            ->performedOn($oldSystemSetting)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => SYSTEM_SETTING_MODULE,
                'msg' => "System setting" . UPDATED_ALERT,
                'old' => $oldSystemSetting,
                'new' => $newSystemSetting
            ])
            ->log(UPDATE);

        return redirect()->back()->with('success', "System setting" . UPDATED_ALERT);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
