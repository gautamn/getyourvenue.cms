<?php
session_start();
$login_required = TRUE;
include_once dirname(__FILE__) . "/../../config/facile.php";
include_once facile::$path_includes . 'functions.php';
//Added for grab image from lastfm
include_once  facile::$path_includes . "imagegrab.php";
//end lastfm add
//upload folders name regarding request
//Constants
//You can alter these options
//$upload_dir = 'files/albumartwork';			// The directory for the images to be saved in
$upload_dir = '../assets/images/tempimg/';
// The directory for the images to be saved temp path
$upload_path = $upload_dir;			// The path to where the image will be saved

if(!isset($_SESSION['PIC_NAME'])){
 $_SESSION['PIC_NAME'] = $large_image_name = md5(time().$_SESSION['admin_user_id']).'large.jpg';		// New name of the large image
}
else{
	$large_image_name = $_SESSION['PIC_NAME'];
}
$thumb_image_name = md5(time().$_SESSION['admin_user_id']).session_id().'.jpg'; 	// New name of the thumbnail image
$max_file = "524288"; 						// Approx 0.5MB
$max_width = "468";				// Max width allowed for the large image

if($_REQUEST['aspect_ratio'] == '130x73'){
	$thumb_width = "130";					// Width of thumbnail image
	$thumb_height = "73";					// Height of thumbnail image
	$aspectRatio = "130:73";			// Height of thumbnail image
}elseif($_REQUEST['aspect_ratio'] == '70x38'){
	$thumb_width = "70";					// Width of thumbnail image
	$thumb_height = "38";					// Height of thumbnail image
	$aspectRatio = "70:38";				// Height of thumbnail image
}elseif($_REQUEST['aspect_ratio'] == '468x398'){//blogs
	$thumb_width = "468";     		// Width of thumbnail image
	$thumb_height = "398";				// Height of thumbnail image
	$aspectRatio = "468:398";			// Height of thumbnail image
}elseif($_REQUEST['aspect_ratio'] == '468x379'){//news
	$thumb_width = "468";     		// Width of thumbnail image
	$thumb_height = "379";				// Height of thumbnail image
	$aspectRatio = "468:379";			// Height of thumbnail image
}else{//news
	$thumb_width = "468";					// Width of thumbnail image
	$thumb_height = "379";        // Height of thumbnail image
	$aspectRatio = "468:379";			// Height of thumbnail image
}
//Image functions
//You do not need to alter these functions
function resizeImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,100);
	chmod($image, 0777);
	return $image;
}
//You do not need to alter these functions

//You do not need to alter these functions
function getHeight($image) {
	$sizes = getimagesize($image);
	$height = $sizes[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$sizes = getimagesize($image);
	$width = $sizes[0];
	return $width;
}

//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;

//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_dir)){
	mkdir($upload_dir, 0777);
	chmod($upload_dir, 0777);
}

//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\" />";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\" />";
} else {
   	$large_photo_exists = "";
    $thumb_photo_exists = "";
}
if (isset($_POST["upload"])) {

//Get the file information
  $warning=0;
  $error ="";
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);
	$flag = $_POST['flag'];
  $sizeinKB=round($userfile_size/1024);
	//Only process if the file is a JPG and below the allowed limit
	if(!empty($_FILES["image"]) && ($_FILES['image']['error']==0)) {
		if ($file_ext!="jpg" || $file_ext!="jpg") {
			$error= "ONLY jpeg/jpg images under 500KB are accepted for upload";
		}else if($sizeinKB>500){
     $warning=1;
    }
	}else{
		$error= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){

		if (isset($_FILES['image']['name'])){

			if(move_uploaded_file($userfile_tmp, $large_image_location)){
        chmod($large_image_location, 0777);
      }
      //echo $large_image_location;

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//echo ($width .'  --  '. $max_width);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				//$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				@unlink($thumb_image_location);
			}
		}

		//Refresh the page to show the new uploaded image
		header("location:".facile::$web_url."action/upload_crop?flag=".$flag."&aspect_ratio=".$_REQUEST['aspect_ratio']."&warning=".$warning);
		exit();

	}
}

if (isset($_POST["frmSubmit"]) && strlen($large_photo_exists)>0) {

	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	$flag = $_POST['flag'];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail
	echo "<script language=\"javascript\">
		parent.getArtwork('{$thumb_image_name}','{$flag}');
		parent.lightModal.close();
	</script>";
	if (file_exists($large_image_location)) {
		@unlink($large_image_location);
	}
	unset($_SESSION['PIC_NAME']);
	$thumb_new=$_POST['hidThumbImage'];
	/*echo "<script language=\"javascript\">
		parent.getArtworkThumb('{$thumb_new}');
		parent.lightModal.close();
	</script>";	*/
	exit();

//	header("location:".$_SERVER["PHP_SELF"]);

}

if (isset($_POST["frmSubmit1"])) {
	$flag = $_POST['flag'];
	$thumb_new=$_POST['photo_clip_full_name'];
	echo "<script language=\"javascript\">
		parent.getArtwork('{$thumb_new}','{$flag}');
		parent.lightModal.close();
	</script>";

	exit();

//	header("location:".$_SERVER["PHP_SELF"]);

}

if ($_GET['a']=="delete"){
	if (file_exists($large_image_location)) {
		unlink($large_image_location);
	}
	if (file_exists($thumb_image_location)) {
		unlink($thumb_image_location);
	}
//	header("location:".$_SERVER["PHP_SELF"]);

	exit();
}

//Added for grab image from lastfm
if (trim($_REQUEST['photofromlast']) != ''){

			$obj = new imagegrab();
			$obj->source_url = $_REQUEST['photofromlast'];
			$obj->dest_path = facile::$web_assets_url.'/'.$large_image_location;
			$obj->download();
			//move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				//$scale = $max_width/$width;
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				@unlink($thumb_image_location);
			}

			//Refresh the page to show the new uploaded image
			header("location:".facile::$web_url.'action/upload_crop?type=clip');
			exit();
		}
//end
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?php echo facile::$theme_url;?>css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo facile::$theme_url;?>css/fileuploader.css" />
<script type="text/javascript" src="<?php echo facile::$jsbaseurl;?>lib/fileuploader.js"></script>
<script type="text/javascript" src="<?php echo facile::$jsbaseurl;?>lib/jquery.js"></script>
<script type="text/javascript" src="<?php echo facile::$jsbaseurl;?>lib/jquery.pack.js"></script>
<script type="text/javascript" src="<?php echo facile::$jsbaseurl;?>lib/jquery.imgareaselect-0.3.min.js"></script>
<script type="text/javascript">
    <?php if($_REQUEST['warning']==1){?>
      alert('Warning : it is recommended that poster/images should not be greater than 500kb');
    <?php } ?>
	function exeSubmit(){
	if(typeof $('#frmthumbnail').attr('id') == 'undefined'){
		var photothumb=$('#photo_clip_full_name').val();
		if(photothumb!=""){
		  $('#thumb_new').submit();
    }else{
			alert("Please Select Image");
    }
	}
	else
	{
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		var flag = $('#flag').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
  		  $('#hidThumbImage').val($('#photo_clip_full_name').val());
	   	  $('#frmthumbnail').submit();
		}
	}
}
	</script>
</head>
<body style="width:600px;background:#fff none">
 <div id="main_content" >

<div class="main_content" style="padding:10px">
<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection)
{
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(document).ready(function () {
	/*$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			$('#hidThumbImage').val($('#photo').val());
			return true;
		}
	});*/
});

$(window).load(function () {
	$('#thumbnail').imgAreaSelect({ aspectRatio: '<?php echo $aspectRatio;?>', onSelectChange: preview });
});
</script>


<?php }?>
<?php
//Display error message if there are any
 if($_REQUEST['warning']==1){
      echo "<div><font color='red'>Warning : it is recommended that poster/images should not be greater than 500kb</font></div><br/>";
 }
if(strlen($error)>0){
	echo "<div><font color='red'><strong>Error!</strong> ".$error."</font></div>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo "<p><strong>NOTE:</strong> If the thumbnail image looks the same as the previous one, just hit refresh a couple of times.</p>";
	echo $large_photo_exists."&nbsp;".$thumb_photo_exists;
	echo "<p><a href=\"".facile::$web_url."action/upload_crop?type=clip&aspect_ratio="."&a=delete\" onclick=\"parent.getArtwork('{$thumb_image_name}');\" id='TB_closeWindowButton' title='Close'>Save and Close</a></p>";
}else if(strlen($large_photo_exists)>0 && !isset($_GET['type']) ){
		?>
		<div>
			<img src="<?php echo $upload_path.$large_image_name;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
			<div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
				<img src="<?php echo $upload_path.$large_image_name;?>?<?=time()?>" style="position: relative;" alt="Thumbnail Preview" id="thumbnalId" />
			</div>
			<br style="clear:both;"/>
			<form name="thumbnail" id="frmthumbnail" action="<?php echo facile::$web_url.'action/upload_crop?type=clip&aspect_ratio='.$_REQUEST['aspect_ratio']?>" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="hidden" name="flag" value="<?php echo $_REQUEST['flag'];?>" />
       	<input type="hidden" name="aspect_ratio" value="<?php echo $_REQUEST['aspect_ratio'];?>" />
        <input type="hidden" name="hidThumbImage"  id="hidThumbImage" />
				<input type="hidden" name="frmSubmit" value="thumbnail" />
			</form>
		</div>
	<hr />
	<?php 	}
	 else{
		?>

	<h4>Upload Photo</h4>
	<form name="photo" enctype="multipart/form-data" action="<?php echo facile::$web_url.'action/upload_crop?type=clip&aspect_ratio='.$_REQUEST['aspect_ratio']?>" method="post">
	<input type="file" name="image" size="30" />
	<input type="hidden" name="type" value="<?php echo $_REQUEST['type'];?>" />
	<input type="hidden" name="flag" value="<?php echo $_REQUEST['flag'];?>" />
	<input type="hidden" name="aspect_ratio" value="<?php echo $_REQUEST['aspect_ratio'];?>" />
	<input type="submit" name="upload" value="Upload" />
	</form>

	<br><br>OR<br><br>
	<form name="thumb_new" id="thumb_new" action="<?php echo facile::$web_url.'action/upload_crop?type=clip&aspect_ratio='.$_REQUEST['aspect_ratio']?>" method="post">
						<div class="lc">
              <b>Upload Thumb Image: [<?=$_REQUEST['aspect_ratio']?>]</b>
              <input type="hidden" name="photo_clip_full_name" id="photo_clip_full_name" value="" />
            </div>
						<div id="clip_full_name"></div>
						<script>
									createUploader('clip_full_name');
									function createUploader(block){
										var uploader = new qq.FileUploader({
											element: document.getElementById(block),
											action: '<?php echo facile::$web_url;?>action/jq_fileupload',
											debug: true
										});
									}
								</script>
							 <input type="hidden" name="frmSubmit1" value="thumb_new"  />
							 <input type="hidden" name="flag" value="<?php echo $_REQUEST['flag'];?>" />
							 <input type="hidden" name="aspect_ratio" value="<?php echo $_REQUEST['aspect_ratio'];?>" />
							</form>
<?php
	}
//Added for grab image from lastfm
if($img_count = count($artist->images['url'])) {
?>
 <h1>OR</h1>
 <br />
<h2>Select Photo</h2>
<?php
for($i=0; $i<$img_count; $i++) {
	$img = $artist->images['url'][$i];
?>
<a href="upload_crop.php?photofromlast=<?=$artist->images['url'][$i]?>"><img src="<?=$img?>" width="200" /></a>
<?
}
}
//end

?>
</div></div>
<input type="submit" name="upload_thumbnail" style="position:relative;" class="submit-green" value="Done" id="save_thumb" onclick="exeSubmit()" />
</body>
</html>
