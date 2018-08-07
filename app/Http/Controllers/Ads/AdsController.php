<?php

namespace App\Http\Controllers\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdsManagement;
use App\Page;
use Auth;

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
        if($type=='account') {
            $type = 'index';
        }

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ADS_MODULE_ID);

        $ads = AdsManagement::where('display', 1)
        ->where('delete_status', 0)
        ->inRandomOrder()
        ->limit(1)
        ->get();

        return view("backend.ads." . $type , compact("ads", "CheckLayoutPermission", "type"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type=NULL)
    {
        if($type=='account') {
            $type = 'index';
        }

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, ADS_MODULE_ID);

        $ads = AdsManagement::where('display', 1)
        ->where('delete_status', 0)
        ->inRandomOrder()
        ->limit(1)
        ->get();

        return view("backend.ads.create" , compact("ads", "CheckLayoutPermission", "type"));
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
        $ads->page = $request->page;
        $ads->title = $request->title;
        $ads->ad_image = $destinationPath . "/" . $request->ad_image;
        $ads->ad_link = $request->ad_link;
        $ads->display = $request->display;
        $banner->created_at = Carbon::now()->toDateTimeString();
        $banner->save();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
