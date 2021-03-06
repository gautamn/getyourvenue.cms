<?php
$arrInfo = array("1"=>"Active","0"=>"In-active");
?>
<div class="module-body">
  <div style="float:left;width:100%;">
    <table cellspacing="10">
      <tr>
         <td width="25%" align="right"> <b>Venue Name:</b> </td>
         <td width="75%" align="left" style="padding:5px;"> <?php echo $records['name'];?> [<b>Rank: <?php echo $records['rank'];?></b>]</td>
       </tr>
       <?php if($records['address1']!="") { ?>
       <tr>
         <td align="right"> <b>Address1:</b> </td>
         <td align="left" style="padding:5px;"> <?php echo $records['address1'];?></td>
       </tr>
       <?php }if($records['address2']!="") { ?>
       <tr>
         <td align="right"> <b>Address2:</b> </td>
          <td align="left" style="padding:5px;"> <?php echo $records['address2'];?></td>
       </tr>
       <?php } ?>
       <tr>
         <td align="right"> <b>Description:</b> </td>
          <td align="left" style="padding:5px;"> <?php echo (!empty($records['content']) ? $records['content'] : '-');?></td>
       </tr>
       <?php
       if(!empty($records['create_timestamp'])){?>
       <tr>
         <td align="right"> <b>Created On:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['create_timestamp'];?></td>
       </tr>
       <?php }
       if(!empty($records['update_timestamp'])){?>
       <tr>
         <td align="right"> <b>Updated On :</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['update_timestamp'];?></td>
       </tr>
       <?php }?>
       <tr>
         <td align="right"> <b>Status:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $arrInfo[$records['is_active']];?></td>
       </tr>
       <tr>
         <td align="right"> <b>Meta Title:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['title'];?></td>
       </tr>
       <tr>
         <td align="right"> <b>Meta Description:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['meta_description'];?></td>
       </tr>
       <tr>
         <td align="right"> <b>Meta Keywords:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['meta_keyword'];?></td>
       </tr>
       <tr>
         <td align="right"> <b>Alternate Image Text:</b> </td>
          <td align="left" style="padding:5px;"><?php echo !empty($records['image_alt_tag']) ? $records['image_alt_tag'] : '-';?></td>
       </tr>
       <?php
       if(!empty($records['venueType'])){?>
       <tr>
         <td align="right"> <b>Venue Type:</b> </td>
          <td align="left" style="padding:5px;"><?php
          $arrTempVenue = array();
          foreach($records['venueType'] as $venueType){
            $arrTempVenue[] = trim($venueType['type']);
          }
          echo (sizeof($arrTempVenue)>0 ? implode(', ',$arrTempVenue) : '-');?></td>
       </tr>
       <?php
       }
       if(!empty($records['venueCapcity'])){?>
       <tr>
         <td align="right"> <b>Venue Capacity:</b> </td>
          <td align="left" style="padding:5px;"><?php
          $arrTempCap = array();
          foreach($records['venueCapcity'] as $venueCap){
            $arrTempCap[] = trim($venueCap['range']);
          }
          echo (sizeof($arrTempCap)>0 ? implode(', ',$arrTempCap) : '-');?></td>
       </tr>
       <?php
       }?>
    </table>
  </div>
</div>