<?php

include_once facile::$path_classes . "/content/content.php";
include_once facile::$path_classes . "/image/image.php";

class contentBlock {

    function process() {
        is_loggedin();
        if (isset($_REQUEST['view']))
            $view = $_REQUEST['view'];
        switch ($view) {
            case 'add':
            case 'edit':
                $qarr = array();
                $qarr['id'] = ($_POST['id']) ? $_POST['id'] : $_GET['id'];
                if ((trim($qarr['id']) != '' && trim($_REQUEST['action']) == 'updateContent') || trim($_REQUEST['action']) == 'saveContent') {
                    // poster
                    $image_obj = new image();

                    // image
                    if ($_FILES['image']) {
                        $upload_path = facile::$path_assets . 'images/';
                        if ($image = $image_obj->upload_image_resize($_FILES['image'], $upload_path)) {
                            $_POST['image'] = $image;
                        }
                    }
                    else
                    $_POST['image'] = $_POST['content_image'];
                    // update team
                    $tplData['msg'] = ($qarr['id'] > 0) ? _DATA_UPDATE : _DATA_INSERT;
                    if ($qarr['id'] = Content::update_contents($qarr)) {
                        $tplData['class'] = 'success';
                    } else {
                        $tplData['msg'] = _DATA_UPDATE_FAILED;
                        $tplData['class'] = 'error';
                    }
                }
                $records = Content::get_contents_list($qarr);
                $tplData['records'] = $records[0];
                if ($view == 'edit' || $qarr['id'] > 0)
                    $tplData['tpl'] = 'content_edit.tpl';
                else
                    $tplData['tpl'] = 'content_add.tpl';
           break;

           default:
                if(trim($_REQUEST['id']) != '' && trim($_REQUEST['action']) == 'changeStatus') {
                  Content::change_status($_REQUEST['id']);
                }
                if(!empty($_REQUEST['vars'])){
                  $vars = $_REQUEST['vars'][0];
                  $sh_keyword = isset($vars['keyword']) ? $vars['keyword'] : "";
                  //print_r($vars);
                  
                  $tplData['sh_keyword'] = $sh_keyword;
                  $arrKeyword = array();
                    if($sh_keyword != '') {
                      $op=" REGEXP ";
                      $sh_keyword_sarch = str_replace(" ",'|',$sh_keyword);
                      $arrKeyword[] = " title ".$op."'".$sh_keyword_sarch."'";
                      $arrKeyword[] = " description ".$op."'".$sh_keyword_sarch."'";
                      if(count($arrKeyword)>0) {
                        $qarr[] = "( ".implode(" OR ",$arrKeyword )." )";
                      }
                   }
                   $records = Content::get_content_searchResult($qarr);
                }else{
                  $records = Content::get_contents_list();
                }
                $tplData['records'] = $records;
            break;
        }




        return $tplData;
    }

}