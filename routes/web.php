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

/*Home Module*/
Route::get('/home', 'HomeController@index')->name('index');
Route::get('/welcome', 'HomeController@index')->name('index');
Route::get('/', 'HomeController@index')->name('/');
/*End Home Module*/

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');


/*User Module*/
Auth::routes();
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

/*Blog module end*/
Route::get('/get-blog-by-category/{id}', 'CMS\PagesFrontController@getBlogByCategories')->name('get-blog-by-category');
Route::get('/blog-list', 'CMS\PagesFrontController@getBlogByCategories')->name('blog-list');

/* TAGS FRONTEND */
Route::get('/tags/{slug}', 'CMS\PagesFrontController@search_tags');
/* END TAGS FRONTEND */


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
    Route::get('/banners/destroy/{id}', 'Banner\BannerController@destroy')->name('banner-destroy');
    Route::resource('/banner', 'Banner\BannerController');
    /*Banner Module End*/

    /*Brand Module Start*/
    Route::get('/brands/destroy/{id}', 'Brand\BrandsController@destroy')->name('brand-destroy');
    Route::resource('/brand', 'Brand\BrandsController');
    /*Brand Module End*/


    /*Customer  Module Start*/
    Route::get('/user-destroy/{id}', 'User\UsersController@destroy')->name('user-destroy');
    Route::resource('/users', 'User\UsersController');
    Route::get('/users-import/', 'User\UsersController@usersImport')->name('users-import');
    Route::post('/users-csv-import', 'User\UsersController@usersImportIntoDB')->name('users-csv-import');
    Route::get('/user-export/{type}', 'User\UsersController@userExport')->name('user-export');
    Route::get('/users-export/{type}', 'User\UsersController@usersExport')->name('users-export');
    Route::get('/product-view/{id}', 'User\UsersController@productView')->name('product-view');
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
    /*Blog module end*/

    /*Tag Module start*/
    Route::get('/tag/destroy/{id}', 'CMS\TagController@destroy')->name('tag-destroy');
    Route::resource('/tag', 'CMS\TagController');
    
    /*Tag module end*/

    Route::get('/temp', 'Products\ProductsController@temp')->name('temp');

    /* PROMOTION PRODUCTS */
    Route::get('/promotion-products', 'Products\ProductsController@promotion_products')->name('promotion-products');
    Route::get('/promotion-products/add', 'Products\ProductsController@promotion_products_add')->name('promotion-products-add');
    Route::post('/promotion-products/add-db', 'Products\ProductsController@promotion_products_add_db')->name('promotion-products-add-db');

    Route::get('/promotion-products/{id}/edit', 'Products\ProductsController@promotion_products_edit')->name('promotion-products-edit');

    Route::post('/promotion-products/{id}/update', 'Products\ProductsController@promotion_products_update')->name('promotion-products-update');

    Route::get('/promotion-products-remove/{id}', 'Products\ProductsController@promotion_products_remove')->name('promotion-products-remove');

    Route::get('/promotion-products/get-formula/{id}', 'Products\ProductsController@promotion_products_get_formula')->name('promotion-products-get-formula');


    /* PROMOTION FORMULA */
    Route::get('/promotion-formula', 'Products\ProductsController@promotion_formula')->name('promotion-formula');

    Route::post('/promotion-formula-db', 'Products\ProductsController@promotion_formula_db')->name('promotion-formula-db');

    Route::get('/promotion-formula/{id}/edit', 'Products\ProductsController@promotion_formula_edit')->name('promotion-formula-edit');

    Route::post('/promotion-formula/{id}/update', 'Products\ProductsController@promotion_formula_update')->name('promotion-formula-update');

    Route::get('/promotion-formula-remove/{id}', 'Products\ProductsController@promotion_formula_remove')->name('promotion-formula-remove');

    Route::get('/bank-products', 'Products\ProductsController@bank_products')->name('bank-products');

    Route::post('/add-more-placement-range', 'Products\ProductsController@addMorePlacementRange')->name('add-more-placement-range');
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
    Route::get('/product-report', 'Reports\ReportController@product_report')->name('product-report');



});
Route::get('{slug}', 'CMS\PagesFrontController@show')->name('slug');

/* FRONT END PRODUCT MANAGEMENT */
Route::post('product-management/store', 'User\ProductManagementController@store')->name('product-management.store');

/* ACCOUNT INFORMATION */
Route::get('/account-information/edit/{id}', 'User\AccountInformationController@edit')->name('account-information.edit');
Route::post('/account-information/update/{id}', 'User\AccountInformationController@update')->name('account-information.update');

Route::post('/fixed-deposit-mode/search/', 'CMS\PagesFrontController@search_fixed_deposit')->name('fixed-deposit-mode.search');
Route::post('/saving-deposit-mode/search/', 'CMS\PagesFrontController@search_saving_deposit')->name('saving-deposit-mode.search');