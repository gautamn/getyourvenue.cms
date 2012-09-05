<?php
$arrInfo = array("1"=>"Active","0"=>"In-active");
?>
<div class="module-body">
  <div style="float:left;width:100%;">
    <table cellpadding="10" border="0" cellspacing="10">
       <tr>
         <td align="left"> <b>Venue Name:</b> <?php echo $records['name'];?></td>
       </tr>
       <tr>
         <td align="left"><b>Thumbnail:</b> <br>
         <?php echo (!empty($thumbImg) ? '<img alt="loading..." align="top" src="'.$thumbImg.'" onload="'.facile::$theme_url."images/loader.gif".'" />':'No Thumbnails found.');?></td>
       </tr>
       <tr>
         <td align="left"> <b>Gallery Images:</b> </td>
       </tr>
       <?php if(!empty($galleryImg)){
         foreach($galleryImg as $img){?>
       <tr>
         <td align="left" style="padding:5px;margin:5px;"><img src="<?php echo $img;?>" alt="loading..." onload="<?php echo facile::$theme_url."images/loader.gif";?>" border="0" align="top" /></td>
       </tr>
       <?php }//foreach
       }else{?>
       <tr>
         <td align="left" style="padding:5px;margin:5px;">No Gallery Image found.</td>
       </tr>
       <?php }?>
    </table>
  </div>
</div>