<?php
if($_REQUEST['type']=='media' && $_REQUEST['act']=='akamaicheckmediafile'){
		$path = '/138688/ftpuploads/';
		$file = trim($_REQUEST['file']);
		$fileInfoArr = @explode("/",$file);

		$flist = Akamai::checkFileExistance($path,$fileInfoArr);
		if(empty($flist)){
			echo json_encode(array('status'=>0,'error'=>'not exist','message'=>'not exist','type'=>'alert','opt'=>'not exist','data'=>array()));
		}else{
			$fnewArr = array();
			foreach($flist AS $k=>$v){
				$xp = @explode("/",$v);
				if(count($fileInfoArr) == 2){
					$_file = $xp[3];
				}else{
					$_file = $xp[2];
				}
				$fnewArr[] = $_file;
			}
			if(in_array($fileInfoArr[count($fileInfoArr)-1],$fnewArr)){
				/*$source = $path.$fileInfoArr[count($fileInfoArr)-1];
				$destination = $path.'test/'.$fileInfoArr[count($fileInfoArr)-1];
				Akamai::moveFile($source,$destination);
				$path = '/138688/clips/119';
				$flist = Akamai::checkFileExistance($path);
				print_r($flist);*/
				echo json_encode(array('status'=>1,'error'=>'','message'=>'exist','type'=>'alert','opt'=>'exist','data'=>array()));
			}else{
				echo json_encode(array('status'=>0,'error'=>'not exist','message'=>'not exist','type'=>'alert','opt'=>'not exist','data'=>array()));
			}
		}
		die;
  }

?>