<?php
include_once facile::$path_classes . "/uploadfile/uploadfile.php";
ini_set('post_max_size','10M');
// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array("jpeg","jpg");
// max file size in bytes
$sizeLimit = 1048576; //1MB
//die($path_prefix.'web/uploads/');
$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(facile::$web_tempfile_path);
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);


?>