<?php

namespace App\Http\Controllers\Products;

use App\Brand;
use App\FormulaVariable;
use App\Http\Controllers\Controller;
use App\PlacementRange;
use App\ProductName;
use App\PromotionFormula;
use App\PromotionProducts;
use App\Rules\MaxRule;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

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

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products_add', compact('CheckLayoutPermission', 'promotion_types', 'formulas', 'banks'));
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

        $destinationPath = 'uploads/products'; // upload path
        $adHorizontalImage = null;
        $adVerticalImage = null;
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/products')) {
            mkdir('uploads/products');
        }


        if ($request->hasFile('ad_horizontal_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image')->move($destinationPath, $adHorizontalImage);
        }
        if ($request->hasFile('ad_image_vertical')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_image_vertical')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_image_vertical')->getClientOriginalExtension();
            // Filename to store
            $adVerticalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_image_vertical')->move($destinationPath, $adVerticalImage);
        }

        $product = new PromotionProducts();

        $product->product_name = $request->name;
        $product->bank_id = $request->bank;
        $product->promotion_type_id = $request->product_type;
        $product->formula_id = $request->formula;
        $product->promotion_period = $request->promotion_period;
        $product->maximum_interest_rate = $request->maximum_interest_rate;
        $product->minimum_placement_amount = $request->minimum_placement_amount;

        $ranges = [];
        if ($product->formula_id == FIX_DEPOSIT_F1) {
            foreach ($request->min_placement as $k => $v) {
                $max = $request->max_placement;
                $bonusInterest = $request->bonus_interest;
                $range = [];
                $range['min_range'] = (int)$v;
                $range['max_range'] = (int)$max[$k];
                $range['bonus_interest'] = array_map('floatVal', $bonusInterest[$k]);
                $ranges[] = $range;

            }
            $tenure = $request->tenure;
            $tenure = json_encode(array_map('intVal', $tenure[0]));
            $ranges = json_encode($ranges);
            $product->tenure = $tenure;
        }
        if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2, SAVING_DEPOSIT_F4])) {
            foreach ($request->min_placement_sdp1 as $k => $v) {
                $max = $request->max_placement_sdp1;
                $bonusInterest = $request->bonus_interest_sdp1;
                $boardInterest = $request->board_rate_sdp1;
                $range = [];
                if ($product->formula_id == SAVING_DEPOSIT_F2) {
                    $range['tenor'] = 3;

                }
                $range['min_range'] = (int)$v;
                $range['max_range'] = (int)$max[$k];
                $range['bonus_interest'] = (float)$bonusInterest[$k];
                $range['board_rate'] = (float)$boardInterest[$k];
                $ranges[] = $range;
            }
            $ranges = json_encode($ranges);
        }
        if (in_array($product->formula_id, [SAVING_DEPOSIT_F3])) {
            $range['min_range'] = (int)$request->min_placement_sdp3;
            $range['max_range'] = (int)$request->max_placement_sdp3;
            $range['counter'] = json_encode(array_map('floatVal', $request->counter_sdp3));
            $range['air'] = (float)$request->air_sdp3;
            $range['sibor_rate'] = (float)$request->sibor_rate_sdp3;
            $ranges[] = $range;

            $ranges = json_encode($ranges);
        }
        if (in_array($product->formula_id, [SAVING_DEPOSIT_F5])) {
            $range['min_range'] = (int)$request->min_placement_sdp5;
            $range['max_range'] = (int)$request->max_placement_sdp5;
            $range['base_interest'] = (float)$request->base_interest_sdp5;
            $range['bonus_interest'] = (float)$request->bonus_interest_sdp5;
            $range['placement_month'] = (int)$request->placement_month_sdp5;
            $range['display_month'] = (int)$request->display_month_sdp5;
            $ranges[] = $range;
            $ranges = json_encode($ranges);
        }
        function intVal($x)
        {
            return (int)$x;
        }
        function floatVal($x)
        {
            return (float)$x;
        }
        $product->product_range = $ranges;
        $product->promotion_start = \Helper::startOfDayBefore($request->start_date);
        $product->promotion_end = \Helper::endOfDayAfter($request->end_date);
        $product->product_footer = $request->product_footer;

        if ($request->hasFile('ad_horizontal_image')) {
            $adHorizontal['ad_image_horizontal'] = $destinationPath . '/' . $adHorizontalImage;
        }
        if ($request->hasFile('ad_image_vertical')) {

            $adVertical['ad_image_vertical'] = $destinationPath . '/' . $adVerticalImage;
        }

        $adHorizontal['ad_link_horizontal'] = $request->ad_horizontal_link;
        $adVertical['ad_link_vertical'] = $request->ad_vertical_link;
        $adsPlacement = [$adHorizontal, $adVertical];

        $product->ads_placement = json_encode($adsPlacement);

        $product->status = $request->status;
        $product->featured = $request->featured;
        $product->save();

        //store activity log
        activity()
            ->performedOn($product)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PRODUCT_MODULE,
                'msg' => $product->product_name . ADDED_ALERT,
                'old' => $product,
                'new' => null])
            ->log(CREATE);


        return redirect()->action('Products\ProductsController@promotion_products')->with('success', $product->product_name . ADDED_ALERT);

        //return $this->promotion_formula();

    }

    public function promotion_products_edit($id)
    {
        $promotion_types = \Helper::getPromotionType();
        $product = \Helper::getProduct($id);
        $product->product_range = json_decode($product->product_range);
        //dd($product);
        $formula = \Helper::productType($id);
        $banks = Brand::where('delete_status', 0)->orderBy('title', 'asc')->get();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products_edit', compact('CheckLayoutPermission', 'promotion_types', 'product', 'formula', 'banks'));

    }

    public function promotion_products_update(Request $request, $id)
    {
        $product = \Helper::getProduct($id);
        $ads = $product->ads_placement;

        if (!$product) {
            return redirect()->action('Products\ProductsController@promotion_products')->with('error', OPPS_ALERT);
        }

        $oldProduct = $product;

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        $destinationPath = 'uploads/products'; // upload path
        $adHorizontalImage = null;
        $adVerticalImage = null;
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/products')) {
            mkdir('uploads/products');
        }


        if ($request->hasFile('ad_horizontal_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image')->move($destinationPath, $adHorizontalImage);
        }
        if ($request->hasFile('ad_image_vertical')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_image_vertical')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_image_vertical')->getClientOriginalExtension();
            // Filename to store
            $adVerticalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_image_vertical')->move($destinationPath, $adVerticalImage);
        }

        $product->product_name = $request->name;
        $product->bank_id = $request->bank;
        $product->promotion_type_id = $request->product_type;
        $product->formula_id = $request->formula;
        $product->promotion_period = $request->promotion_period;
        $product->maximum_interest_rate = $request->maximum_interest_rate;
        $product->minimum_placement_amount = $request->minimum_placement_amount;

        $ranges = [];
        if ($product->formula_id == FIX_DEPOSIT_F1) {
            foreach ($request->min_placement as $k => $v) {
                $max = $request->max_placement;
                $bonusInterest = $request->bonus_interest;
                $range = [];
                $range['min_range'] = (int)$v;
                $range['max_range'] = (int)$max[$k];
                $range['bonus_interest'] = array_map('floatVal', $bonusInterest[$k]);
                $ranges[] = $range;

            }
            $tenure = $request->tenure;
            $tenure = json_encode(array_map('intVal', $tenure[0]));
            $ranges = json_encode($ranges);
            $product->tenure = $tenure;
        }
        if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2, SAVING_DEPOSIT_F4])) {
            foreach ($request->min_placement_sdp1 as $k => $v) {
                $max = $request->max_placement_sdp1;
                $bonusInterest = $request->bonus_interest_sdp1;
                $boardInterest = $request->board_rate_sdp1;
                $range = [];
                if ($product->formula_id == SAVING_DEPOSIT_F2) {
                    $range['tenor'] = 3;

                }
                $range['min_range'] = (int)$v;
                $range['max_range'] = (int)$max[$k];
                $range['bonus_interest'] = (float)$bonusInterest[$k];
                $range['board_rate'] = (float)$boardInterest[$k];
                $ranges[] = $range;
            }
            $ranges = json_encode($ranges);
        }
        if (in_array($product->formula_id, [SAVING_DEPOSIT_F3])) {
            $range['min_range'] = (int)$request->min_placement_sdp3;
            $range['max_range'] = (int)$request->max_placement_sdp3;
            $range['counter'] = json_encode(array_map('floatVal', $request->counter_sdp3));
            $range['air'] = (float)$request->air_sdp3;
            $range['sibor_rate'] = (float)$request->sibor_rate_sdp3;
            $ranges[] = $range;

            $ranges = json_encode($ranges);
        }
        if (in_array($product->formula_id, [SAVING_DEPOSIT_F5])) {
            $range['min_range'] = (int)$request->min_placement_sdp5;
            $range['max_range'] = (int)$request->max_placement_sdp5;
            $range['base_interest'] = (float)$request->base_interest_sdp5;
            $range['bonus_interest'] = (float)$request->bonus_interest_sdp5;
            $range['placement_month'] = (int)$request->placement_month_sdp5;
            $range['display_month'] = (int)$request->display_month_sdp5;
            $ranges[] = $range;
            $ranges = json_encode($ranges);
        }

        function intVal($x)
        {
            return (int)$x;
        }
        function floatVal($x)
        {
            return (float)$x;
        }

        $product->product_range = $ranges;
        $product->promotion_start = \Helper::startOfDayBefore($request->start_date);
        $product->promotion_end = \Helper::endOfDayAfter($request->end_date);
        $product->product_footer = $request->product_footer;

        if ($request->hasFile('ad_horizontal_image')) {
            $adHorizontal['ad_image_horizontal'] = $destinationPath . '/' . $adHorizontalImage;
        } else {
            $adHorizontal['ad_image_horizontal'] = isset($ads[0]->ad_image_horizontal) ? $ads[0]->ad_image_horizontal : null;
        }
        if ($request->hasFile('ad_image_vertical')) {

            $adVertical['ad_image_vertical'] = $destinationPath . '/' . $adVerticalImage;
        } else {
            $adHorizontal['ad_image_vertical'] = isset($ads[1]->ad_image_vertical) ? $ads[1]->ad_image_vertical : null;
        }

        $adHorizontal['ad_link_horizontal'] = $request->ad_horizontal_link;
        $adVertical['ad_link_vertical'] = $request->ad_vertical_link;
        $adsPlacement = [$adHorizontal, $adVertical];

        $product->ads_placement = json_encode($adsPlacement);

        $product->status = $request->status;
        $product->featured = $request->featured;
        $product->save();

        //store activity log
        activity()
            ->performedOn($product)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PRODUCT_MODULE,
                'msg' => $product->product_name . UPDATED_ALERT,
                'old' => $product,
                'new' => null])
            ->log(UPDATE);


        return redirect()->action('Products\ProductsController@promotion_products')->with('success', $product->product_name . UPDATED_ALERT);

        //return $this->promotion_formula();

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
                'msg' => $sel_query->product_name . ' ' . DELETED_ALERT,
                'old' => $sel_query,
                'new' => null])
            ->log(DELETE);


        return redirect()->action('Products\ProductsController@promotion_products')->with('success', $sel_query->product_name . ' ' . DELETED_ALERT);
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

    public function addMorePlacementRange(Request $request)
    {
        if ($request->formula == FIX_DEPOSIT_F1) {
            $teunre = $request->detail;
            //return $teunre[0]['value'];
            ?>
            <div id="placement_range_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success">Min
                                    Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="min_placement[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>
                    </div>

                    <div class="col-sm-4 ">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Max Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger -pull-right  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>" onClick="removePlacementRange(this);">
                            <i
                                class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <?php for ($i = 0; $i < count($request->detail); $i++) { ?>
                    <div class="form-group  <?php echo $i; ?>"
                         id="formula_detail_<?php echo $request->range_id . $i; ?>">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-6 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Tenur</label>
                                    <input type="text" class="form-control only_numeric tenure-<?php echo $i; ?>" id=""
                                           onchange="changeTenureValue(this)" data-formula-detail-id="<?php echo $i; ?>"
                                           name="tenure[<?php echo $request->range_id; ?>][<?php echo $i; ?>]"
                                           value="<?php echo $teunre[$i]['value']; ?>"
                                           placeholder="" readonly="readonly">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest[<?php echo $request->range_id; ?>][<?php echo $i; ?>]"
                                           placeholder="">

                                </div>

                            </div>
                        </div>
                        <div class="col-sm-1 col-sm-offset-1 ">
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>

                <?php } ?>
                <div id="new-formula-detail-<?php echo $request->range_id; ?>"></div>
            </div>
            <?php
        } elseif (in_array($request->formula, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2, SAVING_DEPOSIT_F4])) {
            ?>
            <div id="placement_range_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success">Min
                                    Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="min_placement_sdp1[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>
                    </div>

                    <div class="col-sm-4 ">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Max Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement_sdp1[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger -pull-right  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>" onClick="removePlacementRange(this);">
                            <i
                                class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_sdp1[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Board Rate</label>
                                <input type="text" class="form-control only_numeric"
                                       id="board_rate_<?php echo $request->range_id; ?>"
                                       name="board_rate_sdp1[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            </div>
            <?php
        }
    }

    public function addCounter(Request $request)
    {
        if ($request->counter_value > 0) {

            for ($i = 0; $i < $request->counter_value; $i++) {
                $j = $i + 1; ?>
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="">Counter <?php echo $j; ?></label>
                        <input type="text" class="form-control only_numeric" id="counter_<?php echo $i; ?>"
                               name="counter_sdp3[<?php echo $i; ?>]" value=""
                               placeholder="">
                    </div>
                </div>
                <?php
            }

        } else { ?>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="">Counter 1</label>
                    <input type="text" class="form-control only_numeric" id="counter_1"
                           name="counter[]" value=""
                           placeholder="">
                </div>
            </div>
            <?php
        }
    }

    public function checkProduct(Request $request)
    {

        $query = PromotionProducts::where('product_name', $request->name)
            ->where('bank_id', $request->bank)
            ->where('promotion_type_id', $request->productType)
            ->where('delete_status', 0)
            ->where('formula_id', $request->formula);


        if (!empty($request->product_id)) {
            dd("Hello");
            $query = $query->whereNotIn('id', [$request->product_id]);
        }
        $product = $query->first();
        if ($product) {
            return 1;
        } else {
            return 0;
        }

    }

    public function checkRange(Request $request)
    {

        foreach ($request->min_placement as $key => $value) {
            $key = count($request->min_placement) - 1 - $key;

            for ($i = 0; $i <= (count($request->min_placement) - 1); $i++) {
                if (!is_null($request->min_placement[$key]) && !is_null($request->min_placement[$i]) && !is_null($request->max_placement[$i]) && ($key != $i)) {
                    if ($this->numberBetween($request->min_placement[$key], $request->min_placement[$i], $request->max_placement[$i])) {
                        return 1;
                    } elseif ($this->numberBetween($request->max_placement[$key], $request->min_placement[$i], $request->max_placement[$i])) {
                        return 1;
                    }
                }
            }
        }
        return 0;
    }

    public function numberBetween($varToCheck, $low, $high)
    {
        if ($varToCheck > $high) return false;
        if ($varToCheck < $low) return false;
        return true;
    }

    public function checkTenure(Request $request)
    {
        foreach ($request->tenures as $tenure) {
            if (1 < count(array_keys($request->tenures, $tenure))) {
                return 1;
            }
        }
        return 0;
    }
}
