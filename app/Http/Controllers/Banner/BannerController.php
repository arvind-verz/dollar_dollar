<?php

namespace App\Http\Controllers\Banner;

use App\Banner;
use App\Category;
use App\Helpers\helper\Helper;
use App\Http\Controllers\Controller;
use App\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class BannerController extends Controller
{

    /**
     * BannerController constructor.
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

    public function index($type=NULL)
    {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, BANNER_MODULE_ID);

        if($type=='home-page') {
        $banners = Banner::join('pages', 'banners.page_id', '=', 'pages.id')
            ->where('banners.delete_status', 0)
            ->where('pages.delete_status', 0)
            ->where('pages.slug', '=', 'home')
            ->select('banners.*', 'pages.name as label')
            ->orderBy('page_id', 'ASC')
            ->orderBy('view_order', 'ASC')
            ->get();
        }
        else {
            $banners = Banner::join('pages', 'banners.page_id', '=', 'pages.id')
            ->where('banners.delete_status', 0)
            ->where('pages.delete_status', 0)
            ->where('pages.slug', '!=', 'home')
            ->select('banners.*', 'pages.name as label')
            ->orderBy('page_id', 'ASC')
            ->orderBy('view_order', 'ASC')
            ->get();
        }

        return view("backend.banner.index", compact("banners", "CheckLayoutPermission", "type"));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type=NULL)
    {
        //get pages detail
        $pages = Helper::getPages();

        return view("backend.banner.create", compact("pages", "type"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        //
        $validatorFields = [
            'title' => 'required',
            //'page' => 'required',
            //'banner_content_color' => 'required',
            //'banner_content' => 'required',
            'banner_image' => 'required|image|nullable|max:1999',
            // 'banner_link' => 'required',

        ];

        $validator = Validator::make($request->all(), $validatorFields);
        if ($request->category == "null") {
            $category = null;
        } else {
            $category = $request->category;
        }
        if ($request->page == "null") {

            $validator->getMessageBag()->add('page', 'The page' . ' ' . SELECT_ALERT);
        } else {
            $pages = Page::where('delete_status', 0)->get();
            if ($pages->count()) {
                $page = $pages->where('id', $request->page)->where('delete_status', 0)->first();
                $homePage = $pages->where('is_index', 1)->where('delete_status', 0)->first();

                $banners = Banner::where('delete_status', 0)->get();
                if ($banners->count()) {
                    $existBanner = $banners->where('page_id', $request->page)->where('delete_status', 0)->first();
                    $countBanner = $banners->where('page_id', $request->page)->where('delete_status', 0)
                        ->count();
                    if ($existBanner) {
                        if (($request->page == $homePage->id) && ($countBanner >= 5)) {
                            $validator->getMessageBag()->add('page', MAX_HOME_BANNER_ALERT . ' ' . $page->name);
                        } elseif (($request->page != $homePage->id) && ($countBanner >= 1)) {
                            $validator->getMessageBag()->add('page', MAX_BANNER_ALERT . ' ' . $page->name);
                        }
                    }
                }
            }
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }


        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/banners')) {
            mkdir('uploads/banners');
        }

        $destinationPath = 'uploads/banners'; // upload path
        $banner_image = '';
        if ($request->hasFile('banner_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('banner_image')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('banner_image')->move($destinationPath, $banner_image);
        }
        /*# Resize image
        $frame_width = 1400;
        $frame_height = ($request->pageid == 1) ? 589 : 300;
        Helper::imageResize($destinationPath . "/" . $fileName, $frame_width, $frame_height);*/


        $banner = new Banner;
        $banner->page_id = $request->page;
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->target = $request->target;
        $banner->banner_content_color = $request->banner_content_color;
        $banner->banner_content = $request->banner_content;
        $banner->view_order = $request->view_order;
        $banner->banner_link = ($request->banner_link ? $request->banner_link : '');
        $banner->banner_image = $destinationPath . "/" . $banner_image;
        $banner->created_at = Carbon::now()->toDateTimeString();
        $banner->save();

        //store activity log
        activity()
            ->performedOn($banner)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => USER_MODULE,
                'msg' => strip_tags($banner->title) . ' ' . ADDED_ALERT,
                'old' => $banner,
                'new' => null
            ])
            ->log(CREATE);

        if($type=='inner-page') {
            return $this->bannerInner()->with('success', strip_tags($banner->title) . ' ' . ADDED_ALERT);
        }
        else {
            return $this->bannerHome()->with('success', strip_tags($banner->title) . ' ' . ADDED_ALERT);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id, $type=NULL)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->action('Banner\BannerController@index')->with('error', OPPS_ALERT);
        }

        $pages = Helper::getPages();

        /*$pages = [];
        foreach ($pagesDetails as $pagesDetail) {

            $pages[$pagesDetail->id] = $pagesDetail->label;
        }*/

        return view("backend.banner.edit", compact("banner", "pages", "type"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id, $type)
    {
        //dd($type);
        $banner = Banner::find($id);

        //dd($request->all(),$id,$banner);
        $oldBanner = $banner;
        if (!$banner) {
            return redirect()->action('Banner\BannerController@index')->with('error', OPPS_ALERT);
        }

        //dd($request->all());
        $validatorFields = [
            'title' => 'required',
            //'page' => 'required',
            //'banner_content_color' => 'required',
            //'banner_content' => 'required',
            'banner_image' => 'image|nullable|max:1999',
            // 'banner_link' => 'required',

        ];

        $validator = Validator::make($request->all(), $validatorFields);
        if ($request->page == "null") {

            $validator->getMessageBag()->add('page', 'The page' . ' ' . SELECT_ALERT);
        } else {
            $pages = Page::where('delete_status', 0)->get();
            if ($pages->count()) {
                $page = $pages->where('id', $request->page)->where('delete_status', 0)->first();
                $homePage = $pages->where('is_index', 1)->where('delete_status', 0)->first();

                $banners = Banner::where('delete_status', 0)->whereNotIn('id', [$id])->get();
                if ($banners->count()) {
                    $existBanner = $banners->where('page_id', $request->page)->where('delete_status', 0)->first();
                    $countBanner = $banners->where('page_id', $request->page)->where('delete_status', 0)
                        ->count();
                    if ($existBanner) {
                        if (($request->page == $homePage->id) && ($countBanner >= 5)) {
                            $validator->getMessageBag()->add('page', MAX_HOME_BANNER_ALERT . ' ' . $page->name);
                        } elseif (($request->page != $homePage->id) && ($countBanner >= 1)) {
                            $validator->getMessageBag()->add('page', MAX_BANNER_ALERT . ' ' . $page->name);
                        }
                    }
                }
            }
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/banners')) {
            mkdir('uploads/banners');
        }


        $destinationPath = 'uploads/banners'; // upload path
        $banner_image = '';
        if ($request->hasFile('banner_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('banner_image')->getClientOriginalExtension();
            // Filename to store
            $banner_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('banner_image')->move($destinationPath, $banner_image);
        }

        if ($request->hasFile('banner_image')) {
            if ($banner->banner_image != 'noimage.jpg') {
                \File::delete($banner->banner_image);
            }
            $banner->banner_image = $destinationPath . '/' . $banner_image;
        }


        $banner->page_id = $request->page;
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->target = $request->target;
        $banner->banner_content = $request->banner_content;
        $banner->banner_content_color = $request->banner_content_color;
        $banner->view_order = $request->view_order;
        $banner->banner_link = ($request->banner_link ? $request->banner_link : '');
        $banner->updated_at = Carbon::now()->toDateTimeString();
        $banner->save();

        $newBanner = Banner::find($id);
        //store activity log
        activity()
            ->performedOn($newBanner)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => BANNER_MODULE,
                'msg' => strip_tags($newBanner->title) . ' ' . UPDATED_ALERT,
                'old' => $oldBanner,
                'new' => $newBanner
            ])
            ->log(UPDATE);
        if($type=='inner-page') {
            return $this->bannerInner()->with('success', strip_tags($newBanner->title) . ' ' . UPDATED_ALERT);
        }
        else {
            return $this->bannerHome()->with('success', strip_tags($newBanner->title) . ' ' . UPDATED_ALERT);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type=NULL)
    {
        $Banner = Banner::where('id', $id)->first();
        if (!$Banner) {
            return redirect()->action('Banner\BannerController@index')->with('error', OPPS_ALERT);
        }
        $Banner->delete_status = 1;
        $Banner->save();

        //store activity log
        activity()
            ->performedOn($Banner)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => BANNER_MODULE,
                'msg' => strip_tags($Banner->title) . ' ' . DELETED_ALERT,
                'old' => $Banner,
                'new' => null
            ])
            ->log(DELETE);
        if($type=='inner-page') {
            return $this->bannerInner()->with('success', strip_tags($Banner->title) . ' ' . DELETED_ALERT);
        }
        else {
            return $this->bannerHome()->with('success', strip_tags($Banner->title) . ' ' . DELETED_ALERT);
        }
    }

    public function bannerHome($type='home-page') {
        return $this->index($type);
    }

    public function bannerInner($type='inner-page') {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, BANNER_MODULE_ID);


        $banners = Banner::join('pages', 'banners.page_id', '=', 'pages.id')
            ->where('banners.delete_status', 0)
            ->where('pages.delete_status', 0)
            ->where('pages.slug', '!=', 'home')
            ->select('banners.*', 'pages.name as label')
            ->orderBy('page_id', 'ASC')
            ->orderBy('view_order', 'ASC')
            ->get();

        return view("backend.banner.index", compact("banners", "CheckLayoutPermission", "type"));
    }
}
