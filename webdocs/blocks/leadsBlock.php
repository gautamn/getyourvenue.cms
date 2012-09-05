<?php
/* @desc: block file
 * @auther: Manish Sahu
 * @created On:
 */
//including class file
include_once facile::$path_classes . "/leads/leads.php";

class leadsBlock{
  function process(){
    is_loggedin();

    if (isset($_REQUEST['view']))
      $view = $_REQUEST['view'];

    $vars = isset($_REQUEST['vars'][0]) ? $_REQUEST['vars'][0] : array('');
    $vars['currPage'] = isset($vars['currPage']) ? $vars['currPage'] : 1;

    $action = isset($vars['action']) ? $vars['action'] : '';
    $sh_keyword = isset($vars['sh_keyword']) ? trim($vars['sh_keyword']) : '';
    $seacrhDateFrom = isset($vars['seacrhDateFrom']) ? trim($vars['seacrhDateFrom']) : '';
    $seacrhDateTo   = isset($vars['seacrhDateTo']) ? trim($vars['seacrhDateTo']) : '';

    //searching logic
    $arrKeyword = array();
    $qarr = array();
    if($sh_keyword != '') {
      $op = " REGEXP ";
      $sh_keyword_sarch = str_replace(" ",'|',$sh_keyword);
      $arrKeyword[] = " name ".$op."'".$sh_keyword_sarch."'";
      $arrKeyword[] = " email ".$op."'".$sh_keyword_sarch."'";
      if(count($arrKeyword)>0)
        $qarr[] = " (".implode(" OR ",$arrKeyword ).") ";
    }
    if(!empty($seacrhDateFrom) && !empty($seacrhDateTo)){
      $qarr[] = " (date_format(insertdate,'%Y-%m-%d') BETWEEN '".$seacrhDateFrom."' AND  '".$seacrhDateTo."') ";
    }
    $tplData['sh_keyword']  = $sh_keyword;
    $tplData['seacrhDateFrom']  = $seacrhDateFrom;
    $tplData['seacrhDateTo']  = $seacrhDateTo;

    //counting total records
    $tplData['totalRocords'] = Leads::getLeadsListing($qarr, 1, '', '');

    //pagination
    $paginationParam = array();
    $tplData['paginationHtml'] = getPaginationHtml($paginationParam, $tplData['totalRocords'],'showPage({page})',$vars['currPage']);
    $vars['currPage'] = $tplData['currPage'] = $paginationParam['currPage'];
    //view::$jsInPage .= "console.log(\"currPage:".$paginationParam['currPage']."\");";

    //records with limit
    $tplData['records'] = Leads::getLeadsListing($qarr, 0, $paginationParam['limit'], '');

    //for search result message block
    if($sh_keyword!="" && $tplData['totalRocords']<1) {
        $tplData['msg'] = _NO_RESULT_FOUND;
        $tplData['class'] = 'information';
    }
    return $tplData;
  }
}