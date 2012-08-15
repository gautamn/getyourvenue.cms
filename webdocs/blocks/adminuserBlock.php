<?php
include_once facile::$path_classes . "/users/users.php";
include_once facile::$path_classes . "/adminrole/adminrole.php";
include_once facile::$path_classes . "/image/image.php";
class adminuserBlock{
	
    function process(){
        is_loggedin();
        // view Admin Users                           
        if(isset($_REQUEST['view']))
            $view = $_REQUEST['view'];
        $vars = $_REQUEST['vars'][0];
        //echo '<pre>';print_r($vars);die;
        if(trim($vars['action']) == 'checkUniqueAdminUsername' && $vars['ajax']){
          $ret = users::validate_admin_user($vars,$vars['id']);
          if($ret<0){
            view::$jsInPage .= ' setUniqueUserName(0); '; 
          }else{
            view::$jsInPage .= ' setUniqueUserName(1); '; 
          }
        }
	elseif($view == 'edit' || $view == 'add') {
            $qarr = array();
			$qarr['id'] = $id = ($_POST['id'])?$_POST['id']:$_GET['id'];
			
			if((trim($qarr['id']) != '' && trim($_REQUEST['action']) == 'updatAdminUser') || trim($_REQUEST['action']) == 'saveAdminUser') {
        
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
			
      if($view == 'edit' || $qarr['id']>0)
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
      if($vars['id'] > 0 && trim($vars['action']) == 'changeStatusAdminUser') {
				users::change_status($vars['id']);
			}
      $tplData['sh_keyword'] = $vars['keyword'];
			$records = users::get_admin_users(array('keyword'=>$vars['keyword'])); 
			$tplData['records'] = $records;
		}
		//echo '<pre>';print_r($records);
		return $tplData;
	}
}