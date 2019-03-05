<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Page;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
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
        $blogMenu = Menu::where('delete_status', 0)
            ->where('is_blog', 1)
            ->first();
        if ($blogMenu) {
            $menus = Menu::where('delete_status', 0)
                ->where('parent', $blogMenu->id)
                ->get();
        } else {
            $menus = collect([]);
        }
        $pages = Page::leftJoin('menus', 'pages.menu_id', '=', 'menus.id')
            ->where('pages.delete_status', 0)
            ->where('pages.is_blog', 1)
            ->select('pages.*', 'menus.title as menu_title')
            ->orderBy('pages.name', 'ASC')->get();


        return view("backend.blog.index", compact("pages", "CheckLayoutPermission", "menus"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($category = "all")
    {
        $filterCategory = $category;
        if ($category == "all") {
            $blogMenu = Menu::where('delete_status', 0)
                ->where('is_blog', 1)
                ->first();
            if ($blogMenu) {
                $menus = Menu::where('delete_status', 0)
                    ->where('parent', $blogMenu->id)
                    ->get();
            } else {
                $menus = collect([]);
            }
        } else {
            $menus = Menu::where('delete_status', 0)
                ->where('id', $category)
                ->get();
        }


        $tags = Tag::where('status', 1)
            ->where('delete_status', 0)
            ->get();

        return view("backend.blog.create", compact("menus", "tags", "filterCategory"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filterCategory = $request->filter_category ? $request->filter_category : "all";
        $fields = [
            'name' => 'required',
            'contents' => 'required',
            'title' => 'required',
        ];
        //dd($request->all());

        if (Page::where('slug', '=', str_slug($request->slug))
            ->where('delete_status', 0)->exists()
        ) {
            $fields['slug'] = 'required|unique:pages,slug';
        } else {
            $fields['slug'] = 'required';
        }
        if ($request->menu_id === "null") {
            $fields['category'] = 'required';
        }
        $validator = Validator::make($request->all(), $fields);

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }


        $page = new Page();
        $page->name = ucfirst($request->name);
        $page->disable_ads = $request->disable_ads;
        $page->title = ucfirst($request->title);
        $page->slug = str_slug($request->slug);


        $destinationPath = 'uploads/images/blog';

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }
        if (isset($request->blog_image)) {

            $image = $request->blog_image;
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
            $page->blog_image = $destinationPath . '/' . $imageName;
        }
        /*if (isset($request->blog_image_ads)) {

            $image = $request->blog_image_ads;
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
            $page->blog_image_ads = $destinationPath . '/' . $imageName;
        }*/

        $tags = [];
        if (isset($request->tags)) {
            $tags = $request->tags;
        }
        $page->tags = json_encode($tags);
        $page->short_description = $request->short_description;
        $page->contents = $request->contents;
        $page->meta_title = $request->meta_title;
        $page->is_blog = 1;
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
                'module' => BLOG_MODULE,
                'msg' => "Created new blog " . $page->name,
                'old' => $page,
                'new' => null])
            ->log(CREATE);

        return redirect(route('filter-category', ['id' => $filterCategory]))->with('success', $page->name . ' ' . ADDED_ALERT);

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


    public function edit($id, Request $request)
    {
        $filterCategory = $request->filter_category ? $request->filter_category : "all";
        $page = Page::find($id);

        if (!$page) {
            return redirect()->action('Blog\BlogController@index')->with('error', OPPS_ALERT);
        }
        if ($page->tags != null) {
            $page->tags = json_decode($page->tags);
        } else {
            $page->tags = [];
        }

        $blogMenu = Menu::where('delete_status', 0)
            ->where('is_blog', 1)
            ->first();
        if ($blogMenu) {
            $menus = Menu::where('delete_status', 0)
                ->where('parent', $blogMenu->id)
                ->whereNotIn('id', [$id])
                ->get();
        } else {
            $menus = collect([]);
        }

        $tags = Tag::where('status', 1)
            ->where('delete_status', 0)
            ->get();

        return view("backend.blog.edit", compact("menus", "page", "tags", "filterCategory"));
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
        $filterCategory = $request->filter_category ? $request->filter_category : "all";
        $page = Page::find($id);
        if (!$page) {
            return redirect()->action('Blog\BlogController@index')->with('error', OPPS_ALERT);
        }

        $validatorFields = [
            'name' => 'required',
            'title' => 'required',
        ];

        if ($page->is_dynamic == 0) {
            $validatorFields ['slug'] = 'required';
            $validatorFields ['contents'] = 'required';

        }
        if ($request->menu_id == "null") {
            $validatorFields['category'] = 'required';
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

        $oldPage = $page;
        $page->name = ucfirst($request->name);
        $page->disable_ads = $request->disable_ads;
        $page->title = ucfirst($request->title);
        if (isset($request->slug)) {
            $page->slug = str_slug($request->slug);
        }
        if (isset($request->contents)) {
            $page->contents = $request->contents;
        }

        $destinationPath = 'uploads/images/blog';

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }
        if (isset($request->blog_image)) {

            $image = $request->blog_image;
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
            $page->blog_image = $destinationPath . '/' . $imageName;
        }
        /*if (isset($request->blog_image_ads)) {

            $image = $request->blog_image_ads;
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
            $page->blog_image_ads = $destinationPath . '/' . $imageName;
        }*/

        $tags = [];
        if (isset($request->tags)) {
            $tags = $request->tags;
        }
        $page->tags = json_encode($tags);
        $page->short_description = $request->short_description;
        $page->meta_title = $request->meta_title;
        $page->is_blog = 1;
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
        if (!is_null($request->status)) {
            $page->status = $request->status;
        }
        $page->after_login = $request->after_login;
        $page->updated_at = Carbon::now()->toDateTimeString();
        $page->save();

        $newPage = Page::find($id);
        //store activity log
        activity()
            ->performedOn($page)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => BLOG_MODULE,
                'msg' => "Update blog detail of " . $page->name,
                'old' => $oldPage,
                'new' => $newPage
            ])
            ->log(UPDATE);
        return redirect(route('filter-category', ['id' => $filterCategory]))->with('success', $page->name . ' ' . UPDATED_ALERT);


    }

    public function destroy($id, Request $request)
    {
        $filterCategory = $request->filter_category ? $request->filter_category : "all";
        $page = Page::where('id', $id)->first();
        if (!$page) {
            return redirect()->action('Blog\BlogController@index')->with('error', OPPS_ALERT);
        } else {
            $page->delete_status = 1;
            $page->save();
            //store log of activity
            activity()
                ->performedOn($page)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => BLOG_MODULE,
                    'msg' => "Deleted blog " . $page->name,
                    'old' => $page,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect(route('filter-category', ['id' => $filterCategory]))->with('success', $page->name . ' ' . DELETED_ALERT);

        }
    }

    public function filter($id)
    {

        $filterCategory = $id;
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PAGE_MODULE_ID);
        $blogMenu = Menu::where('delete_status', 0)
            ->where('is_blog', 1)
            ->first();
        //dd($blogMenu);
        if ($blogMenu) {
            $menus = Menu::where('delete_status', 0)
                ->where('parent', $blogMenu->id)
                ->get();
        } else {
            $menus = collect([]);
        }
        $pages = $this->getBlog($id);
        return view("backend.blog.index", compact("pages", "CheckLayoutPermission", "menus", "filterCategory"));
    }

    public function getBlog($id)
    {

        if ($id == 'all') {
            $pages = Page::leftJoin('menus', 'pages.menu_id', '=', 'menus.id')
                ->where('pages.delete_status', 0)
                ->where('pages.is_blog', 1)
                ->select('pages.*', 'menus.title as menu_title')
                ->orderBy('pages.name', 'ASC')->get();
        } else {
            $pages = Page::leftJoin('menus', 'pages.menu_id', '=', 'menus.id')
                ->where('pages.delete_status', 0)
                ->where('pages.is_blog', 1)
                ->where('menu_id', $id)
                ->select('pages.*', 'menus.title as menu_title')
                ->orderBy('pages.name', 'ASC')->get();
        }
        return $pages;
    }
}
