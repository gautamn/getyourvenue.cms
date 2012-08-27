<?php

///////////// Default definition for controller //////
view::$callback = "";
view::$outer_frame = "page_frame_default.tpl";
view::$header_tpl = "page_header.tpl";
view::$footer_tpl = "page_footer.tpl";
view::$jsFiles = Array(JSLIB_JQUERY, JSLIB_LOADER, JS_GLOBAL, JS_LOGIN, JS_MESSAGES, JSLIB_LIGHTMODAL, JSLIB_AJAXLOADER, JSLIB_PSTRENGTH, JSLIB_TABLESORTERMIN, JSLIB_TABLESORTERPAGER, JSLIB_VALIDATE,JSLIB_MASKING,JSLIB_FILEUPLOADER); // JSLIB_JQUERYMIN
view::$cssFiles = Array( CSS_LIGHTMODAL, CSS_MESSAGEBOX, CSS_GRID, CSS_IE, CSS_IE6, CSS_WYSIWYG, CSS_RESET, CSS_STYLES, CSS_TABLESORTER, CSS_THEMEBLUE, CSS_THICKBOX, CSS_STYLES1); // CSS_GLOBAL
view::$bodyclass = 'homeinner';
facile::$GLOBALS['cur_menu_tab'] = '';
view::$submenu = $requestedPage.(isset($_REQUEST['view']) ? '?view='.$_REQUEST['view']:'');
//echo "<br>requestedPage: ".$_SESSION['requestedPage']." , ".$requestedPage;
switch ($requestedPage) {
    case 'logout':
        view::$jsInPage = ' document.location = JSWebURL+"action/logout";';
        break;
    case 'forgotpassword':
        view::$bodyclass = 'homeinner';
        //view::$blocks['middle'] = 'forgotpasswordBlock';
        view::$frames['middle'] = 'frame_three_cols.tpl';
        view::$blocks['middle'] = array('col2' => array('forgotpasswordBlock'));
        break;
    case 'resetpassword':
        if (!empty($_GET['token'])) {
            view::$bodyclass = 'homeinner';
            //view::$blocks['middle'] = 'resetpasswordBlock';
            view::$frames['middle'] = 'frame_three_cols.tpl';
            view::$blocks['middle'] = array('col2' => array('resetpasswordBlock'));
        } else {
            view::$jsInPage = ' document.location = JSWebURL;';
        }
        break;
    case 'changepassword':
        if (!empty($_SESSION['admin_user_id'])) {
            view::$bodyclass = 'homeinner';
            //view::$blocks['middle'] = array('changepasswordBlock');
            view::$frames['middle'] = 'frame_three_cols.tpl';
            view::$blocks['middle'] = array('col2' => array('changepasswordBlock'));
            //view::$callback = 'callbacksearch';
        } else {
            view::$jsInPage = ' document.location = JSWebURL;';
        }
        break;
    case 'venue':
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
        view::$jsFiles[] = JS_VENUE;
        view::$blocks['middle'] = array('venueBlock');
      }else{
        view::$jsInPage = ' document.location = JSWebURL;';
      }
      break;
    case 'adminusers':
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
        view::$jsFiles[]    = JS_ADMINUSER;
        view::$blocks['middle'] = array('adminuserBlock');
      }else{
        view::$jsInPage = ' document.location = JSWebURL;';
      }
      break;
    case 'readerscorner':
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
        view::$jsFiles[]    = JS_READERS_CORNER;
        view::$blocks['middle'] = array('readersCornerBlock');
      }else{
        view::$jsInPage = ' document.location = JSWebURL;';
      }
      break;
    case 'alliedservices':
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
        view::$jsFiles[]    = JS_ALLIED_SERVICES;
        view::$blocks['middle'] = array('alliedServicesBlock');
      }else{
        view::$jsInPage = ' document.location = JSWebURL;';
      }
      break;
    case 'leads':
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
        view::$jsFiles[]    = JS_LEADS;
        view::$blocks['middle'] = array('leadsBlock');
      }else{
        view::$jsInPage = ' document.location = JSWebURL;';
      }
      break;
    case 'home':
      //view::$jsInPage = ' document.location = JSWebURL+"action/logout";';
      view::$bodyclass = 'homeinner';
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
          view::$blocks['middle'] = array('homeTop');
      }else {
          //view::$blocks['middle'] = array('loginBlock') ;
          view::$frames['middle'] = 'frame_three_cols.tpl';
          view::$blocks['middle'] = array('col2' => array('loginBlock'));
      }
      //view::$callback = 'callbackhome';
      view::$jsFiles[] = JSLIB_AJAXLOADER;
      break;
    case 'venuetype':
      if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] > 0) {
        view::$jsFiles[] = JS_VENUETYPE;
        view::$blocks['middle'] = array('venueTypeBlock');
      }else{
        view::$jsInPage = ' document.location = JSWebURL;';
      }
      break;
    default:
      //view::$jsInPage = ' document.location = JSWebURL+"action/logout";';
      view::$bodyclass = 'homeinner';
      view::$blocks['middle'] = array('error404Block');
      break;
}

if (isset($_POST['requesttype']) && $_POST['requesttype'] == 'lazyloading') {
    $_GET['page'] = $_POST['page'];
    view::$renderMode = 'lazyloading';
    $blocks = $_POST['blocks'];
    $jsonresponse = view::renderBlockHtml($blocks);
    echo json_encode(array('script' => view::$jsInPage, 'blockscontent' => $jsonresponse));
    $jsonresponse = null;
    die();
}

if (isset($_POST['requesttype']) && $_POST['requesttype'] == 'ajaxloading') {
    //$_GET['page'] = $_POST['page'];
    view::$renderMode = 'ajaxloading';
    $blocks = array($_POST['blocks']);
    $jsonresponse = view::renderBlockHtml($blocks);
    //echo json_encode($jsonresponse);
    echo json_encode(array('script' => view::$jsInPage, 'blockscontent' => $jsonresponse));
    $jsonresponse = null;
    die();
}
include facile::$path_controllers . 'seo.php';
echo view::render();
