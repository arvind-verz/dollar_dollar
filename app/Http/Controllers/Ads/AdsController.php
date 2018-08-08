<?php

namespace App\Http\Controllers\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdsManagement;
use App\Page;
use Auth;
use Carbon\Carbon;
use Validator;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index($type=NULL)
    {
        

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ADS_MODULE_ID);

        $ads = AdsManagement::where('delete_status', 0)
        ->where('page', $type)
        ->get();
        
        return view("backend.ads.index" , compact("ads", "CheckLayoutPermission", "type"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type=NULL)
    {

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ADS_MODULE_ID);


        return view("backend.ads.create" , compact("CheckLayoutPermission", "type"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validatorFields = [
            'title' => 'required',
            'ad_image' => 'required|image|nullable|max:1999',
            'ad_link'   =>  'required',
            'page'  =>  'required'
        ];

        $validator = Validator::make($request->all(), $validatorFields);

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/ads')) {
            mkdir('uploads/ads');
        }

        $destinationPath = 'uploads/ads'; // upload path
        $ad_image = '';
        if ($request->hasFile('ad_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_image')->getClientOriginalExtension();
            // Filename to store
            $ad_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_image')->move($destinationPath, $ad_image);
        }

        $ads = new AdsManagement;
        $page_type = NULL;
        if($request->page=='product')
        {
            $page_type = $request->page_type;
        }
        $ads->page_type = $page_type;
        $ads->page = $request->page;
        $ads->title = $request->title;
        $ads->ad_image = $destinationPath . "/" . $ad_image;
        $ads->ad_link = $request->ad_link;
        $ads->display = $request->display;
        $ads->created_at = Carbon::now()->toDateTimeString();
        $ads->save();

        //store activity log
        activity()
            ->performedOn($ads)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => ADS_MANAGEMENT,
                'msg' => strip_tags($ads->title) . ' ' . ADDED_ALERT,
                'old' => $ads,
                'new' => null
            ])
            ->log(CREATE);

        
        return redirect('admin/ads/'.$request->page)->with('success', strip_tags($ads->title) . ' ' . ADDED_ALERT);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type=NULL)
    {

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ADS_MODULE_ID);

        $ads = AdsManagement::find($id);
        return view("backend.ads.edit" , compact("ads", "CheckLayoutPermission", "type"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $type=NULL)
    {
        $ads = AdsManagement::find($id);

        //dd($request->all(),$id,$banner);
        $oldAds = $ads;
        if (!$ads) {
            return redirect('admin/ads/'.$request->page)->with('error', OPPS_ALERT);
        }

        //dd($request->all());
        $validatorFields = [
            'title' => 'required',
            'ad_image' => 'required|image|nullable|max:1999',
            'ad_link'   =>  'required',
            'page'  =>  'required'
        ];

        $validator = Validator::make($request->all(), $validatorFields);

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/ads')) {
            mkdir('uploads/ads');
        }


        $destinationPath = 'uploads/ads'; // upload path
        $ad_image = '';
        if ($request->hasFile('ad_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_image')->getClientOriginalExtension();
            // Filename to store
            $ad_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_image')->move($destinationPath, $ad_image);
        }

        if ($request->hasFile('ad_image')) {
            if ($banner->ad_image != 'noimage.jpg') {
                \File::delete($banner->ad_image);
            }
            $banner->ad_image = $destinationPath . '/' . $ad_image;
        }

        $page_type = NULL;
        if($request->page=='product')
        {
            $page_type = $request->page_type;
        }
        $ads->page_type = $page_type;
        $ads->page = $request->page;
        $ads->title = $request->title;
        $ads->ad_link = $request->ad_link;
        $ads->display = $request->display;
        $ads->created_at = Carbon::now()->toDateTimeString();
        $ads->save();

        $newAds = AdsManagement::find($id);
        //store activity log
        activity()
            ->performedOn($newAds)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => ADS_MANAGEMENT,
                'msg' => strip_tags($newAds->title) . ' ' . UPDATED_ALERT,
                'old' => $oldAds,
                'new' => $newAds
            ])
            ->log(UPDATE);
        
        return redirect('admin/ads/'.$request->page)->with('success', strip_tags($newAds->title) . ' ' . UPDATED_ALERT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type=NULL)
    {
        $Ads = AdsManagement::where('id', $id)->first();

        $Ads->delete_status = 1;
        $Ads->save();

        //store activity log
        activity()
            ->performedOn($Ads)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => ADS_MANAGEMENT,
                'msg' => strip_tags($Ads->title) . ' ' . DELETED_ALERT,
                'old' => $Ads,
                'new' => null
            ])
            ->log(DELETE);

        return redirect('admin/ads/'.$type)->with('success', strip_tags($Ads->title) . ' ' . DELETED_ALERT);
    }
}
