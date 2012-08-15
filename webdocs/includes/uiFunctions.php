<?php
//old function
function addNewsPicture($imagename, $imgTitle, $blockName)
{
	if(!empty($imagename))
	{
		$fullsourcepath = facile::$web_tempfile_path.$imagename;
    if(file_exists($fullsourcepath))
		{
      removeNewsPictures($imgTitle);
      $modFolder = facile::$web_newsimage_path;
			$cropped_folder_path = facile::$web_newsimage_relative_path;//$modFolder;
      /*echo '<br>'.facile::$web_tempfile_path;
      echo '<br>'.facile::$web_tempfile_url;
      echo '<br>'.$cropped_folder_path;
      echo '<br>'.$imagename;*/
      //$newImage = ($imgTitle!="") ? $imgTitle.".jpg" : $imagename;

			ImageResize::resize_mk_img(facile::$web_tempfile_path, facile::$web_tempfile_url, $cropped_folder_path, 130,73, $imagename,'','','',RESIZE_CROP_START);
      @rename(facile::$web_newsimage_path.'crop_130x73_'.$imagename, facile::$web_newsimage_path.'crop_130x73_'.$imgTitle.".jpg");

			ImageResize::resize_mk_img(facile::$web_tempfile_path, facile::$web_tempfile_url, $cropped_folder_path, 70,38, $imagename,'','','',RESIZE_CROP_START);
      @rename(facile::$web_newsimage_path.'crop_70x38_'.$imagename, facile::$web_newsimage_path.'crop_70x38_'.$imgTitle.".jpg");

			$destinationpath = facile::$web_newsimage_path.$imgTitle.".jpg";
			@rename($fullsourcepath, $destinationpath); // original image
		}
	}
}

/*
 * @desc for upload_crop.php to create thumbnail
 * @param $imagename - temp image name stored in clip_photo
 * @param $imgTitle - SEO key for inserted entity
 * @param $blockName - module name
 */
function uploadCropPicture($imagename, $imgTitle, $blockName){
  if($blockName==NULL || $imgTitle==NULL) return;

  if(!empty($imagename))
	{
		$fullsourcepath = facile::$web_tempfile_path.$imagename;
    if(file_exists($fullsourcepath))
		{
      switch ($blockName){
        case 'news':
          //remove old image
          removeCropPictures($imgTitle,"news");

          $modFolder = facile::$web_newsimage_path;
          $cropped_folder_path = facile::$web_newsimage_relative_path;//$modFolder;

          foreach(facile::$newsImgSizes as $imgSizeAry){
            ImageResize::resize_mk_img(facile::$web_tempfile_path, facile::$web_tempfile_url, $cropped_folder_path, $imgSizeAry['w'],$imgSizeAry['h'], $imagename,'','','',RESIZE_CROP_START);
            @rename(facile::$web_newsimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename, facile::$web_newsimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imgTitle.'.jpg');
          }

          $destinationpath = facile::$web_newsimage_path.$imgTitle.".jpg";
          @rename($fullsourcepath, $destinationpath); // original image
          break;

        case 'auser':
          //remove old image
          removeCropPictures($imgTitle,"auser");

          $modFolder = facile::$web_auserimage_path;
          $cropped_folder_path = facile::$web_auserimage_relative_path;//$modFolder;

          foreach(facile::$auserPicSizes as $imgSizeAry){
            ImageResize::resize_mk_img(facile::$web_tempfile_path, facile::$web_tempfile_url, $cropped_folder_path, $imgSizeAry['w'],$imgSizeAry['h'], $imagename,'','','',RESIZE_CROP_START);
            @rename(facile::$web_auserimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename, facile::$web_auserimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imgTitle.'.jpg');
          }

          $destinationpath = facile::$web_auserimage_path.$imgTitle.'.jpg';
          @rename($fullsourcepath, $destinationpath); // original image
          break;
        default :
          break;
      }//end switch
		}//if path
	}//if
}

function removeCropPictures($imagename, $blockName)
{
    if($imagename=="") return;
    switch ($blockName){
      case 'news':
        $file = facile::$web_newsimage_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);
        //removing crop images
        foreach(facile::$newsImgSizes as $imgSizeAry){
          $file = facile::$web_newsimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }
        break;

      case 'blogs':
        $file = facile::$web_blogsimage_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);
        //removing crop images
        foreach(facile::$blogsImgSizes as $imgSizeAry){
          $file = facile::$web_blogsimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }

        /*$file = facile::$web_blogsimage_path."crop_260x150_".$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);*/
        break;

      case 'auser':
        $file = facile::$web_auserimage_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);

        foreach(facile::$auserPicSizes as $imgSizeAry){
          $file = facile::$web_auserimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }

        break;
	 case 'player':
        $file = facile::$web_playerimage_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);
        //removing crop images
        foreach(facile::$playerImgSizes as $imgSizeAry){
          $file = facile::$web_playerimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }
        break;
		case 'playerPoster':
        $file = facile::$web_playerposter_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);
        //removing crop images
        foreach(facile::$playerImgSizes as $imgSizeAry){
          $file = facile::$web_playerposter_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }
        break;
    case 'clip_image':
        $file = facile::$web_clipimage_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);
        $file = facile::$web_clipimage_path.$imagename."_original.jpg";
        if(file_exists($file))
          @unlink($file);
        //echo $file; die();
        //removing crop images
        foreach(facile::$clipImgSizes as $imgSizeAry){
          $file = facile::$web_clipimage_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }
        break;
		case 'clip_poster':
        $file = facile::$web_clipposter_path.$imagename.".jpg";
        if(file_exists($file))
          @unlink($file);
        $file = facile::$web_clipposter_path.$imagename."_original.jpg";
        if(file_exists($file))
          @unlink($file);
        //removing crop images
        foreach(facile::$clipImgSizes as $imgSizeAry){
          $file = facile::$web_clipposter_path.'crop_'.$imgSizeAry['w'].'x'.$imgSizeAry['h'].'_'.$imagename.'.jpg';
          if(file_exists($file))
            @unlink($file);
        }
        break;

      default:
        break;
    }
}

function getPaginationHtml(&$param, $totalRecords, $onClick='', $currPage=1, $rowsPerPage=RECORDS_PER_PAGE, $pagesPerPage=5)
    {
      $totRows = (int)$totRows;
      $currPage = ($currPage>0)?(int)$currPage:1;
      $rowsPerPage = (int)$rowsPerPage;
      $totalPages = ceil($totalRecords/$rowsPerPage);

      $onClick = isset($onClick) ? $onClick : 'void(0);';

      $pgHtml .= '<input type="hidden" id="currPage" name="currPage" value="'.$currPage.'" />';
      $pgHtml .= '<div class="totalrds">Total Records: <b>'.$totalRecords.'</b></div>';
      if($totalPages > 1){
        $firstPage = 1;
        $prevPage = ($currPage>1)?$currPage-1:$currPage;
        $nextPage = ($currPage<$totalPages)?$currPage+1:$totalPages;
        $lastPage = $totalPages;

        $pgHtml .= '<a class="button" href="javascript:void(0);" onClick="javascript: '.addslashes(str_replace("{page}",$firstPage,$onClick)).'"><span><img width="12" height="9" alt="First" src="'.facile::$theme_url.'images/arrow-stop-180-small.gif"> First</span></a>';
        $pgHtml .= '<a class="button" href="javascript:void(0);" onClick="javascript: '.addslashes(str_replace("{page}",$prevPage,$onClick)).'"><span><img width="12" height="9" alt="Previous" src="'.facile::$theme_url.'images/arrow-180-small.gif"> Prev</span></a>';
        $pgHtml .= '<div class="numbers">';
        $pg = 1;
        if($currPage > $pagesPerPage){
          $pg = ((int)($currPage/$pagesPerPage))*$pagesPerPage + 1;
        }
        for($p = 1; $pg <= $totalPages && $p <= $pagesPerPage; $pg++, $p++){
          $sep = ($p == 1)?'Page:':'|';
          $selClass = ($pg == $currPage)?' class="current"':'';
          $pgHtml .= '<span>'.$sep.'</span> <a href="javascript:void(0);" onClick="javascript: '.addslashes(str_replace("{page}",$pg,$onClick)).'"><span'.$selClass.'>'.$pg.'</span></a> ';
        }
        $pgHtml .= '</div>';
        // next
        $pgHtml .= '<a class="button" href="javascript:void(0);" onClick="javascript: '.addslashes(str_replace("{page}",$nextPage,$onClick)).'"><span>Next <img width="12" height="9" alt="Next" src="'.facile::$theme_url.'images/arrow-000-small.gif"></span></a>';
        // last
        $pgHtml .= '<a class="button last" href="javascript:void(0);" onClick="javascript: '.addslashes(str_replace("{page}",$lastPage,$onClick)).'"><span>Last <img width="12" height="9" alt="Last" src="'.facile::$theme_url.'images/arrow-stop-000-small.gif"></span></a>';
      }

      $stPos = ($currPage - 1) * $rowsPerPage;

      $param['limit'] = ' LIMIT '.$stPos.','.$rowsPerPage;
      $param['rowsPerPage'] = $rowsPerPage;
      $param['currPage'] = $currPage;
      $param['startPosition'] = ($currPage>1)? ($rowsPerPage*($currPage-1)) : 0;

      return $pgHtml;
    }

function setPlayerNameAbbriviation($name){
   if(!empty($name)){
    $nameArr = @explode(' ',$name);
    $name = strtoupper($nameArr[0][0]).' '.$nameArr[1];
   }
   return $name;
}
?>