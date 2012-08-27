<?php
//CSS FileNames Constants
define("CSS_GLOBAL", "global");
define("CSS_LIGHTMODAL", "lightmodal");
define("CSS_MESSAGEBOX","messagebox");

//datepicker CSS files - sequence
define("CSS_DATEPICKER_CONFIG", "datepicker-config");
define("CSS_DATEPICKER_JQ_UI_CUSTOM", "datepicker-jquery-ui-1.8.17.custom");

//JS files
define("JSLIB_JQUERY", "lib/jquery");
define("JSLIB_LAZYLOADER", "lib/lazyloader");
define("JSLIB_AJAXLOADER", "lib/ajaxloader");
define("JSLIB_LOADER", "lib/loader");
define("JSLIB_LIGHTMODAL", "lib/lightmodal");
define("JSLIB_AUTOCOMPLETE", "lib/jquery.autocomplete");
define("JSLIB_MASKING", "lib/jquery.maskedinput-1.3");
define("JS_GLOBAL", "global");
define("JS_MESSAGES","messages");
define("JS_LOGIN", "login");
define("JS_EVENT", "event");

define("JSLIB_FORM_AUTOCOMPLETE", "lib/form_autocomplete");
define("JS_MIDROLES", "midroles");

//datepicker JS files - sequence
define("JSDATEPICKER_JQ_UI_CORE", "datepicker/jquery.ui.core");
define("JSDATEPICKER_JQ_UI_WIDGET", "datepicker/jquery.ui.widget");
define("JSDATEPICKER_JQ_UI_DATEPICKER", "datepicker/jquery.ui.datepicker");

//JS files
define("JSLIB_JQUERYMIN", "lib/jquery-1.3.2.min");
define("JSLIB_PSTRENGTH", "lib/jquery.pstrength-min.1.2");
define("JSLIB_TABLESORTERMIN", "lib/jquery.tablesorter.min");
define("JSLIB_TABLESORTERPAGER", "lib/jquery.tablesorter.pager");
define("JSLIB_WYSIWYG", "lib/jquery.wysiwyg");
define("JSLIB_THIKBOX", "lib/thickbox");
define("JSLIB_VALIDATE", "lib/jquery.validate");

define("JSLIB_DATETIMEPICKERUI", "lib/jquery-ui-1.7.1.custom.min");
define("JSLIB_DATETIMEPICKER", "lib/jquery-ui-timepicker-addon");
define("JSLIB_MIN", "lib/jquery-1.5.1.min");
define("CSS_UICUSTOM", "jquery-ui-1.8.14.custom");

define("JSLIB_FILEUPLOADER", "lib/fileuploader");

define("JS_VENUE", "venue");
define("JS_SIGNIN", "signin");
define("JS_ADMINUSER", "adminuser");
define("JSLIB_FORM", "lib/jquery.form");
define("JS_READERS_CORNER", "readers_corner");
define("JS_ALLIED_SERVICES", "allied_services");
define("JS_LEADS","leads");
define("JS_VENUETYPE", "venuetype");

define('JS_SEPRATOR','###');

define("CSS_GRID", "grid");
define("CSS_IE", "ie");
define("CSS_IE6", "ie6");
define("CSS_WYSIWYG","jquery.wysiwyg");
define("CSS_RESET","reset");
define("CSS_STYLES","styles");
define("CSS_TABLESORTER","tablesorter");
define("CSS_THEMEBLUE","theme-blue");
define("CSS_THICKBOX","thickbox");
define("CSS_AUTOCOMPLETE","jquery.autocomplete");
define("CSS_STYLES1","style1");

// Define tables
define('ADMINROLE','admin_roles');
define('ADMINUSER','admin_users');
define('ADMINUSERINFO','admin_users_info');
define('ADMINMODULE','admin_modules');
define('ADMINMODULESUSERS','admin_modules_users');

//venues and related tables
define('VENUES','venue');
define('VENUE_TYPE', 'venuetype');
define('CAPACITY', 'capacity');
define('VENUE_CAPACITY_MAPPING', 'venue_capacity_mapping');
define('VENUE_IMAGE_ALTTAG', 'venue_image_alttag');
define('VENUE_SEO_INFO', 'venue_seo_info');
define('VENUE_TYPE_MAPPING', 'venue_type_mapping');
define('VENUE_REGION', 'region');
define('VENUE_POPULAR_CHOICE', 'popular_choice');
define('BOOK_NOW', 'book_now');

define('ROLES','roles');
define('SEO','seo');
define('SEOUSER','seo_user');
define('TABLE_DATA_LIMIT',10);
define('RECORDS_PER_PAGE',20);
//colomns

$ADMINUSERCOL = array('id','name','username','password','email','role_id','status','last_login','image','created_on','created_by','modified_on','modified_by','landing_url');
$ADMINUSERINFOCOL = array('id', 'admin_user_id', 'designation', 'fb_url', 'twitter_url', 'google_plus_url', 'email', 'office_phone', 'home_phone', 'mobile', 'alternate_mobile','about','seo_key');

// Session Vaiables Admin
define('_ADMIN_ID','admin_user_id');
define('_PARENT_ID','parent_id');
define('_ROLE_ID','admin_role_id');
define('_ADMIN_NAME','admin_name');
define('_ACTIVE_TAB','active_tab');
//End Session

// Message Error
define('_LOGIN_FAILED','Invalid Login!');
define('_DATA_INSERT','Added Successfully!');
define('_REQUIRED_FIELD','Please enter all required fields!');
define('_IMAGE_UPLOAD_FIELD','Image upload failed.');
define('_DATA_UPDATE','Data updated successfully!');
define('_DATA_UPDATE_FAILED','Data update failed!');
define('_PAGE_NOT_FOUND','Page Not Found!');
define('_ERROR_SUBSCRIBE','Username OR Email already exists!');
define('_SUBSCRIBE','Subscription successfull!');
define('_PASSWORD_ERR','PASSWORD DO NOT MATCH!');
define('_PASSWORD_WORNG','Old PASSWORD is not valid!');
define('_PASSWORD_MSG','PASSWORD changed successfully.');
define('_TITLE_EXISTS', 'Content title exists in database');
define('_INAVLID_FORMAT', 'File format is not valid.');
define('_UPLOAD_SUCCESS', 'Uploaded successfully.');
define('_UPLOAD_FIELD','Upload failed.');
define('_INAVALID_DATA','Please enter valid data.');
define('_EVENT_UNIQUENESS','This time slot is already occupied by some other event.');
define('_EVENT_PROCESSED','Event has been proceesed.');
define('_ITEM_STATUS_CHANGED','Status has been changed.');
define('_NO_RESULT_FOUND','No records found pertaining to search.');
