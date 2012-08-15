<?php
$arrInfo = array("Y"=>"Active","N"=>"In-active");
?>
<div class="module-body">
  <div style="float:left;width:100%;">
    <table cellspacing="10">
      <tr>
         <td width="20%" align="right"> <b>Venue Name:</b> </td>
         <td width="80%" align="left" style="padding:5px;"> <?php echo $records['name'];?> [<b>Rank: <?php echo $records['rank'];?></b>]</td>
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
       if(!empty($records['createdate'])){?>
       <tr>
         <td align="right"> <b>Created On:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['createdate'];?></td>
       </tr>
       <?php }
       if(!empty($records['updatedate'])){?>
       <tr>
         <td align="right"> <b>Updated On :</b> </td>
          <td align="left" style="padding:5px;"><?php echo $records['updatedate'];?></td>
       </tr>
       <?php }?>
       <tr>
         <td align="right"> <b>Status:</b> </td>
          <td align="left" style="padding:5px;"><?php echo $arrInfo[$records['is_active']];?></td>
       </tr>
       <tr>
         <td align="right"> <b>Alternate Image Text:</b> </td>
          <td align="left" style="padding:5px;"><?php echo !empty($records['alttag']) ? $records['alttag'] : '-';?></td>
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
       }
       if($records['image']!="") { ?>
        <tr>
         <td align="right"> <b>Image:</b> </td>
          <td align="left" style="padding:5px;">
                <img src="<?php echo facile::$web_venueimage_url.$records['image'];?>"  height="100" />
          </td>
       </tr>
       <?php }?>
    </table>
  </div>
</div>