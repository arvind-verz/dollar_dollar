<?php

namespace App\Http\Controllers\Products;

use App\FormulaVariable;
use App\PlacementRange;
use App\ProductName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Brand;
use App\PromotionFormula;
use App\PromotionTypes;
use App\PromotionProducts;
use Validator;
use  App\Rules\MaxRule;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function promotion_products()
    {
        $products = \Helper::getProducts();

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products', compact('CheckLayoutPermission', 'products'));
    }

    public function promotion_products_add()
    {


        //dd($formulaDetails);

        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();
        $banks = Brand::where('delete_status', 0)->orderBy('title', 'asc')->get();
        $products = PromotionProducts::where('delete_status', 0)->whereNotNull('product_name_id')->groupBy('product_name_id')->get();
        $alreadyStoreProductNamesId = [];
        if ($products->count()) {
            $alreadyStoreProductNamesId = $products->pluck('product_name_id')->all();
            //dd($alreadyStoreProductNamesId);
        }
        $product_names = ProductName::whereNotIn('id', $alreadyStoreProductNamesId)
            ->orderBy('product_name', 'asc')->get();

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products_add', compact('CheckLayoutPermission', 'promotion_types', 'formulas', 'banks', 'product_names'));
    }

    public function promotion_products_get_formula(Request $request)
    {
        $sel_query = \Helper::getAllFormula($request->promotion_type);


        //print_r($sel_query);
        ?>
        <option value="">None</option>
        <?php
        if ($sel_query->count()) {
            foreach ($sel_query as $value) { ?>
                <option
                    value="<?php echo $value->id; ?>" <?php if ($value->id == $request->formula) echo "selected=selected"; ?> ><?php echo $value->name ?></option>
            <?php }
        }
    }

    public function promotion_products_add_db(Request $request)
    {

        //dd($request->all());
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);


        $validate = [
            'name' => 'required',
            'bank' => 'required',
            'product_type' => 'required',
            'formula' => 'required',
            'promotion_start_date' => 'required|date',
            'promotion_end_date' => 'required|date|after_or_equal:promotion_start_date',
        ];
        /*DB::enableQueryLog();
        $productDetail = PromotionProducts::where('name', $request->name)
            ->where('delete_status', 0)
            ->get();
        if ($productDetail->count() > 0) {
            $validate['name'] = 'required|unique:promotion_products';
        } else {
            $validate['name'] = 'required';
        }*/
        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        //set day of time before one second and end of day after one second for between date
        $startDate = \Helper::startOfDayBefore($request->start_date);
        $endDate = \Helper::endOfDayAfter($request->end_date);

        $sel_query = PromotionProducts::where('promotion_type_id', $request->product_type)
            ->where('formula_id', $request->formula)
            ->where('bank_id', $request->bank)
            ->where('min_range', $request->min_placement)
            ->where('max_range', $request->max_placement)
            ->where('promotion_start', $startDate)
            ->where('promotion_end', $endDate)
            ->where('tenure', $request->tenure)
            ->where('bonus_interest', $request->bonus_interest)
            ->where('delete_status', 0)
            ->get();
        //dd(DB::getQueryLog());
        if ($sel_query->count() > 0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $products = new PromotionProducts();
            $destinationPath = 'uploads/products'; // upload path
            $adPoster = null;
            if (!is_dir('uploads')) {
                mkdir('uploads');
            }

            if (!is_dir('uploads/products')) {
                mkdir('uploads/products');
            }


            if ($request->hasFile('ad_poster')) {

                // Get filename with the extension
                $filenameWithExt = $request->file('ad_poster')->getClientOriginalName();
                // Get just filename
                $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
                // Get just ext
                $extension = $request->file('ad_poster')->getClientOriginalExtension();
                // Filename to store
                $adPoster = $filename . '_' . time() . '.' . $extension;
                // Upload Image
                $request->file('ad_poster')->move($destinationPath, $adPoster);
            }
            $product = new PromotionProducts();
            $product->name = $request->name;
            $product->bank_id = $request->bank;
            $product->promotion_type_id = $request->product_type;
            $product->formula_id = $request->formula;

            $product->min_range = $request->min_placement;
            $product->max_range = $request->max_placement;
            $product->promotion_start = $request->promotion_start_date;
            $product->promotion_end = $request->promotion_end_date;
            $product->tenure = $request->tenure;
            $product->bonus_interest = $request->bonus_interest;
            $product->criteria = $request->criteria;
            $product->key_points = $request->key_points;
            $product->ad_type = $request->ad_type;
            $product->ad_link = $request->ad_link;
            $product->main_page_link = $request->main_page_link;
            $product->tc_link = $request->tc_link;
            $product->status = $request->status;
            $product->featured = $request->featured;
            if ($request->hasFile('ad_poster')) {
                if ($product->ad_image != null) {
                    \File::delete($product->ad_image);
                }
                $product->ad_image = $destinationPath . '/' . $adPoster;
            }
            $product->save();

            //store activity log
            activity()
                ->performedOn($products)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => 'Data ' . ADDED_ALERT,
                    'old' => $product,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', $product->name . ADDED_ALERT);

            //return $this->promotion_formula();
        }
    }

    public function promotion_products_edit($id)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $product = \Helper::getProduct($id);
        $formula = \Helper::productType($id);
        $banks = Brand::where('delete_status', 0)->orderBy('title', 'asc')->get();

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        return view('backend.products.promotion_products_edit', compact('CheckLayoutPermission', 'promotion_types', 'product', 'formula', 'banks'));

    }

    public function promotion_products_update(Request $request, $id)
    {
        //dd($request->all());
        $product = \Helper::getProduct($id);
        if (!$product) {
            return redirect()->action('Products\ProductsController@promotion_products')->with('error', OPPS_ALERT);
        }

        $oldProduct = $product;
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        $validate = [
            'bank' => 'required',
            'product_type' => 'required',
            'formula' => 'required',
            'min_placement' => 'required',
            'max_placement' => 'required',
            'promotion_start_date' => 'required|date|before_or_equal:promotion_start_date',
            'promotion_end_date' => 'required|date|after_or_equal:promotion_end_date',
            'tenure' => 'required',
            'bonus_interest' => 'required',
            'ad_poster' => 'image|nullable|max:1999',
        ];
        DB::enableQueryLog();
        $productDetail = PromotionProducts::where('name', $request->name)
            ->where('delete_status', 0)
            ->whereNotIn('id', [$id])
            ->get();
        if ($productDetail->count() > 0) {
            $validate['name'] = 'required|unique:promotion_products';
        } else {
            $validate['name'] = 'required';
        }

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        //set day of time before one second and end of day after one second for between date
        $startDate = \Helper::startOfDayBefore($request->start_date);
        $endDate = \Helper::endOfDayAfter($request->end_date);

        $sel_query = PromotionProducts::where('promotion_type_id', $request->product_type)
            ->where('formula_id', $request->formula)
            ->where('bank_id', $request->bank)
            ->where('min_range', $request->min_placement)
            ->where('max_range', $request->max_placement)
            ->where('promotion_start', $startDate)
            ->where('promotion_end', $endDate)
            ->where('tenure', $request->tenure)
            ->where('bonus_interest', $request->bonus_interest)
            ->whereNotIn('id', [$id])
            ->where('delete_status', 0)
            ->get();
        //dd(DB::getQueryLog());
        if ($sel_query->count() > 0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $destinationPath = 'uploads/products'; // upload path
            $adPoster = null;
            if (!is_dir('uploads')) {
                mkdir('uploads');
            }

            if (!is_dir('uploads/products')) {
                mkdir('uploads/products');
            }


            if ($request->hasFile('ad_poster')) {

                // Get filename with the extension
                $filenameWithExt = $request->file('ad_poster')->getClientOriginalName();
                // Get just filename
                $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
                // Get just ext
                $extension = $request->file('ad_poster')->getClientOriginalExtension();
                // Filename to store
                $adPoster = $filename . '_' . time() . '.' . $extension;
                // Upload Image
                $request->file('ad_poster')->move($destinationPath, $adPoster);
            }
            $product->name = $request->name;
            $product->bank_id = $request->bank;
            $product->promotion_type_id = $request->product_type;
            $product->formula_id = $request->formula;

            $product->min_range = $request->min_placement;
            $product->max_range = $request->max_placement;
            $product->promotion_start = $request->promotion_start_date;
            $product->promotion_end = $request->promotion_end_date;
            $product->tenure = $request->tenure;
            $product->bonus_interest = $request->bonus_interest;
            $product->criteria = $request->criteria;
            $product->key_points = $request->key_points;
            $product->ad_type = $request->ad_type;
            $product->ad_link = $request->ad_link;
            $product->main_page_link = $request->main_page_link;
            $product->tc_link = $request->tc_link;
            $product->status = $request->status;
            $product->featured = $request->featured;
            if ($request->hasFile('ad_poster')) {
                if ($product->ad_image != null) {
                    \File::delete($product->ad_image);
                }
                $product->ad_image = $destinationPath . '/' . $adPoster;
            }
            $product->save();

            $newProduct = PromotionProducts::find($id);
            //store activity log
            activity()
                ->performedOn($product)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $newProduct->name . ' ' . UPDATED_ALERT,
                    'old' => $oldProduct,
                    'new' => $newProduct])
                ->log(UPDATE);


            return redirect()->action('Products\ProductsController@promotion_products')->with('success', $newProduct->name . UPDATED_ALERT);

            //return $this->promotion_formula();
        }

    }

    public function promotion_products_remove($id)
    {
        $sel_query = PromotionProducts::where('id', $id)->first();
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


        return redirect()->action('Products\ProductsController@promotion_products')->with('error', "Data" . ' ' . DELETED_ALERT);
    }

    public function promotion_formula()
    {
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();

        //dd($formulas);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_formula', compact('CheckLayoutPermission', 'promotion_types', 'formulas'));
    }

    public function promotion_formula_db(Request $request)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);


        $validate = [
            'promotion_type' => 'required',
            'formula_name' => 'required',
            'formula' => 'required'
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
        if (count($sel_query) > 0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
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

    public function promotion_formula_edit($id)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formula = \Helper::getFormula($id);
        //dd($formulas);

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        return view('backend.products.promotion_formula_edit', compact('CheckLayoutPermission', 'promotion_types', 'formula'));

    }

    public function promotion_formula_update(Request $request, $id)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula($id);
        //dd($formulas);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);


        $validate = [
            'promotion_type' => 'required',
            'formula_name' => 'required',
            'formula' => 'required'
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
        if (count($sel_query) > 0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
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


            return redirect()->action('Products\ProductsController@promotion_formula')->with('success', 'Data ' . UPDATED_ALERT);

            //return $this->promotion_formula();
        }

    }

    public function promotion_formula_remove($id)
    {
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

    public function addProductName(Request $request)
    {
        $validate = [
            'product_name' => 'required|unique:product_names',
        ];

        $validator = Validator::make($request->all(), $validate);

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $productName = New ProductName();
            $productName->product_name = $request->product_name;
            $productName->save();

            //store activity log
            activity()
                ->performedOn($productName)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_NAME_MODULE_SINGLE,
                    'msg' => $productName->product_name . ' ' . ADDED_ALERT,
                    'old' => $productName,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', $productName->product_name . ' ' . ADDED_ALERT);

        }

    }

    public function addPriceRange(Request $request)
    {

        $validate = ['product_name' => 'required'];
        $validate['min_placement'] = ['required', 'not_in:0', 'numeric', new MaxRule($request->max_placement, 'max_placement')];
        $validate['max_placement'] = 'required|not_in:0|numeric';
        $validator = Validator::make($request->all(), $validate);

        $minPlacementRange = $request->min_placement;
        $maxPlacementRange = $request->max_placement;
        $placementRange = PlacementRange::where(function ($query) use ($minPlacementRange, $maxPlacementRange) {
            $query->whereBetween('min_placement_range', [$minPlacementRange, $maxPlacementRange])
                ->orWhereBetween('max_placement_range', [$minPlacementRange, $maxPlacementRange])
                ->orWhere(function ($query) use ($minPlacementRange, $maxPlacementRange) {
                    $query->where('min_placement_range', '<=', $minPlacementRange)
                        ->where('max_placement_range', '>=', $maxPlacementRange);
                });
        })->first();
        if ($placementRange) {
            $validator->getMessageBag()->add('Placement range', 'The placement range' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $placementRange = New PlacementRange();
            $placementRange->product_name_id = $request->product_name;
            $placementRange->min_placement_range = $request->min_placement;
            $placementRange->max_placement_range = $request->max_placement;
            $placementRange->save();

            //store activity log
            activity()
                ->performedOn($placementRange)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PLACEMENT_RANGE_MODULE_SINGLE,
                    'msg' => $placementRange->min_placement_range . ' - ' . $placementRange->max_placement_range . ' range ' . ADDED_ALERT,
                    'old' => $placementRange,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', $placementRange->min_placement_range . ' - ' . $placementRange->max_placement_range . ' range ' . ADDED_ALERT);

        }

    }

    public function addFormulaDetail(Request $request)
    {
        $validate = ['product_name' => 'required'];
        $validate['placement_range'] = ['required'];
        $validate['tenure'] = ['required', 'not_in:0', 'integer'];
        $validate['bonus_interest'] = 'required|not_in:0|numeric';
        $validator = Validator::make($request->all(), $validate);

        $oldFormulaDetail = FormulaVariable::where('product_name_id', $request->product_name)
            ->where('placement_range_id', $request->placement_range)
            ->where('tenure', $request->tenure)
            ->where('bonus_interest', $request->bonus_interest)
            ->first();

        if ($oldFormulaDetail) {
            $validator->getMessageBag()->add('Formula detail', 'The formula detail' . ' ' . ALREADY_TAKEN_ALERT);

        }

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $formulaDetail = New FormulaVariable();
            $formulaDetail->product_name_id = $request->product_name;
            $formulaDetail->placement_range_id = $request->placement_range;
            $formulaDetail->tenure = $request->tenure;
            $formulaDetail->bonus_interest = $request->bonus_interest;
            $formulaDetail->save();

            //store activity log
            activity()
                ->performedOn($formulaDetail)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => FORMULA_DETAIL_MODULE_SINGLE,
                    'msg' => 'Formula detail ' . ADDED_ALERT,
                    'old' => $formulaDetail,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', 'Formula detail ' . ADDED_ALERT);

        }

    }

    public function getPlacementRange(Request $request)
    {
        $placementRanges = PlacementRange::where('product_name_id', $request->formula_product_id)->get();
        ?>
        <option value="">None</option>
        <?php
        if ($placementRanges->count()) {
            foreach ($placementRanges as $placementRange) { ?>
                <option
                    value="<?php echo $placementRange->id; ?>" <?php if ($placementRange->id == $request->placement_range) echo "selected=selected"; ?> ><?php echo $placementRange->min_placement_range . ' - ' . $placementRange->max_placement_range ?></option>
            <?php }
        }
    }

    public function getFormulaDetail(Request $request)
    {
        $formulaDetails = FormulaVariable::join('placement_range', 'formula_variables.placement_range_id', 'placement_range.id')
            ->join('product_names', 'formula_variables.product_name_id', 'product_names.id')
            ->where('formula_variables.delete_status', 0)
            ->where('formula_variables.product_name_id', $request->product_name_id)
            ->select('formula_variables.*', 'placement_range.min_placement_range', 'placement_range.max_placement_range', 'product_names.product_name')
            ->get();
        if ($formulaDetails->count()) {
            $formulaDetails = array_values($formulaDetails->groupBy('placement_range_id')->toArray());
        }
       // dd($formulaDetails);
        if (count($formulaDetails)) {
            foreach ($formulaDetails as $formulaDetail) {
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div class="box box-primary direct-chat direct-chat-primary collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo $formulaDetail[0]['min_placement_range'] . ' - ' . $formulaDetail[0]['max_placement_range'] ?></h3>

                                <div class="box-tools pull-right">

                                    <button type="button" class="btn btn-box-tool list "
                                            data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool edit"
                                            data-toggle="tooltip"
                                            title="Edit" data-widget="chat-pane-toggle">
                                        <i class="fa fa-pencil "></i></button>
                                    <button type="button" class="btn btn-box-tool delete"
                                            data-widget="remove">
                                        <i class="fa fa-trash "></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <!-- /.direct-chat-pane -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">

                            </div>
                            <!-- /.box-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>

                </div>
                <!-- AdminLTE App -->
                <!--<script src="../public/backend/dist/js/adminlte.min.js"></script>-->
                <?php
            }
        }
    }
}
