<?php
$arrInfo = array("1"=>"Active","0"=>"In-active");
?>
<div class="module-body">
  <div style="float:left;width:100%;">
    <table cellspacing="10">
      <tr>
         <td width="25%"> <b>Allied Service:</b> </td>
         <td width="75%" align="left" style="padding:5px;"><?php echo $records['HEADING'];?></td>
       </tr>
       <tr>
         <td><b>Status:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $arrInfo[$records['IS_ACTIVE']];?></td>
       </tr>
       <tr>
         <td><b>Meta Title:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['TITLE'];?></td>
       </tr>
       <tr>
         <td><b>Meta Description:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['META_DESCRIPTION'];?></td>
       </tr>
       <tr>
         <td><b>Meta Keywords:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['META_KEYWORD'];?></td>
       </tr>
       <tr>
         <td><b>Banner Path:</b> </td>
         <td align="left" style="padding:5px;"><?php echo $records['BANNER_PATH'];?></td>
       </tr>
       <tr>
         <td><b>Jcarousel Path:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['JCAROUSEL_IMAGES_FOLDER_PATH'];?></td>
       </tr>
       <tr>
         <td><b>Themes Url:</b> </td>
          <td align="left" style="padding:5px;"> <?php echo $records['THEMES_URLS'];?></td>
       </tr>
       <?php
       if(!empty($records['CREATE_TIMESTAMP'])){?>
       <tr>
         <td><b>Created On:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['CREATE_TIMESTAMP'];?></td>
       </tr>
       <?php }
       if(!empty($records['UPDATE_TIMESTAMP'])){?>
       <tr>
         <td><b>Updated On :</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['UPDATE_TIMESTAMP'];?></td>
       </tr>
       <?php }?>
    </table>
  </div>
</div>