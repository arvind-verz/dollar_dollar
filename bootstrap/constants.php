<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 12-02-2018
 * Time: 14:23
 */

define('ADMIN', 'Administrator');

//order status
define('PROCESSING', 0);
define('AWAITING_PAYMENT', 1);
define('PAID', 2);
define('SHIPPED', 3);

//start random number for customer_ref_no
define('CUSTOMER_REF_NO', 11111);

//set default Price List id, this id base on database table price lists
define('USD_A', 1);

//set Product category
define('SPARE', 'Spare');
define('SEARCH', 'Search');
define('PROMOTION', 'Promotion');


//set mail name
define('ADMIN_EMAIL', 'nicckk3@gmail.com');
define('ENQUIRY_EMAIL', 'enquiry@speedo.com.sg');

//Activity log status
define('CREATE', 'Created');
define('UPDATE', 'Updated');
define('DELETE', 'Deleted');
define('EXPORT', 'Exported');
define('IMPORT', 'Imported');
define('ACTIVE', 'Active');
define('DEACTIVATE', 'Deactivate');
define('TRUE_STATUS', 'True');
define('FALSE_STATUS', 'False');
define('ASC_ORDER', 'asc');
define('DESC_ORDER', 'desc');


//CONSTANTS FOR PRODUCT IMPORT VALUES IF NULL
define('PRICE_NULL', "Please enquire directly for pricing");
define('WEIGHT_NULL', "Unavailable - to be provided upon purchase");
define('DIMENSION_NULL', "Unavailable - to be provided upon purchase");

//Session key
define('RECENT_PRODUCTS', "recent_products");

//Module Name
define('DASHBOARD', "Dashboard");
define('PRODUCT_MODULE', "Product Management");
define('CATEGORY_MODULE', "Category Management");
define('BRAND_MODULE', "Brand Management");
define('BANNER_MODULE', "Banner Management");
define('USER_MODULE', "User Management");
define('CUSTOMER_MODULE', "Customer Management");
define('ORDER_MODULE', "Order Management");
define('HOMEPAGE_MODULE', "Homepage Management");
define('ACTIVITY_LOG_MODULE', "Activity Log Management");
define('MENU_MODULE', "Menu Management");
define('PAGE_MODULE', "Page  Management");
define('SYSTEM_SETTING_MODULE', "System Setting Management");
define('PERMISSION_MODULE', "Permission Management");
define('BLOG_MODULE', "Blog Management");
define('BLOG_CATEGORY_MODULE', "Blog Category Management");
define('ENQUIRY_MODULE', "Enquiry Management");
define('TAG_MODULE', "Tag Management");
define('REPORT_MODULE', "Report Management");

//Single Module Name for action
define('PRODUCT_MODULE_SINGLE', "Product");
define('CATEGORY_MODULE_SINGLE', "Category");
define('BANNER_MODULE_SINGLE', "Banner");
define('BRAND_MODULE_SINGLE', "Brand");
define('USER_MODULE_SINGLE', "User");
define('REPORT_MODULE_SINGLE', "Report");
define('CUSTOMER_MODULE_SINGLE', "Customer");
define('ORDER_MODULE_SINGLE', "Order");
define('HOMEPAGE_MODULE_SINGLE', "Homepage");
define('ACTIVITY_LOG_MODULE_SINGLE', "Activity Log");
define('MENU_MODULE_SINGLE', "Menu");
define('PAGE_MODULE_SINGLE', "Page");
define('SYSTEM_SETTING_MODULE_SINGLE', "System Setting");
define('PERMISSION_MODULE_SINGLE', "Permission");
define('BLOG_MODULE_SINGLE', "Blog");
define('BLOG_CATEGORY_MODULE_SINGLE', "Blog Category");
define('HEALTH_INSURANCE_ENQUIRY_MODULE', "Health Insurance Enquiry");
define('LIFE_INSURANCE_ENQUIRY_MODULE', "Life Insurance Enquiry");
define('CONTACT_ENQUIRY_MODULE', "Contact Enquiry");
define('TAG_MODULE_SINGLE', "Tag");
define('PRODUCT_NAME_MODULE_SINGLE', "Product Name");
define('FORMULA_DETAIL_MODULE_SINGLE', "Formula Detail");
define('PLACEMENT_RANGE_MODULE_SINGLE', "Placement Range");

//Action name
define('ADD_ACTION', "Add");
define('EDIT_ACTION', "Edit");
define('VIEW_ACTION', "View");
define('UPDATE_ACTION', "Update");
define('DELETE_ACTION', "Delete");
define('IMPORT_ACTION', "Import");
define('EXPORT_ACTION', "Export");
define('CLEAR_ACTION', "Clear");


//Menu Id temporary
define('HOME_MENU_ID', 7);

//product uri
define('PRODUCT_URL', 'product');
define('BLOG_URL', 'blog-list');
define('BLOG_SLUG', 'blog-list');

//module id
define('ACTIVITY_LOG_MODULE_ID', 24);
define('MENU_MODULE_ID', 25);
define('PAGE_MODULE_ID', 26);
define('BANNER_MODULE_ID', 27);
define('BRAND_MODULE_ID', 28);
define('CATEGORY_MODULE_ID', 29);
define('PRODUCT_MODULE_ID', 30);
define('CUSTOMER_MODULE_ID', 31);
define('USER_MODULE_ID', 32);
define('BLOG_MODULE_ID', 33);
define('BLOG_CATEGORY_MODULE_ID', 34);
define('ENQUIRY_MODULE_ID', 35);
define('TAG_MODULE_ID', 36);

//Temp Pages Id
define('PRODUCT_PAGE_ID', 20);
define('CATEGORY_PAGE_ID', 26);
define('PROMOTION_PAGE_ID', 21);

//Blog menu id
define('BLOG_MENU_ID', 21);
define('PRODUCT_ID', 37);

//Alert messages
define('IMPORTED_ALERT', " has been successfully imported.");
define('EXPORT_ALERT', " has been successfully exported.");
define('ADDED_ALERT', " has been successfully added.");
define('UPDATED_ALERT', " has been successfully updated.");
define('DELETED_ALERT', " has been successfully deleted.");
define('ALREADY_TAKEN_ALERT', " has already been taken.");
define('OPPS_ALERT', " Oops! Something went wrong!");
define('CREDENTIALS_ALERT', " These credentials do not match our records.");
define('SELECT_ALERT', " has been not selected.");
define('MAX_HOME_BANNER_ALERT', " You can upload only 5 banners for ");
define('MAX_BANNER_ALERT', " You can upload only 1 banner for ");

//Constant for Slug
define('PRODUCTS_SLUG', "product");
define('PROMOTION_SLUG', "promotion");
define('LOGIN_SLUG', "login");
define('SEARCH_SLUG', "search");
define('REGISTER_SLUG', "register");
define('REGISTRATION', 'registration');
define('CATEGORY_SLUG', "get-products-category");
define('HOME_SLUG', "home");
define('CONTACT_SLUG', "contact");
define('THANK_SLUG', "thank");
define('HEALTH_INSURANCE_ENQUIRY', "health-insurance-enquiry");
define('LIFE_INSURANCE_ENQUIRY', "life-insurance-enquiry");
define('FIXED_DEPOSIT_MODE', "fixed-deposit-mode");
define('SAVING_DEPOSIT_MODE', "saving-deposit-mode");
define('WEALTH_DEPOSIT_MODE', "wealth-deposit-mode");
define('FOREIGN_CURRENCY_DEPOSIT_MODE', "foriegn-currency-deposit-mode");
define('PROFILEDASHBOARD', "profile-dashboard");
define('ACCOUNTINFO', "account-information");
define('PRODUCTMANAGEMENT', "product-management");

//display section contact or offer section
define('CONTACT_US_SECTION', "Contact Us Now");
define('OFFER_SECTION', "What We Offer");
define('CONTACT_US_SECTION_VALUE', "contact_us_section");
define('OFFER_SECTION_VALUE', "offer_section");

//value for enquiry option store in constants
define('PRIVATE_COVERAGE', "Private Hospital");
define('GOVERNMENT_COVERAGE', "Government Hospital (A Class Ward)");
define('SEMI_PRIVATE_COVERAGE', "Semi Private Hospital");
define('YES', "Yes");
define('NO', "No");
define('TIME_ANYTIME', "Anytime");
define('TIME_MORNING', "Mornings");
define('TIME_AFTERNOON', "Afternoons");
define('TIME_EVENING', "Evenings");
define('TIME_OTHER', "Other");
define('COMPONENTS_PROTECTION', "Protection");
define('COMPONENTS_INVESTMENT', "Investment");
define('COMPONENTS_SAVING', "Savings");
define('GENDER_MALE', "Male");
define('GENDER_FEMALE', "Female");

//salutation constants
define('MR', "Mr.");
define('MRS', "Mrs.");
define('MISS', "Miss.");

//formula type ids
define('FIX_DEPOSIT_F1', 1);
define('SAVING_DEPOSIT_F1', 2);
define('SAVING_DEPOSIT_F2', 3);
define('SAVING_DEPOSIT_F3', 4);
define('SAVING_DEPOSIT_F4', 5);
define('SAVING_DEPOSIT_F5', 6);
define('ALL_IN_ONE_ACCOUNT_F1', 7);
define('ALL_IN_ONE_ACCOUNT_F2', 8);
define('ALL_IN_ONE_ACCOUNT_F3', 9);
define('ALL_IN_ONE_ACCOUNT_F4', 10);