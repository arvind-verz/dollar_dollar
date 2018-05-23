<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, MENU_MODULE_ID);

        $menus = Menu::where('delete_status', 0)
            ->where('parent', 0)
            ->orderBy('view_order', 'ASC')
            ->get();

        $parent = null;
        return view("backend.cms.menu.index", compact("menus", "CheckLayoutPermission", "parent"));


    }

    public function getSubMenus($id)
    {

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, MENU_MODULE_ID);
        $menus = Menu::orderBy('view_order', 'ASC')
            ->where('parent', $id)
            ->where('delete_status', 0)
            ->get();
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->action('CMS\MenuController@index')->with('error', OPPS_ALERT);
        }
        $parent = $id;

        return view("backend.cms.menu.index", compact("menus", 'id', "CheckLayoutPermission", 'parent'));
    }


    public function menuCreate(Request $request)
    {
        $menus = Menu::where('delete_status', 0)->where('id', $request->parent)->get();
        $parent = $request->parent;
        return view("backend.cms.menu.create", compact("menus", 'parent'));
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

        if (Menu::where('title', ucfirst($request->title))
            ->where('parent', '=', $request->parent)
            ->where('delete_status', 0)->exists()
        ) {
            $validatorFields = array_add($validatorFields, 'title', "required|unique:menus");
        } else {
            $validatorFields = array_add($validatorFields, 'title', "required");
        }
        $this->validate($request, $validatorFields);

        $menu = new Menu;
        $menu->title = ucfirst($request->title);
        $menu->parent = $request->parent;
        $menu->view_order = $request->view_order;
        $menu->child = 0;
        $menu->main = 0;


        if ($request->parent != 0) {
            $parentId = $request->parent;
            do {
                $parentMenu = Menu::find($parentId);
                if (!$parentMenu) {
                    $parentId = 0;
                    $mainMenuId = 0;
                } elseif ($parentMenu->parent != 0) {
                    $parentId = $parentMenu->parent;
                } else {
                    $parentId = 0;
                    $mainMenuId = $parentMenu->id;
                }
            } while ($parentId != 0);

            $menu->main = $mainMenuId;

            $parentMenu = Menu::find($request->parent);
            $parentMenu->child = 1;
            $parentMenu->save();
        }
        $menu->created_at = Carbon::now()->toDateTimeString();
        $menu->save();

        //store activity log
        activity()
            ->performedOn($menu)
            ->withProperties(['ip' => \Request::ip(),
                'module' => MENU_MODULE,
                'msg' => "Created new menu " . $menu->title,
                'old' => $menu,
                'new' => null])
            ->log(CREATE);


        return redirect()->action('CMS\MenuController@index')->with('success', $menu->title . ' ' . ADDED_ALERT);
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
        $menu = Menu::find($id);

        if (!$menu) {
            return redirect()->action('CMS\MenuController@index')->with('error', OPPS_ALERT);
        }
        $menus = Menu::where('delete_status', 0)
            ->whereNotIn('id', [$id])
            ->get();

        return view("backend.cms.menu.edit", compact("menus", "menu"));
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

        if (Menu::where('title', ucfirst($request->title))
            ->where('parent', '=', $request->parent)
            ->whereNotIn('id', [$id])
            ->where('delete_status', 0)->exists()
        ) {
            $validatorFields = array_add($validatorFields, 'title', "required|unique:menus");
        } else {
            $validatorFields = array_add($validatorFields, 'title', "required");
        }
        $this->validate($request, $validatorFields);

        if (Menu::where('title', ucfirst($request->title))
            ->whereNotIn('id', [$id])
            ->where('parent', '=', $request->parent)
            ->where('delete_status', 0)->exists()
        ) {
            $validatorFields = array_add($validatorFields, 'title', "required|unique:menus");
        } else {
            $validatorFields = array_add($validatorFields, 'title', "required");
        }
        $this->validate($request, $validatorFields);

        $menu = Menu::find($id);
        $oldMenu = $menu;
        if (!$menu) {
            return redirect()->action('CMS\MenuController@index')->with('error', OPPS_ALERT);
        }

        $menu->title = ucfirst($request->title);
        $menu->parent = $request->parent;
        $menu->view_order = $request->view_order;
        if ($request->parent != 0) {
            $parentId = $request->parent;
            do {
                $parentMenu = Menu::find($parentId);
                if (!$parentMenu) {
                    $parentId = 0;
                    $mainMenuId = 0;
                } elseif ($parentMenu->parent != 0) {
                    $parentId = $parentMenu->parent;
                } else {
                    $parentId = 0;
                    $mainMenuId = $parentMenu->id;
                }
            } while ($parentId != 0);

            $menu->main = $mainMenuId;

            $parentMenu = Menu::find($request->parent);
            $parentMenu->child = 1;
            $parentMenu->save();
        }
        $menu->updated_at = Carbon::now()->toDateTimeString();
        $menu->save();

        $newMenu = Menu::find($id);
        //store activity log
        activity()
            ->performedOn($menu)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => MENU_MODULE,
                'msg' => "Update menu detail of " . $menu->title,
                'old' => $oldMenu,
                'new' => $newMenu
            ])
            ->log(UPDATE);


        return redirect()->action('CMS\MenuController@index')->with('success', $menu->title . ' ' . UPDATED_ALERT);
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
        $menu = Menu::where('id', $id)->first();
        if (!$menu) {
            return redirect()->action('CMS\MenuController@index')->with('error', OPPS_ALERT);
        } else {
            $childIds = [$menu->id];
            $ids = $childIds;
            do {
                $childMenus = Menu::whereIn('main', $childIds)
                ->where('delete_status', '!=', 1)
                ->get();

                if ($childMenus->count()) {
                    $childIds = $childMenus->pluck('id')->all();
                    $ids = array_values(array_merge($ids, $childIds));
                } else {
                    $childIds = [];
                }
            } while (count($childIds) != 0);

            if (count($ids)) {
                if(count($ids)<=1) {
                    $update_query = Menu::where('id', $ids)->update(['main'=> 0, 'parent'=> 0, 'child'=> 0]);
                }
                $updateDeleteStatus = Menu::whereIn('id', $ids)
                    ->update(['delete_status' => 1]);
                
                //store log of activity
                activity()
                    ->performedOn($menu)
                    ->withProperties([
                        'ip' => \Request::ip(),
                        'module' => MENU_MODULE,
                        'msg' => "Deleted menu " . $menu->title,
                        'old' => $menu,
                        'new' => null
                    ])
                    ->log(DELETE);
                return redirect(route('menu.index'))->with('success', $menu->title . ' ' . DELETED_ALERT);
            }
        }
    }
}
