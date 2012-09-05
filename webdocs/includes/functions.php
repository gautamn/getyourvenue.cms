<?php
  //@desc: check user logged in ot not
  function is_loggedin(){
    if(!isset($_SESSION[_ADMIN_ID])) {
      header("location: ". facile::$web_url);
      exit;
    }
  }

  function renderTpl($block, $dataArray){
      include_once view::$block_path . $block . '.php';
      $blockobj = new $block;
      foreach($dataArray as $key => $value){
          $blockobj->$key = $value;
      }
      $data = $blockobj->process();

      $data['tpl'] = (!$data['tpl']) ? $block . '_inner_default.tpl' : $data['tpl'];
      $file = view::$tpl_path . '/' . $data['tpl'] ;
      $template = new template($file, $data);
      $html = $template->fetch();
      return $html;
  }

  function weightage_rand($ads){
    foreach($ads as $k=>$v){
      for($i=0;$i<$v['weightage'];$i++){
        $return[] = $k;
      }
    }
    $key = rand(0, count($return));
    return $return[$key];
  }

	function serchInArray($array,$searchData){
		foreach($array as $key=>$element){
			$searchKey = (stripos($element,$searchData)>-1 ? $key : -1);
		}
		return $searchKey;
	}

	function appCommaList($list,$filedtype, $space='N'){
		$tList=array();
		if($list)
		{
			while(list(,$row) = each($list)){
				$tList[] = $row[$filedtype];
			}
			if($space == 'N')
				$str = join(',',$tList);
			else
				 $str = join(', ',$tList);
		}
		$str = (empty($str) ? "' '":$str);
		return $str;
	}

	  function chkMultiArray($ar){
		  $arr = array();
		  if(sizeof($ar)>0){
			  foreach($ar as $key=>$value){
				  if(is_array($value))
				  {
					  foreach($value as $key1=>$val){
						  $arr[] = $val;
					  }
				  }
				  else
					$arr[] = $value;
			  }
		  }
		  return $arr;
	  }


	 function chkIndex($str,$find){
		 if(stripos($str,$find)>-1)
			 return true;
		 else
			 return false;
	 }

	 function prepareAddSlashes($params){
     if(is_array($params)){
        foreach($params as $key => $val){
          if(!empty($params[$key])){
            $params[$key] = prepareAddSlashes($val);
          }
        }
     }else{
        if(get_magic_quotes_gpc()){
					$params = stripslashes($params);
				}
				return trim(addslashes($params));
     }
     return $params;
	}

	function prepareStripSlashes($params){
		foreach($params as $key => $val){
			if(!empty($params[$key])){
				if(!is_array($val))
				   $params[$key] = stripslashes($val);
				else
					prepareStripSlashes($val);
			}
		}
		return $params;
	}

	function prepareEmpty($str){
		return (empty($str) ? "''" : $str);
	}

	 function getAge($Birthdate){
		 list($BirthDay,$BirthMonth,$BirthYear) = explode("/", $Birthdate);
		 if($BirthDay == 00 || $BirthMonth==00 || $BirthYear==0000) return '';
		 $YearDiff = date("Y") - $BirthYear;
		 $MonthDiff = date("m") - $BirthMonth;
		 $DayDiff = date("d") - $BirthDay;
		 if ($DayDiff < 0 || $MonthDiff < 0)
			 $YearDiff--;
		 return $YearDiff;
     }
	//calculate the ratings
	function calculateRating($clipdetails){
		$averageRating = number_format(($clipdetails['rating']/$clipdetails['num_ratings']),1,'.','');
		$fraction = (int)substr($averageRating,(int)strpos($averageRating,'.')+1);
		$fraction1 = (int)substr($averageRating,(int)strpos($averageRating,'.')-1);
		if($fraction==0){
			$value = 0;
		}else if($fraction>0 && $fraction<=5){
			$value = .5;
		}else{
			$value = 1;
		}
	   $cliprate = number_format(($fraction1+$value),1);
	   return $cliprate;
	}

	 /**
  * @param input data array
  * function prepare sql statement
  */
 function prepairDbArr($DataArr){
	foreach($DataArr as $key => $val){
		if(empty($DataArr[$key]) && !is_numeric($DataArr[$key])){
		   $DataArr[$key] = '';
		}
	}
	return $DataArr;
 }

/**
* @desc time calculation
* @param integer $time
* @return  string
*/

function calculate_time($time) {
	$time_ago = time()-$time;
	$days = $time_ago/86400;
	$hrs = ($days-(int)$days)*24;
	$min = ($hrs-(int)$hrs)*60;
	$sec = ($min-(int)$min)*60;

	if ((int)$days != 0) {
		if((int)$days == 1) {
			$days_name = " day";
		}
		else {
			$days_name = " days";
		}
		$time_ago = (int)$days.$days_name;
	} else if ((int)$hrs != 0) {
		if((int)$hrs == 1) {
			$hrs_name = " hr";
		}
		else {
			$hrs_name = " hrs";
		}
		$time_ago = (int)$hrs. $hrs_name;
	} else if ((int)$min != 0) {
		if((int)$min == 1) {
			$min_name = " min";
		}
		else {
			$min_name = " mins";
		}
		$time_ago = (int)$min. $min_name;
	} else if  ((int)$sec != 0) {
		$time_ago = (int)$sec. " sec";
	}
	if ($time_ago == 0) {
		$time_ago = $time_ago. " sec";
    }
    return $time_ago." ago";
  }


  function ago($ut,$ct=''){
		$utime=convert_datetime($ut);
		if($ct == '')
			$ctime=convert_datetime(date('Y-m-d H:i:s'));
		else
			$ctime=convert_datetime($ct);
        $difference = (int)$ctime - $utime;
		if($difference < 0 )
			$difference = 1;
        if($difference < 60)
            return $difference.$a=($difference < 2)?' sec ago':' secs ago';
        else{
            $difference = round($difference / 60);
            if($difference < 60)
                return $difference.$a=($difference < 2)?' min ago':' mins ago';
            else{
                $difference = round($difference / 60);
                if($difference < 24)
                    return $difference.$a=($difference < 2)?' hr ago':' hrs ago';
                else{
                    $difference = round($difference / 24);
                    if($difference < 7)
                        return $difference.$a=($difference < 2)?' day ago':' days ago';
                    else{
                        $difference = round($difference / 7);
						if($difference < 52)
                       	 return $difference.$a=($difference < 2)?' week ago':' weeks ago';
						else{

							$timeArr = @explode(' ',$ut);
							return date("jS M, Y", mktime(0, 0, 0, $timeArr[2], $timeArr[1], $timeArr[0]));
						}
                    }
                }
            }
        }
  }

function convert_datetime($str)
{
	list($date, $time) = explode(' ', $str);
	list($year, $month, $day) = explode('-', $date);
	list($hour, $minute, $second) = explode(':', $time);

	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

	return $timestamp;
}

function let_to_num($v){ //This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
    $l = substr($v, -1);
    $ret = substr($v, 0, -1);
    switch(strtoupper($l)){
    case 'P':
        $ret *= 1024;
    case 'T':
        $ret *= 1024;
    case 'G':
        $ret *= 1024;
    case 'M':
        $ret *= 1024;
    case 'K':
        $ret *= 1024;
        break;
    }
    return $ret;
 }

function clean_special_character($text, $strtolower=1){
	$text = trim($text);
  if($strtolower){
    $text = strtolower(trim($text));
  }
	// replace all white space sections with a dash
	$text = str_replace(' ', '-', $text);
	// strip all non alphanum or -
	$clean = preg_replace("[^A-Za-z0-9-]", "", $text);
  $clean = str_replace(' ', '-', trim(str_replace('-', ' ', trim($clean))));
	while(strpos($clean,"--")){
		$clean=str_replace("--","-",$clean);
	}
	return $clean;
}

function selfURL($fileonly=false){
  if(!isset($_SERVER['REQUEST_URI'])){
      $serverrequri = $_SERVER['PHP_SELF'];
  }else{
      $serverrequri =    $_SERVER['REQUEST_URI'];
  }
  if($fileonly) $serverrequri = str_replace('?'. $_SERVER['QUERY_STRING'],'',$serverrequri);
  $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
  $proto = (explode("/",strtolower($_SERVER["SERVER_PROTOCOL"])));
  $protocol = $proto[0].$s;
  $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
  return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
}

function getFieldList($table)
{
  $fields = array();
  $q = "SHOW COLUMNS FROM ".$table;
  $res = fDB::fetch_assoc_all($q);
  foreach($res['result'] as $r)
  {
    $fields[] = $r['Field'];
  }
  return $fields;
}


function get_dropdown($arr,$name,$selected='0',$arrAttr=array(),$defaulText='Please Select')
{
    $arr1 = array();
    $strAttributes = "";
    if(count($arrAttr)>0) {
        foreach($arrAttr as $key=>$val){
            if(trim($val) == "getCurrentMatch()"){
              $val = 'getCurrentMatch("'.$arrAttr['eventzone'].'")';
              $arr1[] = $key ."='".($val)."'";
            }else{
              $arr1[] = $key ."='".addslashes($val)."'";
            }
        }
    }
    $strAttributes = implode(" ",$arr1);
    $strHTML="<select name='".$name."' id='".$name."' $strAttributes >";
    $strHTML .="<option value=''>".$defaulText."</option>";
    for($i=0;$i<count($arr);$i++) {
         $strSelected="";
        if($selected==$arr[$i]['id'])
            $strSelected="selected=selected";

        $strHTML .="<option value='".$arr[$i]['id']."' ".$strSelected.">".$arr[$i]['name']."</option>";
    }
    $strHTML .="</select>";
    return $strHTML;

}

function findexts ($filename) {
	$filename = strtolower($filename) ;
	$exts = preg_split("[\.]", $filename) ;
  $n = count($exts)-1;
	$exts = $exts[$n];
  //echo "<br>Ext: ".$exts; die();
	return $exts;
}

function unzipFile($file){
  $filename = basename($file, ".zip").PHP_EOL;
  $zip = new ZipArchive() ;
  if ($zip->open($file) !== TRUE) {
    die ("Could not open archive");
  }
  $createdir = facile::$path_assets."xml/".trim($filename);
  @mkdir($createdir, 0777);
  $return = $zip->extractTo($createdir);
  $zip->close();
  return $return;
}

function parseurl($file){
  $_xml = file_get_contents($file);
  $start = stripos($_xml,'media:content url="');
  $start += 19;
  $url_base = substr($_xml,$start,500);
  $end = stripos($url_base,'">');
  $url = substr($url_base,0,$end);
  return $url;
}

function formatTime($ttime){
  $ttime = str_replace(':','.',$ttime);
  $timeparts = explode('.',$ttime);
  if(count($timeparts) == 2){
    $ttime = '0.'. $ttime;
    $timeparts = explode('.',$ttime);
  }
  if(count($timeparts) == 1){
    $ttime = '0.0.'. $ttime;
    $timeparts = explode('.',$ttime);
  }
  $out = Array();
  $timeparts = array_reverse($timeparts);
  $rem = 0;
  foreach($timeparts as $part){
    $rem_ = floor($part / 60);
    $part = (((int) $part) % 60) + $rem;
    $out[] = $part < 10 ? '0'. $part : $part;
    $rem = $rem_;
  }
  $out = array_reverse($out);
  $outtime = implode(':',$out);
  return $outtime;
}

function chop_string($string, $length=30) {
    if($string==NULL) return " ";
    $string = strip_tags($string);
    $return = substr($string, 0, $length);
    if(strlen($string) > $length) {
        $return .= "..";
    }
  return $return;
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$thumb_image_name,100);
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

function getArtworkURL($type,$image,$size='small'){
if($type==NULL || $image==NULL) return;
  switch($type){
    case 'venue'://thumb
      $file = facile::$web_venueimage_path.$image;
      $file =(@file_exists($file))? facile::$web_venueimage_url.$image:NULL;
      break;
    case 'venueGallery':
      $file = facile::$web_venueimage_path.$image;
      $file =(@file_exists($file))? facile::$web_venueimage_url.$image:NULL;
      break;
    default:
      $file = NULL;
      break;
    }
    return $file;
}

  // pass current seo key in $params['seo_key'] and $insert=0 value when action is "update"
  function insertUpdateSEO($id, $seo_key_input, $entity_type, $insert = 1, $params=array()){
      //echo "$id, $seo_key_input, $entity_type, $insert = 1, <pre>".print_r($params,1)."</pre>";
      if(!($id>0 && $entity_type)){
        return '';
      }
      $seo_key_input = trim($seo_key_input);
      $seo_key = clean_special_character($seo_key_input); // new seo key without duplicacy check

      // select seo table
      switch ($entity_type){

        case 'admin_user':
        case 'user':
          $seo_table = SEOUSER;
          break;
        default:
          $seo_table = SEO;
      }

      if(!$insert){ // if update
        if(trim($params['seo_key'])){ // if current seo key is passed
          $query = "SELECT entity_id,url FROM " . $seo_table . " WHERE entity_id = ? AND entity_type =?";
          $data = array($id,$entity_type);
          $seoRow = fDB::fetch_assoc_first($query,$data);
          if($seoRow['entity_id']>0 && $seoRow['url']){
            if($seoRow['url'] == trim($params['seo_key'])){
              return $seoRow['url'];                // since seo key is not changed so return current seo key as there is no need of new one.
            }else{
              $seo_key = clean_special_character($params['seo_key'],0); // if passed seo key is changed
            }
          }else{
            $insert = 1; // if current seo key is not passed then follow same logic of "insert".
          }
        }else{
          $insert = 1; // if current seo key is not passed then follow same logic of "insert".
        }
      }

      // delete current entry of seo key in seo table before checking duplicacy of seo key
      $query = "DELETE FROM " . $seo_table . " WHERE entity_id = ? AND entity_type =?";
      $data = array($id,$entity_type);
      fDB::query($query,$data);

      // duplicacy check of seo key in seo table
      $seo_key1 = $seo_key;
      $i = 0;
      do{
        $Querycount = "SELECT COUNT(*) as tot FROM " . $seo_table . " WHERE entity_type=? AND url=?";
        $dataCount  = array($entity_type, $seo_key1);
        $arr = fDB::fetch_assoc_first($Querycount,$dataCount);
        $count = $arr['tot'];
        if($count>0){
          $i++;
          $seo_key1 = $seo_key . "-" .($count+$i);
        }
      }while($count > 0);
      $seo_key = $seo_key1;

      // insert unique seo key in seo table
      $query="INSERT INTO " . $seo_table . " (entity_id,entity_type,url) VALUES (?,?,?)";
      $data = array($id,$entity_type,$seo_key);
      fDB::query($query,$data);

      return $seo_key;
    }

    function getSEO($id, $entity_type){
      $entity_type = trim($entity_type);
      if($entity_type == '' || !($id>0)){
        return '';
      }
      switch ($entity_type){
        case 'admin_user':
        case 'user':
          $seo_table = SEOUSER;
          break;
        default:
          $seo_table = SEO;
      }
      $query = "SELECT url FROM " . $seo_table . " WHERE entity_id = ? AND entity_type =?";
      $data = array($id,$entity_type);
      $seoRow = fDB::fetch_assoc_first($query,$data);
      $seo_key = $seoRow['url'];
      return $seo_key;
    }

    function writeExceptionLog($errormsg,$url){
      $exceptionFailedLog = facile::$path."/log/exceptionLog.txt";
      $fh = @fopen($exceptionFailedLog, 'a');
      $dateTimeData=date('Y-m-d h:m:s');
      $stringDataFailed = "Dated :-".$dateTimeData." - Hit Url(".$url.") - Error (".$errormsg.")"."\n";
      @fwrite($fh, $stringDataFailed);
      @fclose($fh);
    }

    function getModPath($type,$id,$modNumber=100){
		if($id==NULL) return;
		$mod = ($id%$modNumber);

		return $mod;
	}
/**
 * @param int $newsTimestamp
 */
function getDateFormat($timestamp){
  if($timestamp==NULL) return;
  return date('M j, Y, H:i:s', strtotime($timestamp));
}

/**
 * @desc to prepare data for input field so html tag does'nt break in form
 * @param array/string $dataArray
 */
function getFormatedEditData($dataArray){
  if(is_array($dataArray)){
    foreach($dataArray as $key => $data){
      $dataArray[$key] = htmlentities($data, ENT_QUOTES);
    }
  }else{
    $dataArray = htmlentities($dataArray, ENT_QUOTES);
  }
  return $dataArray;
}

function copyImageFromUrl($url, $sourceImageName, $destImagePath, $destImageName = ''){
  $url              = trim($url);
  $sourceImageName  = trim($sourceImageName);
  $destImagePath    = trim($destImagePath);
  $destImageName    = trim($destImageName);
  if($url == '' || $sourceImageName == '' || $destImagePath == ''){
    return;
  }
  if($destImageName == ''){
    $destImageName = $sourceImageName;
  }
  //echo "<br>url: ".$url.$sourceImageName."<br>dest: ".$destImagePath.$destImageName;

  $content = file_get_contents($url.$sourceImageName);
  //Store in the filesystem.
  $fp = @fopen($destImagePath.$destImageName, "w");
  @fwrite($fp, $content);
  @fclose($fp);
}

function findfile($location='',$fileregex='') {
    if (!$location or !is_dir($location) or !$fileregex) {
       return false;
    }

    $matchedfiles = array();

    $all = opendir($location);
    while ($file = readdir($all)) {
       if (is_dir($location.'/'.$file) and $file <> ".." and $file <> ".") {
          $subdir_matches = findfile($location.'/'.$file,$fileregex);
          $matchedfiles = array_merge($matchedfiles,$subdir_matches);
          unset($file);
       }
       elseif (!is_dir($location.'/'.$file)) {
          if (preg_match($fileregex,$file)) {
             array_push($matchedfiles,$location.'/'.$file);
          }
       }
    }
    closedir($all);
    unset($all);
    return $matchedfiles;
 }

  /**
	 * log the cms activity
	 * Enter description here ...
   * activity : Insert | Update | Delete
   * $extra: sql query in the form json_encode
	*/
	function cms_activity_log($activity=NULL, $extra=NULL){
    $user_id = !empty($_SESSION['admin_user_id']) ? $_SESSION['admin_user_id'] : 0;
    if($user_id<1){
      return;
    }
    if(preg_match('/log_cms_activity/', $extra) || preg_match('/log_cms_login_histroy/', $extra)){
      return;
    }
    $modules = !empty($_SESSION['requestedPage']) ? trim($_SESSION['requestedPage']) : '';
    $page_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    $view_date = date('Y-m-d H:i:s');
    $ip = getIP();
    //logging to the log_cms_activity for every processing..
    $sql = "INSERT INTO log_cms_activity(user_id, page_url, section, activity, activity_date, extra) VALUES (?, ?, ?, ?, ?, ?)";
    $data = array($user_id, $page_url, $modules, $activity, $view_date, $ip);
    fDB::query($sql, $data);
  }

//Function to get IP address of user
function getIP(){
	if(isset($_SERVER["HTTP_TRUE_CLIENT_IP"]))
		$IP = $_SERVER["HTTP_TRUE_CLIENT_IP"];
	elseif(isset($_SERVER["HTTP_NS_REMOTE_ADDR"]))
		$IP = $_SERVER["HTTP_NS_REMOTE_ADDR"];
	else
		$IP = $_SERVER["REMOTE_ADDR"];
	return($IP);
}

?>