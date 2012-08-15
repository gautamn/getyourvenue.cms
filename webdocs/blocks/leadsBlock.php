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

    $vars = $_REQUEST['vars'][0];
    $vars['currPage'] = isset($vars['currPage']) ? $vars['currPage'] : 1;

    $action = isset($vars['action']) ? $vars['action'] : $_REQUEST['action'];
    $sh_keyword = isset($vars['sh_keyword']) ? trim($vars['sh_keyword']) : trim($_REQUEST['sh_keyword']);

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
    $tplData['sh_keyword']  = $sh_keyword;

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