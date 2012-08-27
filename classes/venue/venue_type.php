<?php
/**
 * Description of venue_type
 *
 * @author manish
 */
class venueType {
  //put your code here
    public function get_venuetype_details($venuetype_id) {
      if(empty($venuetype_id))
        return;
      $where = '';
      $res = array();
      $where = ($venuetype_id) ? "WHERE id=$venuetype_id" : '';
      $query = "SELECT * FROM " . VENUE_TYPE . $where . " order by venuetypeid desc";
      $res = fDB::fetch_assoc_first($query);
      return $res;
    }

    /* @name: getVenueTypeListing
     * @desc: function to fetch venuetype rows with paging limit and order
     */
    public function getVenueTypeListing($cond, $getTotalRecords=0, $limit = '', $orderBy = '') {
        $data = array();
        $where = '1';

        if (count($cond) > 0) {
            $where = implode(" AND ", $cond);
        }
        $query = "SELECT * FROM " . VENUE_TYPE . " WHERE ".$where;

        if($getTotalRecords>0){
          $sql_cnt = "SELECT count(*) as numRecords FROM ".VENUE_TYPE." WHERE $where";
          $res = fDB::fetch_assoc_first($sql_cnt);
          return intval($res['numRecords']);
        }
        $orderBy = ($orderBy!="") ? " ORDER BY ". $orderBy : " ORDER BY venuetypeid DESC";
        $query = $query.$orderBy.$limit;
        $res = fDB::fetch_assoc_all($query, $data);
        return isset($res['numRecords']) ? $res['result'] : '';
    }

    //function to save venue details
    public function saveVenueType($params){
      if(!is_array($params))
        return false;
      $params['seo_title'] = !empty($params['seo_title']) ? $params['seo_title'] : $params['venue_type'];
      $params['seo_title'] = clean_special_character($params['seo_title']);
      $date = date('Y-m-d H:i:s');
      $res = '';

      if(isset($params['id']) && $params['id']>0){
        $sql = "UPDATE ".VENUE_TYPE." SET type=?, venuetype=?, update_timestamp=? WHERE venuetypeid=?";
        $data = array($params['venue_type'], $params['seo_title'], $date, $params['id']);
        $res = fDB::query($sql, $data);
      }else{
        $sql = "INSERT INTO ".VENUE_TYPE." SET type=?, venuetype=?, create_timestamp=?, update_timestamp=?";
        $data = array($params['venue_type'], $params['seo_title'], $date, $date);
        $res = fDB::query($sql, $data);
      }
      return $res;
    }

    /*@name:
     *@desc: function to get single venue details by id
     */
    public function getVenueTypeDetailsById($venue_id) {
      if($venue_id<1)
        return;
      $row = array();

      $query = "SELECT * FROM ". VENUE_TYPE ." WHERE venuetypeid=$venue_id";
      $row = fDB::fetch_assoc_first($query);
      return $row;
    }
}
?>