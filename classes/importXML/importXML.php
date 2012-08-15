<?php

include_once facile::$path_classes . "event/event.php";

class importXML {
    
  function readXMLfile($file){
     
    include_once facile::$path_utilities. 'rss_php.php';

    global $report;
    $dataArr = array();
    $rss = new rss_php();
    $rss->load($file);
    $items = $rss->getItems(); 
    $items = $items[0];
    
    //echo "<pre>".print_r($items,1)."</pre>"; die();

    $dataArr['title']         = $items['media:title'];
    $dataArr['description']   = $items['media:content']['media:description'];
    $dataArr['keyword']       = $items['media:content']['media:keywords'];
    //$dataArr['category']      = $items['media:content']['media:category'];
    $dataArr['matchfile']     = $items['media:content']['media:matchfile']; //$dataArr['match_id'] = $items['media:content']['media:matchid'];
    //$dataArr['platform']      = $items['media:content']['media:platform'];
    $dataArr['web_permission']      = $items['media:content']['media:web_permission'];
    $dataArr['mobile_permission']      = $items['media:content']['media:mobile_permission'];
    $dataArr['android_permission']      = $items['media:content']['media:android_permission'];
    $dataArr['artworksmall']  = $items['media:content']['media:artworksmall'];
    $dataArr['artworkbig']    = $items['media:content']['media:artworkbig'];
    $dataArr['duration']      = $items['media:content']['media:duration'];
    $dataArr['timescategory'] = $items['media:content']['media:timescategory'];
    //$dataArr['event']         = $items['media:content']['media:event'];   // True/False
    $dataArr['event']         = True;   // True/False
    $dataArr['time_hms']      = $items['media:content']['media:time_hms'];
    $dataArr['file_web_720000'] = $items['media:content']['media:file_web_720000'];
    $dataArr['file_web_480000'] = $items['media:content']['media:file_web_480000'];
    $dataArr['file_web_360000'] = $items['media:content']['media:file_web_360000'];
    $dataArr['file_web_240000'] = $items['media:content']['media:file_web_240000'];
    $dataArr['file_mobile'] = $items['media:content']['media:file_mobile'];
    $dataArr['file_audio'] = $items['media:content']['media:file_audio'];
    $dataArr['file_android'] = $items['media:content']['media:file_android'];
    $dataArr['allow_in'] = $items['media:content']['media:allow_in'];
    $dataArr['allow_row'] = $items['media:content']['media:allow_row'];
    $dataArr['allow_us'] = $items['media:content']['media:allow_us'];
    $dataArr['inning'] = $items['media:content']['media:inning'];
    $dataArr['playerids'] = $items['media:content']['media:playerids'];
    $dataArr['adcuepoints'] = $items['media:content']['media:adcuepoints']; // array of adcuepoints
    $dataArr['cuepoints'] = $items['media:content']['media:cuepoints']; // array of cuepoints
    $dataArr['url']           = parseurl($file);
    $dataArr['language']      = $items['yt:language'];
    $dataArr['date_recorded'] = $items['yt:date_recorded'];
    $dataArr['location']      = $items['yt:location']['yt:location_text'];
    $dataArr['start_time']    = $items['yt:start_time'];
    $dataArr['custom_id']     = trim($items['yt:web_metadata']['yt:custom_id']);
    $dataArr['playlists']     = $items['yt:playlists']['yt:playlist']['yt:name'];
    $report[]                 = $dataArr['timescategory'];
    
    if(!empty($dataArr)){
      $chk = self::checkData($dataArr);
      if($chk<1){
        // pick event of season 5 only 
        $rowschdata = Event::get_events(array('matchfile'=>trim($dataArr['matchfile'])),' Group BY e.id, e.match_season HAVING e.match_season=5 ');
        $rowschdata = $rowschdata[0];     //echo "<pre>".print_r($rowschdata,1)."</pre>";
        $matchNo    = $rowschdata['eventMatchId'];  // event id
        if($matchNo > 0){
          $dataArr['event_row'] = $rowschdata;
          $id = self::addData($dataArr);  
          return $id;
        }else{
          return -2;
          //$error[]="match is not found!";
        }
        //$error[]="data inserted successfully!";
      }else{
        //$error[]="already exists!";
        return -1;
      }	
    }		
    return 0;
  }

  function addData($params){
    global $IMPORTEDDATACOL;
    $title        = trim($params['title']);
    $description  = trim($params['description']);
    $keyword      = trim($params['keyword']);
    $language     = trim($params['language']);
    $date_recorded= trim($params['date_recorded']);
    $location     = trim($params['location']);
    $start_time   = trim($params['start_time']);
    $custom_id    = trim($params['custom_id']);
    $playlists    = trim($params['playlists']);
    //$category     = trim($params['category']);
    $matchfile    = trim($params['matchfile']); //$match_id = trim($params['match_id']);
    //$platform     = trim($params['platform']);
    $web_permission = trim($params['web_permission']);
    $mobile_permission = trim($params['mobile_permission']);
    $artworksmall = trim($params['artworksmall']);
    $artworkbig   = trim($params['artworkbig']);
    $timescategory= trim($params['timescategory']);
    $event        = trim($params['event']);
    $url          = trim($params['url']);
    $dur          = trim($params['duration']); 
    
    $time_hms         = trim($params['time_hms']);
    $file_web_720000  = trim($params['file_web_720000']);
    $file_web_480000  = trim($params['file_web_480000']);
    $file_web_360000  = trim($params['file_web_360000']);
    $file_web_240000  = trim($params['file_web_240000']);
    $file_mobile      = trim($params['file_mobile']);
    $file_audio       = trim($params['file_audio']);
    $file_android     = trim($params['file_android']);
    $allow_in         = strtolower(trim($params['allow_in']))=='true'?1:0;
    $allow_row        = strtolower(trim($params['allow_row']))=='true'?1:0;
    $allow_us         = strtolower(trim($params['allow_us']))=='true'?1:0;
    $inning           = trim($params['inning']);
    $playerids        = trim($params['playerids']);
    $adcuepoints = '';
    foreach($params['adcuepoints'] as $adcuepoint){
      if(trim($adcuepoint)){
        $adcuepoints .= $com . trim($adcuepoint);   // comma separated adcuepoints
        $com = ',';
      }
    }

    $clip_cuepoints_ary = array();
    foreach($params['cuepoints'] as $cuepoint){
      if(trim($cuepoint['start']) && trim($cuepoint['type'])){
        $clip_cuepoints_ary[] = $cuepoint;
      }
    }
    $clip_cuepoints = (count($clip_cuepoints_ary)>0) ? serialize($clip_cuepoints_ary) : '';

    /*
    $queryschedule = "SELECT id,venue,match_number,matchtime_ist,matchdate_ist,teama_short,teamb_short FROM ".SCHEDULES." WHERE matchnumber='Match ".$match_id."' ORDER BY id DESC";
    $rowschdata = fDB::fetch_assoc_first($queryschedule);
    
    $matchNo    = $rowschdata['match_number'];
    $matchtime  = $rowschdata['matchtime_ist'];
    $matchdate  = $rowschdata['matchdate_ist'];
    $teama      = $rowschdata['teama_short'];
    $teamb      = $rowschdata['teamb_short'];		
    $venue      = $rowschdata['venue'];
    */

    //$rowschdata = Event::get_events(array('matchfile'=>trim($matchfile)),' Group BY e.id ');
    //$rowschdata = $rowschdata[0];               //echo "<pre>".print_r($rowschdata,1)."</pre>"; die();
    $rowschdata = $params['event_row'];
    $matchNo    = $rowschdata['eventMatchId'];  // event id
    $arrMatchStart = $rowschdata['match_start'];
    $matchtime  = $arrMatchStart[1];
    $matchdate  = $arrMatchStart[0];
    $teama      = $rowschdata['teama_short'];
    $teamb      = $rowschdata['teamb_short'];		
    $venue      = $rowschdata['venue'];

    $durationhms= formatTime($dur);
    $desc       = $description;
    $imagebig   = $artworkbig;
    $imagethumb = $artworksmall;
    $clSubType  = $timescategory;  // Fall of Wickets

    // added for duration column in seconds //
    $dataduration = explode(':',$durationhms);
    $duration= ($dataduration[0]*60*60)+($dataduration[1]*60)+($dataduration[2]);
    // end  //
    
    $webchk = $mobilechk = $iphonechk = 0;
    $fileName = $webfile = $mobilefile = $iphonefile = '';
    $fileName	= @end(@explode('//',$url));	

    $mobilefile = $file_mobile;	 

    if( strtolower(trim($web_permission))=='true' ) {
      $webchk = '1';
    }	
    if( strtolower(trim($mobile_permission))=='true' ) {
      $mobilechk = '1';
    }
    $android_permission = strtolower(trim($params['android_permission']))=='true'?1:0;
    /*
    else if( strtolower(trim($platform))==strtolower('iDevices') )	{
      $fileName	    = @end(@explode('//',$url));
      $iphonechk = '1';
      $iphonefile = @end(@explode('//',$url));			
    }	
    else{
      	
    }
    */
    $clipType=(strtolower($params['event']) == 'true')?'Event':'Post';
    $status = 1;
    //$timehms = ;
    //$inning = '';
    $userid = $_SESSION['admin_user_id'];
    
    $query="INSERT INTO ".IMPORTEDDATA." (clip_cuepoints,adcuepoints,playerids,matchfile, teama, teamb, matchNo, innings, clipType,  title, description, clipTimeHMS, clipDurationHMS, clipDuration, fileName, file_web_720000, file_web_480000, file_web_360000, file_web_240000, clip_file_audio, clip_file_android,clip_permission_android, clipSubtype,status, addedDate, 
    addedUser, `fileType`, formType, allow_in, allow_row, allow_us, clip_permission, imagethumb, imagebig, matchtime, matchdate, matchvenue,source, webchk,mobilechk,mobilefile,iphonechk,iphonefile, keyword,language,date_recorded,location,start_time,custom_id,playlists,match_id,artworksmall,artworkbig,duration,timescategory,event,url, displayStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  SYSDATE(), 
      ?, ?, ?, ? , ? ,?, ?, ?, ?, ?, ?, ?, 'yt', 
      ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $dataAry = array($clip_cuepoints,$adcuepoints,$playerids,$matchfile, $teama, $teamb, $matchNo, $inning, $clipType, $title, $description, $time_hms, $durationhms, $duration, $fileName, $file_web_720000, $file_web_480000, $file_web_360000, $file_web_240000,$file_audio,$file_android,$android_permission, $clSubType, $status, 
      $userid, $fileType, $formType, $allow_in, $allow_row, $allow_us, $clip_permission, $imagethumb, $imagebig, $matchtime, $matchdate, $venue, 
      $webchk, $mobilechk, $mobilefile, $iphonechk, $iphonefile, $keyword, $language, $date_recorded, $location, $start_time, $custom_id, $playlists, $match_id, $artworksmall, $artworkbig, $duration, $timescategory, $event, $url);
    fDB::query($query, $dataAry); //echo "<br>".$query."<br><pre>".print_r($dataAry,1)."</pre>"; die();
    $insertid = fDB::inserted_id();
    return $insertid;
  }

  function updateData($params){
    
    global $IMPORTEDDATACOL;
    $id = $params['id'];
    $qry = '';
    $where = '';
    $data = array();
    foreach ($params as $k => $v) {
      if (in_array($k, $IMPORTEDDATACOL)) {
          $qry .= "`$k`=?,";
          array_push($data, $v);
      }
    }
    if (self::checkData('',$params['id'])) {
        $qry .= "`modifiedUser`=?, `modifiedDate`=?,";
        array_push($data, $_SESSION['admin_user_id']);
        array_push($data, date('Y-m-d H:i:s'));
        $query = "UPDATE  " . IMPORTEDDATA . " SET ";
        $whereArr = self::where_str(array("id"=>$params['id']));
        $where = $whereArr['where'];
        $dataW = $whereArr['data'];
        foreach ($dataW as $v) {
            array_push($data, $v);
        }
    } 

    if (strlen($qry)) {
        $query .= substr($qry, 0, -1) . $where; //echo "<br>".$query."<pre>".print_r($data,1)."</pre>";
        fDB::query($query, $data);
        return $id;
    }
    return 0;
  }

  function checkData($params, $id=0){
    $cond = "WHERE custom_id=?";    // unique data check while importing clip from xml
    $data = array($params['custom_id']);
    if($id>0){
      $cond = "WHERE id=?";
      $data = array($id);
    }
    $Query="SELECT count(*) as cnt FROM ".IMPORTEDDATA." ".$cond; 
    $row = fDB::fetch_assoc_first($Query, $data);
    return $row['cnt'];
  }

  function getData($params){
    $Query="SELECT * from ".IMPORTEDDATA;
    $row = fDB::fetch_assoc_first($Query);
    return $row;
  }

  public function change_status($id, $status) {
    $username = $_SESSION['admin_user_id'];
    $query = "UPDATE  " . IMPORTEDDATA . " SET `displayStatus`='" . $status . "', modifiedDate = SYSDATE() , modifiedUser='".$username."' WHERE id='" . (int) $id . "'"; //echo $query; die();
    fDB::query($query);
  }
  
  // getting mapped data
  function getDataDetails($id){
    $Query = "SELECT dt.`id`, dt.`title`, dt.`description`, dt.`keyword`, dt.`language`, dt.`date_recorded`, dt.`location`, dt.`start_time`, dt.`custom_id`, dt.`playlists`, dt.`clipType` as `category`, dt.`match_id`, dt.`artworksmall`, dt.`artworkbig`, dt.`duration`, dt.`timescategory`, dt.`event`, dt.`url`, dt.`matchNo`, dt.`clipType`, dt.`clipTime`, dt.`clipDuration`, dt.`fileName`, dt.`fileType`, dt.`clipSubtype`, dt.`status`, dt.`addedDate`, dt.`modifiedDate`, dt.`addedUser`, dt.`modifiedUser`, dt.`formType`, dt.`clipTimeHMS`, dt.`clipDurationHMS`, dt.`clip_permission`, dt.`allow_us`, dt.`allow_in`, dt.`allow_row`, dt.`imageUrl`, dt.`imageName`, dt.`teamid`, dt.`imagethumb`, dt.`imagebig`, dt.`matchtime`, dt.`matchdate`, dt.`pathurl`, dt.`teama`, dt.`teamb`, dt.`webchk`, dt.`mobilechk`, dt.`mobilefile`, dt.`matchvenue`, dt.`iphonechk`, dt.`iphonefile`, dt.`cron_status`, dt.`imagestatus`, dt.`check_schedule`, dt.`recordListingID`, dt.`source`, dt.`playcount`, dt.`displayStatus`, dt.`innings`, dt.playerids, dt.adcuepoints, dt.clip_cuepoints " . 
    
    ", dt.file_web_720000 as clip_file_web_720000, dt.file_web_480000 as clip_file_web_480000, dt.file_web_360000 as clip_file_web_360000, dt.file_web_240000 as clip_file_web_240000, dt.mobilefile as clip_file_mobile, dt.clip_file_audio, dt.clip_file_android, dt.clipTimeHMS as clip_time_hms, dt.clipDuration as clip_duration, dt.allow_us as clip_permission_us , dt.allow_in as clip_permission_india, dt.allow_row as clip_permission_world, dt.`webchk` as clip_permission_web, dt.`mobilechk` as clip_permission_mobile, dt.clip_permission_android, dt.`innings` as match_inning, dt.matchfile as matchfile  " . 
    
    ", cat1.id as category_id, cat1.name as category_name, cat2.id as sub_category_id, cat2.name as sub_category_name" .

    ", CONCAT(e.teama_short,' vs ',e.teamb_short,' - ',e.matchfile) as event_title " .
    
    " FROM " . IMPORTEDDATA .  " dt ".
    " LEFT JOIN ".CATEGORIES." cat1 ON (dt.`clipType`=cat1.name AND cat1.type='vod') LEFT JOIN ".CATEGORIES . " cat2 ON (cat1.id=cat2.parent_id AND cat2.name=timescategory)" .
    " LEFT JOIN " . EVENTS . " e ON (e.id=dt.`matchNo`) " .
    " WHERE dt.id='".(int)$id."'";
    //echo $Query;
    $row = fDB::fetch_assoc_first($Query);
    return $row;
  }
  
  public function where_str($arr) {
      if (is_array($arr)) {
          $data = array();
          $and = '';
          foreach ($arr as $k => $v) {
              if($k == 'keyword'){
                $v = trim($v);
                if($v){
                  $v = str_replace("","|",$v);
                  $and .= " (`title` REGEXP ? OR `fileName` REGEXP ? OR `clipType` REGEXP ? OR `mobilefile` REGEXP ? OR `iphonefile` REGEXP ?) AND";
                  array_push($data, $v,$v,$v,$v,$v);
                }
              }
              else{
                $and .= " `$k`=? AND";
                array_push($data, $v);
              }
          }
          $where = (strlen($and)) ? " WHERE " . substr($and, 0, -4) : ' WHERE 1=1 ';
          return array("where" => $where, "data" => $data);
      }
      return false;
  }

  function getRows($arr = ''){
    $whereArr = self::where_str($arr);
    $where = $whereArr['where'];
    $data = $whereArr['data'];
    $query="SELECT ".IMPORTEDDATA.".*, IF(e.event_type='Others', e.matchfile ,CONCAT(e.teama_short,' vs ',e.teamb_short,' - ',e.matchfile)) as event_title from ".IMPORTEDDATA." LEFT JOIN " . EVENTS . " e ON (e.id=".IMPORTEDDATA.".`matchNo`) ". $where." ORDER BY `title`";
    $rows = fDB::fetch_assoc_all($query,$data);
    return $rows['result'];
  }
}

?>