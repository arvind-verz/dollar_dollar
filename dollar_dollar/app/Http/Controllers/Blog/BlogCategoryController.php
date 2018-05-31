<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\BlogCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BlogCategoryController extends Controller
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, BLOG_CATEGORY_MODULE_ID);

        $blogCategories = BlogCategory::where('delete_status', 0)
            ->where('parent', 0)
            ->orderBy('view_order', 'ASC')
            ->get();

        $parent = null;
        return view("backend.blog.blogCategory.index", compact("blogCategories", "CheckLayoutPermission", "parent"));


    }

    public function getSubCategories($id)
    {

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, BLOG_CATEGORY_MODULE_ID);
        $blogCategories = BlogCategory::orderBy('view_order', 'ASC')
            ->where('parent', $id)
            ->where('delete_status', 0)
            ->get();
        $blogCategory = BlogCategory::find($id);
        if (!$blogCategory) {
            return redirect()->action('Blog\BlogCategoryController@index')->with('error', OPPS_ALERT);
        }
        $parent = $id;

        return view("backend.blog.blogCategory.index", compact("blogCategories", 'id', "CheckLayoutPermission", 'parent'));
    }


    public function categoryCreate(Request $request)
    {
        $blogCategories = BlogCategory::where('delete_status', 0)->where('id', $request->parent)->get();
        $parent = $request->parent;
        return view("backend.blog.blogCategory.create", compact("blogCategories", 'parent'));
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
        $validatorFields = [];

        if (BlogCategory::where('title', ucfirst($request->title))
            ->where('parent', '=', $request->parent)
            ->where('delete_status', 0)->exists()
        ) {
            $validatorFields = array_add($validatorFields, 'title', "required|unique:blog-categories");
        } else {
            $validatorFields = array_add($validatorFields, 'title', "required");
        }
        $this->validate($request, $validatorFields);

        $blogCategory = new BlogCategory;
        $blogCategory->title = ucfirst($request->title);
        $blogCategory->parent = $request->parent;
        $blogCategory->view_order = $request->view_order;
        $blogCategory->child = 0;
        $blogCategory->main = 0;


        if ($request->parent != 0) {
            $parentId = $request->parent;
            do {
                $parentCategory = BlogCategory::find($parentId);
                if (!$parentCategory) {
                    $parentId = 0;
                    $mainCategoryId = 0;
                } elseif ($parentCategory->parent != 0) {
                    $parentId = $parentCategory->parent;
                } else {
                    $parentId = 0;
                    $mainCategoryId = $parentCategory->id;
                }
            } while ($parentId != 0);

            $blogCategory->main = $mainCategoryId;

            $parentCategory = BlogCategory::find($request->parent);
            $parentCategory->child = 1;
            $parentCategory->save();
        }
        $blogCategory->created_at = Carbon::now()->toDateTimeString();
        $blogCategory->save();

        //store activity log
        activity()
            ->performedOn($blogCategory)
            ->withProperties(['ip' => \Request::ip(),
                'module' => BLOG_CATEGORY_MODULE,
                'msg' => "Created new blog category " . $blogCategory->title,
                'old' => $blogCategory,
                'new' => null])
            ->log(CREATE);


        return redirect()->action('Blog\BlogCategoryController@index')->with('success', $blogCategory->title . ' ' . ADDED_ALERT);
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
    function edit($id)
    {
        $blogCategory = BlogCategory::find($id);

        if (!$blogCategory) {
            return redirect()->action('Blog\BlogCategoryController@index')->with('error', OPPS_ALERT);
        }
        $blogCategories = BlogCategory::where('delete_status', 0)
            ->whereNotIn('id', [$id])
            ->get();

        return view("backend.blog.blogCategory.edit", compact("blogCategories", "blogCategory"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //dd($request->all());
        $validatorFields = [];

        if (BlogCategory::where('title', ucfirst($request->title))
            ->where('parent', '=', $request->parent)
            ->whereNotIn('id', [$id])
            ->where('delete_status', 0)->exists()
        ) {
            $validatorFields = array_add($validatorFields, 'title', "required|unique:blog_categories");
        } else {
            $validatorFields = array_add($validatorFields, 'title', "required");
        }
        $this->validate($request, $validatorFields);

        if (BlogCategory::where('title', ucfirst($request->title))
            ->whereNotIn('id', [$id])
            ->where('parent', '=', $request->parent)
            ->where('delete_status', 0)->exists()
        ) {
            $validatorFields = array_add($validatorFields, 'title', "required|unique:blog_categories");
        } else {
            $validatorFields = array_add($validatorFields, 'title', "required");
        }
        $this->validate($request, $validatorFields);

        $blogCategory = BlogCategory::find($id);
        $oldBlogCategory = $blogCategory;
        if (!$blogCategory) {
            return redirect()->action('Blog\BlogCategoryController@index')->with('error', OPPS_ALERT);
        }

        $blogCategory->title = ucfirst($request->title);
        $blogCategory->parent = $request->parent;
        $blogCategory->view_order = $request->view_order;
        if ($request->parent != 0) {
            $parentId = $request->parent;
            do {
                $parentCategory = BlogCategory::find($parentId);
                if (!$parentCategory) {
                    $parentId = 0;
                    $mainCategory = 0;
                } elseif ($parentCategory->parent != 0) {
                    $parentId = $parentCategory->parent;
                } else {
                    $parentId = 0;
                    $mainCategory = $parentCategory->id;
                }
            } while ($parentId != 0);

            $blogCategory->main = $mainCategory;

            $parentCategory = BlogCategory::find($request->parent);
            $parentCategory->child = 1;
            $parentCategory->save();
        }
        $blogCategory->updated_at = Carbon::now()->toDateTimeString();
        $blogCategory->save();

        $newBlogCategory = BlogCategory::find($id);
        //store activity log
        activity()
            ->performedOn($blogCategory)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => BLOG_CATEGORY_MODULE,
                'msg' => "Update blog category detail of " . $blogCategory->title,
                'old' => $oldBlogCategory,
                'new' => $newBlogCategory
            ])
            ->log(UPDATE);


        return redirect()->action('Blog\BlogCategoryController@index')->with('success', $blogCategory->title . ' ' . UPDATED_ALERT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $blogCategory = BlogCategory::where('id', $id)->first();
        if (!$blogCategory) {
            return redirect()->action('Blog\BlogCategoryController@index')->with('error', OPPS_ALERT);
        } else {
            $childIds = [$blogCategory->id];
            $ids = $childIds;
            do {
                $ChildCategories = BlogCategory::whereIn('main', $childIds)->get();

                if ($ChildCategories->count()) {
                    $childIds = $ChildCategories->pluck('id')->all();
                    $ids = array_values(array_merge($ids, $childIds));
                } else {
                    $childIds = [];
                }
            } while (count($childIds) != 0);

            if (count($ids)) {

                $updateDeleteStatus = BlogCategory::whereIn('id', $ids)
                    ->update(['delete_status' => 1]);
                //store log of activity
                activity()
                    ->performedOn($blogCategory)
                    ->withProperties([
                        'ip' => \Request::ip(),
                        'module' => BLOG_CATEGORY_MODULE,
                        'msg' => "Deleted blog category " . $blogCategory->title,
                        'old' => $blogCategory,
                        'new' => null
                    ])
                    ->log(DELETE);
                return redirect(route('blog-category.index'))->with('success', $blogCategory->title . ' ' . DELETED_ALERT);
            }
        }
    }
}
