<?php if(!empty($msg)){ ?>
    <div>
        <span class="notification n-<?php echo $class;?>"><?php echo $msg;?></span>
    </div>
<?php }?>
<h1 id="pgHeading">Venue Type</h1>
<div class="homeButton"><a href="index.php">Home</a></div>

<div class="module">
<h2><span> Search</span></h2>
<div class="module-table-body">
  <form action="" method="post" id="searchVenue" name="searchVenue">
    <table border="0" class="NoBorder">
      <tr>
        <td class="wid35prcnt">
            <span class="FieldBox">Keyword : <input type="text" class="input-medium" name="sh_keyword" id="sh_keyword" value="<?php echo $sh_keyword?>"></span>
            <span class="FieldBox"><input class="submit-green" id="btn_search" onclick="javascript:searchVenueType();" type="button" value="Search" /></span>
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
                      <th style="width:20%">Venue Type</th>
                      <th style="width:20%">SEO Key</th>
                      <th style="width:20%">Created On</th>
                      <th style="width:20%">Updated On</th>
                      <th style="width:10%">Action</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              foreach($records as $key => $rows) {
              ?>
                <tr class="<?php echo ($key%2==0)? 'even' : 'odd';?>">
                    <td class="align-center"><?php echo ($key+RECORDS_PER_PAGE*($currPage-1)+1);?></td>
                    <td><?php echo $rows['type'];?></td>
                    <td><?php echo $rows['venuetype'];?></td>
                    <td><?php echo $rows['create_timestamp'];?></td>
                    <td><?php echo $rows['update_timestamp'];?></td>
                    <td><a title="Edit" href="<?php echo facile::$web_url.'venuetype?view=edit&id='.$rows['venuetypeid'];?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a></td>
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
