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
    <form action="javascript:;" method="post" id="searchAlliedServices" name="searchAlliedServices">
      <table border="0" class="NoBorder">
        <tr>
          <td class="wid35prcnt">
              <span class="FieldBox">Keyword: <input type="text" class="input-medium" name="sh_keyword" id="sh_keyword" value="<?php echo $sh_keyword?>"></span>
              <span class="FieldBox">Status:
                <select id="sh_status" name="sh_status">
                  <option value="" <?php echo (($sh_status=='') ?'selected':''); ?>>All</option>
                  <option value="0" <?php echo (($sh_status=='0') ? 'selected':'');?>>Unpublished</option>
                  <option value="1" <?php echo (($sh_status=='1') ? 'selected':'');?>>Published</option>
                </select>
                </span>
              <span class="FieldBox"><input class="submit-green" id="btn_search" onclick="javascript:searchAllied();" type="button" value="Search" /></span>
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
                        <th style="width:25%">Service Name</th>
                        <th style="width:45%">Title</th>
                        <th style="width:15%">Created On</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($records as $key => $rows) {
                ?>
                    <tr>
                        <td class="align-center"><?php echo ($key+RECORDS_PER_PAGE*($currPage-1)+1);?></td>
                        <td><a href="javascript:void(0);" onClick="javascript:showAlliedServiceDetail('<?php echo $rows["SEO_ID"];?>');" title="<?php echo $rows['HEADING'];?>"><?php echo $rows['HEADING'];?></a></td>
                        <td><?php echo $rows['TITLE'];?></td>
                        <td><?php echo $rows['CREATE_TIMESTAMP'];?></td>
                        <td>
                            <a title="Change Status" href="javascript:void(0);" onClick="javascript:changeStatus('<?php echo $rows["SEO_ID"]?>');"><img src="<?php echo facile::$theme_url;?>images/<?php echo (($rows['IS_ACTIVE']==1)?'tick-':'minus-');?>circle.gif" width="16" height="16" alt="Change Status" /></a>
                            <a title="Edit" href="<?php echo facile::$web_url;?>alliedservices?view=edit&id=<?php echo $rows['SEO_ID']?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a>
                            <a title="View Details" href="javascript:void(0);" onClick="javascript:showAlliedServiceDetail('<?php echo $rows["SEO_ID"]?>');"><img src="<?php echo facile::$theme_url;?>images/preview.png" width="16" height="16" alt="View Details" /></a>
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