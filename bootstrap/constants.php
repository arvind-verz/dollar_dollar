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
define('ADMIN_EMAIL', 'admin@dollardollar.sg');
define('WEALTH_EMAIL', 'wealth@dollardollar.sg');
define('HOME_LOAN_EMAIL', 'homeloan@dollardollar.sg');
define('ENQUIRY_EMAIL', 'contactus@dollardollar.sg');

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
define('SYSTEM_SETTING_LEGEND_MODULE', "System Setting Legend Table Management");
define('PERMISSION_MODULE', "Permission Management");
define('BLOG_MODULE', "Blog Management");
define('BLOG_CATEGORY_MODULE', "Blog Category Management");
define('ENQUIRY_MODULE', "Enquiry Management");
define('TAG_MODULE', "Tag Management");
define('RATE_TYPE_MODULE', "Rate Type Management");
define('REPORT_MODULE', "Report Management");
define('FIX_DEPOSIT_MODULE', "Fix Deposit");
define('SAVING_DEPOSIT_MODULE', "Saving Deposit");
define('ALL_IN_ONE_ACCOUNT_DEPOSIT_MODULE', "All in One Account Deposit");
define('PRIVILEGE_DEPOSIT_MODULE', "Privilege Deposit");
define('FOREIGN_CURRENCY_DEPOSIT_MODULE', "Foreign Currency Deposit");
define('LOAN_MODULE', "Loan");

define('ADS_MANAGEMENT', "Ads Management");

//Single Module Name for action
define('PRODUCT_MODULE_SINGLE', "Product");
define('CATEGORY_MODULE_SINGLE', "Category");
define('BANNER_MODULE_SINGLE', "Banner");
define('ADS_MODULE_SINGLE', "Ads");
define('BRAND_MODULE_SINGLE', "Brand");
define('USER_MODULE_SINGLE', "User");
define('REPORT_MODULE_SINGLE', "Report");
define('CUSTOMER_MODULE_SINGLE', "Customer");
define('CUSTOMER_DELETION_MODULE_SINGLE', "Customer Deletion ");
define('CUSTOMER_UPDATE_DETAIL_SINGLE', "Customer Update Details ");
define('ORDER_MODULE_SINGLE', "Order");
define('HOMEPAGE_MODULE_SINGLE', "Homepage");
define('ACTIVITY_LOG_MODULE_SINGLE', "Activity Log");
define('MENU_MODULE_SINGLE', "Menu");
define('PAGE_MODULE_SINGLE', "Page");
define('SYSTEM_SETTING_MODULE_SINGLE', "System Setting");
define('SYSTEM_SETTING_LEGEND_MODULE_SINGLE', "Legend Table Setting");
define('PERMISSION_MODULE_SINGLE', "Permission");
define('BLOG_MODULE_SINGLE', "Blog");
define('BLOG_CATEGORY_MODULE_SINGLE', "Blog Category");
define('HEALTH_INSURANCE_ENQUIRY_MODULE', "Health Insurance Enquiry");
define('LIFE_INSURANCE_ENQUIRY_MODULE', "Life Insurance Enquiry");
define('INVESTMENT_ENQUIRY_MODULE', "Investment Enquiry");
define('CONTACT_ENQUIRY_MODULE', "Contact Enquiry");
define('LOAN_ENQUIRY_MODULE', "Loan Enquiry");
define('TAG_MODULE_SINGLE', "Tag");
define('RATE_TYPE_MODULE_SINGLE', "Rate Type");
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
define('ADS_MODULE_ID', 39);
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
define('HOME_PAGE_ID', 18);
//Blog menu id
define('BLOG_MENU_ID', 21);
define('WEALTH_MENU_ID', 22);
define('PRODUCT_ID', 37);

//Alert messages
define('IMPORTED_ALERT', " has been successfully imported.");
define('EXPORT_ALERT', " has been successfully exported.");
define('ADDED_ALERT', " has been successfully added.");
define('ADDED_ERROR_ALERT', " has been already added.");
define('UPDATED_ALERT', " has been successfully updated.");
define('DELETED_ALERT', " has been successfully deleted.");
define('ALREADY_TAKEN_ALERT', " has already been taken.");
define('OPPS_ALERT', " Oops! Something went wrong!");
define('CREDENTIALS_ALERT', " These credentials do not match our records.");
define('SELECT_ALERT', " has been not selected.");
define('MAX_HOME_BANNER_ALERT', " You can upload only 4 banners for ");
define('MAX_BANNER_ALERT', " You can upload only 1 banner for ");
define('EMPTY_AD_IMAGE_ALERT', "At least upload one ad image.");

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
define('HEALTH_INSURANCE', "health-insurance");
define('LIFE_INSURANCE_ENQUIRY', "life-insurance-enquiry");
define('INVESTMENT_ENQUIRY', "investment-enquiry");
define('LIFE_INSURANCE', "life-insurance");
define('FIXED_DEPOSIT_MODE', "fixed-deposit-mode");
define('SAVING_DEPOSIT_MODE', "saving-deposit-mode");
define('PRIVILEGE_DEPOSIT_MODE', "privilege-deposit-mode");
define('FOREIGN_CURRENCY_DEPOSIT_MODE', "foreign-currency-deposit-mode");
define('AIO_DEPOSIT_MODE', "all-in-one-deposit-mode");
define('LOAN_MODE', "loan");
define('LOAN_ENQUIRY', "loan-enquiry");
define('TERMS_CONDITION', "terms-and-condition");
define('PROFILEDASHBOARD', "profile-dashboard");
define('ACCOUNTINFO', "account-information");
define('PRODUCTMANAGEMENT', "product-management");
define('FORGOT_PASSWORD', "forgot-password");
define('RESET_PASSWORD', "reset-password");
define('FORGOT_PASSWORD_RESET', "forgot-password-reset");
define('PRODUCT_MANAGEMENT_SLUG', "product-management");

//display section contact or offer section
define('CONTACT_US_SECTION', "Contact Us Now");
define('OFFER_SECTION', "What We Offer");
define('CONTACT_US_SECTION_VALUE', "contact_us_section");
define('OFFER_SECTION_VALUE', "offer_section");
define('FOOTER3', "Footer 3");
define('FOOTER4', "Footer 4");
define('FOOTER3_VALUE', "footer3");
define('FOOTER4_VALUE', "footer4");

//value for enquiry option store in constants
define('PRIVATE_COVERAGE', "Private Hospital");
define('GOVERNMENT_COVERAGE', "Government Hospital");
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
define('GOAL_INCOME', "Building passive income");
define('GOAL_FAMILY', "Starting a family");
define('GOAL_RETIREMENT', "Retirement");
define('GOAL_OTHER', "Others");
define('RISK_CONSERVATIVE', "Conservative");
define('RISK_MODERATE', "Moderately Conservative");
define('RISK_BALANCED', "Balanced");
define('RISK_GROWTH', "Growth");

//salutation constants
define('MR', "Mr.");
define('MRS', "Mrs.");
define('MISS', "Miss.");

//Promotion Types
//formula type ids
define('FIX_DEPOSIT', 1);
define('SAVING_DEPOSIT', 2);
define('ALL_IN_ONE_ACCOUNT', 3);
define('PRIVILEGE_DEPOSIT', 4);
define('FOREIGN_CURRENCY_DEPOSIT', 5);
define('LOAN', 6);
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
define('ALL_IN_ONE_ACCOUNT_F5', 23);
define('ALL_IN_ONE_ACCOUNT_F6', 25);
define('PRIVILEGE_DEPOSIT_F1', 11);
define('PRIVILEGE_DEPOSIT_F2', 12);
define('PRIVILEGE_DEPOSIT_F3', 13);
define('PRIVILEGE_DEPOSIT_F4', 14);
define('PRIVILEGE_DEPOSIT_F5', 15);
define('FOREIGN_CURRENCY_DEPOSIT_F1', 16);
define('FOREIGN_CURRENCY_DEPOSIT_F2', 17);
define('FOREIGN_CURRENCY_DEPOSIT_F3', 18);
define('FOREIGN_CURRENCY_DEPOSIT_F4', 19);
define('FOREIGN_CURRENCY_DEPOSIT_F5', 20);
define('FOREIGN_CURRENCY_DEPOSIT_F6', 21);
define('PRIVILEGE_DEPOSIT_F6', 22);
define('LOAN_F1', 24);

//search value
define('PLACEMENT', "Placement");
define('INTEREST', "Interest");
define('TENURE', "Tenure");
define('CRITERIA', "Criteria");
define('INSTALLMENT', "Installment");
define('MINIMUM_LOAN_AMOUNT', "Minimum loan");

//Row Heading for Saving Deposit Formula 5
define('CUMMULATED_MONTHLY_SAVINGS_AMOUNT', "CUMMULATED MONTHLY SAVINGS AMOUNT");
define('BASE_INTEREST', "BASE INTEREST");
define('ADDITIONAL_INTEREST', "ADDITIONAL 2% P.A. INTEREST");
define('TOTAL_AMOUNT', "TOTAL AMOUNT");

//sort by constants
define('MINIMUM', "1");
define('MAXIMUM', "2");

//words
define('ONGOING', "Ongoing");
define('EXPIRED', "Expired");

//Error Message
define('CRITERIA_ERROR', "Sorry. Products do not meet your search criteria");
define('NOT_ELIGIBLE', "Placement amount not eligible for this promotion/product");
define('NILL', "NIL");
define('MONTHS', "Months");
define('DAYS', "Days");
define('UNTIL', "Until");
define('SEARCH_RESULT_ERROR', "There are no results that match your search");
define('BLOG_NOT_FOUND', "");


// single lines for product result
define('BASE_EFFECTIVE_RATE', "Base on effective interest rate for 1 year");

//order by value
define('MAXIMUM_INTEREST_RATE', "maximum_interest_rate");
define('MINIMUM_PLACEMENT_AMOUNT', "minimum_placement_amount");
define('PROMOTION_PERIOD', "promotion_period");

//currency
define('SGD', "SGD");
//product name
define('FIX_DEPOSIT_TITLE', "Fixed Deposit");
define('SAVING_DEPOSIT_TITLE', "Saving Deposit");
define('FOREIGN_DEPOSIT_TITLE', "Foreign Deposit");
define('PRIVILEGE_DEPOSIT_TITLE', "Privilege Deposit");
define('ALL_IN_ONE_ACCOUNT_TITLE', "All in one Account");
define('LOAN_TITLE', "Loan");
//drop down constants
define('BOTH_VALUE', "Both");
define('FIXED_RATE', "Fixed");
define('FIX_RATE', "Fix");
define('FLOATING_RATE', "Floating");
define('FIX_RATE_TYPE', "Fix");
define('SIBOR_RATE_TYPE', "Sibor");

//Property type
define('HDB_PROPERTY', "HDB");
define('PRIVATE_PROPERTY', "Private");
define('COMMERCIAL_INDIVIDUAL_PROPERTY', "Commercial/Individual");
define('HDB_PRIVATE_PROPERTY', "HDB/Private");
define('COMMERCIAL_PROPERTY', "Commercial Individual");

//Completion status
define('COMPLETE', "Completed");
define('COMPLETE_BUC', "Completed/BUC");
define('BUC', "BUC");
define('ALL', "ALL");

//log status
define('DEACTIVATED', 1);
define('DELETED', 2);

//update By
define('ADMIN_USER', 'Admin');
define('FRONT_USER', 'User');
define('YOU', 'You');



