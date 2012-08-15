<?php
class cleancacheBlock {
  function process() {
    
    if($_POST['action']=='cleancache' && trim($_POST['pages']) && trim($_POST['grpPO'])){
      $url = "http://223.165.31.166:8080/AkamaiPurge/akamai_process.jsp";
      $data['username'] = 'nilay.pran@indiatimes.co.in';
      $data['password'] = 'times@123';
      $data['email']    = trim($_POST['email']);
      $data['pages']    = trim($_POST['pages']);
      $data['grpPO']    = (trim($_POST['grpPO'])=='i') ? 'invalidate' : 'remove';      //echo "<pre>".print_r($data,1)."</pre>";
      $msg              = curlPostData($url,$data);
      //$tplData['msgClass'] = 'error';
    }
    $tplData['msg'] = $msg;
    $tplData['msgClass'] = $msgClass;
    return $tplData;
  }
}
