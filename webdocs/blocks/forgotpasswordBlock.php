<?php
class forgotpasswordBlock{

  function process(){
      $tpldata['type'] = "inpage";
      $tpldata['tpl'] = "modals/forgotpassword_default.tpl";
      return $tpldata;
  }
}
?>
