<?php

class Role
{
	
  public function get_role_id_name_pair($id=0) {
        $cond = '';
        if($id>0){
          $cond .= " AND id='".(int)$id."' ";
        }
        $query = "SELECT id, name FROM " . ROLES . " WHERE 1=1 ".$cond;
        $row = fDB::fetch_assoc_all($query);
        return $row['result'];
    }

    public function get_autocomplete($key) {
      $key = addslashes($key);
      $query = "SELECT id, name FROM " . ROLES . " WHERE name LIKE '$key%' ORDER BY name";
      $row = fDB::fetch_assoc_all($query);
      return $row['result'];
  }

	
}
?>