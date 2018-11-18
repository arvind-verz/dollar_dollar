<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*FrontEnd Routes*/

Route::get('/clear', function () {
    //dd("Hello");
    $exitCode1 = Artisan::call('cache:clear');
    $exitCode2 = Artisan::call('config:clear');
    $exitCode3 = Artisan::call('view:clear');

    return '<h1>All cleared</h1>';
});

/*Home Module*/
Route::get('/home', 'HomeController@index')->name('index');
Route::get('/welcome', 'HomeController@index')->name('index');
Route::get('/', 'HomeController@index')->name('/');
/*End Home Module*/

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


/*User Module*/
Auth::routes();
Route::get('registration_page/{redirect_url}', 'Auth\RegisterController@registration_page');

/*Forgot Password route*/
    Route::post('/forgot-password', 'User\UserFrontController@postForgotPassword')->name('forgot-password');
    Route::get('/password-reset/{token}', 'User\UserFrontController@postForgotPasswordReset')->name('password-reset');
    Route::post('/forgot-password-reset', 'User\UserFrontController@postResetPassword')->name('forgot-password-reset');
/*End Forgot password route*/
// Password Reset Routes...
/*    Route::get('/userpassword/reset', 'Auth\ResetPasswordController@showLinkRequestForm')->name('user.password.reset');
    Route::post('/userpassword/email/{token}', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
*/

Route::get('/users/resetpassword/{id}', 'Auth\LoginController@resetPassword')->name('user.resetpassword');
Route::post('/users/resetpassword/update/{id}', 'Auth\LoginController@resetPasswordUpdate')->name('user.resetpassword.update');

Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::post('/registration/add', 'Auth\RegisterController@userRegistration')->name('registration-add');
//Route::post('/login/db', 'Auth\LoginController@userLogin')->name('login-db');


/* FRONTEND ACCOUNT 
Route::group(array('prefix' =>  'account'), function() {
    Route::get('/login', 'AccountsController@login');
});
/* END FRONTEND ACCOUNT */


/*
Route::get('/user/account-setting/{id}', 'User\UserFrontController@edit')->name('user.edit');
Route::put('/user/account-setting/{id}', 'User\UserFrontController@update')->name('user.update');
Route::get('/user/change-password/{id}', 'User\UserFrontController@changePassword')->name('user.change.password');
Route::put('/user/change-password/{id}', 'User\UserFrontController@updatePassword')->name('user.update.password');
Route::get('/login-status', 'User\UserFrontController@getLoginStatus')->name('user.login.status');
/*End User Module*/

Route::post('/post-contact-enquiry', 'Enquiry\EnquiryFrontController@postContactEnquiry')->name('post-contact-enquiry');
Route::post('/post-health-enquiry', 'Enquiry\EnquiryFrontController@postHealthEnquiry')->name('post-health-enquiry');
Route::post('/post-life-enquiry', 'Enquiry\EnquiryFrontController@postLifeEnquiry')->name('post-life-enquiry');
Route::post('/investment-enquiry', 'Enquiry\EnquiryFrontController@investmentEnquiry')->name('investment-enquiry');
Route::post('/loan-enquiry', 'Enquiry\EnquiryFrontController@loanEnquiry')->name('loan-enquiry');
Route::post('/post-loan-enquiry', 'Enquiry\EnquiryFrontController@postLoanEnquiry')->name('post-loan-enquiry');

/*Blog module end*/
Route::get('/blog-list', 'CMS\PagesFrontController@getBlogByCategories')->name('blog-list');
Route::get('/get-blog-by-category/{id}', 'CMS\PagesFrontController@getBlogByCategories')->name('get-blog-by-category');

Route::get('/blog-search', 'CMS\PagesFrontController@getBlogByCategories')->name('blog-search');


Route::post('/combine-criteria-filter', 'CMS\PagesFrontController@combineCriteriaFilter')->name('combine-criteria-filter');
Route::post('/general-individual-criteria-filter', 'CMS\PagesFrontController@generalIndividualCriteriaFilter')->name('general-individual-criteria-filter');

/* TAGS FRONTEND */
Route::get('/tags/{slug}', 'CMS\PagesFrontController@search_tags');
/* END TAGS FRONTEND */
//Route::get('/test-mail', 'Enquiry\EnquiryFrontController@testMail');
//get product slider details

Route::post('/get-product-slider-details', 'CMS\PagesFrontController@getProductSliderDetails');



/*End FrontEnd Routes*/
Route::group(array('prefix' => 'admin'), function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/register', 'Auth\AdminRegistrationController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegistrationController@register')->name('admin.register.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    // Password reset routes
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');


    /*Banner Module Start*/
    Route::get('/banners/destroy/{id}/{type}', 'Banner\BannerController@destroy')->name('banner-destroy');
    Route::get('/banner/{type}', 'Banner\BannerController@index')->name('banner.index');
    Route::get('/banner-edit/{id}/{type}', 'Banner\BannerController@edit')->name('banner.edit');
    Route::put('/banner-update/{id}/{type}', 'Banner\BannerController@update')->name('banner.update');
    Route::get('/banner-create/{type}', 'Banner\BannerController@create')->name('banner.create');
    Route::post('/banner-store/{type}', 'Banner\BannerController@store')->name('banner.store');
    /*Route::resource('/banner-inner-page', 'Banner\BannerInnerController');
    Route::get('/banner-home', 'Banner\BannerController@bannerHome')->name('banner-home');
    Route::get('/banner-inner', 'Banner\BannerController@bannerInner')->name('banner-inner');*/
    /*Banner Module End*/

    /*Brand Module Start*/
    Route::get('/brands/destroy/{id}', 'Brand\BrandsController@destroy')->name('brand-destroy');
    Route::resource('/brand', 'Brand\BrandsController');
    /*Brand Module End*/


    /* ADS MANAGEMENT */
    Route::get('/ads/{type}', 'Ads\AdsController@index')->name('ads.index');
    Route::get('/ads/{type}/create', 'Ads\AdsController@create')->name('ads.create');
    Route::post('/ads/store/{type}', 'Ads\AdsController@store')->name('ads.store');
    Route::get('/ads/edit/{id}/{type}', 'Ads\AdsController@edit')->name('ads.edit');
    Route::post('/ads/update/{id}/{type}', 'Ads\AdsController@update')->name('ads.update');
    Route::get('/ads/destroy/{id}/{type}', 'Ads\AdsController@destroy')->name('ads.destroy');


    /*Customer  Module Start*/
    Route::get('/user-destroy/{id}', 'User\UsersController@destroy')->name('user-destroy');
    Route::resource('/users', 'User\UsersController');
    Route::get('/users-import/', 'User\UsersController@usersImport')->name('users-import');
    Route::post('/users-csv-import', 'User\UsersController@usersImportIntoDB')->name('users-csv-import');
    Route::get('/user-export/{type}', 'User\UsersController@userExport')->name('user-export');
    Route::get('/users-export/{type}', 'User\UsersController@usersExport')->name('users-export');
    Route::get('/product-view/{id}', 'User\UsersController@productView')->name('product-view');
    Route::post('/user-bulk-delete', 'User\UsersController@bulkRemove')->name('user-bulk-remove');
    /* Customer module end*/


    /*Activity Log Module*/
    Route::get('/activity-destroy/', 'ActivityLog\ActivityLogController@destroy')->name('activity-destroy');
    Route::resource('/activity', 'ActivityLog\ActivityLogController');
    /**/

    /*Menu Module start*/
    Route::get('/menus/destroy/{id}', 'CMS\MenuController@destroy')->name('menu-destroy');
    Route::resource('/menu', 'CMS\MenuController');
    Route::get('/getSubMenus/{id}', 'CMS\MenuController@getSubMenus')->name('getSubMenus');
    Route::get('/menu-create', 'CMS\MenuController@menuCreate')->name('menu-create');
    /*Menu module end*/

    /*Page Module start*/
    Route::get('/pages/destroy/{id}', 'CMS\PagesController@destroy')->name('page-destroy');
    Route::resource('/page', 'CMS\PagesController');
    /*Menu module end*/

    /*System setting start*/
    Route::resource('/system-setting', 'CMS\SystemSettingController');
    Route::resource('/system-setting-homepage', 'CMS\systemSettingHomepageController');
    Route::get('/system-setting-legend-table/{id}', 'CMS\systemSettingLegendTableController@destroy')->name('system-setting-legend-table-destory');
    Route::resource('/system-setting-legend-table', 'CMS\systemSettingLegendTableController');

    /*System setting start*/

    /*User Module start*/
    Route::get('/admins/destroy/{id}', 'Admin\AdminController@destroy')->name('admins-destroy');
    Route::resource('/admins', 'Admin\AdminController');
    Route::get('/update-profile/{id}', 'Admin\AdminController@editProfile')->name('edit-profile');
    Route::put('/update-profile/{id}', 'Admin\AdminController@updateProfile')->name('update-profile');
    Route::get('/update-password/{id}', 'Admin\AdminController@editPassword')->name('edit-password');
    Route::put('/update-password/{id}', 'Admin\AdminController@updatePassword')->name('update-password');
    /*User Module end*/

    Route::get('/users/permissions/create/', 'Admin\AdminController@permissions_create')->name('permissionsCreate');
    Route::post('/users/permissions/store', 'Admin\AdminController@permissions_store')->name('permissionsStore');
    Route::get('/users/permissions/{id}/edit', 'Admin\AdminController@permissions_edit')->name('permissionsEdit');
    Route::post('/users/permissions/{id}/update', 'Admin\AdminController@permissions_update')->name('permissionsUpdate');
    Route::get('/users/permissions/destroy/{id}', 'Admin\AdminController@permissions_destroy')->name('permissionsDestroy');

    /*Blog module start*/
    Route::get('/blog/destroy/{id}', 'Blog\BlogController@destroy')->name('blog-destroy');
    Route::resource('/blog', 'Blog\BlogController');
    Route::get('/blog-create/{category}', 'Blog\BlogController@create')->name('blog-add');
    Route::get('/filter-category/{id}', 'Blog\BlogController@filter')->name('filter-category');
    /*Blog module end*/

    /*Blog module start*/
    Route::get('/contact-enquiry/destroy/{id}', 'Enquiry\ContactEnquiryController@destroy')->name('contact-enquiry-destroy');
    Route::resource('/contact-enquiry', 'Enquiry\ContactEnquiryController');
    /*Blog module end*/

    /*Blog module start*/
    Route::get('/life-insurance-enquiry/destroy/{id}', 'Enquiry\LifeInsuranceEnquiryController@destroy')->name('life-insurance-destroy');
    Route::resource('/life-insurance-enquiry', 'Enquiry\LifeInsuranceEnquiryController');
    /*Blog module end*/

    /*Blog module start*/
    Route::get('/health-insurance-enquiry/destroy/{id}', 'Enquiry\HealthInsuranceEnquiryController@destroy')->name('health-insurance-destroy');
    Route::resource('/health-insurance-enquiry', 'Enquiry\HealthInsuranceEnquiryController');

    Route::get('/investment-enquiry/destroy/{id}', 'Enquiry\InvestmentEnquiryController@destroy')->name('investment-enquiry-destroy');
    Route::resource('/investment-enquiry', 'Enquiry\InvestmentEnquiryController');

    Route::get('/loan-enquiry/destroy/{id}', 'Enquiry\LoanEnquiryController@destroy')->name('loan-enquiry-destroy');
    Route::resource('/loan-enquiry', 'Enquiry\LoanEnquiryController');

    /*Blog module end*/

    /*Tag Module start*/
    Route::get('/tag/destroy/{id}', 'CMS\TagController@destroy')->name('tag-destroy');
    Route::resource('/tag', 'CMS\TagController');

    /*Tag module end*/

    Route::get('/temp', 'Products\ProductsController@temp')->name('temp');

    /* PROMOTION PRODUCTS */
    Route::get('/promotion-products/{productTypeId}', 'Products\ProductsController@promotion_products')->name('promotion-products');
    Route::get('/promotion-products-add/{productTypeId}', 'Products\ProductsController@promotion_products_add')->name('promotion-products-add');
    Route::post('/promotion-products/add-db', 'Products\ProductsController@promotion_products_add_db')->name('promotion-products-add-db');

    Route::get('/promotion-products/{id}/edit', 'Products\ProductsController@promotion_products_edit')->name('promotion-products-edit');

    Route::post('/promotion-products/{id}/update', 'Products\ProductsController@promotion_products_update')->name('promotion-products-update');

    Route::get('/promotion-products-remove/{id}', 'Products\ProductsController@promotion_products_remove')->name('promotion-products-remove');

    Route::get('/promotion-products/get-formula/{id}', 'Products\ProductsController@promotion_products_get_formula')->name('promotion-products-get-formula');

    Route::get('/default-search/{productTypeId}', 'Products\ProductsController@defaultSearch')->name('default-search');
    Route::post('/default-search-update', 'Products\ProductsController@defaultSearchUpdate');
    Route::put('/default-search-update', 'Products\ProductsController@defaultSearchUpdate');

    Route::get('/tool-tip/{productTypeId}', 'Products\ProductsController@toolTip')->name('tool-tip');
    Route::post('/tool-tip-update', 'Products\ProductsController@toolTipUpdate');
    Route::put('/tool-tip-update', 'Products\ProductsController@toolTipUpdate');


    /* PROMOTION FORMULA */
    Route::get('/promotion-formula', 'Products\ProductsController@promotion_formula')->name('promotion-formula');

    Route::post('/promotion-formula-db', 'Products\ProductsController@promotion_formula_db')->name('promotion-formula-db');

    Route::get('/promotion-formula/{id}/edit', 'Products\ProductsController@promotion_formula_edit')->name('promotion-formula-edit');

    Route::post('/promotion-formula/{id}/update', 'Products\ProductsController@promotion_formula_update')->name('promotion-formula-update');

    Route::get('/promotion-formula-remove/{id}', 'Products\ProductsController@promotion_formula_remove')->name('promotion-formula-remove');

    Route::get('/bank-products', 'Products\ProductsController@bank_products')->name('bank-products');

    Route::post('/add-more-placement-range', 'Products\ProductsController@addMorePlacementRange')->name('add-more-placement-range');
    Route::post('/add-more-currency-range', 'Products\ProductsController@addMoreCurrencyRange')->name('add-more-currency-range');
    Route::post('/add-counter', 'Products\ProductsController@addCounter')->name('addCounter');
    Route::post('/check-product', 'Products\ProductsController@checkProduct')->name('check-product');
    Route::post('/check-range', 'Products\ProductsController@checkRange')->name('check-range');
    Route::post('/check-tenure', 'Products\ProductsController@checkTenure')->name('check-tenure');

    Route::post('/add-product-name', 'Products\ProductsController@addProductName')->name('add-product-name');
    Route::post('/add-price-range', 'Products\ProductsController@addPriceRange')->name('add-price-range');
    Route::post('/add-formula-detail', 'Products\ProductsController@addFormulaDetail')->name('add-formula-detail');
    Route::post('/get-placement-range', 'Products\ProductsController@getPlacementRange')->name('get-placement-range');
    Route::post('/get-formula-detail', 'Products\ProductsController@getFormulaDetail')->name('get-formula-detail');


    Route::post('/promotion-products/get-formula', 'Products\ProductsController@promotion_products_get_formula')->name('promotion-products-get-formula');

    Route::put('/promotion-products/{id}/update', 'Products\ProductsController@promotion_products_update')->name('promotion-products-update');
    Route::get('/bank-products', 'Products\ProductsController@promotion_products')->name('bank-products');

    /* REPORTS */
    Route::get('/customer-report', 'Reports\ReportController@customer_report')->name('customer-report');
    Route::get('/customer-report-excel', 'Reports\ReportController@customer_report_excel')->name('customer-report-excel');
    Route::get('/product-report', 'Reports\ReportController@product_report')->name('product-report');
    Route::get('/reminder-email', 'Products\ProductsController@reminder')->name('reminder-email');

    /* REMOVE IMAGE */
    Route::post('/remove-image', 'AdminController@removeImage')->name('remove-image');




});
Route::get('{slug}', 'CMS\PagesFrontController@show')->name('slug');

/* FRONT END PRODUCT MANAGEMENT */
Route::get('product-management/edit/{id}', 'User\ProductManagementController@edit')->name('product-management.edit');
Route::post('product-management/update/{id}', 'User\ProductManagementController@update')->name('product-management.update');
Route::post('product-management/store', 'User\ProductManagementController@store')->name('product-management.store');
Route::get('product-management/delete/{id}', 'User\ProductManagementController@destroy')->name('product-management.delete');

/* ACCOUNT INFORMATION */
Route::get('/account-information/edit/{id}/{location}', 'User\AccountInformationController@edit')->name('account-information.edit');
Route::post('/account-information/update/{id}', 'User\AccountInformationController@update')->name('account-information.update');

Route::post('/fixed-deposit-mode/search/', 'CMS\PagesFrontController@search_fixed_deposit')->name('fixed-deposit-mode.search');
Route::post('/saving-deposit-mode/search/', 'CMS\PagesFrontController@search_saving_deposit')->name('saving-deposit-mode.search');
Route::get('/saving-deposit-mode/search/', 'CMS\PagesFrontController@savingDepositMode');
Route::post('/privilege-deposit-mode/search/', 'CMS\PagesFrontController@search_privilege_deposit')->name('privilege-deposit-mode.search');
Route::post('/foreign-currency-deposit-mode/search/', 'CMS\PagesFrontController@search_foreign_currency_deposit')->name('foreign-currency-deposit-mode.search');
Route::post('/aioa-deposit-mode/search/', 'CMS\PagesFrontController@search_aioa_deposit')->name('aioa-deposit-mode.search');
Route::get('/aioa-deposit-mode/search/', 'CMS\PagesFrontController@aioDepositMode');
Route::post('/loan/search/', 'CMS\PagesFrontController@searchLoan')->name('loan.search');
Route::get('/loan/search/', 'CMS\PagesFrontController@loanMode');

Route::post('/product-search', 'CMS\PagesFrontController@product_search_homepage')->name('product-search');
Route::post('/deposit-type', 'HomeController@depositType')->name('deposit-type');