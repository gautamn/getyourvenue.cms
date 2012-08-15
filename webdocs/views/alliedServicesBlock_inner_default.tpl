<?php
/* @desc: tpl file
 * @auther: Manish Sahu
 * @created On:
 */
?>
<?php
if(!empty($msg)){ ?>
<div>
    <span class="notification n-<?php echo $class;?>"><?php echo $msg;?></span>
</div>
<?php }?>

<h1 id="pgHeading">Allied Services</h1>
<div class="homeButton"><a href="index.php">Home</a></div>

<div class="module">
  <h2><span> Search</span></h2>
  <div class="module-table-body">
    <form action="" method="post" id="searchVenue" name="searchVenue">
      <table border="0" class="NoBorder">
        <tr>
          <td class="wid35prcnt">
              <span class="FieldBox">Keyword : <input type="text" class="input-medium" name="sh_keyword" id="sh_keyword" value="<?php echo $sh_keyword?>"></span>
              <span class="FieldBox">Status :
                <select id="sh_status" name="sh_status">
                  <option value="" <?php echo (($sh_status=='') ?'selected':''); ?>>All</option>
                  <option value="N" <?php echo (($sh_status=='N') ? 'selected':'');?>>Unpublished</option>
                  <option value="Y" <?php echo (($sh_status=='Y') ? 'selected':'');?>>Published</option>
                </select>
                </span>
              <span class="FieldBox"><input class="submit-green" id="btn_search" onclick="javascript:searchVenues();" type="button" value="Search" /></span>
            </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<div class="module">
    <h2><span>Allied Services Listing</span></h2>

    <div class="module-table-body">
        <?php if(!empty($records)){?>
            <table id="myTable" class="tablesorter">
                <thead>
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:25%">Venue Name</th>
                        <th style="width:45%">Place</th>
                        <th style="width:15%">Created On</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($records as $key => $rows) {
                ?>
                    <tr>
                        <td class="align-center"><?php echo ($key+RECORDS_PER_PAGE*($currPage-1)+1);?></td>
                        <td><a href="javascript:void(0);" onClick="javascript:showVenueDetail('<?php echo $rows["id"];?>');" title="<?php echo $rows['name'];?>"><?php echo $rows['name'];?></a></td>
                        <td><?php echo $rows['address1'].' '.$rows['address2'];?></td>
                        <td><?php echo $rows['createdate'];?></td>
                        <td>
                            <a title="Change Status" href="javascript:void(0);" onClick="javascript:changeStatus('<?php echo $rows["id"]?>');"><img src="<?php echo facile::$theme_url;?>images/<?php echo (($rows['is_active']=='Y')?'tick-':'minus-')?>circle.gif" width="16" height="16" alt="Change Status" /></a>
                            <a title="Edit" href="<?php echo facile::$web_url;?>venue?view=edit&id=<?php echo $rows['id']?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a>
                            <a title="View Details" href="javascript:void(0);" onClick="javascript:showVenueDetail('<?php echo $rows["id"]?>');"><img src="<?php echo facile::$theme_url;?>images/preview.png" width="16" height="16" alt="View Details" /></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
          <!-- Start pagination -->
          <div class="pagination">
            <?php echo $paginationHtml;?>
          </div>
          <!-- End pagination-->
        <?php }else{
            echo "<div class='pad10'>No records found.</div>";
        } ?>
        <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body -->
</div>
<!-- End .module -->