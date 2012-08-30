<?php
/**
 * @desc Manage Admin Users
 */
include_once facile::$path_classes . "/adminrole/adminrole.php";

class users{

  function processLogin($params) {
    $Query = "select * from " . ADMINUSER . " where username = ? AND password = ? AND status = 1";
    $data = array($params['username'],md5($params['password']));
    $res = fDB::fetch_assoc_all($Query, $data);
    $row = current(end($res));
    //echo "select * from " . ADMINUSER . " where username = $params[username] AND password = $params[password] AND status = 1";
    return $row;
  }

  function setSession($params) {
    $_SESSION['admin_email'] = $params['email'];
    $_SESSION['admin_user_name'] = $params['username'];     // $_SESSION['username'] =
    $_SESSION['admin_name'] = $params['name'];
    $_SESSION['admin_user_id'] = $params['id'];             // $_SESSION['user_id'] =
    $_SESSION['admin_role_id'] = $params['role_id'];
    $_SESSION['admin_user_status'] = $params['status'];     // $_SESSION['user_status'] =
    $_SESSION['admin_landing_url'] = trim($params['landing_url']);     // $_SESSION['user_status'] =
    $_SESSION['admin_user_img'] = getArtworkURL('auser', getSEO($_SESSION['admin_user_id'],'admin_user').'_'.$_SESSION['admin_user_id'].'.jpg' ,'small');
    //self::updateLastLogin('sess_' . session_id(), $_SESSION['admin_user_id']);
  }

  function updateLastLogin($user_id, $session='') {
    /*$Query = "select user_session from " . ADMINUSER . " where id=?";
    $data = array($user_id);
    $res = fDB::fetch_assoc_all($Query, $data);
    $row = current(end($res));
    if (!empty($row['user_session'])) {
      unlink(session_save_path() . '/' . $user_session[0]);
    }
    $Query = "update users set last_login=now(),user_session=? where id=?";
    $data = array($session, $user_id);
    */
    $Query = "update " . ADMINUSER . " set last_login=now() where id=?";
    $data = array($user_id);
    fDB::query($Query, $data);
  }

  function unsetSession() {
    unset($_SESSION['admin_user_name']);
    unset($_SESSION['admin_user_id']);
    unset($_SESSION['admin_role_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['admin_email']);
    unset($_SESSION['admin_user_status']);
    unset($_SESSION['admin_user_img']);
    unset($_SESSION['admin_landing_url']);
  }

  function changePassword($params)
  {
    //$ret = self::validatePassword($params['user_id'], $params['password']);
    $ret = 0;
    $params = prepareAddSlashes($params);
    $user_id = (int) $params['user_id'];
    $newpassword = $params['newpassword'];
    $password = $params['password'];
    if($user_id > 0 && $newpassword && $password)
    {
      $Query = "select count(id) as tot from " . ADMINUSER . " where password='" .  md5($params['password']) . "' and id='" . (int) $user_id . "'";
      $res = fDB::fetch_assoc_first($Query);
      if($res['tot'] > 0)
      {
        $Query = "UPDATE " . ADMINUSER . " set password=? where id =?";
        $data = array(md5($params['newpassword']), $user_id);
        $res = fDB::query($Query, $data);
        $ret = 1;
      }
      else
      {
        $ret = 2;
      }
    }
    return $ret;
  }

  function adminUserDetails($id){
		$Query="SELECT * FROM " . ADMINUSER . " where id=".(int)$id;
		$row = fDB::fetch_assoc_first($Query);
		return $row;
	}

  function setToken($params) {
    $Query = "INSERT INTO admin_forgot_password set user_id=?, token=?";
    $data = array((int) $params['id'], $params['token']);
    fDB::query($Query, $data);
  }

  function getToken($lenth = 10) {
    $arrstr = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    $out = '';
    for ($c = 0; $c < $lenth; $c++) {
      $out .= $arrstr[mt_rand(0, count($arrstr) - 1)];
    }
    return $out;
  }

  function resetToken($params) {
    $Query = "SELECT user_id from admin_forgot_password WHERE token = ? AND status = 1 ORDER BY enter_date desc LIMIT 1";
    $data = array($params['token']);
    $row = current(end(fDB::fetch_assoc_all($Query, $data)));
    if ($row['user_id']) {
      $Query = "SELECT email from " . ADMINUSER . " WHERE id='" . $row['user_id'] . "' and status=1 LIMIT 1";
      $res = current(end(fDB::fetch_assoc_all($Query)));
      $params['email'] = $res['email'];

      //sso implementation for forget password
      //   SSO::callApi($params,'forgetpasswordAuth');

      $Query = "UPDATE " . ADMINUSER . " SET password = ? WHERE id=?";
      $data = array(md5($params['password']), (int) $row['user_id']);
      //echo $params['password']; die();
      if (fDB::query($Query, $data)) {
        $Query = "DELETE FROM admin_forgot_password WHERE token=?";
        $data = array($params['token']);
        fDB::query($Query, $data);
        return true;
      }
    }
    return false;
  }

  function forgotPassword($params)
  {
    $params = prepareAddSlashes($params);
    $params['id'] = 0;
    if ($params['useremail']) {
      $Query = "SELECT id, status from " . ADMINUSER . " WHERE email='" . $params['useremail'] . "' LIMIT 1";
      $res = current(end(fDB::fetch_assoc_all($Query)));
      if($res['id']>0)
      {
        $params['id'] = $res['id'];
      }
    }
    return $params['id'];
  }


  function  rightUserDetails($id, $to_show = 0)
	{
		if(trim($id)!='')
		{
      $cond = '';
      $user = self::adminUserDetails($id);
      if($user['role_id']==1)
      {
        $join = "right";
      }
      else
      {
        $join = "inner";
        $cond = " AND user_id='".(int)$id."'";
      }
      $cond .= ($to_show == 1) ? " AND am.priority>=0 " : "";
			$query="select * from admin_modules_users amu ".$join." join admin_modules am on am.id=amu.module_id where am.status=1 ".$cond." group by am.controller_file_name order by am.priority asc"; //echo $query;
			$res = fDB::fetch_assoc_all($query);
			$user_right=array();
			$section_name=array();
      if(!empty($res['result']))
			foreach($res['result'] as $row) {
        $row['rights'] = ($user['role_id']==1) ? 1 : $row['rights'];
        $right_module=trim($row['module']);
        $user_right[$right_module] = $row['rights'];
        if(!(in_array($row['section'],$section_name)))
        {
          $section_name[]=$row['section'];
          $group_section[$row['group']][]=$row['section'];
        }
        $sec_name=strtolower(trim($row['section']));
        $cont_file_rel_url = $row['controller_file_name'];
        if(strpos($cont_file_rel_url,'?')!=false && (strpos($cont_file_rel_url,'~~~')!=false || strpos($cont_file_rel_url,'###')!=false))
        {
          $ary = explode('?', $cont_file_rel_url);
          $q = $ary[1];
          if($q != '~~~') // all paramets are allowed
          {
            $rel_url_ary = array();
            $qAry = explode('&', $q);
            foreach($qAry as $v)
            {
              $vAry = explode('=', $v);
              $key = $vAry[0];
              $val = $vAry[1];
              if($val != '~~~' && $val != '###')
              {
                $rel_url_ary[] = $v;
              }
            }
            $rel_url = trim(implode('&',$rel_url_ary));
            $rel_url = ($rel_url) ? '?'.$rel_url : $rel_url;
            $ary[0] = $ary[0] . $rel_url;
          }
          $cont_file_rel_url = $ary[0];
        }
        $user_right[$sec_name][]=$row['title'].'^~~^'.$cont_file_rel_url.'^~~^'.$row['rights'];
        $user_right[][]=$cont_file_rel_url;
        $user_right['section']=$section_name;
        $user_right['group']=$group_section;
      }
			//echo "<pre>".print_r($user_right,1)."</pre>"; die();
			return $user_right;
		}
	}

  function checkUrlAuthentication($user_id, $q1='', $params=array()){
    unset($params['q']);
    //echo "<br>".$q1."<br><pre>".print_r($params,1)."</pre><br>";
    $autenticationFreeURI = facile::$autenticationFreeURI; // array('forgotpassword','resetpassword','forgetpassword');
    $user = self::adminUserDetails($user_id);
    //echo "U:<pre>".print_r($user,1)."</pre><br>";
    if(!$user['status'] && $_SESSION['admin_user_id']>0) { return true; }

    if($user['role_id']==1) { return 1; }

    //echo dirname(__FILE__);
    //echo "<pre>".print_r($_SERVER,1)."</pre><br>";
    //return true;
    $canAccess = 0;
    $fileNameV = '';
    $exactMatch = 1;
    if (!empty ($q1))
    {
      $uriV = $q1;
      if(count($params)>0)
      {
        $exactMatch = 0;
        foreach($params as $kk=>$vv) { $params[$kk] = $kk."=".$vv; }
        $qV = implode("&", $params);
      }
      $uriV = str_replace('?'.$qV, '', $uriV);
      $qAryV = explode('&', $qV);
      $qAryVKey = $qAryVVal = array();
      foreach($qAryV as $k => $v)
      {
        $vAry = explode('=', $v);
        $qAryVKey[$k] = $vAry[0];
        $qAryVVal[$k] = trim($vAry[1]);
        if($vAry[0] == 'intID' && trim($vAry[1])==='') // exception
        {
          $qAryVVal[$k] = '0';
        }
      }
      $uriAryV = explode('/', $uriV);
      $lastIndV = count($uriAryV) - 1;
      $fileNameV = trim($uriAryV[$lastIndV]);
      $parentDirName = trim($uriAryV[$lastIndV-1]);
    }
    //echo $fileNameV; die(); // manage_content_queue.php
    if(in_array($fileNameV, $autenticationFreeURI) || in_array($parentDirName."/", $autenticationFreeURI) || $fileNameV=='home1')
    {
      return 1;
    }
    elseif(!($user_id>0))
    {
      return 0;
    }
    if($exactMatch)
    {
      $cond = " AND (am.controller_file_name = '".$fileNameV."' OR am.controller_file_name LIKE '".$fileNameV."?%=~~~%' OR am.controller_file_name LIKE '".$fileNameV."?~~~' OR am.controller_file_name LIKE '".$fileNameV."?%=###')";
    }
    else
    {
       $cond = " AND am.controller_file_name LIKE '".$fileNameV."?%'";
    }
    $Query = "SELECT am.id, am.controller_file_name, amu.rights FROM admin_modules am JOIN admin_modules_users amu ON (amu.module_id=am.id) WHERE amu.user_id='".$user_id."' AND am.status = '1' ".$cond." ORDER BY amu.rights, am.priority ";    //echo $Query;
    $res = fDB::fetch_assoc_all($Query);
		if($exactMatch)
    {
      if($row = $res['result'][0])
      {
        $canAccess = ($row['rights'] == 1) ? 1 : 0;
      }
    }
    else
    {
      $keyCount = 0;
      foreach ($res['result'] as $row)
      {
        //echo "<pre>".print_r($row,1)."</pre><br>";
        $q = str_replace($fileNameV.'?', '', $row['controller_file_name']);
        if($q == '~~~') // if all parameters are allowed
        {
          $canAccess = ($row['rights'] == 1) ? 1 : 0;
          continue;
        }
        $qAry = explode('&', $q);
        $keyCount = count($qAry);
        $keyCountMatched = 0;
        foreach($qAry as $v)
        {
          $vAry = explode('=', $v);
          $key = $vAry[0];
          $val = $vAry[1];
          $k = array_search($key, $qAryVKey);
          //echo "<br>".$key."=".$val.", ".$qAryVKey[$k]."=".$qAryVVal[$k];
          if(in_array($key, $qAryVKey) && !($qAryVVal[$k]===''))
          {
            if($val == '~~~')
            {
              $keyCountMatched++;
            }
            else
            {
              if($val == $qAryVVal[$k])
              {
                $keyCountMatched++;
              }
              elseif($val == '###')
              {
                $keyCountMatched--;
              }
            }
          }
          elseif($key == '#~id') // in case of Add Meta , Manage Meta, ...
          {
            $keyCountMatched++;
          }
          elseif($val == '###')
          {
            $keyCount--;
          }
        } // foreach
        if($keyCountMatched == $keyCount)
        {
          $canAccess = ($row['rights'] == 1) ? 1 : 0;
        }
        //echo "<br>".$row['controller_file_name']." , keyCountMatched:".$keyCountMatched ." , keyCount:". $keyCount ." , CanAccess:".$canAccess."<br>" ;
        if($canAccess == true)
        {
          break;
        }
      } // while
    }
    //echo "<br>Final CanAccess:".$canAccess;  die();
    return $canAccess;
  }

  function getAdminRoles($id = -1)
  {
    if($id >= 0)
    {
       $cond = " AND id='".(int)$id."'";
    }
    $query="select * from admin_roles where 1 ".$cond." order by id";
		$res = fDB::fetch_assoc_all($query);
		return $res['result'];
  }

  function getUserDefaultModules($roleid)
  {
    if(!($roleid > 0))
    {
      return array();
    }
    $role = self::getAdminRoles($roleid);
    $role = $role[0];
    $role['default_sections'] = trim($role['default_sections']);
    $role['default_modules'] = trim($role['default_modules']);

    if($role['default_sections']=='all' || $role['default_modules']=='all')
    {
      $cond = "";
    }
    else
    {
      $role['default_modules'] = implode("','", explode(",", $role['default_modules']));
      $role['default_sections'] = implode("','", explode(",", $role['default_sections']));
      $cond = " AND ( id IN ('".$role['default_modules']."') OR section IN ('".$role['default_sections']."') ) ";
    }
    $query="SELECT id,title FROM admin_modules WHERE status = 1 ".$cond." GROUP BY id ORDER BY id"; //echo $query.", ";
		$res = fDB::fetch_assoc_all($query);
		return $res['result'];
  }

  public function where_str($arr) {
    if (is_array($arr)) {
      $data = array();
      $and = '';
      foreach ($arr as $k => $v) {
        if($k=='field_prefix'){continue;}
        if($k=='keyword'){
          if(trim($v)){
            $v = str_replace(" ",'|',trim($v));
            $and .= " ".$arr['field_prefix']."`name` REGEXP ? AND";
            array_push($data, trim($v));
          }
        }else{
          $and .= " ".$arr['field_prefix']."`$k`=? AND";
          array_push($data, trim($v));
        }
      }
      $where = (strlen($and)) ? " WHERE " . substr($and, 0, -4) : ' WHERE 1=1 ';
      return array("where" => $where, "data" => $data);
    }
    return false;
  }

  function get_admin_users($arr = '', $orderBy = '', $joinArr = array(), $mapping_cols_ary = array()) {
    $arr['field_prefix'] = 'au.';
    $whereArr = self::where_str($arr);
    $where = $whereArr['where'];
    $data = $whereArr['data'];
    $cond = '';
    if($joinArr){
      $join = $joinArr['join'];
      $cond = $joinArr['cond'];
      $col = $joinArr['col'];
    }
    if($mapping_cols_ary){
      foreach($mapping_cols_ary as $cl=>$cl_name){
        $col .= ", ".$arr['field_prefix'].$cl." as ".$cl_name;
      }
    }
    $orderBy = (trim($orderBy)) ? ' ORDER BY '.$arr['field_prefix'].trim($orderBy) : ' ORDER BY au.id DESC';
    $query = "SELECT au.*, ar.role as role_name, aui.`designation`, aui.`fb_url`, aui.`twitter_url`, aui.`google_plus_url`, aui.`office_phone`, aui.`home_phone`, aui.`mobile`, aui.`alternate_mobile`, aui.`about`, aui.`seo_key` ".$col .
            " FROM " . ADMINUSER . " au " .
            " LEFT JOIN " . ADMINROLE . " ar ON (ar.id = au.role_id) " .
            " LEFT JOIN " . ADMINUSERINFO . " aui ON (aui.admin_user_id = au.id) " .
              $join . " " .
              $where . " " . $cond .
            " GROUP BY au.id ".
              $orderBy; //echo $query."<pre>".print_r($data,1)."</pre>";
    $res = fDB::fetch_assoc_all($query, $data);
    return $row = $res['result'];
  }

  public function update_admin_user($arr = '') {
        global $ADMINUSERCOL;
        if (isset($_POST)) {
            if($ret = self::validate_admin_user($_POST,$_POST['id'])){
              return $ret;
            }
            $qry = '';
            $where = '';
            $data = array();
            extract($_POST);
            foreach ($_POST as $k => $v) {
                if (in_array($k, $ADMINUSERCOL)) {
                  if($k == 'password'){
                    if(trim($v)){
                      $v = md5($v);
                      $qry .= "`$k`=?,";
                      array_push($data, $v);
                    }
                  }else{
                    $qry .= "`$k`=?,";
                    array_push($data, $v);
                  }
                }
            }
            if (self::check_admin_user(array('id' => $id))) {
                $qry .= "`modified_by`=?, `modified_on`=?,";
                array_push($data, $_SESSION['admin_user_id']);
                array_push($data, date('Y-m-d H:i:s'));
                $query = "UPDATE  " . ADMINUSER . " SET ";
                $whereArr = self::where_str($arr);
                $where = $whereArr['where'];
                $dataW = $whereArr['data'];
                foreach ($dataW as $v) {
                    array_push($data, $v);
                }
            } else {
                $query = "INSERT INTO " . ADMINUSER . " SET ";
                $qry .= "`created_by`=?, `created_on`=?,";
                array_push($data, $_SESSION['admin_user_id']);
                array_push($data, date('Y-m-d H:i:s'));
                $ins = 1;
            }

            if (strlen($qry)) {
                $query .= substr($qry, 0, -1) . $where; //echo "<br>".$query."<pre>".print_r($data,1)."</pre>";
                fDB::query($query, $data);
                $ret = (($ins) ? fDB::inserted_id() : $id);

                $_POST['seo_key'] = insertUpdateSEO($ret, $_POST['name'], 'admin_user', $ins, array('seo_key'=>$_POST['seo_key']));

                if(!empty($_POST['auser_photo'])){
                  $imgTitle = $seo_key.'_'.$ret;
                  uploadCropPicture($_POST['auser_photo'], $imgTitle, 'auser');
                  $img = $imgTitle .'.jpg' ;
                  $queryImg = "UPDATE  " . ADMINUSER . " SET `image`=? WHERE `id`=?";
                  $dataImg = array($img,$ret);
                  fDB::query($queryImg, $dataImg);
                }

                if($ret > 0 && $_POST['role_id']==2){

                  $_POST['admin_user_id'] = $ret ;
                  unset($_POST['id']);
                  self::update_admin_user_info(array('admin_user_id'=>$ret));
                }
                self::update_admin_modules_users(array('user_id'=>$ret,'role_id'=>$_POST['role_id']));

                return $ret;
            }
        }
    }

    public function update_admin_user_info($arr = '') {
        global $ADMINUSERINFOCOL;
        if (isset($_POST)) {
            $qry = '';
            $where = '';
            $data = array();
            extract($_POST);
            foreach ($_POST as $k => $v) {
                if (in_array($k, $ADMINUSERINFOCOL)) {
                  $qry .= "`$k`=?,";
                  array_push($data, $v);
                }
            }
            if (self::check_admin_user_info($arr)) {
                $query = "UPDATE  " . ADMINUSERINFO . " SET ";
                $whereArr = self::where_str($arr);
                $where = $whereArr['where'];
                $dataW = $whereArr['data'];
                foreach ($dataW as $v) {
                    array_push($data, $v);
                }
            } else {
                $query = "INSERT INTO " . ADMINUSERINFO . " SET ";
                $ins = 1;
            }

            if (strlen($qry)) {
                $query .= substr($qry, 0, -1) . $where; //echo "<br>".$query."<pre>".print_r($data,1)."</pre>";
                fDB::query($query, $data);
                return (($ins) ? fDB::inserted_id() : $admin_user_id);
            }
        }
    }

    public function update_admin_modules_users($arr = '') {
      $query = 'DELETE FROM '.ADMINMODULESUSERS.' WHERE user_id=?';
      $data = array($arr['user_id']);
      fDB::query($query, $data);

      if($arr['role_id']){
        $rows = self::getUserDefaultModules($arr['role_id']);
        foreach($rows as $row){
          $query = "INSERT INTO ".ADMINMODULESUSERS." ( user_id, module_id, module, rights) values(?,?,?,'1')";
          $data = array($arr['user_id'],$row['id'],$row['title']);
          fDB::query($query, $data);
        }
      }
    }

    public function check_admin_user($arr = '') {
      $whereArr = self::where_str($arr);
      $where = $whereArr['where'];
      $data = $whereArr['data'];
      $query = "SELECT * FROM " . ADMINUSER . $where;
      $res = fDB::fetch_assoc_all($query, $data);
      return $res['numRecords'];
    }

    public function check_admin_user_info($arr = '') {

        $whereArr = self::where_str($arr);
        $where = $whereArr['where'];
        $data = $whereArr['data'];
        $query = "SELECT * FROM " . ADMINUSERINFO . $where;
        $res = fDB::fetch_assoc_all($query, $data);
        return $res['numRecords'];
    }

    public function validate_admin_user($arr = '', $id = 0) {
      $arr['username'] = trim($arr['username']);
      if($arr['username']==''){
        return -2;
      }
      $qarr = array('username'=>$arr['username']);
      $whereArr = self::where_str($qarr);
      $where = $whereArr['where'];
      $data = $whereArr['data'];
      if($id>0){
        $cond = " AND id!='".(int)$id."'";
      }
      $query = "SELECT * FROM " . ADMINUSER . $where . $cond;
      $res = fDB::fetch_assoc_all($query, $data);
      if( $res['numRecords']>0){
        return -1;
      }else{
        return 0; // is valid
      }
    }

    public function change_status($id) {
        $query = "SELECT * FROM " . ADMINUSER . " WHERE id='" . (int) $id . "'";
        $row = fDB::fetch_assoc_first($query);
        $status = ($row['status'] == 1) ? 0 : 1;
        $query = "UPDATE  " . ADMINUSER . " SET status='" . $status . "' WHERE id='" . (int) $id . "'"; //echo $query; die();
        fDB::query($query);
    }

    function get_adminuser_id_name_pair($role_id = 0){
        if($role_id > 0){
          $cond = " AND role_id = '".(int)$role_id."'";
          if($_SESSION['admin_role_id'] == 2)
              $cond .= " AND id in (".$_SESSION['admin_user_id'].") ";
        }

        $query = "SELECT id, name FROM " . ADMINUSER . " WHERE 1=1 and status=1 ".$cond." ORDER BY `name`" ;
        $row = fDB::fetch_assoc_all($query);
        return $row['result'];
    }


}
?>