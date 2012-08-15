<?php
	class image {

		// upload banner
		public function upload_image_resize($image,$path,$width=NULL,$img_name="") {
			$size_arr = @getimagesize($image['tmp_name']);
			if($size_arr[0]) {
				$size = $size_arr[0].'X'.$size_arr[1];
				$file = ($img_name==NULL) ? time().$image['name'] : $img_name.'-'.$size.'-'.$image['name'];
				$save_path = $path.$file;
				if(move_uploaded_file($image['tmp_name'],$save_path)){
					if($width!=NULL)
					$this->resize($path,$file,$width);
				}
					return $file;
			}
			return false;
		}
		public function upload_image($image,$path,$img_name="") {
			$size_arr = @getimagesize($image['tmp_name']);
			if($size_arr[0]) {
				$size = $size_arr[0].'X'.$size_arr[1];
				$file = ($img_name==NULL) ? time().$image['name'] : $img_name;
				$save_path = $path.$file;
				if(move_uploaded_file($image['tmp_name'],$save_path))
					return $file;
			}
			return false;
		}
		public function resize($path,$file,$width) {
			require_once facile::$path_utilities.'phpthumb/ThumbLib.inc.php';
			$thumb = PhpThumbFactory::create($path.$file);
			/*$thumb->resize(200);
			$thumb->save($path.'200/'.$file);*/
			$thumb->resize($width);
			$thumb->save($path.'thumb/'.$file);


			//$thumb->save($path.'thumb/'.$file);
			/*$thumb->resize(120);
			$thumb->save($path.'120/'.$file);*/
			//$thumb->show();
			//$thumb->cropFromCenter(120);

			//$thumb->adaptiveResize(140, 100)->createReflection(40, 40, 100, true, '#a4a4a4');
			//$thumb->show(100);
			//$thumb->destruct();
		}

		public function upload_doc($doc,$path) {

			$file = time().$doc['name'];
			$path = $path.$file;
			if(move_uploaded_file($doc['tmp_name'],$path))
				return $file;
			return false;
		}

    public function copy_temp_file($file_name,$destination_path,$img_name="") {
      //$size = $size_arr[0].'X'.$size_arr[1];
      $source_path = facile::$web_tempfile_path.$file_name;
      $file = ($img_name==NULL) ?time().$file_name : $img_name;
      $save_path = $destination_path.$file;
			$cp = @copy($source_path, $save_path);
      if($cp == 1){
        @unlink($source_path);
        return $file;
      }
      return false;
		}
	}
?>