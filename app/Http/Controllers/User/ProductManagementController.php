<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\ProductManagement;
use App\Page;
use App\Brand;
use Auth;
use App\AdsManagement;
use Route;

class ProductManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validate = Validator::make($request->all(), [
            'bank_id' => 'required',
            'amount' => 'required|numeric',
            'interest_earned' => 'nullable'
        ]);
        if ($validate->fails()) {
            return redirect('product-management')
                ->withErrors($validate)
                ->withInput();
        } else {

            $product_management = new ProductManagement();
            $product_management->user_id = Auth::user()->id;
            $product_management->bank_id = $request->bank_id;
            $product_management->other_bank = $request->bank_id_other;
            $product_management->account_name = $request->account_name;
            $product_management->amount = $request->amount;
            $product_management->tenure = $request->tenure;
            $product_management->product_reminder = json_encode($request->reminder);
            if ($request->start_date) {
                $product_management->start_date = \Helper::startOfDayBefore($request->start_date);
            } else {
                $product_management->start_date = null;
            }
            if ($request->end_date) {
                $product_management->end_date = \Helper::endOfDayAfter($request->end_date);
            } else {
                $product_management->end_date = null;
            }
            $product_management->interest_earned = $request->interest_earned;
            $product_management->save();
        }
        return back()->with('success', 'Data ' . ADDED_ALERT);
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
        //dd(Route::current());
        $ads = AdsManagement::where('delete_status', 0)
                    ->where('display', 1)
                    ->where('page', 'account')
                    ->inRandomOrder()
                    ->limit(1)
                    ->get();
        $page = Page::LeftJoin('menus', 'menus.id', '=', 'pages.menu_id')
            ->where('pages.slug', 'product-management')
            ->where('pages.delete_status', 0)
            ->where('pages.status', 1)
            ->select('pages.*', 'menus.title as menu_title', 'menus.id as menu_id')
            ->first();

        $brands = Brand::where('delete_status', 0)->where('display', 1)->orderBy('title', 'asc')->get();

        $product_management = ProductManagement::find($id);
        //dd($product_management);

        return view('frontend.user.product-management-edit', compact("product_management", "page", "brands", "ads"));
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

        $product_management = ProductManagement::find($id);
        $validate = Validator::make($request->all(), [
            'bank_id' => 'required',
            'amount' => 'required|numeric',
            'interest_earned' => 'nullable'
        ]);
        if ($validate->fails()) {
            return redirect('product-management')
                ->withErrors($validate)
                ->withInput();
        } else {
            $product_management->bank_id = $request->bank_id;
            $product_management->other_bank = $request->bank_id_other;
            $product_management->account_name = $request->account_name;
            $product_management->amount = $request->amount;
            $product_management->tenure = $request->tenure;
            $product_management->product_reminder = json_encode($request->reminder);
            if ($request->start_date) {
                $product_management->start_date = \Helper::startOfDayBefore($request->start_date);
            } else {
                $product_management->start_date = null;
            }
            if ($request->end_date) {
                $product_management->end_date = \Helper::endOfDayAfter($request->end_date);
            } else {
                $product_management->end_date = null;
            }
            $product_management->interest_earned = $request->interest_earned;
            $product_management->save();
        }
        return redirect('product-management')->with('success', 'Data ' . UPDATED_ALERT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        $product_management = ProductManagement::find($id);
        $product_management->delete();
        return back()->with('success', 'Data ' . DELETED_ALERT);
    }
}
