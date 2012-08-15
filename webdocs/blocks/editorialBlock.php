<?php

include_once facile::$path_classes . "/editorial/editorial.php";
include_once facile::$path_classes . "/image/image.php";
include_once facile::$path_classes . "/category/category.php";
class editorialBlock {

  function process() {
    is_loggedin();
    // view events
    //echo '<pre>';print_r($_REQUEST);die;
    if (isset($_REQUEST['view']))
      $view = $_REQUEST['view'];
 
    global $TIPSOFDAYCOLS;
    
        
    
    $arrTblName = array();
    $arrTblName['tips_add']   = TIPSOFDAY;
    $arrTblName['tips_edit']  = TIPSOFDAY;
    $arrTblName['image_add']  = HOMEIMAGE;
    $arrTblName['image_edit'] = HOMEIMAGE;
    
    switch ($view) {

      case 'tips_add':
      case 'tips_edit':  
      case 'image_edit':    
      case 'image_add':   
        $qarr = array();
        $qarr['id'] = ($_POST['id']) ? $_POST['id'] : $_GET['id'];
       
        if($view=="image_edit" || $view=="image_add") {
          $image_obj = new image();  
          if ($_FILES['image']) {
                  $upload_path = facile::$path_assets . 'images/';
                  if ($image = $image_obj->upload_image_resize($_FILES['image'], $upload_path)) {
                      $_POST['image'] = $image;
                  }
            }
            else
               $_POST['image'] = $_POST['home_image'];   
        }elseif($view=="tips_edit" || $view=="tips_add") {
          $tplData['arr_categories'] = Category::get_category_id_name_pair(false,0,'tch');
          $tplData['showType'] = 1;
        }
        
        if (trim($_REQUEST['action']) == 'saveEditorial') {
              $tplData['msg'] = ($qarr['id'] > 0) ? _DATA_UPDATE : _DATA_INSERT;
              if ($qarr['id'] = Editorial::update_editorials($qarr,$arrTblName[$view])) {
                $tplData['class'] = 'success';
              } else {
                $tplData['msg'] = _DATA_UPDATE_FAILED;
                $tplData['class'] = 'error';
              }
        }
        $records = Editorial::get_editorials($qarr,$arrTblName[$view]);
        $tplData['records'] = $records[0];
        $tplData['tpl'] = 'editorial_'.$view.'.tpl';

        break;

      default:
        
        
        if(isset($_REQUEST['vars']))
         $vars = $_REQUEST['vars'][0]; 
      
        $id = trim($vars['id'])? trim($vars['id']) : trim($_REQUEST['id']);
        $action = trim($vars['action'])? trim($vars['action']) : trim($_REQUEST['action']);
        $tblName = trim($vars['tblName'])? trim($vars['tblName']) : trim($_REQUEST['tblName']);
        
        
        if ($id != '' && $action == 'changeStatus') {
          Editorial::change_status($id,$tblName);
        }
        
        $qarr = array();
        if($tblName=="") {
          $tblName = ($_POST['tblName']) ? $_POST['tblName'] : TIPSOFDAY;
        }
        $sh_keyword = trim($vars['sh_keyword']);
        $arrKeyword = array();
        if($sh_keyword != '') {
             $op=" REGEXP ";
             $sh_keyword_sarch = str_replace(" ",'|',$sh_keyword); 
             if($vars['tblName']==TIPSOFDAY) {
                $arrKeyword[] = " text   ".$op."'".$sh_keyword_sarch."'"; 
             } 
             if($vars['tblName']==HOMEIMAGE) {
                $arrKeyword[] = " title   ".$op."'".$sh_keyword_sarch."'"; 
             } 
             
             if(count($arrKeyword)>0)
             $qarr[] = "( ".implode(" OR ",$arrKeyword )." )";
             $tblName = trim($vars['tblName']);
        }
        
        if($view=="image"){
           $tblName = HOMEIMAGE;
           $tplData['tpl'] = 'editorialHomeImage_inner_default.tpl';
        }
        
        
        $records = Editorial::get_editorials_searchResult($qarr,$tblName);
        $tplData['records'] = $records;
        break;
    }


    return $tplData;
  }

}