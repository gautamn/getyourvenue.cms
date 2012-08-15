<?php
# Constants
  define('MAX_WIDTH', 150);
  define('MAX_HEIGHT', 150);

# Constants for desktop images
  define('MAX_WIDTH_DESKTOP', 200);
  define('MAX_HEIGHT_DESKTOP', 100);

# Constants for changing image size
  define('IMAGE_MEDIUM', 4);
  define('IMAGE_VERYSMALL', 0.5);
  define('IMAGE_THUMBNAIL', 0.3);
  define('IMAGE_DESKTOP', 4);

# Constants for resized image path
  define('SMALL', "$path/web/files/smallimages/small_");
  define('MEDIUM', "$path/web/files/mediumimages/medium_");
  define('VERY_SMALL', "$path/web/files/verysmallimages/verysmall_");
  define('THUMBNAIL', "$path/web/files/thumbnails/thumbnail_");
  define('DESKTOP', "$path/web/files/desktopimages/desktop_");
  define('SQUARE_IMAGES', "$path/web/files/square");

# Constants for resizing operations
  define("RESIZE_STRETCH", 1); // ignore aspect ratio, just stretch to the given size (output image will be exactly the desired size)
  define("RESIZE_CROP", 2); // scale the image to be larger than the output size, then crop out the middle (output image will be exactly the desired size)
  define("RESIZE_CROP_NO_EXPAND", 3); // as with RESIZE_CROP, but just crop to fit, don't scale up.
  define("RESIZE_FIT", 4); // scale the image to fit insize the output size (output image may be smaller than the desired size)
  define("RESIZE_FIT_NO_EXPAND", 5); // as with RESIZE_FIT, but only ever scale down.
  define("RESIZE_CROP_START", 6); // as with RESIZE_CROP, but just crop to fit, don't scale up.

// Image type constants - FIXME: maybe already defined in PHP5?
if (@(IMAGETYPE_GIF != 1))
{
    define("IMAGETYPE_GIF", 1);
    define("IMAGETYPE_JPEG", 2);
    define("IMAGETYPE_PNG", 3);
}

/**
* Class Images
* @author Tekriti Software
*/
class ImageResize {

  static $skip_gd = FALSE; // set to TRUE to *not* use GD
  static $skip_magick = FALSE; // set to TRUE to *not* use ImageMagick

  private static $resize_type_prefixes = array(
      RESIZE_STRETCH => "stretch",
      RESIZE_CROP => "crop",
      RESIZE_CROP_NO_EXPAND => "crop_s",
      RESIZE_FIT => "fit",
      RESIZE_FIT_NO_EXPAND => "fit_s",
      RESIZE_CROP_START => "crop",
  );

  /**
  *  resize the images
  * @param $iamge_path the path of an image to be resized
    DEPRECATED
  */
  private static function resize_image($image_path, $desktop_image=0) {
    //Logger::log("Enter: ImageResize::resize_image");
    global $path_prefix;
    $img = null;
    $path = explode('/', $image_path);
    $imagename = end($path);
    $path1 = explode('.', $image_path);
    $ext = strtolower(end($path1));

    // To Check whether GD is installed or not.
    if(function_exists("gd_info") && function_exists("imagecreatefromjpeg") && $ext != 'bmp') {
      // Get image size and scale ratio
      if ($ext == 'jpg' || $ext == 'jpeg') {
        $img = @imagecreatefromjpeg($image_path);
      }
      elseif ($ext == 'png') {
        $img = @imagecreatefrompng($image_path);
      }
      elseif ($ext == 'gif') {
        $img = @imagecreatefromgif($image_path);
      }
      if ($desktop_image==1) {
        if ($img) {
          $width = imagesx($img);
          $height = imagesy($img);
          $scale = min(MAX_WIDTH_DESKTOP/$width, MAX_HEIGHT_DESKTOP/$height);
        }
      }
      else {
        if ($img) {
          $width = imagesx($img);
          $height = imagesy($img);
          $scale = min(MAX_WIDTH/$width, MAX_HEIGHT/$height);
        }
      }
      if ($scale < 1) {

        if ($desktop_image==1) {
          // to make desktop images
          if ($img) {
            // If the image is larger than the max shrink it
            $new_width = floor($scale*$width*IMAGE_DESKTOP);
            $new_height = floor($scale*$height*IMAGE_DESKTOP);
            $tmp_img = @imagecreatetruecolor($new_width, $new_height);
            @imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

          }
          if ($ext == 'jpg') {
            @imagejpeg($tmp_img, DESKTOP."$imagename",100);
          }
          else {
            $method = "image$ext";
            @$method($tmp_img, DESKTOP."$imagename");
          }
          @imagedestroy($tmp_img);
        }
        else {
          if ($img) {
            // If the image is larger than the max shrink it
            $new_width = floor($scale*$width);
            $new_height = floor($scale*$height);

            // Create a new temporary image
            $tmp_img = @imagecreatetruecolor($new_width, $new_height);

            // Copy and resize old image into new image
            @imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

          }

          // Save the image
          if ($ext == 'jpg') {
            @imagejpeg($tmp_img, SMALL."$imagename",100);
          }
          else {

            $method = "image$ext";
            @$method($tmp_img, SMALL."$imagename");
          }
          @imagedestroy($tmp_img);
          // to make medium size images
          if ($img) {
            // If the image is larger than the max shrink it
            $new_width = floor($scale*$width*IMAGE_MEDIUM);
            $new_height = floor($scale*$height*IMAGE_MEDIUM);
            $tmp_img = @imagecreatetruecolor($new_width, $new_height);
            @imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

          }
          if ($ext == 'jpg') {
            @imagejpeg($tmp_img, MEDIUM."$imagename",100);
          }
          else {
            $method = "image$ext";
            @$method($tmp_img, MEDIUM."$imagename");
          }
          @imagedestroy($tmp_img);

          // to make very small images
          if ($img) {
            // If the image is larger than the max shrink it
            $new_width = floor($scale*$width*IMAGE_VERYSMALL);
            $new_height = floor($scale*$height*IMAGE_VERYSMALL);
            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            @imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

          }
          if ($ext == 'jpg') {
            @imagejpeg($tmp_img, VERY_SMALL."$imagename",100);
          }
          else {
            $method = "image$ext";
            @$method($tmp_img, VERY_SMALL."$imagename");
          }
          @imagedestroy($tmp_img);

          // to make thumbnail of images
          if ($img) {
            // If the image is larger than the max shrink it
            $new_width = floor($scale*$width*IMAGE_THUMBNAIL);
            $new_height = floor($scale*$height*IMAGE_THUMBNAIL);
            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            @imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

          }
          if ($ext == 'jpg') {
            @imagejpeg($tmp_img, THUMBNAIL."$imagename",100);
          }
          else {
            $method = "image$ext";
            @$method($tmp_img, THUMBNAIL."$imagename");
          }
          @imagedestroy($tmp_img);
        }
      }
    }
    //Logger::log("Exit: ImageResize::resize_image");
  }

  /**
  * to get the images
  * @return $array_of_images having path for all type of images
  *
    DEPRECATED
  * NOTE: you should probably be using uihelper_resize_mk_img() or
  * uihelper_resize_mk_user_img() to resize images.
  */
  public static function get_images($image_path, $desktop_image=0) {
    //Logger::log("Enter: ImageResize::get_images");
    global $path_prefix;
    $array_of_images[] = array();
    $path = explode('/', $image_path);
    $image_name = end($path);
    $path1 = explode('.', $image_path);
    $ext = strtolower(end($path1));

    if ($desktop_image==1) {
      $array_of_images['original_image'] = "$image_path";
      $d_path = DESKTOP."$image_name";
      if (!file_exists("$d_path")) {
        ImageResize::resize_image($image_path,  $desktop_image);
      }
      $array_of_images['desktop_image'] = $d_path;
      $t = $array_of_images['desktop_image'];
      //print "$image_path(($desktop_image)) $t"; exit;
    }
    else {
      $m_path = MEDIUM."$image_name";
      $s_path = SMALL."$image_name";
      $vs_path = VERY_SMALL."$image_name";
      $t_path = THUMBNAIL."$image_name";

      $array_of_images['original_image'] = "$image_path";
      if (!file_exists("$m_path") || !file_exists("$s_path") || !file_exists("$vs_path") || !file_exists("$t_path")) {
        ImageResize::resize_image($image_path);
      }
      $array_of_images['medium_image'] = $m_path;
      $array_of_images['small_image'] = $s_path;
      $array_of_images['verysmall_image'] = $vs_path;
      $array_of_images['thumbnail_image'] = $t_path;
    }

    return $array_of_images;
    //Logger::log("Exit: ImageResize::get_images");
 }

  /* Given a root path and URL, and relative paths to a picture and an
   * alternate picture, resizes the picture if it exists, or otherwise
   * resizes the alternate picture.  Then generates an <img> tag
   * pointing to whichever it could resize.
   *
   * The image is downsized to fit within the provided rectangle
   * ($max_x, $max_y).  If it is already small enough to fit, it is
   * not modified.
   *
   * IMPORTANT NOTE: You are probably better off using
   * uihelper_resize_mk_img() to resize general images (e.g. photos in
   * an album) or uihelper_resize_mk_user_img() to resize user images
   * (as it will automatically specify the default user image as an
   * alternate).
   *
   * Usage:
   *
   * $img_tag = ImageResize::resize_mk_img("$path_prefix/web",
   * $base_url, "files/resized", 75, 50, "files/picture-of-me.jpg",
   * "images/default.jpg");
   *
   * (see web/uihelper.php).
   * 
   * resize_mk_img("$path_prefix/web", PP::$url, "files/rsz", $max_x, $max_y, "files/$user_or_picture", DEFAULT_USER_PHOTO_REL, NULL, $extra_attrs, RESIZE_CROP)
   */
  public static function resize_mk_img(
      $root_path, // path to which all other paths passed to resize_mk_img are relative
      $root_url, // url of $root_path
      $output_path, // relative path to a directory where we can put resized images
      $max_x, // max width of output image
      $max_y, // max height of output image
      $picture, // relative path to image to resize
      $alternate=NULL, // relative path to an alternate image
      $overwrite=FALSE, // set to TRUE if you want to overwrite the resized image if it's already there
      $extra_attrs="", // extra attributes to include in the <img> tag
      $resize_type=RESIZE_CROP // RESIZE_CROP, RESIZE_FIT or RESIZE_STRETCH.
      ) {
     
      $info = ImageResize::resize_img($root_path, $root_url, $output_path, $max_x, $max_y, $picture, $alternate, $overwrite, $resize_type);

      if (!@file_exists( $info['final_path'])) {
        $info = NULL;                
        // For Animated Gif files Only
        ImageResize::create_frame_from_animated_pic($root_path,$picture,$output_path,$max_x,$max_y);
        $info = ImageResize::resize_img($root_path, $root_url, $output_path, $max_x, $max_y, $picture, $alternate, $overwrite, $resize_type);
      }
      $url = "$root_url/".$info['final_path'];
      if ($extra_attrs) $img = "<img $extra_attrs"; else $img = "<img";
      return $img.' border="0" src="'.htmlspecialchars($url).'" '.$info['size_attr'].'/>';
  }

  // like resize_mk_img, but returns url, width, height etc so you can
  // access them individually.  used by web/api/lib/api_impl.php.
  public static function resize_img(
      $root_path, // path to which all other paths passed to resize_mk_img are relative
      $root_url, // url of $root_path
      $output_path, // relative path to a directory where we can put resized images
      $max_x, // max width of output image
      $max_y, // max height of output image
      $picture, // relative path to image to resize
      $alternate=NULL, // relative path to an alternate image
      $overwrite=FALSE, // set to TRUE if you want to overwrite the resized image if it's already there
      $resize_type=RESIZE_CROP // RESIZE_FIT, RESIZE_CROP or RESIZE_STRETCH
      ) {

      $final_path = NULL;

      if ($picture && is_file("$root_path/$picture") && (getimagesize("$root_path/$picture") !== false)) {
	//	$sz = ; var_dump($sz);
          $pic_path = $picture;
      } else if (!$alternate || !is_file("$root_path/$alternate")) {
          // we could throw a FILE_NOT_FOUND exception here, but that
          // breaks things, so instead we output an image tag with the
          // requested size that refers to the original path.  this
          // way the admin will see 404 errors in the log, and maybe
          // fix what's wrong.
          $final_path = $picture;
	  $width = $max_x;
	  $height = $max_y;
      } else {
          $pic_path = $alternate;
      }
//print_r($pic_path);echo 'Final path';die;
      if (!$final_path) {
          // if it's a png or gif, convert to png - so we don't lose transparency.  otherwise jpg.
          $path_parts = pathinfo($pic_path);
          $ext = $path_parts['extension'];
          switch ($ext) {
          case 'png':
          case 'gif':
              $ext = 'png';
              break;
          case 'JPG':
              $ext = 'JPG';
              break;
          default:
              $ext = 'jpg';
              break;
          }

	  $prefix = ImageResize::$resize_type_prefixes[$resize_type];
	  if (!$prefix) throw new PAException(BAD_PARAMETER, "Invalid resize type: $resize_type");
          
          // relative path to resized file
          $resized_pic_path = $prefix."_".$max_x."x".$max_y."_".preg_replace("/\.[A-Za-z]+$/", "", $pic_path) . ".$ext";
		  //merging image logic by suyash dt:14112010
          // abs path to resized file
          $resized_fn = "$root_path/$output_path/$resized_pic_path";
          
	  // only overwrite an existing file if it's out of date or we have been told to (via $overwrite)
          if (!file_exists($resized_fn) || (filemtime($resized_fn) < filemtime("$root_path/$pic_path")) || $overwrite) {
              // make all path parts up to the image
              if (!is_dir(dirname($resized_fn))) {
                  $mkdir_path = "$root_path/$output_path";
                  ImageResize::try_mkdir($mkdir_path);
                  foreach (explode("/", dirname($resized_pic_path)) as $path_part) {
                      $mkdir_path .= "/$path_part";
                      //ImageResize::try_mkdir($mkdir_path); merging image logic by suyash dt:14112010
                  }
              }
              
              ImageResize::do_resize_to_max_side("$root_path/$pic_path", $resized_fn, $max_x, $max_y, $resize_type);
	      clearstatcache();
          }
          list($width, $height) = @getimagesize($resized_fn);

          $final_path = "$output_path/".dirname($resized_pic_path)."/".rawurlencode(basename($resized_pic_path));
      }

      return array(
	  'final_path' => $final_path,
	  'width' => $width,
	  'height' => $height,
	  'size_attr' => 'width="'.$width.'" height="'.$height.'"'
	  );
  }

  //FIXME: replace calls to this image with calls to uihelper_resize_mk_img
  public static function mk_img($fn_leaf, $max_side) {
      $im_info = ImageResize::resize_to_max_side($fn_leaf, $max_side);
      return '<img border="0" src="'.htmlspecialchars($im_info['url']).'" '.$im_info['attr'].' alt="PA"/>';
  }

  /* Make an image with a given max side length, returning path, url,
   * width/height, and width/height in 'width="123" height="234"'
   * format, ready for insert into an <img> tag.  If the resized image
   * already exists, this won't overwrite it unless $overwrite=TRUE,
   * so you can use this to get the url/width/height of an image prior
   * to display.
   *
   * Args:
   *
   * $fn_leaf = leaf name of file to resize, e.g. "foobar.jpg" if the
   * full path is "$path_prefix/web/files/foobar.jpg".
   *
   * $max_side = number of pixels you want to have in the longest side
   * of the resized image.
   *
   * $overwrite = TRUE if you want to overwrite an existing scaled
   * image (i.e. if you're calling this in response to an upload), or
   * FALSE to just get its dimensions if it's there (i.e. if you're
   * calling this just to *display* something).
   *
   * $files_root = path to the 'files' directory - usually
   * "$path_prefix/web/files", but you can use this elsewhere if you
   * really want to :-)
   */
  //FIXME: replace calls to this with calls to uihelper_resize_mk_img
/*  public static function resize_to_max_side($fn_leaf, $max_side, $overwrite=FALSE, $files_root=NULL) {
      global $base_url, $path_prefix;
      if (!$files_root) $files_root = "$path_prefix/web/files";

      if (!$fn_leaf) throw new PAException(FILE_NOT_FOUND, "No filename specified");

      $files_root = realpath($files_root);
      $resized_root = "$files_root/resized";
      $resized_path = "$resized_root/$max_side";
      $src_fn = "$files_root/$fn_leaf";

      $resized_fn_leaf = preg_replace("/\.[A-Za-z]+$/", "", $fn_leaf) . ".jpg";
      $resized_fn = "$resized_path/$resized_fn_leaf";

      if (!file_exists($src_fn))
          throw new PAException(FILE_NOT_FOUND, "full-size image not found");

      if (!file_exists($resized_fn) || $overwrite) {
          ImageResize::try_mkdir($resized_root);
          ImageResize::try_mkdir($resized_path);
          ImageResize::do_resize_to_max_side($src_fn, $resized_fn, $max_side, $max_side);
      }

      $size = getimagesize($resized_fn);

      return array(
          'path' => $resized_fn,
          'url' => "$base_url/files/resized/$max_side/$resized_fn_leaf",
          'w' => $size[0],
          'h' => $size[1],
          'mime' => $size['mime'],
          'attr' => $size[3],
          );
  }*/

  // functions used by resize_max_size

  private static function gd_available() {
    return function_exists("gd_info") && function_exists("imagecreatefromjpeg");
  }

  public static function get_engine() {
    if (ImageResize::find_magick() && !ImageResize::$skip_magick) return "magick";
    if (ImageResize::gd_available() && !ImageResize::$skip_gd) return "gd";
    return NULL;
  }

  private static function do_resize_to_max_side($src_fn, $resized_fn, $max_x, $max_y, $resize_type=RESIZE_CROP) {
      $convert = ImageResize::find_magick();
      $magick_attempted = FALSE;
      
      ImageResize::$skip_magick = TRUE;
      
      if ($convert && !ImageResize::$skip_magick) {
          // try to do it with imagemagick
         $magick_attempted = TRUE;
         try {
           return ImageResize::magick_resize_image($convert, $src_fn, $resized_fn, $max_x, $max_y, $resize_type);
         } catch (PAException $magick_exc) {
           //Logger::log("ImageMagick failed to resize $src_fn; trying GD");
         }
      }

      if (ImageResize::gd_available() && !ImageResize::$skip_gd) {
          // we have gd installed
          return ImageResize::gd_resize_image($src_fn, $resized_fn, $max_x, $max_y, $resize_type);
      }

      if ($magick_attempted) throw $magick_exc;

      throw new PAException(MISSING_DEPENDENCY, "need to have either gd or imagemagick installed to resize images");
  }

  private static function try_mkdir($path) {
      if (!is_dir($path)) {
          if (!@mkdir($path)) {
              throw new PAException(OPERATION_NOT_PERMITTED, "Can't create directory $path");
          }
      }
  }

  private static function loadimage($file) {
      if( !file_exists($file) ) return FALSE;

      $what = getimagesize($file);

      switch( $what[2] ){
      case IMAGETYPE_PNG: $src_id = @imagecreatefrompng($file); break;
      case IMAGETYPE_JPEG: $src_id = @imagecreatefromjpeg($file); break;
      case IMAGETYPE_GIF:
          $old_id = @imagecreatefromgif($file);
          $src_id = @imagecreatetruecolor($what[0], $what[1]);
          @imagecopy($src_id,$old_id,0,0,0,0,$what[0],$what[1]);
          break;
      default: return FALSE;
      }

      return $src_id;
  }

  public static function gd_resize_image($infn, $outfn, $max_x, $max_y, $resize_type=RESIZE_CROP) {
      //Logger::log("Resizing $infn to $outfn using built in GD");

      // figure out x and y scale required to fit input image to desired size
      list($w, $h) = @getimagesize($infn);
      $x_scale = floatval($max_x)/floatval($w);
      $y_scale = floatval($max_y)/floatval($h);

      // now decide on scale required for desired resizing operation
      switch ($resize_type) {
      case RESIZE_CROP:
	  $x_scale = $y_scale = max($x_scale, $y_scale);
	  break;
      case RESIZE_CROP_START:
      case RESIZE_CROP_NO_EXPAND:
	  $x_scale = $y_scale = min(1.0, max($x_scale, $y_scale));
	  break;

      case RESIZE_FIT:
	  $x_scale = $y_scale = min($x_scale, $y_scale);
	  break;

      case RESIZE_FIT_NO_EXPAND:
	  $x_scale = $y_scale = min(1.0, $x_scale, $y_scale);
	  break;

      case RESIZE_STRETCH:
	  // keep previously calculated values
	  break;

      default:
	  throw new PAException(BAD_PARAMETER, "Invalid resize_type: $resize_type");
      }

      // figure out size of output image
      $tw = intval($w * $x_scale + 0.5);
      $th = intval($h * $y_scale + 0.5);
      
      // if cropping, work out offsets and reduce $tw and $th as required
      switch ($resize_type) {
      case RESIZE_CROP_START:
	  if ($tw > $max_x) {
	      $x_offset = 0;
	      $w = intval(floatval($max_x) / $x_scale + 0.5);
	      $tw = $max_x;
	  }
	  if ($th > $max_y) {
	      $y_offset = 0;
	      $h = intval(floatval($max_y) / $y_scale + 0.5);
	      $th = $max_y;
	  }
	  break;

      case RESIZE_CROP_NO_EXPAND:
	  case RESIZE_CROP:
	  if ($tw > $max_x) {
	      $x_offset = (int)((floatval($tw - $max_x) / 2.0) / $x_scale);
	      $w = intval(floatval($max_x) / $x_scale + 0.5);
	      $tw = $max_x;
	  }
	  if ($th > $max_y) {
	      $y_offset = (int)((floatval($th - $max_y) / 2.0) / $y_scale);
	      $h = intval(floatval($max_y) / $y_scale + 0.5);
	      $th = $max_y;
	  }
	  break;

      default:
	  // not cropping
	  $x_offset = $y_offset = 0;
	  break;
      }


      // create blank white image
      $thumb = @imagecreatetruecolor($tw, $th);
      @imagealphablending($thumb, FALSE);
      @imagefilledrectangle($thumb, 0, 0, $tw, $th, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
      @imagealphablending($thumb, TRUE);

      // load image and resample into output image
      $orig = ImageResize::loadimage($infn);
      @imagecopyresampled($thumb, $orig, 0, 0, $x_offset, $y_offset, $tw, $th, $w, $h);

      // save output and tidy up
      $path_parts = pathinfo($outfn);
      switch (strtolower($path_parts['extension'])) {
      case 'png':
          @imagealphablending($thumb, FALSE);
          @imagesavealpha($thumb, TRUE);
          imagepng($thumb, $outfn);
          break;
      default:
          imagejpeg($thumb, $outfn,100);
          break;
      }

      @imagedestroy($orig);
      @imagedestroy($thumb);

      return Array($tw, $th);
  }

  private static function find_magick() {
      $f = popen("which convert", "r");
      $convert = trim(fgets($f));
      pclose($f);

      return $convert;
  }

  private static function shell_escape($txt) {
      return str_replace(" ", "\\ ", escapeshellcmd($txt));
  }

  public static function magick_resize_image($convert, $src_fn, $resized_fn, $max_x, $max_y, $resize_type=RESIZE_CROP) {
      //Logger::log("Resizing $src_fn to $resized_fn using ImageMagick");
      if (!$convert) $convert = ImageResize::find_magick();

      list ($w, $h) = getimagesize($src_fn);

      $x_scale = floatval($max_x)/floatval($w);
      $y_scale = floatval($max_y)/floatval($h);

      switch ($resize_type) {
      case RESIZE_STRETCH:
	$args = "-geometry ${max_x}x$max_y!";
	break;

      case RESIZE_CROP:
      case RESIZE_CROP_START:
      case RESIZE_CROP_NO_EXPAND:
	// first crop the input image, then resize that to fit the output
	$scale = max($x_scale, $y_scale);
	if ($resize_type == RESIZE_CROP_NO_EXPAND) $scale = min(1.0, $scale);
	
	// convert output size into input coords
	$input_max_x = min($w, intval(floatval($max_x) / $scale + 0.5));
	$input_max_y = min($h, intval(floatval($max_y) / $scale + 0.5));
	if ($resize_type == RESIZE_CROP_NO_EXPAND) {
	  $max_x = intval(floatval($input_max_x) * $scale + 0.5);
	  $max_y = intval(floatval($input_max_y) * $scale + 0.5);
	}
	// now find offsets
	$input_x_offset = intval(($w - $input_max_x) / 2);
	$input_y_offset = intval(($h - $input_max_y) / 2);

	$args = "-crop ${input_max_x}x${input_max_y}+$input_x_offset+$input_y_offset -geometry ${max_x}x$max_y!";
	break;

      case RESIZE_FIT:
	$args = "-geometry ${max_x}x$max_y";
	break;

      case RESIZE_FIT_NO_EXPAND:
	$max_x = min($max_x, $w);
	$max_y = min($max_y, $h);
	$args = "-geometry ${max_x}x$max_y";
	break;
      }

      // call /usr/bin/convert and return an error if it fails
      $cmd = $convert.' '.ImageResize::shell_escape($src_fn)." $args ".ImageResize::shell_escape($resized_fn);
      system($cmd, $retval);
      if ($retval) throw new PAException(GENERAL_SOME_ERROR, "$convert returned error code $retval (for command: $cmd)");
  }
  
  private function make_square_image ($infn, $gd_OR_magick = "GD") {
    global $path_prefix;
    $directory = "$path_prefix/web/files/square/"; //TO DO: Remove hardcoding here.
    if (!@is_dir($directory)) {
      ImageResize::try_mkdir($directory);
    }
        
    $file_path = explode("/", $infn);
    // TO DO: Rename images to avoid conflicts.
    $imageName = $file_path[(count($file_path) - 1)];
    $destination = $directory.$imageName;
    if(@file_exists($destination) && filemtime($destination) > filemtime($infn)) { return SQUARE_IMAGES.'/'.$imageName;}
    $dimensions = @getimagesize ($infn);
    $width = $dimensions[0];
    $height = $dimensions[1];
    
    if ($width == $height) { // Image is a square image    
      @copy($infn, $destination);
      return SQUARE_IMAGES.'/'.$imageName;
    }
    
    $X_start = $Y_start = $width_final = $height_final = $offset = 0;
    
    if ($width > $height) {  // width more than height            
      $X_start = round(($width - $height)/2);
      $Y_start = 0;
      $offset = $height;
      $width_final = $height_final = $height;
      
    } 
    else { // height more than width            
      $X_start = 0;
      $Y_start = round(($height - $width)/2);      
      $width_final = $height_final = $width;      
      $offset = $width;
    }
    
    if ($gd_OR_magick == "MAGICK") {      
      $cmd = 'convert -crop '.$width_final.'x'.$height_final.'+'.$X_start.'+'.$Y_start.' '.$infn.' '.SQUARE_IMAGES.'/'.$imageName;
      system($cmd, $retval);
      return SQUARE_IMAGES.'/'.$imageName;
    }
    
    $orig = ImageResize::loadimage($infn);
    $imageDestination = @imagecreatetruecolor($width_final, $height_final);
    @imagecopyresampled($imageDestination, $orig, 0, 0, $X_start, $Y_start, $width_final, $height_final, $offset, $offset);
    
    @imagejpeg($imageDestination, $destination, 100);
    @imagedestroy($imageDestination);
    @imagedestroy($orig);
    return SQUARE_IMAGES.'/'.$imageName;
  }
  /**
    Creating a Function which take an Animated Gif Image and Convert into Still image 
  */
  public function create_frame_from_animated_pic ($img_input_path,$picture,$img_output_path,$max_x,$max_y ,$new_image_name = False) {
    global $base_url;
    //Logger::log("create_frame_from_animated_pic($img_input_path, $picture, $img_output_path, $max_x, $max_y, $new_image_name)");
   
    // for Retriving the Original Name of file 
    $temp_name = explode('/',$picture);
    $temp_name = $temp_name['1'];
   
    if (!empty($temp_name)) {
      $name = explode('.',$temp_name);
      $file_name = $name['0'];
      // if it's a .gif image
      if (preg_match("/\.gif$/i", $temp_name)) {
	//$image_full_path = $base_url.'/files/'.$temp_name;
  $image_full_path = $img_input_path.'/files/'.$temp_name; 
	$img_input_path = $img_input_path.'/files/';
	$new_image =  $file_name;
	
	// creating the object of the Gifsplit class and initializing the Contructor
	$sg = new GifSplit($image_full_path, 'GIF', $new_image, $img_input_path);
	if ($sg->getReport() == 'ok') { 
	  return TRUE;
	}
      }
      return FALSE ;
    }
    
  }
  
}

######################

// GifSplit by Laszlo Zsidi, http://gifs.hu
// From http://www.phpclasses.org/browse/file/15123.htmlL
class GifSplit
{

  /*===========================================*/
  /*==           V A R I A B L E S           ==*/
  /*===========================================*/
  var $image_count   = 0;
  var $buffer      = array();
  var $global      = array();
  var $gif       = array(0x47, 0x49, 0x46);

  var $logical_screen_descriptor;
  var $global_color_table_size;
  var $global_color_table_code;
  var $global_color_table_flag;
  var $image_descriptor;
  var $global_sorted;
  var $fin;
  var $fou;
  var $sp;
  var $fm;
  var $es;
  var $output;
  
  function GifSplit($image, $format, $path ,$output)
  {
    error_reporting(0);
    $this->fm = $format;
    $this->sp = $path;
    $this->output = $output;
    if($this->fin = fopen($image, "rb"))
    {
      $this->getbytes(6);
      if(!$this->arrcmp($this->buffer, $this->gif, 3))
      {
        $this->es = "error #1";
        return(0);
      }
            $this->getbytes(7);
            $this->logical_screen_descriptor = $this->buffer;
            $this->global_color_table_flag = ($this->buffer[4] & 0x80) ? TRUE : FALSE;
            $this->global_color_table_code = ($this->buffer[4] & 0x07);
            $this->global_color_table_size = 2 << $this->global_color_table_code;
            $this->global_sorted = ($this->buffer[4] & 0x08) ? TRUE : FALSE;
            if($this->global_color_table_flag)
            {
                $this->getbytes(3 * $this->global_color_table_size);
                for($i = 0; $i < ((3 * $this->global_color_table_size)); $i++)
                  $this->global[$i] = $this->buffer[$i];
            }
          //  $i= 0;

            for($loop = true; $loop; )
            {
              $this->getbytes(1);
             
              switch($this->buffer[0])
                {
                  case 0x21:
                    $this->read_extension();
                  break;
                  case 0x2C:
                    $this->read_image_descriptor();
                    $loop = false; // For Only First Frame when we found the value of $this->buffer[0] = 44 , we Break the for Loop
                  break;
                  case 0x3B:
                    $loop = false;
                  break;
                  default:
                    $this->es = sprintf("Unrecognized byte code %u\n<br>", $this->buffer[0]);
                  }
                // This is case of only 1 image of animated gif 
               
              }
            
            fclose($this->fin);
    }
    else
    {
      $this->es = "error #2";
      return(0);
    }
    $this->es = "ok";
  }
  /*///////////////////////////////////////////////*/
  /*//        Function :: read_extension()       //*/
  /*///////////////////////////////////////////////*/
    function read_extension()
    {
    /* Reset global variables */
    $this->buffer = array();

      $this->getbytes(1);
        for(;;)
        {
          $this->getbytes(1);
            if(($u = $this->buffer[0]) == 0)
              break;
            $this->getbytes($u);
        }
    }
  /*///////////////////////////////////////////////*/
  /*//    Function :: read_image_descriptor()    //*/
  /*///////////////////////////////////////////////*/
  function read_image_descriptor()
  {
    /* Reset global variables */
    $this->buffer = array();
    $this->fou = '';

    /* Header -> GIF89a */
    $this->fou .= "\x47\x49\x46\x38\x39\x61";

    $this->getbytes(9);
        for($i = 0; $i < 9; $i++)
            $this->image_descriptor[$i] = $this->buffer[$i];

        $local_color_table_flag = ($this->buffer[8] & 0x80) ? TRUE : FALSE;
        if($local_color_table_flag)
        {
          $code = ($this->buffer[8] & 0x07);
          $sorted = ($this->buffer[8] & 0x20) ? TRUE : FALSE;
        }
        else
        {
            $code = $this->global_color_table_code;
            $sorted = $this->global_sorted;
        }

        $size = 2 << $code;

        $this->logical_screen_descriptor[4] &= 0x70;
        $this->logical_screen_descriptor[4] |= 0x80;
        $this->logical_screen_descriptor[4] |= $code;

        if($sorted)
      $this->logical_screen_descriptor [4] |= 0x08;
    $this->putbytes($this->logical_screen_descriptor, 7);

    if($local_color_table_flag)
    {
      $this->getbytes(3 * $size);
            $this->putbytes($this->buffer, 3 * $size);
    }
    else
      $this->putbytes($this->global, 3 * $size);

    $this->fou .= "\x2C";

    $this->image_descriptor[8] &= 0x40;

    $this->putbytes($this->image_descriptor, 9);

        /* LZW minimum code size */
    $this->getbytes(1);
    $this->putbytes($this->buffer, 1);

    /* Image Data */
        for(;;)
        {
          $this->getbytes(1);
          $this->putbytes($this->buffer, 1);
          if(($u = $this->buffer[0]) == 0)
              break;
          $this->getbytes($u);
          $this->putbytes($this->buffer, $u);
        }

    /* trailer */
    $this->fou .= "\x3B";

    /* Write to file */
    switch($this->fm)
    {
      /* Write as BMP */
      case "BMP":
        $im = imageCreateFromString($this->fou);
        $framename = $this->sp . $this->image_count++ . ".bmp";
        if(!$this->imageBmp($im, $framename))
        {
          $this->es = "error #3";
          return(0);
        }
        imageDestroy($im);
      break;
            /* Write as PNG */
      case "PNG":
        $im = imageCreateFromString($this->fou);
        $framename = $this->sp . $this->image_count++ . ".png";
        if(!imagePng($im, $framename))
        {
          $this->es = "error #3";
          return(0);
        }
        imageDestroy($im);
      break;
      /* Write as JPG */
      case "JPG":
        $im = imageCreateFromString($this->fou);
        $framename = $this->sp . $this->image_count++ . ".jpg";
        if(!imageJpeg($im, $framename,100))
        {
          $this->es = "error #3";
          return(0);
        }
        imageDestroy($im);
      break;
      /* Write as GIF */
      case "GIF":
        $im = imageCreateFromString($this->fou);
      
        $framename = $this->output.$this->sp . ".gif";
      
        if(!imageGif($im, $framename))
        {
          $this->es = "error #3";
          return(0);
        }
        imageDestroy($im);
      break;
    }
  }
  /*///////////////////////////////////////////////*/
  /*//             BMP creation group            //*/
  /*///////////////////////////////////////////////*/
  /* ImageBMP */
  function imageBmp($img, $file, $RLE=0)
  {
    $ColorCount = imagecolorstotal($img);
    $Transparent = imagecolortransparent($img);
    $IsTransparent = $Transparent != -1;
    if($IsTransparent)
      $ColorCount--;
    if($ColorCount == 0)
    {
      $ColorCount = 0;
      $BitCount = 24;
    }
    if(($ColorCount > 0) && ($ColorCount <= 2))
    {
      $ColorCount = 2;
      $BitCount = 1;
    }
    if(($ColorCount > 2) && ($ColorCount <= 16))
    {
      $ColorCount = 16;
      $BitCount = 4;
    }
    if(($ColorCount > 16) && ($ColorCount <= 256))
    {
      $ColorCount = 0;
      $BitCount = 8;
    }
    $Width = imageSX($img);
    $Height = imageSY($img);
    $Zbytek = (4 - ($Width / (8 / $BitCount)) % 4) % 4;
    if($BitCount < 24)
      $palsize = pow(2, $BitCount) * 4;
    $size = (floor($Width / (8 / $BitCount)) + $Zbytek) * $Height + 54;
    $size += $palsize;
    $offset = 54 + $palsize;
    // Bitmap File Header
    $ret = 'BM';
    $ret .= $this->int_to_dword($size);
    $ret .= $this->int_to_dword(0);
    $ret .= $this->int_to_dword($offset);
    // Bitmap Info Header
    $ret .= $this->int_to_dword(40);
    $ret .= $this->int_to_dword($Width);
    $ret .= $this->int_to_dword($Height);
    $ret .= $this->int_to_word(1);
    $ret .= $this->int_to_word($BitCount);
    $ret .= $this->int_to_dword($RLE);
    $ret .= $this->int_to_dword(0);
    $ret .= $this->int_to_dword(0);
    $ret .= $this->int_to_dword(0);
    $ret .= $this->int_to_dword(0);
    $ret .= $this->int_to_dword(0);
    // image data
    $CC = $ColorCount;
    $sl1 = strlen($ret);
    if($CC == 0)
      $CC = 256;
    if($BitCount < 24)
    {
      $ColorTotal = imagecolorstotal($img);
      if($IsTransparent)
        $ColorTotal--;
      for($p = 0; $p < $ColorTotal; $p++)
      {
        $color = imagecolorsforindex($img, $p);
        $ret .= $this->inttobyte($color["blue"]);
        $ret .= $this->inttobyte($color["green"]);
        $ret .= $this->inttobyte($color["red"]);
        $ret .= $this->inttobyte(0);
      }
      $CT = $ColorTotal;
      for($p = $ColorTotal; $p < $CC; $p++)
      {
        $ret .= $this->inttobyte(0);
        $ret .= $this->inttobyte(0);
        $ret .= $this->inttobyte(0);
        $ret .= $this->inttobyte(0);
      }
    }
    if($BitCount <= 8)
    {
      for($y = $Height - 1; $y >= 0; $y--)
      {
        $bWrite = "";
        for($x = 0; $x < $Width; $x++)
        {
          $color = imagecolorat($img, $x, $y);
          $bWrite .= $this->decbinx($color, $BitCount);
          if(strlen($bWrite) == 8)
          {
            $retd .= $this->inttobyte(bindec($bWrite));
            $bWrite = "";
          }
        }
        if((strlen($bWrite) < 8) and (strlen($bWrite) != 0))
        {
          $sl = strlen($bWrite);
          for($t = 0; $t < 8 - $sl; $t++)
            $sl .= "0";
          $retd .= $this->inttobyte(bindec($bWrite));
        }
        for($z = 0; $z < $Zbytek; $z++)
          $retd .= $this->inttobyte(0);
      }
    }
    if(($RLE == 1) and ($BitCount == 8))
    {
      for($t = 0; $t < strlen($retd); $t += 4)
      {
        if($t != 0)
          if(($t) % $Width == 0)
            $ret .= chr(0).chr(0);

        if(($t + 5) % $Width == 0)
        {
          $ret .= chr(0).chr(5).substr($retd, $t, 5).chr(0);
          $t += 1;
        }
        if(($t + 6) % $Width == 0)
        {
          $ret .= chr(0).chr(6).substr($retd, $t, 6);
          $t += 2;
        }
        else
          $ret .= chr(0).chr(4).substr($retd, $t, 4);
      }
      $ret .= chr(0).chr(1);
    }
    else
      $ret .= $retd;
    if($BitCount == 24)
    {
      for($z = 0; $z < $Zbytek; $z++)
        $Dopl .= chr(0);

      for($y = $Height - 1; $y >= 0; $y--)
      {
        for($x = 0; $x < $Width; $x++)
        {
          $color = imagecolorsforindex($img, ImageColorAt($img, $x, $y));
          $ret .= chr($color["blue"]).chr($color["green"]).chr($color["red"]);
        }
        $ret .= $Dopl;
      }
    }
    if(fwrite(fopen($file, "wb"), $ret))
      return true;
    else
      return false;
  }
  /* INT 2 WORD */
  function int_to_word($n)
  {
    return chr($n & 255).chr(($n >> 8) & 255);
  }
  /* INT 2 DWORD */
  function int_to_dword($n)
  {
    return chr($n & 255).chr(($n >> 8) & 255).chr(($n >> 16) & 255).chr(($n >> 24) & 255);
  }
  /* INT 2 BYTE */
  function inttobyte($n)
  {
    return chr($n);
  }
  /* DECIMAL 2 BIN */
  function decbinx($d,$n)
  {
    $bin = decbin($d);
    $sbin = strlen($bin);
    for($j = 0; $j < $n - $sbin; $j++)
       $bin = "0$bin";
    return $bin;
  }
  /*///////////////////////////////////////////////*/
  /*//            Function :: arrcmp()           //*/
  /*///////////////////////////////////////////////*/
  function arrcmp($b, $s, $l)
  {
    for($i = 0; $i < $l; $i++)
    {
      if($s{$i} != $b{$i}) return false;
    }
    return true;
  }
  /*///////////////////////////////////////////////*/
  /*//           Function :: getbytes()          //*/
  /*///////////////////////////////////////////////*/
  function getbytes($l)
  {
    for($i = 0; $i < $l; $i++)
    {
      $bin = unpack('C*', fread($this->fin, 1));
      $this->buffer[$i]  = $bin[1];
    }
    return $this->buffer;
  }
  /*///////////////////////////////////////////////*/
  /*//           Function :: putbytes()          //*/
  /*///////////////////////////////////////////////*/
  function putbytes($s, $l)
  {
    for($i = 0; $i < $l; $i++)
    {
      $this->fou .= pack('C*', $s[$i]);
    }
  }
  function getReport()
  {
    return $this->es;
  }
}
?>
