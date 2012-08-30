<?php

/* @desc: php file
 * @auther: Manish Sahu
 * @created On:
 */
?>
<!-- Initiate tablesorter script -->
<!-- Example table -->
                <div class="module">

                  <h2><span> Search</span></h2>
                  <div class="module-table-body">
                    <form action="" method="post" id="frmsearchadminusers" name="frmsearchadminusers" novalidate="novalidate">
                      <table class="NoBorder" border="0">
                        <tbody><tr>
                          <td width="30%">
                            Keyword : <input type="text" name="sh_keyword" id="sh_keyword" value="<?php echo $sh_keyword?>">
                          </td>
                          <td valign="middle">
                              <input type="submit" class="submit-green" value="submit" id="searchAdminUserBtn">
                          </td>
                          <td align="right">
                            <input type="button" class="submit-green" value="Add New" id="addAdminUserBtn" onclick="javascript:window.location='<?php echo facile::$web_url;?>adminusers?view=add'">
                            </td>
                        </tr>
                      </tbody></table>
                    </form>
                  </div>
                </div>

                <div class="module">
                	<h2><span>Admin Users</span></h2>
                    <div class="module-table-body">
                      <?php if(!empty($records)){?>
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:25%">Name</th>
                                    <th style="width:25%">Email</th>
                                    <th style="width:25%">Role</th>
                                    <th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                              foreach($records as $i=> $row) {
                            ?>
                                <tr class="<?php echo ($i%2==0)? 'even' : 'odd';?>">
                                    <td class="align-center"><?php echo ($i+1);?></td>
                                    <td><a href="<?php echo facile::$web_url;?>adminusers?view=edit&id=<?php echo $row['id']?>" title="<?php echo $row['name']?>"><?=chop_string($row['name'],50)?></a></td>
                                    <td><?=chop_string($row['email'],50)?></td>
                                    <td><?=chop_string($row['role_name'])?></td>
                                    <td>
                                    	  <a href="javascript:void(0);" onClick="javascript:changeStatusAdminUser('<?php echo $row['id']?>','<?php echo $row['status']?>')"><img src="<?php echo facile::$theme_url;?>images/<?php echo (($row['status']==1)?'tick-':'minus-')?>circle.gif" width="16" height="16" alt="published" /></a>
                                        <a href="<?php echo facile::$web_url;?>adminusers?view=edit&id=<?php echo $row['id'];?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                    </td>
                                </tr>
                             <?php }?>
                            </tbody>
                        </table>
                    <div style="clear: both"></div>
                    <?php }else{
                              echo "<div>No Record found.</div>";
                            }?>
                 </div> <!-- End .module-table-body -->
            </div> <!-- End .module -->
