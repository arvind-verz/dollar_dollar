<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RateType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\PromotionProducts;
use Illuminate\Support\Facades\Validator;


class RateTypeController extends Controller
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
    public function index($rateType = LOAN)
    {
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        $rateTypes = RateType::where('delete_status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view("backend.products.rateTypes.index", compact("rateTypes", "CheckLayoutPermission"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->create_permission(@Auth::user()->role_type_id, PRODUCT_ID) == 0) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }

        return view("backend.products.rateTypes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $fields = [
            'name' => 'required|unique:rate_types,name,',
            'interest_rate' => 'required',
        ];
        $validator = Validator::make($request->all(), $fields);
        $rateType = RateType::where('delete_status', 0)->where('name', $request->name)->first();
        if ($rateType) {
            $validator->getMessageBag()->add('name', $request->name . '' . ADDED_ERROR_ALERT);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $rateType = new RateType();
        $rateType->name = $request->name;
        $rateType->interest_rate = $request->interest_rate;
        $rateType->updated_at = null;
        $rateType->save();
        //store activity log
        activity()
            ->withProperties(['ip' => \Request::ip(),
                'module' => RATE_TYPE_MODULE,
                'msg' => $request->name . ' ' . ADDED_ALERT,
                'old' => null,
                'new' => $rateType])
            ->log(CREATE);

        return redirect()->action('Products\RateTypeController@index')->with('success', $request->name . ' ' . ADDED_ALERT);
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
        if ($this->edit_permission(@Auth::user()->role_type_id, PRODUCT_ID) == 0) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }

        $rateType = RateType::find($id);
        if (!$rateType) {
            return redirect()->action('Products\RateTypeController@index')->with('error', OPPS_ALERT);
        }

        return view("backend.products.rateTypes.edit", compact("rateType"));
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
            'name' => 'required|unique:rate_types,name,' . $id,
            'interest_rate' => 'required'
        ]);
        $rateType = RateType::find($id);
        $oldRateType = $rateType;

        if (!$rateType) {
            return redirect()->action('Products\RateTypeController@index')->with('error', OPPS_ALERT);
        }

        $products = PromotionProducts::where('promotion_type_id', 6)->whereNotNull('product_range')->get();
        if ($products->count()) {
            foreach ($products as $product) {
                $productRanges = json_decode($product->product_range);
                $changeStatus =0;
                if (count($productRanges)) {
                    foreach ($productRanges as &$range) {
                        if(isset($range->floating_rate_type) && ($range->floating_rate_type == $rateType->name)){
                            $range->floating_rate_type = $request->name;
                            $range->bonus_interest = $request->interest_rate;
                            $changeStatus = 1;
                        }


                        if(isset($range->there_after_rate_type) && ($range->there_after_rate_type == $rateType->name)){
                            $range->there_after_rate_type = $request->name;
                            $range->there_after_bonus_interest = $request->interest_rate;
                            $changeStatus = 1;
                        }


                    }
                }
                $product->product_range = json_encode($productRanges);

            if($changeStatus == 1){
                $product->save();
                //dd($product);
            }

            }
        }
        $rateType->name = $request->name;
        $rateType->interest_rate = $request->interest_rate;
        $rateType->updated_at = Carbon::now()->toDateTimeString();
        $rateType->save();
        $newRateType = RateType::find($id);
        //store activity log
        activity()
            ->performedOn($newRateType)
            ->withProperties([
                'ip' => \Request::ip(),
                'module' => RATE_TYPE_MODULE,
                'msg' => $newRateType->name . ' ' . UPDATED_ALERT,
                'old' => $oldRateType,
                'new' => $newRateType
            ])
            ->log(UPDATE);
        return redirect()->action('Products\RateTypeController@index')->with('success', $newRateType->name . ' ' . UPDATED_ALERT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->delete_permission(@Auth::user()->role_type_id, 4) == PRODUCT_ID) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }
        $rateType = RateType::where('id', $id)->first();
        if (!$rateType) {
            return redirect()->action('Products\RateTypeController@index')->with('error', OPPS_ALERT);
        } else {
            $rateType->delete_status = 1;
            $rateType->save();
            //store log of activity
            activity()
                ->performedOn($rateType)
                ->withProperties([
                    'ip' => \Request::ip(),
                    'module' => PRODUCT_ID,
                    'msg' => $rateType->name . ' ' . DELETED_ALERT,
                    'old' => $rateType,
                    'new' => null
                ])
                ->log(DELETE);
            return redirect()->action('Products\RateTypeController@index')->with('success', $rateType->name . ' ' . DELETED_ALERT);
        }
    }
}
