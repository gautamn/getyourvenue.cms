<?php
/**
 * Description of leads
 * @author manish
 */
class Leads {
  /* @name: getVenueListing
   * @desc: function to fetch venue rows with paging limit and order
   */
  public function getLeadsListing($cond, $getTotalRecords=0, $limit = '', $orderBy = '') {
    $data = array();
    $where = '1';

    if (isset($cond) && count($cond) > 0) {
        $where = implode(" AND ", $cond);
    }
    $query = "SELECT * FROM " . BOOK_NOW . " WHERE ".$where;

    if($getTotalRecords){
      $res = fDB::fetch_assoc_all($query);
      return $res['numRecords'];
    }
    $orderBy = ($orderBy!="") ? " ORDER BY ". $orderBy : " ORDER BY id DESC";
    $query = $query.$orderBy.$limit;
    $res = fDB::fetch_assoc_all($query, $data);
    return isset($res['numRecords']) ? $res['result'] : array();
  }
}
?>