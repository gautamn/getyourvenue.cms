 <?php
  include_once facile::$path_classes . "/venue/venue.php";

  class venueDetail{
    function process(){
      $tplData['records'] = array();
      $tplData['title'] = 'Venue Detail';

      $tplData['Id'] = intval($_REQUEST['Id']);
      $tplData['records'] = Venue::getVenueFullDetailsById($tplData['Id']);
      $tplData['tpl'] = 'venueDetail_default.tpl';
      return $tplData;
    }
  }