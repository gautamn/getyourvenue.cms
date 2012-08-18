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
                $and = " `$k`=? AND";
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

        if($getTotalRecords){
          $res = fDB::fetch_assoc_all($query);
          return $res['numRecords'];
        }
        $orderBy = ($orderBy!="") ? " ORDER BY ". $orderBy : " ORDER BY id DESC";
        $query = $query.$orderBy.$limit;
        $res = fDB::fetch_assoc_all($query, $data);
        return isset($res['numRecords']) ? $res['result'] : '';
    }

    //function to save venue details
    public function saveVenue($arr){
      if(!is_array($arr))
        return false;
    }

    //function to update venues
    public function updateVenues($arr = '') {
        return (($ins) ? fDB::inserted_id() : $venue_id);
    }

    //function to change status
    public function change_status($venue_id) {
       if(empty($venue_id))
         return;
       $query = "SELECT * FROM " . VENUES . " WHERE id='" . (int) $venue_id . "'";
       $row = fDB::fetch_assoc_first($query);
       $status = ($row['is_active'] == 'Y') ? 'N' : 'Y';
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