 <?php
  include_once facile::$path_classes . "/allied_services/allied_services.php";

  class alliedServiceDetail{
    function process(){
      $tplData['records'] = array();
      $tplData['title'] = 'Allied Service Detail';

      $tplData['Id'] = trim($_REQUEST['Id']);
      $tplData['records'] = Allied_Services::getAlliedServiceDetailsId($tplData['Id']);
      $tplData['tpl'] = 'alliedService_default.tpl';
      return $tplData;
    }
  }