<?php

class Content {

    //getting all Contents
    public static function get_contents_list($arr = '') {
        $whereArr = self::where_str($arr);
        $where = $whereArr['where'];
        $data = $whereArr['data'];
        $query = "SELECT * FROM " . CONTENTS . $where . " order by id DESC";
        $res = fDB::fetch_assoc_all($query, $data);
        return $row = $res['result'];
    }

    public function where_str($arr) {
        if (is_array($arr)) {
            $data = array();
            $and = '';
            foreach ($arr as $k => $v) {
                $and = " `$k`=? AND";
                array_push($data, $v);
            }
            $where = (strlen($and)) ? " WHERE " . substr($and, 0, -4) : '';
            return array("where" => $where, "data" => $data);
        }
        return false;
    }

    public function get_contents($arr = '') {
        $whereArr = self::where_str($arr);
        $where = $whereArr['where'];
        $data = $whereArr['data'];
        $query = "SELECT * FROM " . CONTENTS . $where . " order by id DESC";
        $res = fDB::fetch_assoc_all($query, $data);
        return $row = $res['result'];
    }

    public function update_contents($arr = '') {
        global $CONTENTCOL;
        if (isset($_POST)) {
            $qry = '';
            $where = '';
            $data = array();
            extract($_POST);
            foreach ($_POST as $k => $v) {
                if (in_array($k, $CONTENTCOL)) {
                    $qry .= "`$k`=?,";
                    array_push($data, $v);
                }
            }
           if (self::check_contents(array('id' => $id))) {
                $query = "UPDATE  " . CONTENTS . " SET ";
                $whereArr = self::where_str($arr);
                $where = $whereArr['where'];
                $dataW = $whereArr['data'];
                if(is_array($dataW)) {
                    foreach ($dataW as $v) {
                        array_push($data, $v);
                    }
                }
            }
            else {
                $query = "INSERT INTO " . CONTENTS . " SET ";
                $ins = 1;
            }

            if (strlen($qry)) {
                $query .= substr($qry, 0, -1) . $where;
                fDB::query($query, $data);
                $ret = (($ins) ? fDB::inserted_id() : $id);
                //seo
                //$seo_key = insertUpdateSEO($ret, $_POST['title'], 'content');
                $seo_key = insertUpdateSEO($ret, $_POST['title'], 'content', $ins, array('seo_key'=>$_POST['content_seo']));
                self::updateSEOContent($seo_key, $ret);
                return $ret;// (($ins) ? fDB::inserted_id() : $id);

            }
        }
    }

    public function check_contents($arr = '') {
        $whereArr = self::where_str($arr);
        $where = $whereArr['where'];
        $data = $whereArr['data'];
        $query = "SELECT * FROM " . CONTENTS . $where;
        $res = fDB::fetch_assoc_all($query, $data);
        return $res['numRecords'];
    }
    public function change_status($id) {
        $query = "SELECT * FROM " . CONTENTS . " WHERE id='" . (int) $id . "'";
        $row = fDB::fetch_assoc_first($query);
        $status = ($row['status'] == 1) ? 0 : 1;
        $query = "UPDATE  " . CONTENTS . " SET status='" . $status . "' WHERE id='" . (int) $id . "'";
        fDB::query($query);
    }

    /**@desc search function
     * @param String $cond
     * @return array search result
     */
    public function get_content_searchResult($cond) {
      $whr = 1;
      $row = array();
      if (count($cond) > 0) {
        $whr = implode(" AND ", $cond);
      }
      $query = "SELECT * FROM " . CONTENTS . " WHERE " . $whr . " ORDER BY id DESC";
      $res = fDB::fetch_assoc_all($query, $data);
      if($res['numRecords']>0){
        $row = $res['result'];
      }
      return $row;
    }

    /**
     * @desc
     * @param type $seo_key
     * @param type $content_id
     */
    public function updateSEOContent($seo_key, $id){
      if($id == NULL) return;
      $sql = "UPDATE ".CONTENTS." SET content_seo='".$seo_key."' WHERE id=$id";
      fDB::query($sql);
    }

    public function getContentDetails($id){
      if($id == NULL) return;
      $sql = "SELECT * FROM ".CONTENTS." WHERE id=$id";
      return fDB::fetch_assoc_first($sql);
    }
}

?>