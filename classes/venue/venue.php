<?php
/*
 * @desc: Venue class
 * @author: Manish Sahu
 */
class Venue {
    public function get_venue_details($venue_id) {
      if(empty($venue_id))
        return;
      $where = '';
      $res = array();
      $where = ($venue_id) ? "WHERE id=$venue_id" : '';
      $query = "SELECT * FROM " . VENUES . $where . " order by id desc";
      $res = fDB::fetch_assoc_first($query);
      return $res;
    }

    public function where_str($arr) {
        $data = array();
        if (is_array($arr)) {
            $and = '';
            foreach ($arr as $k => $v) {
                $and = " $k=? AND";
                array_push($data, $v);
            }
            $where = (strlen($and)) ? " WHERE " . substr($and, 0, -4) : '';
            return array("where" => $where, "data" => $data);
        }
        return array("where" => '', "data" => $data);
    }

    /* @name: getVenueListing
     * @desc: function to fetch venue rows with paging limit and order
     */
    public function getVenueListing($cond, $getTotalRecords=0, $limit = '', $orderBy = '') {
        $data = array();
        $where = '1';

        if (count($cond) > 0) {
            $where = implode(" AND ", $cond);
        }
        $query = "SELECT * FROM " . VENUES . " WHERE ".$where;

        if($getTotalRecords>0){
          $sql_cnt = "SELECT count(*) as numRecords FROM ".VENUES." WHERE $where";
          $res = fDB::fetch_assoc_first($sql_cnt);
          return intval($res['numRecords']);
        }
        $orderBy = ($orderBy!="") ? " ORDER BY ". $orderBy : " ORDER BY id DESC";
        $query = $query.$orderBy.$limit;
        $res = fDB::fetch_assoc_all($query, $data);
        return isset($res['numRecords']) ? $res['result'] : '';
    }

    //function to save venue details
    public function saveVenue($params){
      if(!is_array($params))
        return false;
      $params['seo_title'] = !empty($params['seo_title']) ? $params['seo_title'] : $params['venue_name'];
      $params['seo_title'] = clean_special_character($params['seo_title']);
      $date = date('Y-m-d H:i:s');

      if(isset($params['id']) && $params['id']>0){
        $sql = "UPDATE ".VENUES." SET venueid=?, name=?, rank=?, address1=?, address2=?, content=?, iframe=?, regionid=?, popular_choice=?, image_alt_tag=?, update_timestamp=?, meta_description=?, meta_keyword=?, title=? WHERE id=?";
        $data = array($params['seo_title'], $params['venue_name'], $params['venue_rank'], $params['address1'], $params['address2'], $params['description'], $params['iframe_code'], $params['region'], $params['popular'], $params['image_alt'], $date, $params['meta_description'], $params['meta_keyword'], $params['meta_title'], $params['id']);
      }else{
        $sql = "INSERT INTO ".VENUES." SET venueid=?, name=?, rank=?, address1=?, address2=?, content=?, iframe=?, regionid=?, popular_choice=?, image_alt_tag=?, create_timestamp=?, update_timestamp=?, meta_description=?, meta_keyword=?, title=?";
        $data = array($params['seo_title'], $params['venue_name'], $params['venue_rank'], $params['address1'], $params['address2'], $params['description'], $params['iframe_code'], $params['region'], $params['popular'], $params['image_alt'], $date, $date, $params['meta_description'], $params['meta_keyword'], $params['meta_title']);
      }
      $res = fDB::query($sql, $data);
      if($res){
        $id = (isset($params['id']) && $params['id']>0) ? intval($params['id']) : fDB::inserted_id();
        //updating venue type mapping
        if($id>0){
          //venue
          $venueT = is_array($params['venueType']) ? implode(',',$params['venueType']) : '';
          $venueT = ($venueT!='') ? 'AND venuetypeid NOT IN('.$venueT.')' : '';
          //delete venue_type
          fDB::query("DELETE FROM ".VENUE_TYPE_MAPPING." WHERE venueid=$id $venueT");

          //venue_type
          if(!empty($params['venueType'])){
            foreach($params['venueType'] as $vType){
              //chking if not exits
              $sql_ck = "SELECT count(*) as cnt FROM ".VENUE_TYPE_MAPPING." WHERE venueid=$id AND venuetypeid=$vType";
              $res_type = fDB::fetch_assoc_first($sql_ck);
              if(isset($res_type['cnt']) && $res_type['cnt']<1){
                $sql_ins_type = "INSERT INTO ".VENUE_TYPE_MAPPING." (venueid, venuetypeid, create_timestamp, update_timestamp) VALUES(?,?,?,?)";
                $data_type = array($id, $vType, $date, $date);
                fDB::query($sql_ins_type, $data_type);
              }
            }//foreach
          }//if
          //insert & delete capcity mapping
          $venueCap = !empty($params['venuecapacity']) ? implode(',',$params['venuecapacity']) : '';
          $venueCap = ($venueCap!='') ? 'AND capacityid NOT IN('.$venueCap.')' : '';
          //delete venue_type
          fDB::query("DELETE FROM ".VENUE_CAPACITY_MAPPING." WHERE venueid=$id $venueCap");

          //venue_type
          if(!empty($params['venuecapacity'])){
            foreach($params['venuecapacity'] as $vCap){
              //chking if not exits
              $sql_ck = "SELECT count(*) as cnt FROM ".VENUE_CAPACITY_MAPPING." WHERE venueid=$id AND capacityid=$vCap";
              $res_cap = fDB::fetch_assoc_first($sql_ck);
              if(isset($res_cap['cnt']) && $res_cap['cnt']<1){
                $sql_ins_cap = "INSERT INTO ".VENUE_CAPACITY_MAPPING." (venueid, capacityid, create_timestamp, update_timestamp) VALUES(?,?,?,?)";
                $data_cap = array($id, $vCap, $date, $date);
                fDB::query($sql_ins_cap, $data_cap);
              }
            }//foreach
          }//if
        }//if id>0
      }//if res
      return $res;
    }

    //function to change status
    public function change_status($venue_id) {
       if(empty($venue_id))
         return;
       $query = "SELECT * FROM " . VENUES . " WHERE id='" . (int) $venue_id . "'";
       $row = fDB::fetch_assoc_first($query);
       $status = ($row['is_active'] == '1') ? '0' : '1';
       $query = "UPDATE " . VENUES . " SET is_active='" . $status . "' WHERE id='" . (int) $venue_id . "'";
       fDB::query($query);
    }

    //function to get venue type mapping details
    public function getVenueTypeMappingDetails($venue_id=''){
      if($venue_id==null)
        return;
      $res = array();
      if(isset($venue_id) && $venue_id>0){
        $query = "SELECT vt.venuetypeid, vt.venuetype, vt.type FROM " . VENUE_TYPE_MAPPING." vm INNER JOIN ".VENUE_TYPE." vt ON (vm.venuetypeid=vt.venuetypeid) WHERE vm.venueid=$venue_id";
        $res = fDB::fetch_assoc_all($query);
      }
      return !empty($res) ? $res['result'] : $res;
    }

    //@desc: function to get venue capacity mapping details
    public function getVenueCapacityMappingDetails($venue_id) {
      $res = array();
      if(isset($venue_id) && $venue_id>0) {
        $query = "SELECT c.capacityid, c.range FROM ".VENUE_CAPACITY_MAPPING." vc INNER JOIN ".CAPACITY." c ON (vc.capacityid=c.capacityid) WHERE vc.venueid=$venue_id";
        $res = fDB::fetch_assoc_all($query);
      }
      return !empty($res) ? $res['result'] : $res;
    }

    /*@name:
     *@desc: function to get single venue details by id
     */
    public function getVenueFullDetailsById($venue_id) {
      if($venue_id<1)
        return;
      $row = array();
      $venueType = array();
      $venueCapcity = array();

      $query = "SELECT * FROM ". VENUES ." WHERE id=$venue_id";
      $row = fDB::fetch_assoc_first($query);

      //fetching venue type details
      if(!empty($row)) {
        $venueType = self::getVenueTypeMappingDetails($row['id']);
      }
      //fetching venue capacity details
      if(!empty($row)) {
        $venueCapcity = self::getVenueCapacityMappingDetails($row['id']);
      }
      $row['venueType'] = $venueType;
      $row['venueCapcity'] = $venueCapcity;
      return $row;
    }

    /*function to get region name*/
    public function getVenueRegionList(){
      $sql = "SELECT regionid, regionname FROM ".VENUE_REGION." ORDER BY regionname";
      $res = fDB::fetch_assoc_all($sql);
      return !empty($res['result']) ? $res['result'] : array();
    }

    /*function to get capacity*/
    public function getVenueCapacityList(){
      $sql = "SELECT * FROM ".CAPACITY." ORDER BY capacityid";
      $res = fDB::fetch_assoc_all($sql);
      return !empty($res['result']) ? $res['result'] : array();
    }

    /*function to get venue type*/
    public function getVenueTypeList(){
      $sql = "SELECT * FROM ".VENUE_TYPE." ORDER BY type";
      $res = fDB::fetch_assoc_all($sql);
      return !empty($res['result']) ? $res['result'] : array();
    }

    /*function to get venue popularity*/
    public function getVenuePopularityList(){
      $sql = "SELECT * FROM ".VENUE_POPULAR_CHOICE." ORDER BY popularchoicename";
      $res = fDB::fetch_assoc_all($sql);
      return !empty($res['result']) ? $res['result'] : array();
    }
}
?>