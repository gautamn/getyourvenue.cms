<?php
include_once facile::$path_classes . "/users/users.php";
include_once facile::$path_classes . "/adminrole/adminrole.php";
include_once facile::$path_classes . "/image/image.php";
class adminuserBlock{

    function process(){
        is_loggedin();
        // view Admin Users
        $qarr = isset($_REQUEST) ? $_REQUEST : array();
        $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';

        $vars = isset($_REQUEST['vars'][0]) ? $_REQUEST['vars'][0] : array();
        //echo '<pre>';print_r($vars);die;
        if(isset($vars['action']) && trim($vars['action']) == 'checkUniqueAdminUsername' && $vars['ajax']){
          $ret = users::validate_admin_user($vars,$vars['id']);
          if($ret<0){
            view::$jsInPage .= ' setUniqueUserName(0); ';
          }else{
            view::$jsInPage .= ' setUniqueUserName(1); ';
          }
        }
        elseif($view == 'edit' || $view == 'add') {
          $qarr = array();
       $qarr['id'] = $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

			if(isset($qarr['id']) && $qarr['id']>0 && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'updatAdminUser' || $_REQUEST['action'] == 'saveAdminUser')) {

        // update AdminUser
        $tplData['msg'] = ($qarr['id']>0)?_DATA_UPDATE:_DATA_INSERT;
				if($qarr['id'] = users::update_admin_user($qarr)){
          if($qarr['id']>0){
            $tplData['class'] = 'success';
          }else{

            if($qarr['id'] == -1)
					    $tplData['username_msg'] = 'Username already exists';
            elseif($qarr['id'] == -2)
					    $tplData['username_msg'] = 'Username can not be left blank';

					  $tplData['msg'] = _DATA_UPDATE_FAILED;
            $tplData['class'] = 'error';

            $qarr['id'] = $id;
          }
				}
				else{
					$tplData['msg'] = _DATA_UPDATE_FAILED;
					$tplData['class'] = 'error';
				}
			}

      if($view == 'edit' && (isset($qarr) && $qarr['id']>0))
      {
        $tplData['tpl'] = 'adminuser_edit.tpl';
        $records=users::get_admin_users($qarr);
        $tplData['records'] = $records[0];
      }
      else{
        $tplData['records'] = $_POST;
			  $tplData['tpl'] = 'adminuser_add.tpl';
      }

      $tplData['arr_adminrole'] = AdminRole::get_id_name_pair();
		}
		else{
      if(isset($vars['id']) && $vars['id'] > 0 && trim($vars['action']) == 'changeStatusAdminUser') {
				users::change_status($vars['id']);
			}
      $tplData['sh_keyword'] = !empty($vars['keyword']) ? $vars['keyword'] : '';
			$records = users::get_admin_users(array('keyword'=>$tplData['sh_keyword']));
			$tplData['records'] = $records;
		}
		//echo '<pre>';print_r($records);
		return $tplData;
	}
}