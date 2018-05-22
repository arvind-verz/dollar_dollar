<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\PromotionFormula;
use App\PromotionTypes;
use App\PromotionProducts;
use Validator;

class ProductsController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function promotion_products() {
        $products = \Helper::getProducts();
        
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products', compact('CheckLayoutPermission', 'products'));
    }

    public function promotion_products_add() {
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products_add', compact('CheckLayoutPermission', 'promotion_types', 'formulas'));
    }

    public function promotion_products_get_formula($id) {
        $sel_query = \Helper::getAllFormula($id);
        //print_r($sel_query);
        ?>
        <option value="">None</option>
        <?php
        if(count($sel_query)) {
        foreach($sel_query as $value) { ?>
            <option value="<?php echo $value->id; ?>"><?php echo $value->name .' => '. $value->formula; ?></option>
        <?php }}
    }

    public function promotion_products_add_db(Request $request) {

        //dd($request->all());
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        

        $validate = [
            'promotion_type'        =>  'required',
            'formula_id'            =>  'required',
            'product_name'          =>  'required',
            'min_range'             =>  'required',
            'max_range'             =>  'required',
            'promotion_start'       =>  'required',
            'promotion_end'         =>  'required',
            'tenure'                =>  'required',
            'bonus_interest'        =>  'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        DB::enableQueryLog();
        $sel_query = PromotionProducts::where('promotion_type_id', $request->promotion_type)
        ->where('formula_id', $request->formula_id)
        ->where('product_name', $request->product_name)
        ->where('min_range', $request->min_range)
        ->where('max_range', $request->max_range)
        ->where('promotion_start', $request->promotion_start)
        ->where('promotion_end', $request->promotion_end)
        ->where('tenure', $request->tenure)
        ->where('bonus_interest', $request->bonus_interest)
        ->where('delete_status', 0)
        ->get();
        //dd(DB::getQueryLog());
        if(count($sel_query)>0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        else {
            $products = new PromotionProducts();
            $products->promotion_type_id    =   $request->promotion_type;
            $products->formula_id           =   $request->formula_id;
            $products->product_name         =   $request->product_name;
            $products->min_range            =   $request->min_range;
            $products->max_range            =   $request->max_range;
            $products->promotion_start      =   $request->promotion_start;
            $products->promotion_end        =   $request->promotion_end;
            $products->tenure               =   $request->tenure;
            $products->bonus_interest       =   $request->bonus_interest;
            $products->save();

            //store activity log
            activity()
                ->performedOn($products)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => 'Data ' . ADDED_ALERT,
                    'old' => $products,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success','Data ' . ADDED_ALERT);

            //return $this->promotion_formula();
        }
    }

    public function promotion_products_edit($id) {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $product = \Helper::getProduct($id);
        $formula = \Helper::productType($id);
        //dd($formula);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        
        return view('backend.products.promotion_products_edit', compact('CheckLayoutPermission', 'promotion_types', 'product', 'formula'));

    }

    public function promotion_products_update(Request $request, $id) {
        //dd($request->all());
        $product = \Helper::getProduct($id);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        

        $validate = [
            'promotion_type'        =>  'required',
            'formula_id'            =>  'required',
            'product_name'          =>  'required',
            'min_range'             =>  'required',
            'max_range'             =>  'required',
            'promotion_start'       =>  'required',
            'promotion_end'         =>  'required',
            'tenure'                =>  'required',
            'bonus_interest'        =>  'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        DB::enableQueryLog();
        $sel_query = PromotionProducts::where('promotion_type_id', $request->promotion_type)
        ->where('formula_id', $request->formula_id)
        ->where('product_name', $request->product_name)
        ->where('min_range', $request->min_range)
        ->where('max_range', $request->max_range)
        ->where('promotion_start', $request->promotion_start)
        ->where('promotion_end', $request->promotion_end)
        ->where('tenure', $request->tenure)
        ->where('bonus_interest', $request->bonus_interest)
        ->where('delete_status', 0)
        ->get();
        //dd(DB::getQueryLog());
        if(count($sel_query)>0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        else {
            $product->promotion_type_id    =   $request->promotion_type;
            $product->formula_id           =   $request->formula_id;
            $product->product_name         =   $request->product_name;
            $product->min_range            =   $request->min_range;
            $product->max_range            =   $request->max_range;
            $product->promotion_start      =   $request->promotion_start;
            $product->promotion_end        =   $request->promotion_end;
            $product->tenure               =   $request->tenure;
            $product->bonus_interest       =   $request->bonus_interest;
            $product->save();

            //store activity log
            activity()
                ->performedOn($product)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => 'Data ' . UPDATED_ALERT,
                    'old' => $product,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products')->with('success','Data ' . UPDATED_ALERT);

            //return $this->promotion_formula();
        }

    }

    public function promotion_products_remove($id) {
        $sel_query = PromotionFormula::where('id', $id)->first();
        $sel_query->delete_status = 1;
        $sel_query->save();
        //dd($sel_query);
        //store activity log
            activity()
                ->performedOn($sel_query)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $sel_query->name . ' ' . DELETED_ALERT,
                    'old' => $sel_query,
                    'new' => null])
                ->log(CREATE);

        
        return redirect()->action('Products\ProductsController@promotion_products_add')->with('error', "Data" . ' ' . DELETED_ALERT);
    }

    public function promotion_formula() {
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();

        //dd($formulas);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_formula', compact('CheckLayoutPermission', 'promotion_types', 'formulas'));
    }

    public function promotion_formula_db(Request $request) {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        

        $validate = [
            'promotion_type'    =>  'required',
            'formula_name'      =>  'required',
            'formula'           =>  'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        DB::enableQueryLog();
        $sel_query = PromotionFormula::where('promotion_id', $request->promotion_type)
        ->where('name', $request->formula_name)
        ->where('formula', $request->formula)
        ->where('delete_status', 0)
        ->get();
        //dd(DB::getQueryLog());
        if(count($sel_query)>0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        else {
            $formula_store = new PromotionFormula();
            $formula_store->promotion_id = $request->promotion_type;
            $formula_store->name = $request->formula_name;
            $formula_store->formula = $request->formula;
            $formula_store->save();

            //store activity log
            activity()
                ->performedOn($formula_store)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $formula_store->name . ' ' . ADDED_ALERT,
                    'old' => $formula_store,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_formula')->with('success', $formula_store->name . ' ' . ADDED_ALERT);

            //return $this->promotion_formula();
        }
    }

    public function promotion_formula_edit($id) {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formula = \Helper::getFormula($id);
        //dd($formulas);

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        
        return view('backend.products.promotion_formula_edit', compact('CheckLayoutPermission', 'promotion_types', 'formula'));

    }

    public function promotion_formula_update(Request $request, $id) {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula($id);
        //dd($formulas);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        

        $validate = [
            'promotion_type'    =>  'required',
            'formula_name'      =>  'required',
            'formula'           =>  'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        DB::enableQueryLog();
        $sel_query = PromotionFormula::where('promotion_id', $request->promotion_type)
        ->where('name', $request->formula_name)
        ->where('formula', $request->formula)
        ->where('delete_status', 0)
        ->where('id', '<>', $id)
        ->get();
        //dd(DB::getQueryLog());
        if(count($sel_query)>0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        else {
            $formulas->promotion_id = $request->promotion_type;
            $formulas->name = $request->formula_name;
            $formulas->formula = $request->formula;
            $formulas->save();

            //store activity log
            activity()
                ->performedOn($formulas)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $formulas->name . ' ' . UPDATED_ALERT,
                    'old' => $formulas,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_formula')->with('success',  'Data ' . UPDATED_ALERT);

            //return $this->promotion_formula();
        }

    }

    public function promotion_formula_remove($id) {
        $sel_query = PromotionFormula::where('id', $id)->first();
        $sel_query->delete_status = 1;
        $sel_query->save();
        //dd($sel_query);
        //store activity log
            activity()
                ->performedOn($sel_query)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $sel_query->name . ' ' . DELETED_ALERT,
                    'old' => $sel_query,
                    'new' => null])
                ->log(CREATE);

        
        return redirect()->action('Products\ProductsController@promotion_formula')->with('error', "Data" . ' ' . DELETED_ALERT);
    }

    public function bank_products() {
        
    }
}
