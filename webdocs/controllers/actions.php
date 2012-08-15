<?php
$base_path = dirname(__FILE__) . '/../../';
require $base_path . 'config/facile.php';
include facile::$path_includes . 'functions.php';
include facile::$path_includes . 'uiFunctions.php';
$requestedAction = $_REQUEST['qq']; //echo "<pre>".print_r($_REQUEST,1)."</pre>";

switch ($requestedAction) {
    //Homepage Controller Definition//
   case 'action/logout':
        $callAction = 'logout';
        break;
   case 'action/login':
        $callAction = 'login';
        break;
   case 'action/forgotpassword':
        $callAction = 'forgotpassword';
        break;
   case 'action/get_time':
        $callAction = 'get_time';
        break;

   case 'action/resetpassword':
        $callAction = 'resetpassword';
        break;
   case 'action/changepassword':
        $callAction = 'changepassword';
        break;
   case 'action/updateschedule':
        $callAction = 'updateschedule';
        break;
   case 'action/teams_by_match':
        $callAction = 'teams_by_match';
        break;
   case 'action/unique':
        $callAction = 'unique';
        break;
   case 'action/unique_date_range':
        $callAction = 'unique_date_range';
        break;
   case 'action/unique_event_date_range':
        $callAction = 'unique_event_date_range';
        break;
   case 'action/check_feed':
        $callAction = 'chk_feed';
        break;

   case 'action/subcategories':
        $callAction = 'subcategories';
        break;

   case 'action/autocomplete':
        $callAction = 'autocomplete';
        break;
   case 'action/updateclip':
        $callAction = 'updateclip';
        break;
   case 'action/publishxmldata':
        $callAction = 'publish_xmldata';
        break;
   case 'action/jq_fileupload':
        $callAction = 'jq_fileupload';
        break;
   case 'action/upload_crop':
        $callAction = 'upload_crop';
        break;
   case 'action/checkuniqueblog':
        $callAction = 'blog';
        break;
   case 'action/adspot':
        $callAction = 'adspot';
        break;
   case 'action/updatesnewsfeatured':
        $callAction = 'updatesnewsfeatured';
        break;
   case 'action/feature':
        $callAction = 'feature';
        break;
    case 'action/setNewsPriority':
        $callAction = 'setNewsPriority';
        break;
    case 'action/actionNewsIcons':
        $callAction = 'actionNewsIcons';
        break;
    case 'action/blogs':
        $callAction = 'blog';
        break;
    case 'action/sponser':
        $callAction = 'sponser';
        break;
    case 'action/delete_uploaded_image':
        $callAction = 'delete_uploaded_image';
        break;
	 case 'action/assignscreen':
        $callAction = 'assignscreen';
        break;
	case 'action/addskin':
        $callAction = 'addskin';
        break;
   case 'action/cleancachelog':
        $callAction = 'cleancachelog';
        break;
   case 'action/midroles':
        $callAction = 'midroles';
        break;
  case 'action/akamai':
        $callAction = 'akamai';
        break;
  case 'action/genGutterJson':
        $callAction = 'genGutterSkinJson';
        break;
  case 'action/savecurrentmatch':
        $callAction = 'saveCurrentMatch';
        break;
  default:
        break;
}
include_once facile::$path_actions . $callAction . '.php';