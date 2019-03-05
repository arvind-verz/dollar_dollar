<?php
namespace App\Helpers\Helper;
use App\Banner;
use App\BlogCategory;
use App\Brand;
use App\Menu;
use App\Page;
use App\ProductManagement;
use App\PromotionFormula;
use App\PromotionProducts;
use App\PromotionTypes;
use App\SystemSetting;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Defr;
use App\DefaultSearch;
class Helper
{
//get all categories
public static function getCategories($id)
{
$details = [];
$categories = Category::orderBy('view_order', 'ASC')
->where('parent', $id)
->where('delete_status', 0)
->get();
$categoriesCount = $categories->count();
$details['categories'] = $categories;
$details['count'] = $categoriesCount;
return $details;
}
/* //get all parent categories with count
public static function getParentCategories($id)
{
$details = [];
$categories = Category::orderBy('view_order', 'ASC')
->where('parent', $id)
->get();
$categoriesCount = $categories->count();
if ($categoriesCount > 4) {
$categories = $categories->all();
}
$details['categories'] = $categories;
$details['count'] = $categoriesCount;
return $details;
}*/
//get all parent categories with count
public static function getBreadCumsCategory($id)
{
$categories = [];
$category = Category::find($id);
array_push($categories, ['id' => $category->id, 'category' => $category->category]);
$parentId = $category->parent;
while ($parentId != 0) {
$category = Category::find($parentId);
array_push($categories, ['id' => $category->id, 'category' => $category->category]);
$parentId = $category->parent;
}
return array_reverse($categories);
}
//get all parent categories by division
public static function getBreadCumsCategoryByDivision($division)
{
$categories = [];
$category = Category::where('division', $division)->first();
array_push($categories, ['division' => $category->division, 'category' => $category->category]);
$parentId = $category->parent;
while ($parentId != 0) {
$category = Category::find($parentId);
array_push($categories, ['division' => $category->division, 'category' => $category->category]);
$parentId = $category->parent;
}
return array_reverse($categories);
}
//get all parent categories by division
public static function getBreadCumsCategoryByMenus($menuId)
{
$menus = [];
$menu = Menu::join('pages', 'menus.id', '=', 'pages.menu_id')->where('menus.id', $menuId)->select('pages.*')->first();
array_push($menus, ['id' => $menu->id, 'title' => $menu->name, 'slug' => $menu->slug]);
$parentMenuId = $menu->parent;
while ($parentMenuId != 0) {
$menu = Menu::find($parentMenuId);
array_push($menus, ['id' => $menu->id, 'title' => $menu->title, 'slug' => $menu->slug]);
$parentMenuId = $menu->parent;
}
return array_reverse($menus);
}
//get all parent categories by division
public static function getBackendBreadCumsCategoryByMenus($menuId)
{
$menus = [];
$menu = Menu::where('menus.id', $menuId)->first();
//dd($menu);
array_push($menus, ['id' => $menu->id, 'title' => $menu->title]);
$parentMenuId = $menu->parent;
while ($parentMenuId != 0) {
$menu = Menu::find($parentMenuId);
array_push($menus, ['id' => $menu->id, 'title' => $menu->title]);
$parentMenuId = $menu->parent;
}
return array_reverse($menus);
}
/*get pages from page table this pages are manually add in database */
public static function getPages()
{
$pages = DB::table('pages')
->orderBy('name', 'asc')
->where('delete_status', 0)
->where('status', 1)
->get();
return $pages;
}
/*get homepage id*/
public static function getHomePage()
{
$homePage = Homepage::where('delete_status', 0)->first();
return $homePage;
}
/*get banners*/
public static function getBanners($slug)
{
$banners = Banner::join('pages', 'pages.id', '=', 'banners.page_id')
->where('banners.delete_status', 0)
->where('banners.display', 1)
->where('pages.delete_status', 0)
->where('pages.slug', $slug)
->select('banners.*', 'pages.slug')
->inRandomOrder()
->get();
//dd($slug);
return $banners;
}
/*get Brands*/
public static function getBrands()
{
$brands = Brand::where('delete_status', 0)
->where('display', 1)
->select('brand_logo')
->orderBy('view_order', 'ASC')
->get();
return $brands;
}
/*get banners*/
public static function getHomeCategories()
{
$homePage = Homepage::where('delete_status', 0)
->first();
if ($homePage['categories'] != null) {
$homePage['categories'] = unserialize($homePage['categories']);
foreach ($homePage['categories'] as $k => $v) {
$homePage[$k] = $v;
}
}
if ($homePage['promotion'] != null) {
$homePage['promotion'] = unserialize($homePage['promotion']);
foreach ($homePage['promotion'] as $k => $v) {
$homePage[$k] = $v;
}
$homePage = (object)$homePage;
}
return $homePage;
}
static function  getDownload($file_path, $file_name)
{
//PDF file is stored under project/public/download/info.pdf
$file = public_path() . '/' . $file_path;
$headers = array(
'Content-Type: application/pdf',
);
return Response::download($file, $file_name, $headers);
}
static function getProductUnserialize($id)
{
$product = Product::find($id);
if (!$product) {
return redirect()->back()->with('error', OPPS_ALERT);
}
//dd($product);
if ($product->image_array != null) {
$product->image_array = unserialize($product->image_array);
} else {
$product->image_array = [];
}
if ($product->brochure_array != null) {
$product->brochure_array = unserialize($product->brochure_array);
} else {
$product->brochure_array = [];
}
if ($product->manual_array != null) {
$product->manual_array = unserialize($product->manual_array);
} else {
$product->manual_array = [];
}
if ($product->related_products != null) {
$product->related_products = unserialize($product->related_products);
} else {
$product->related_products = [];
}
return $product;
}
static function getPriceByProduct($id, $priceListName = 'USD-A')
{
//dd($priceList);
$productPrice = null;
//find price list
if ((Auth::user()) && (Auth::user()->price_list != null)) {
$priceList = Pricelist::find(Auth::user()->price_list);
} else {
$priceList = Pricelist::where('label', $priceListName)->first();
}
//dd($priceList);
//find product and then if find product then get product price by price list.
$product = Product::select($priceList->name)->where('id', $id)->first();
if ($product) {
$product = $product->toArray();
$productPrice = $product[$priceList->name];
}
return $productPrice;
}
static function getMainPriceCat()
{
$priceList = [];
$priceList['USD'] = Pricelist::where('label', 'LIKE', 'USD%')->pluck('id')->all();
$priceList['SGD'] = Pricelist::where('label', 'LIKE', 'SGD%')->pluck('id')->all();
return $priceList;
}
//get all menus
public static function getMenus()
{
$menus = [];
DB::enableQueryLog();
$details = Menu::leftJoin('pages', 'pages.menu_id', '=', 'menus.id')
->orderBy('menus.view_order', 'ASC')
->where('menus.delete_status', 0)
//->where('pages.delete_status', 0)
->select('menus.*', 'pages.name', 'pages.slug', 'pages.after_login')
->get();
//dd(DB::getQueryLog());
//dd(json_encode($details));
if (Auth::guest()) {
if ($details->count()) {
$details = $details->whereIn('pages.after_login', [0, null]);
}
}
if ($details->count()) {
$filter_data = $details->filter(function ($detail) {
if (($detail->child != 0) || ($detail->slug != null))
return $detail;
});
$menus = $filter_data->groupBy('parent')->toArray();
}
//dd($menus);
return $menus;
}
public static function getBlogMenus()
{
$details = [];
$categories = Menu::orderBy('view_order', 'ASC')
->where('delete_status', 0)
->where('main', BLOG_MENU_ID)
->get();
if ($categories->count()) {
$details = $categories->groupBy('parent')->toArray();
}
// dd($details);
return $details;
}
public static function getMenuCategories()
{
$details = [];
$categories = BlogCategory::orderBy('view_order', 'ASC')
->where('delete_status', 0)
->get();
if ($categories->count()) {
$details = $categories->groupBy('parent')->toArray();
}
return $details;
}
public static function getSystemSetting()
{
$systemSetting = SystemSetting::where('delete_status', 0)
->orderBy('id', 'desc')
->first();
if (!$systemSetting) {
return back()->with('error', OPPS_ALERT);
}
return $systemSetting;
}
public static function getBackEndMenu()
{
$checkMenuPermission = \DB::table('role_type_access')
->join('modules', 'role_type_access.module_id', '=', 'modules.id')
->where(['role_type_access.role_type_id' => @Auth::user()->role_type_id, 'role_type_access.view' => 1])
->where('modules.delete_status', 0)
->select('role_type_access.module_id', 'modules.name', 'modules.label', 'modules.icon')
->orderBy('modules.view_order', 'asc')
->get();
return $checkMenuPermission;
}
/* TAGS */
public static function getTags($tags_id)
{
$sel_query = Tag::whereIn('id', $tags_id)->get();
return $sel_query;
//dd($sel_query);
}
public static function searchTags($slug)
{
//dd($slug);
$sel_query = Tag::where('title', '=', $slug)->get();
$tag_id = $sel_query[0]->id;
$tags_found = [];
$sel_query = Page::whereNotNull('tags')->where('delete_status',0)->get();
//dd($sel_query[0]->tags);
foreach ($sel_query as $value) {
$mytags = json_decode($value->tags);
//print_r($tag_id);
if (in_array($tag_id, $mytags)) {
$tags_found[] = $value->id;
}
}
return $tags_found;
}
/* END TAGS */
/* PRODUCTS */
public static function getProducts($productTypeId = FIX_DEPOSIT)
{
DB::enableQueryLog();
$sel_query = PromotionProducts::leftjoin('brands', 'brands.id', '=', 'promotion_products.bank_id')
->leftjoin('promotion_types', 'promotion_types.id', '=', 'promotion_products.promotion_type_id')
->leftjoin('promotion_formula', 'promotion_formula.id', '=', 'promotion_products.formula_id')
->where('promotion_products.delete_status', '=', 0)
->where('promotion_products.promotion_type_id', '=', $productTypeId)
->select('promotion_products.*', 'brands.title as bank_name', 'promotion_types.name as promotion_type', 'promotion_formula.name as promotion_formula')
->get();
return $sel_query;
}
public static function getProduct($id = NULL)
{
$sel_query = PromotionProducts::find($id);
if (!$sel_query) {
return null;
}
if ($sel_query->ads_placement) {
$sel_query->ads_placement = json_decode($sel_query->ads_placement);
}
return $sel_query;
}
public static function productType($id = NULL)
{
$sel_query = PromotionProducts::find($id);
$sel_query = PromotionFormula::where('id', $sel_query->promotion_type_id)
->where('delete_status', 0)
->get();
return $sel_query;
}
/* END PRODUCTS */
/* FORMULAS */
public static function getFormula($id = NULL)
{
//DB::enableQueryLog();
if ($id) {
$sel_query = PromotionFormula::find($id);
} else {
$sel_query = PromotionFormula::where('delete_status', '=', 0)->get();
}
//dd(DB::getQueryLog());
return $sel_query;
}
public static function getAllFormula($id = NULL)
{
$sel_query = PromotionFormula::where('promotion_id', $id)->where('delete_status', 0)->orderBy('view_order', 'ASC')->get();
return $sel_query;
}
/* END FORMULAS */
/* PROMOTION TYPE */
public static function getPromotionType($productTypeId = null)
{
$sel_query = PromotionTypes::where('delete_status', '=', 0)
->where('id', '=', $productTypeId)
->get();
return $sel_query;
}
/* END PROMOTION TYPE */
//convert date into start of the day
public static function startOfDayBefore($date = null)
{
if (!$date) {
$date = Carbon::now();
}
$date = date("Y-m-d H:i:s", strtotime($date));
$startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $date)->startOfDay()->toDateTimeString();
return $startOfDay;
}
//convert date into end of the day
public static function endOfDayAfter($date = null)
{
if (!$date) {
$date = Carbon::now();
}
$date = date("Y-m-d H:i:s", strtotime($date));
$endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $date)->endOfDay()->toDateTimeString();
return $endOfDay;
}
public static function convertToCarbonStartDate($date = null)
{
if (!$date) {
$carbonStartDate = Carbon::now()->startOfDay();
} else {
$carbonStartDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->startOfDay();
}
return $carbonStartDate;
}
public static function convertToCarbonEndDate($date = null)
{
if (!$date) {
$carbonEndDate = Carbon::now()->endOfDay();
} else {
$carbonEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->endOfDay();
}
return $carbonEndDate;
}
public static function days_or_month_or_year($tenure_type, $tenure)
{
$day = '';
if(is_numeric($tenure))
{
if ($tenure_type == 1) {
if ($tenure > 1) {
$day = 'Days';
} else {
$day = 'Day';
}
} elseif ($tenure_type == 2) {
if ($tenure > 1) {
$day = 'Months';
} else {
$day = 'Month';
}
} elseif ($tenure_type == 3) {
if ($tenure > 1) {
$day = 'Years';
} else {
$day = 'Year';
}
}
}
return $day;
}
public static function daysMonthYearShortForm($tenure_type, $tenure)
{
$day = '';
if(is_numeric($tenure))
{
if ($tenure_type == 1) {
if ($tenure > 1) {
$day = 'Days';
} else {
$day = 'Day';
}
} elseif ($tenure_type == 2) {
if ($tenure > 1) {
$day = 'Mths';
} else {
$day = 'Mth';
}
} elseif ($tenure_type == 3) {
if ($tenure > 1) {
$day = 'Years';
} else {
$day = 'Year';
}
}
}
return $day;
}
public static function daysOrMonthForSlider($tenure_type, $tenure)
{
$day = '';
if(is_numeric($tenure))
{
if ($tenure_type == 1) {
if ($tenure > 1) {
$day = 'Days';
} else {
$day = 'Day';
}
} elseif ($tenure_type == 2) {
if ($tenure > 1) {
$day = 'MTHS';
} else {
$day = 'MTH';
}
} elseif ($tenure_type == 3) {
if ($tenure > 1) {
$day = 'Years';
} else {
$day = 'Year';
}
}
}
return $day;
}
public static function get_page_detail($slug = HOME_SLUG)
{
//dd($slug);
$page = Page::where('delete_status', 0)->where('slug', $slug)->first();
if (!$page) {
return back()->with('error', OPPS_ALERT);
}
$brands = Brand::where('delete_status', 0)->where('display', 1)->orderBy('view_order', 'asc')->get();
$systemSetting = \Helper::getSystemSetting();
if (!$systemSetting) {
return back()->with('error', OPPS_ALERT);
}
$slug = $page->slug;
//get banners
$banners = \Helper::getBanners($slug);
$details = [];
$details['brands'] = $brands;
$details['page'] = $page;
$details['systemSetting'] = $systemSetting;
$details['banners'] = $banners;
return $details;
}
public static function inThousand($amount)
{
//dd($amount);
if ($amount > 999999) {
$amount = $amount / 1000000;
$intVal = intval(number_format((float)$amount, 2, '.', ''));
if (($amount - $intVal) > 0.009) {
if(($amount - $intVal) > 0.09){
$amount = number_format((float)$amount, 1, '.', '').'M';
}else{
$amount = number_format((float)$amount, 2, '.', '').'M';
}
}else{
$amount = $intVal.'M';
}
}
elseif ($amount > 999) {
$amount = $amount / 1000;
$intVal = intval($amount);
if (($amount - $intVal) > 0.009) {
if(($amount - $intVal) > 0.09){
$amount = number_format((float)$amount, 1, '.', '').'K';
}else{
$amount = number_format((float)$amount, 2, '.', '').'K';
}
}else{
$amount = $intVal.'K';
}
} else {
$intVal = intval($amount);
if(($amount-$intVal)>0.009)
{
$amount = number_format((float)$amount, 2, '.', '');
}
}
return $amount;
}
public static function inRoundTwoDecimal($amount)
{
$intVal = intval(number_format((float)$amount, 2, '.', ''));
if (($amount - $intVal) > 0.009) {
/*if(($amount - $intVal) > 0.09){
$amount = number_format((float)$amount, 2);
}else{*/
$amount = number_format((float)$amount, 2);
/*}*/
}else{
$amount = $intVal;
}
return  $amount;
}
public static function todayDate()
{
return Carbon::now()->format('Y-m-d');
}
public static function base64_encode($str)
{
return strtr(base64_encode($str), '+/', '-_');
}
public static function base64_decode($str)
{
return base64_decode(strtr($str, '-_', '+/'));
}
public static function multiExplode ($delimiters,$string) {
$ready = str_replace($delimiters, $delimiters[0], $string);
$launch = explode($delimiters[0], $ready);
return  $launch;
}
public static function getHomeProducts($productType, $byOrderValue)
{
$products = DB::table('promotion_products')->join('promotion_types',
'promotion_products.promotion_type_id', '=', 'promotion_types.id')
->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
->join('promotion_formula', 'promotion_products.formula_id', '=',
'promotion_formula.id')
->leftJoin('currency', 'promotion_products.currency', '=', 'currency.id')
->where('promotion_products.promotion_type_id', '=', $productType)
->where('promotion_products.delete_status', '=', 0)
->where('promotion_products.status', '=', 1)
->select('promotion_products.featured','promotion_products.slider_status','brands.id as brand_id', 'promotion_products.id as promotion_product_id',
'promotion_products.maximum_interest_rate','promotion_products.minimum_placement_amount','promotion_products.promotion_period','promotion_products.formula_id',
'promotion_products.formula_id','promotion_products.promotion_type_id','promotion_products.slider_status','promotion_products.until_end_date', 'currency.code as currency_code',
'currency.icon as currency_icon', 'currency.currency as currency_name','brands.brand_logo')
->get();
$searchFilter=null;
if ($byOrderValue == 'minimum_placement_amount') {
$searchFilter = PLACEMENT;
} elseif ($byOrderValue == 'maximum_interest_rate') {
$searchFilter = INTEREST;
} elseif ($byOrderValue == 'promotion_period') {
$searchFilter = TENURE;
if($productType==ALL_IN_ONE_ACCOUNT)
{
$searchFilter = CRITERIA;
}
}
$productUrl = null;
if($productType==FIX_DEPOSIT)
{
$productUrl=FIXED_DEPOSIT_MODE;
}
elseif($productType==SAVING_DEPOSIT){
$productUrl=SAVING_DEPOSIT_MODE;
}
elseif($productType==PRIVILEGE_DEPOSIT){
$productUrl=PRIVILEGE_DEPOSIT_MODE;
}
elseif($productType==FOREIGN_CURRENCY_DEPOSIT){
$productUrl=FOREIGN_CURRENCY_DEPOSIT_MODE;
}
elseif($productType==ALL_IN_ONE_ACCOUNT){
$productUrl=AIO_DEPOSIT_MODE;
}
foreach ($products as $key => &$product) {
$maxTenure = 0;
$minTenure = 0;
$product->by_order_value = $searchFilter;
$product->product_url = $productUrl;
if ($product->promotion_period == ONGOING) {
$product->tenure_category = ONGOING;
} else {
$placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
if (count($placementPeriod)) {
$placementTenures = [];
foreach ($placementPeriod as $period) {
$value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
if ($value > 0) {
$placementTenures[] = $value;
}
}
if (count($placementTenures)) {
$maxTenure = max($placementTenures);
$minTenure = min($placementTenures);
if(count($placementTenures)>4)
{
$product->promotion_period = $minTenure.' - '.$maxTenure;
}
}
}
if (in_array($product->formula_id, [SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {
$product->tenure_category = DAYS;
} else {
$product->tenure_category = MONTHS;
}
}
$product->max_tenure = $maxTenure;
$product->min_tenure = $minTenure;
if ($product->promotion_period == ONGOING) {
$product->tenure_value = ONGOING;
} else {
$product->tenure_value = $maxTenure;
}
$todayDate = Carbon::today();
if (!is_null($product->until_end_date)) {
$untilEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $product->until_end_date)->endOfDay();
if ($untilEndDate > $todayDate) {
$product->remaining_days = $todayDate->diffInDays($untilEndDate); // tenure in days
} else {
$product->remaining_days = EXPIRED;
}
} else {
$product->remaining_days = null;
}
}
if ($byOrderValue == 'minimum_placement_amount') {
$products = $products->sortByDesc('minimum_placement_amount')->values();
} elseif ($byOrderValue == 'maximum_interest_rate') {
$products = $products->sortByDesc('maximum_interest_rate')->values();
} elseif ($byOrderValue == 'promotion_period') {
if($productType==ALL_IN_ONE_ACCOUNT)
{
$products = $products->sortBy('promotion_period')->values();
}else
{
$results = collect();
$products1 = $products->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
$products2 = $products->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
$products3 = $products->where('tenure_category', DAYS)->sortBy('min_tenure')->values();
if ($products1->count()) {
$results = $results->merge($products1);
}
if ($products2->count()) {
$results = $results->merge($products2);
}
if ($products3->count()) {
$results = $results->merge($products3);
}
$products = $results;
}
}
$products = $products->sortByDesc('featured')->values();
return $products;
}
public static function getLoanProducts($productType, $byOrderValue)
{
$filter = $byOrderValue ? $byOrderValue : INTEREST;
$promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
//->whereNotNull('promotion_products.formula_id')
->where('promotion_types.id', '=', $productType)
->where('promotion_products.delete_status', '=', 0)
->where('promotion_products.status', '=', 1)
->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'promotion_products.id as product_id', 'promotion_products.id as product_id')
->get();
$filterProducts=[];
if ($promotion_products->count()) {
foreach ($promotion_products as $key => $product) {
$defaultSearch = DefaultSearch::where('promotion_id', LOAN)->first();
if ($defaultSearch) {
$defaultPlacement = $defaultSearch->placement;
$defaultRateType = $defaultSearch->rate_type;
$defaultTenure = $defaultSearch->tenure;
$defaultPropertyType = $defaultSearch->property_type;
$defaultCompletion = $defaultSearch->completion;
} else {
$defaultPlacement = 0;
$defaultRateType = BOTH_VALUE;
$defaultTenure = 35;
$defaultPropertyType = HDB_PROPERTY;
$defaultCompletion = COMPLETE;
}
$placement = 0;
$searchValue = $defaultPlacement;
$rateType = $defaultRateType;
$tenure = $defaultTenure;
$propertyType = $defaultPropertyType;
$completion = $defaultCompletion;
$searchFilter['search_value'] = $defaultPlacement;
$searchFilter['rate_type'] = $defaultRateType;
$searchFilter['tenure'] = $defaultTenure;
$searchFilter['property_type'] = $defaultPropertyType;
$searchFilter['completion'] = $defaultCompletion;
$searchFilter['filter'] = INTEREST;
$searchFilter['sort_by'] = MAXIMUM;
$status = true;
$productRanges = json_decode($product->product_range);
if ($product->promotion_formula_id == LOAN_F1) {
$tenure= (int)$tenure;
$totalInterests = [];
$interestEarns = [];
$product->highlight = false;
$firstProductRange = $productRanges[0];
if ($rateType != BOTH_VALUE && ($rateType != $firstProductRange->rate_type)) {
$status = false;
}
if ($completion != ALL && ($completion != $firstProductRange->completion_status)) {
$status = false;
}
$hdbProperty = [HDB_PROPERTY, HDB_PRIVATE_PROPERTY];
$privateProperty = [PRIVATE_PROPERTY, HDB_PRIVATE_PROPERTY];
$commonProperty = [];
if (in_array($propertyType, [HDB_PROPERTY, PRIVATE_PROPERTY])) {
if ($propertyType == HDB_PROPERTY) {
$commonProperty = $hdbProperty;
} elseif ($propertyType == PRIVATE_PROPERTY) {
$commonProperty = $privateProperty;
}
if (!in_array($firstProductRange->property_type, $commonProperty)) {
$status = false;
}
} elseif ($propertyType != COMMERCIAL_PROPERTY) {
$status = false;
}
$productRangeCount = count($productRanges);
$totalInterest = 0;
$totalMonthlyInstallment = 0;
$totalTenure = 0;
$j = 0;
foreach ($productRanges as $k => $productRange) {
$productRange->tenure_highlight = false;
$interest = $productRange->bonus_interest + $productRange->rate_interest_other;
if ($interest <= 0) {
                            $productRange->monthly_payment = 0;
                        }else{
                            $mortage = new Defr\MortageRequest($searchValue, $interest, $tenure);
                            $result = $mortage->calculate();
                            $productRange->monthly_payment = $result->monthlyPayment;
                        }
if ($tenure > $totalTenure) {
if ($j <= 2) {
$totalInterest += $interest;
$totalTenure++;
$totalMonthlyInstallment += $productRange->monthly_payment;
}
$productRange->tenure_highlight = true;
}
$j++;
}
while ($j <= 2)
{
$interest = $firstProductRange->there_after_bonus_interest + $firstProductRange->there_after_rate_interest_other;
if ($interest <= 0) {
                            $monthlyThereAfterPayment = 0;
                        }else{
                            $mortage = new Defr\MortageRequest($searchValue, $interest, $tenure);
                            $result = $mortage->calculate();
                            $monthlyThereAfterPayment = $result->monthlyPayment;
                        }
$totalInterest += $interest;
$totalTenure++;
$totalMonthlyInstallment += $monthlyThereAfterPayment;
$j++;
}
$interest = $firstProductRange->there_after_bonus_interest + $firstProductRange->there_after_rate_interest_other;
if ($interest <= 0) {
                        $product->there_after_installment = 0;
                    }else{
                        $mortage = new Defr\MortageRequest($searchValue, $interest, $tenure);
                        $result = $mortage->calculate();
                        $product->there_after_installment = $result->monthlyPayment;
                    }
$product->placement = $searchValue;
$product->tenure = $tenure;
if ($tenure > $productRangeCount) {
//$totalInterest += ($tenure - $productRangeCount) * $interest;
// $totalMonthlyInstallment += ($tenure - $productRangeCount) * $result->monthlyPayment;
$product->highlight = true;;
}
$product->avg_interest = round(($totalInterest / $totalTenure), 2);
$product->monthly_installment = $totalMonthlyInstallment / $totalTenure;
$product->avg_tenure = $totalTenure;
$product->product_range = $productRanges;
$product->by_order_value = $filter;
$product->product_url = LOAN_MODE;
$filterProducts[] = $product;
}
}
}
$products = collect($filterProducts);
if ($products->count()) {
if ($filter == INSTALLMENT) {
$products = $products->sortBy('minimum_loan_amount')->values();
} elseif ($filter == INTEREST) {
$products = $products->sortBy('avg_interest')->values();
} elseif ($filter == TENURE) {
$products = $products->sortBy('lock_in')->values();
}
}
$products = $products->sortByDesc('featured')->values();
return $products;
}
public static function getCustomerReportData($id)
{
DB::connection()->enableQueryLog();
$customer_reports = ProductManagement::join('users', 'product_managements.user_id', '=', 'users.id')
->leftJoin('brands', 'product_managements.bank_id', '=', 'brands.id')
->where('users.id', $id)
->get();
//dd(DB::getQueryLog());
//dd($customer_reports);
$count = $customer_reports->count();
$table_tag = [];
for($j=1;$j<$count;$j++) {
$table_tag[] = '<td></td>';
}
//dd($table_tag);
$i = 1;
foreach($customer_reports as $customer_report) {
if($i!=1) { ?> <tr>
    <td><?php echo ucfirst($customer_report->first_name) . ' ' . ucfirst($customer_report->last_name).'<br/>'. $customer_report->email.'<br/>'. $customer_report->country_code . $customer_report->tel_phone; ?></td></td>
    <td style='display: none'></td>
    <td></td>
    <?php } ?>
    <td><?php if(!$customer_report->title){ echo $customer_report->other_bank;} else{echo $customer_report->title;}  ?></td>
    <td><?php echo ucwords($customer_report->account_name); ?></td>
    <td><?php echo '$'.$customer_report->amount; ?></td>
    <td><?php if($customer_report->end_date) {echo date('d-m-Y', strtotime($customer_report->end_date));} ?></td>
    <td>
        <?php
        if($customer_report->status==1) {
        echo 'Active';
        }
        else {
        echo 'Inactive';
        }
        ?>
    </td>
<?php if($i!=1) { ?> </tr> <?php }
if($i==1) { ?> </tr> <?php }
$i++;
}
}
public static function manageAds($adsCollection)
{
$ads = $adsCollection->first();
/*if(empty($ads->ad_image)){
$ads1 = $adsCollection->where('ad_image','!=',null)->first();
$paidAds1 = $adsCollection->filter(function ($item)  {
$date = Carbon::now();
$startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $date)->startOfDay()->toDateTimeString();
$endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $date)->endOfDay()->toDateTimeString();
return (data_get($item, 'ad_end_date') > $startOfDay) && (data_get($item, 'ad_start_date') < $endOfDay);
})->first();
if($ads1){
$ads->ad_image = $ads1->ad_image;
$ads->ad_link = $ads1->ad_link;
}elseif($paidAds1){
$ads->ad_image = $paidAds1->paid_ad_image;
$ads->ad_link = $paidAds1->paid_ad_link;
}
}
if(empty($ads->paid_ad_image)){
$ads3 = $adsCollection->where('paid_ad_image','!=',null)->first();
if($ads3){
$ads->paid_ad_image = $ads3->paid_ad_image;
$ads->paid_ad_link = $ads3->paid_ad_link;}
}*/
/*if($ads->page != 'product') {
if(empty($ads->horizontal_banner_ad_image)){
$ads2 = $adsCollection->where('horizontal_banner_ad_image','!=',null)->first();
$paidAds2 = $adsCollection->filter(function ($item)  {
$date = Carbon::now();
$startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $date)->startOfDay()->toDateTimeString();
$endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $date)->endOfDay()->toDateTimeString();
return (data_get($item, 'ad_end_date') > $startOfDay) && (data_get($item, 'ad_start_date') < $endOfDay);
})->first();
if($ads2){
$ads->horizontal_banner_ad_image = $ads2->horizontal_banner_ad_image;
$ads->horizontal_banner_ad_link = $ads2->horizontal_banner_ad_link;}elseif($paidAds2){
$ads->horizontal_banner_ad_image = $paidAds2->horizontal_paid_ad_image;
$ads->horizontal_banner_ad_link = $paidAds2->horizontal_paid_ad_link;
}
}
if(empty($ads->horizontal_paid_ad_image)){
$ads4 = $adsCollection->where('horizontal_paid_ad_image','!=',null)->first();

if($ads4){
$ads->horizonstal_paid_ad_image = $ads4->horizontal_paid_ad_image;
$ads->horizontal_paid_ad_link = $ads4->horizontal_paid_ad_link;}
}
}*/
//dd($ads);
return $ads;
}

public static function isValidEmail($email){
return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
}