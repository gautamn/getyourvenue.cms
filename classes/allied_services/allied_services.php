<?php
/**
 * Description of allied_services
 * @author manish
 */
class Allied_Services {

  /* @name: getVenueListing
     * @desc: function to fetch venue rows with paging limit and order
     */
    public function getVenueListing($cond, $getTotalRecords=0, $limit = '', $orderBy = '') {
        $data = array();
        $where = '1';

        if (count($cond) > 0) {
            $where = implode(" AND ", $cond);
        }
        $query = "SELECT * FROM " . ALLIED_SERVICES . " WHERE ".$where;

        if($getTotalRecords>0){
          $sql_cnt = "SELECT count(*) as numRecords FROM ".ALLIED_SERVICES." WHERE $where";
          $res = fDB::fetch_assoc_first($sql_cnt);
          return intval($res['numRecords']);
        }
        $orderBy = ($orderBy!="") ? " ORDER BY ". $orderBy : " ORDER BY SEO_ID DESC";
        $query = $query.$orderBy.$limit;
        $res = fDB::fetch_assoc_all($query, $data);
        return isset($res['numRecords']) ? $res['result'] : '';
    }

    //function to save venue details
    public function saveAlliedService($params){
      if(!is_array($params))
        return false;
      $params['seo_title'] = !empty($params['seo_title']) ? $params['seo_title'] : $params['venue_name'];
      $params['seo_title'] = clean_special_character($params['seo_title']);
      $date = date('Y-m-d H:i:s');

      if(!empty($params['id'])){
        $sql = "UPDATE ".ALLIED_SERVICES." SET SEO_ID=?, BANNER_PATH=?, HEADING=?, HTML_CONTENT=?, TITLE=?, META_DESCRIPTION=?, META_KEYWORD=?, JCAROUSEL_IMAGES_FOLDER_PATH=?, THEMES_URLS=?, UPDATE_TIMESTAMP=? WHERE SEO_ID=?";
        $data = array($params['seo_title'], $params['banner_path'], $params['service_name'], $params['description'], $params['meta_title'], $params['meta_description'], $params['meta_keyword'], $params['jcarousel_path'], $params['themes_path'], $date, $params['id']);
      }else{
        $sql = "INSERT INTO ".ALLIED_SERVICES." SET SEO_ID=?, BANNER_PATH=?, HEADING=?, HTML_CONTENT=?, TITLE=?, META_DESCRIPTION=?, META_KEYWORD=?, JCAROUSEL_IMAGES_FOLDER_PATH=?, THEMES_URLS=?, CREATE_TIMESTAMP=?, UPDATE_TIMESTAMP=?";
        $data = array($params['seo_title'], $params['banner_path'], $params['service_name'], $params['description'], $params['meta_title'], $params['meta_description'], $params['meta_keyword'], $params['jcarousel_path'], $params['themes_path'], $date, $date);
      }
      $res = fDB::query($sql, $data);
      return $res;
    }

    //function to change status
    public function change_status($aid) {
       if(empty($aid))
         return;
       $query = "SELECT * FROM " . ALLIED_SERVICES . " WHERE SEO_ID='" . $aid . "'";
       $row = fDB::fetch_assoc_first($query);
       $status = ($row['IS_ACTIVE'] == 1) ? 0 : 1;
       $query = "UPDATE " . ALLIED_SERVICES . " SET IS_ACTIVE=" . $status . " WHERE SEO_ID='" . $aid . "'";
       fDB::query($query);
    }

    /*@name:
     *@desc: function to get single venue details by id
     */
    public function getAlliedServiceDetailsId($aid) {
      if(empty($aid))
        return;
      $row = array();

      $query = "SELECT * FROM ". ALLIED_SERVICES ." WHERE SEO_ID='".$aid."'";
      $row = fDB::fetch_assoc_first($query);
      return $row;
    }
}
?>