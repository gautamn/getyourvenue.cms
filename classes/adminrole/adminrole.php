<?php

class AdminRole {

    function get_id_name_pair(){
        $query = "SELECT id, role as name FROM " . ADMINROLE . " WHERE 1=1 ".$cond." ORDER BY id,role" ;
        $row = fDB::fetch_assoc_all($query);
        return $row['result'];
    }

    function getDetails($role_id){
        $query = "SELECT * FROM " . ADMINROLE . " WHERE id='".$role_id."'" ;
        $row = fDB::fetch_assoc_first($query);
        return $row;
    }


}

?>