<?php
/* @desc: php file
 * @auther: Manish Sahu
 * @created On:
 */

//date js
view::$jsInPage .=" showDates();";
if(!empty($msg)){ ?>
<div>
    <span class="notification n-<?php echo $class;?>"><?php echo $msg;?></span>
</div>
<?php }?>

<h1 id="pgHeading">Leads</h1>
<div class="homeButton"><a href="index.php">Home</a></div>

<div class="module">
  <h2><span> Search</span></h2>
  <div class="module-table-body">
    <form action="" method="post" id="searchLeadsForm" name="searchLeadsForm">
      <table border="0" class="NoBorder">
        <tr>
          <td class="wid35prcnt">
            <span class="FieldBox">Keyword : <input type="text" class="input-medium" name="sh_keyword" id="sh_keyword" value="<?php echo $sh_keyword;?>"></span>
            <span class="FieldBox">Date Range [ From: <input type="text" id="seacrhDateFrom" class="input-short" name="seacrhDateFrom" maxlength="10" value="<?php echo $seacrhDateFrom;?>" /> To: <input type="text" id="seacrhDateTo" class="input-short" name="seacrhDateTo" maxlength="10" value="<?php echo $seacrhDateTo;?>" /> ]</span>
            <span class="FieldBox"><input class="submit-green" id="btn_search" type="button" value="Search" /></span>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<div class="module">
    <h2><span>Leads Listing</span></h2>
    <div class="module-table-body">
        <?php if(!empty($records)){?>
        <table id="myTable" class="tablesorter">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:25%">Name [Email | Mobile]</th>
                    <th style="width:45%">Preferred Venue/ Region/ Date / Other details</th>
                    <th style="width:15%">Message</th>
                    <th style="width:10%">Lead Date</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($records as $key => $rows) {
            ?>
                <tr class="<?php echo ($key%2==0)? 'even' : 'odd';?>">
                    <td class="align-center"><?php echo ($key+RECORDS_PER_PAGE*($currPage-1)+1);?></td>
                    <td><?php echo $rows['name'];?><br><?php echo $rows['email'].'<br>'.$rows['contact_no'];?> </td>
                    <td><?php echo ($rows['preferred_region']>0) ? facile::$regionIdName[$rows['preferred_region']].'<br>' : '';
                    echo $rows['preferred_venue'];
                    echo '<br>'.$rows['preferred_date'];
                    echo !empty($rows['no_of_guests']) ? $rows['no_of_guests'] .' guests' : ''; echo !empty($rows['budget']) ? ' budget:'.$rows['budget'] : '';?></td>
                    <td><?php echo ($rows['message']!="" && $rows['message']!='Type in your message here...') ? $rows['message'] : '-';?></td>
                    <td><?php echo $rows['insertdate'];?></td>
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
