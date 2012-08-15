<?php

define('SESSION_LIFE',2592000);

class fSession {
  
  protected $session;
  protected $seslife;
  public function __construct($mcacheInfo) {
    session_set_save_handler(
      array($this, "open"),
      array($this, "close"),
      array($this, "read"),
      array($this, "write"),
      array($this, "destroy"),
      array($this, "gc")
    );
    $this->session = new Memcache;
    $this->session->connect($mcacheInfo['ip'], $mcacheInfo['port']);	
    $this->seslife = SESSION_LIFE;
  }

  public function open($sessionName) {    
    $this->lifetime = ini_get('session.gc_maxlifetime'); 
    return true;
  }

  public function close() {
    return true;
  }

  public function read($id){    
    $_ses = $this->session->get($id);
    $usession = isset($_ses['user_id']) ? $this->session->get('usession_' . $_ses['user_id']) : $_ses;
    return $usession; 
  }

  public function write($id, $data) {    
    $sdata = readSessions($data);
    if(isset($sdata['user_id'])){
      $sesdata = array('user_id'=> $sdata['user_id']);
      $result = $this->session->set($id, $sesdata, MEMCACHE_COMPRESSED, $this->seslife);
      $result = $this->session->set('usession_' . $sdata['user_id'],$data, MEMCACHE_COMPRESSED, $this->seslife);	
    }else {
      $result = $this->session->set($id, $data, MEMCACHE_COMPRESSED, $this->seslife);
    } 
    return true;
  }

  public function destroy($id) {
    return($this->session->delete($id));
  }

  public function gc($maxlifetime) { 
    return true;
  }
}

function readSessions($encodedData){
    //$encodedData    = session_encode();
    $explodeIt    = explode(";",$encodedData);
    for($i=0;$i<count($explodeIt)-1;$i++) {
        $sessGet    = explode("|",$explodeIt[$i]);
        $sessName[$i]    = $sessGet[0];
        if(@substr($sessGet[1],0,2) == "s:") {
            @$sessData[$i] = str_replace("\"","",strstr($sessGet[1],"\""));
        } else {
            @$sessData[$i] = substr($sessGet[1],2);
        } // end if
    } // end for
    $result = array_combine($sessName,$sessData);
    return $result;
}
