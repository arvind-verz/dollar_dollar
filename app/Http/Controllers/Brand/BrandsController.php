<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandsController extends Controller
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
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, BRAND_MODULE_ID);


        $brands = Brand::where('brands.delete_status', 0)
            ->orderBy('view_order', 'ASC')->get();

        return view("backend.brand.index", compact("brands", "CheckLayoutPermission"));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("backend.brand.create");
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
        //
        $this->validate($request, [
            'title' => 'required',
            'brand_logo' => 'required|image|nullable|max:1999',
            // 'brand_link' => 'required',
        ]);


        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/brands')) {
            mkdir('uploads/brands');
        }

        if (!is_dir('uploads/brands/logos')) {
            mkdir('uploads/brands/logos');
        }
        $destinationPath = 'uploads/brands/logos'; // upload path
        $brand_logo = '';
        if ($request->hasFile('brand_logo')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('brand_logo')->getClientOriginalName();
            // Get just filename
             $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('brand_logo')->getClientOriginalExtension();
            // Filename to store
            $brand_logo = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('brand_logo')->move($destinationPath, $brand_logo);
        }
        /*# Resize image
        $frame_width = 1400;
        $frame_height = ($request->pageid == 1) ? 589 : 300;
        Helper::imageResize($destinationPath . "/" . $fileName, $frame_width, $frame_height);*/

        $brand = new Brand;
        $brand->title = $request->title;
        $brand->display = $request->display;
        $brand->view_order = $request->view_order;
        $brand->brand_link = ($request->brand_link ? $request->brand_link : '');
        $brand->brand_logo = $destinationPath . "/" . $brand_logo;
        $brand->created_at = Carbon::now()->toDateTimeString();
        $brand->save();

        //store activity log
        activity()
            ->performedOn($brand)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => BRAND_MODULE,
                'msg' => $brand->title . ' ' . ADDED_ALERT,
                'old' => $brand,
                'new' => null
            ])
            ->log(CREATE);


        return redirect()->action('Brand\BrandsController@index')->with('success', $brand->title . ' ' . ADDED_ALERT);

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
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->action('Brand\BrandsController@index')->with('error', OPPS_ALERT);
        }

        /*$pages = [];
        foreach ($pagesDetails as $pagesDetail) {

            $pages[$pagesDetail->id] = $pagesDetail->label;
        }*/
        return view("backend.brand.edit", compact("brand"));
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
        $this->validate($request, [
            'title' => 'required',
            'brand_logo' => 'image|nullable|max:1999',
            //'brand_link' => 'required',
        ]);
        $destinationPath = 'uploads/brands/logos'; // upload path
        $brand_logo = 'noimage.jpg';

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/brands')) {
            mkdir('uploads/brands');
        }

        if (!is_dir('uploads/brands/logos')) {
            mkdir('uploads/brands/logos');
        }
        if ($request->hasFile('brand_logo')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('brand_logo')->getClientOriginalName();
            // Get just filename
             $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('brand_logo')->getClientOriginalExtension();
            // Filename to store
            $brand_logo = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('brand_logo')->move($destinationPath, $brand_logo);
        }
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->action('Brand\BrandsController@index')->with('error', OPPS_ALERT);
        }

        $oldBrand = $brand;
        if ($request->hasFile('brand_logo')) {
            if ($brand->brand_logo != 'noimage.jpg') {
                \File::delete($brand->brand_logo);
            }
            $brand->brand_logo = $destinationPath . '/' . $brand_logo;
        }
        $brand->title = $request->title;
        $brand->view_order = $request->view_order;
        $brand->display = $request->display;
        $brand->brand_link = ($request->brand_link ? $request->brand_link : '');
        $brand->updated_at = Carbon::now()->toDateTimeString();
        $brand->save();

        $newBrand = Brand::find($id);
        //store activity log
        activity()
            ->performedOn($newBrand)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => BRAND_MODULE,
                'msg' => $newBrand->title . ' ' . UPDATED_ALERT,
                'old' => $oldBrand,
                'new' => $newBrand
            ])
            ->log(UPDATE);

        return redirect(route('brand.index'))->with('success', $newBrand->title . ' ' . UPDATED_ALERT);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Brand = Brand::where('id', $id)->first();


        if ($Brand) {

            Brand::where('id', $id)
                ->update(['delete_status' => 1]);

            //store activity log
            activity()
                ->performedOn($Brand)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => BRAND_MODULE,
                    'msg' => $Brand->title . ' ' . DELETED_ALERT,
                    'old' => $Brand,
                    'new' => null
                ])
                ->log(DELETE);

            return redirect(route('brand.index'))->with('success', $Brand->title . ' ' . DELETED_ALERT);
        } else {
            return redirect()->action('Brand\BrandsController@index')->with('error', OPPS_ALERT);

        }
    }
}
