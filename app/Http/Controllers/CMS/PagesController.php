<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PAGE_MODULE_ID);

        $pages = Page::leftJoin('menus', 'pages.menu_id', '=', 'menus.id')
            ->where('pages.delete_status', 0)
            ->whereNotIn('pages.is_blog', [1])
            ->select('pages.*', 'menus.title as menu_title')
            ->orderBy('pages.name', 'ASC')->get();


        return view("backend.cms.pages.index", compact("pages", "CheckLayoutPermission"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::where('delete_status', 0)->get();

        if ($menus->count()) {
            foreach ($menus as &$menu) {
                $mainMenu = $menus->where('id', $menu->main)->first();

                if ($mainMenu) {
                    $menu->parent_menu = $mainMenu->title;
                } else {
                    $menu->parent_menu = "Main menu";
                }
            }
        }

        return view("backend.cms.pages.create", compact("menus"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validatorFields = [
            'name' => 'required',
            'contents' => 'required',
            'title' => 'required',
            //'slug' => 'required'
        ];
        $this->validate($request, $validatorFields);

        if (Page::where('slug', '=', str_slug($request->slug))
            ->where('delete_status', 0)->exists()
        ) {
            return redirect()->back()->withInput($request->input())->withErrors(['The slug' . ALREADY_TAKEN_ALERT]);
        }



        $page = new Page();
        $page->name = ucfirst($request->name);
        $page->title = ucfirst($request->title);
        $page->slug = str_slug($request->slug);
        $page->contents = $request->contents;
        $page->meta_title = $request->meta_title;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;
        if ($request->menu_id == "null") {
            $page->menu_id = null;
        } else {
            $page->menu_id = $request->menu_id;
        }
        if ($request->contact_or_offer == "null") {
            $page->contact_or_offer = null;
        } else {
            $page->contact_or_offer = $request->contact_or_offer;
        }

        $page->status = $request->status;
        $page->created_at = Carbon::now()->toDateTimeString();
        $page->save();

        //store activity log
        activity()
            ->performedOn($page)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PAGE_MODULE,
                'msg' => $page->name . ' ' . ADDED_ALERT,
                'old' => $page,
                'new' => null])
            ->log(CREATE);


        return redirect()->action('CMS\PagesController@index')->with('success', $page->name . ' ' . ADDED_ALERT);

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
        DB::enableQueryLog();
        $page = Page::find($id);

        if (!$page) {
            return redirect()->action('CMS\PageController@index')->with('error', OPPS_ALERT);
        }
        $menus = Menu::leftjoin('pages', 'menus.id', '=', 'pages.menu_id')
            ->where('menus.delete_status', 0)
            ->whereNotIn('menus.id', [$id])
            ->select('menus.*')
            ->get();

        $allpages = Page::where('delete_status', 0)->get();
        //dd(DB::getQueryLog($menus));
            
    //dd(DB::getQueryLog());
        if ($menus->count()) {
            foreach ($menus as &$menu) {
                $mainMenu = $menus->where('id', $menu->main)->first();

                if ($mainMenu) {
                    $menu->parent_menu = $mainMenu->title;
                } else {
                    $menu->parent_menu = "Main menu";
                }
            }
        }


        return view("backend.cms.pages.edit", compact("menus", "page", "allpages"));
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
        $product = \Helper::getProduct($id);
        $ads = $product->ads_placement;
        $adHorizontalPopupImage = $adHorizontalPopup = null;
        $destinationPath = 'uploads/products';
        $page = Page::find($id);
        if (!$page) {
            return redirect()->action('CMS\PagesController@index')->with('error', OPPS_ALERT);
        }

        $validatorFields = [
            'name' => 'required',
            'title' => 'required',
        ];

        if ($page->is_dynamic == 0) {
            $validatorFields ['slug'] = 'required';
            $validatorFields ['contents'] = 'required';

        }
        $this->validate($request, $validatorFields);

        if (isset($request->slug)) {
            if (Page::where('slug', '=', str_slug($request->slug))
                ->whereNotIn('id', [$id])
                ->where('delete_status', 0)->exists()
            ) {

                return redirect()->back()->withInput($request->input())->withErrors(['The slug' . ALREADY_TAKEN_ALERT]);
            }
        }

        if ($request->hasFile('ad_horizontal_image_popup')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image_popup')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image_popup')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalPopupImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image_popup')->move($destinationPath, $adHorizontalPopupImage);
        }
       
        if ($request->hasFile('ad_horizontal_image_popup')) {
           // dd($request);
            $adHorizontalPopup['ad_horizontal_image_popup'] = $destinationPath . '/' . $adHorizontalPopupImage;
        }
        $adHorizontalPopup['ad_link_horizontal_popup'] = $request->ad_horizontal_link_popup;
        $adsPlacement = [$adHorizontalPopupImage];


        $oldPage = $page;
        $page->name = ucfirst($request->name);
        $page->title = ucfirst($request->title);
        if (isset($request->slug)) {
            $page->slug = str_slug($request->slug);
        }
        if (isset($request->contents)) {
            $page->contents = $request->contents;
        }
        $page->meta_title = $request->meta_title;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_description = $request->meta_description;
        if ($request->menu_id == "null") {
            $page->menu_id = null;
        } else {
            $page->menu_id = $request->menu_id;
        }
        if ($request->page_linked == "null") {
            $page->page_linked = null;
        } else {
            $page->page_linked = $request->page_linked;
        }
        if ($request->contact_or_offer == "null") {
            $page->contact_or_offer = null;
        } else {
            $page->contact_or_offer = $request->contact_or_offer;
        }
        if (!$request->status) {
            $page->status = 1;
        } else {
            $page->status = $request->status;
        }
        $page->ads_placement = json_encode($adsPlacement);
        $page->after_login = $request->after_login;
        $page->created_at = Carbon::now()->toDateTimeString();
        $page->save();

        $newPage = Page::find($id);
        //store activity log
        activity()
            ->performedOn($page)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => PAGE_MODULE,
                'msg' => $newPage->name . ' ' . UPDATED_ALERT,
                'old' => $oldPage,
                'new' => $newPage
            ])
            ->log(UPDATE);

        return redirect()->action('CMS\PagesController@index')->with('success', $page->name . ' ' . UPDATED_ALERT);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::where('id', $id)->first();
        if (!$page) {
            return redirect()->action('CMS\PageController@index')->with('error', OPPS_ALERT);
        } else {
            $page->delete_status = 1;
            $page->save();
            //store log of activity
            activity()
                ->performedOn($page)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => MENU_MODULE,
                    'msg' => "Deleted Page " . $page->name,
                    'old' => $page,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('page.index'))->with('success', $page->name . ' ' . DELETED_ALERT);
        }
    }
}
