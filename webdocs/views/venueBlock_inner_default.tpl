<?php if(!empty($msg)){ ?>
    <div>
        <span class="notification n-<?php echo $class;?>"><?php echo $msg;?></span>
    </div>
<?php }?>
<h1 id="pgHeading">Venue</h1>
<div class="homeButton"><a href="index.php">Home</a></div>

<div class="module">
<h2><span> Search</span></h2>
<div class="module-table-body">
  <form action="" method="post" id="searchVenue" name="searchVenue">
    <table border=0  class="NoBorder">
      <tr>
        <td class="wid35prcnt">
            <span class="FieldBox">Keyword : <input type="text" class="input-medium" name="sh_keyword" id="sh_keyword" value="<?php echo $sh_keyword?>"></span>
            <span class="FieldBox">Status :
              <select id="sh_status" name="sh_status">
                <option value="" <?php echo (($sh_status=='') ?'selected':''); ?>>All</option>
                <option value="0" <?php echo (($sh_status=='0') ? 'selected':'');?>>Unpublished</option>
                <option value="1" <?php echo (($sh_status=='1') ? 'selected':'');?>>Published</option>
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
    <h2><span> Venues Listing</span></h2>

    <div class="module-table-body">
        <?php if(!empty($records)){?>
            <table id="myTable" class="tablesorter">
              <thead>
                  <tr>
                      <th style="width:5%">#</th>
                      <th style="width:25%">Venue Name</th>
                      <th style="width:43%">Place</th>
                      <th style="width:17%">Created On</th>
                      <th style="width:10%">Action</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              foreach($records as $key => $rows) {
              ?>
                <tr class="<?php echo ($key%2==0)? 'even' : 'odd';?>">
                    <td class="align-center"><?php echo ($key+RECORDS_PER_PAGE*($currPage-1)+1);?></td>
                    <td><a href="javascript:void(0);" onClick="javascript:showVenueDetail('<?php echo $rows["id"];?>');" title="<?php echo $rows['name'];?>"><?php echo $rows['name'];?></a></td>
                    <td><?php echo $rows['address1'].' '.$rows['address2'];?></td>
                    <td><?php echo $rows['create_timestamp'];?></td>
                    <td>
                        <a title="Change Status" href="javascript:void(0);" onClick="javascript:changeStatus('<?php echo $rows["id"]?>');"><img src="<?php echo facile::$theme_url;?>images/<?php echo (($rows['is_active']==1)?'tick-':'minus-');?>circle.gif" width="16" height="16" alt="Change Status" /></a>
                        <a title="Edit" href="<?php echo facile::$web_url;?>venue?view=edit&id=<?php echo $rows['id'];?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a>
                        <a title="Gallery Images" href="javascript:void(0);" onClick="javascript:showVenueImages('<?php echo $rows["id"]?>');"><img src="<?php echo facile::$theme_url;?>images/picture.png" width="16" height="16" alt="Gallery Images" /></a>
                        <a title="Preview" target="_blank" href="<?php echo facile::$web_url_ui.'venue/'.$rows["venueid"];?>"><img src="<?php echo facile::$theme_url;?>images/preview.png" alt="Preview" /></a>
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
            echo "<div>No records found.</div>";
        } ?>
        <div style="clear: both"></div>
    </div> <!-- End .module-table-body -->
</div> <!-- End .module -->
