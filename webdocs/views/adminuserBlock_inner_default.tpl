<!-- Initiate tablesorter script -->
<!-- Example table -->
                <div class="module">

                  <h2><span> Search</span></h2>
                  <div class="module-table-body">
                    <form action="" method="post" id="frmsearchadminusers" name="frmsearchadminusers" novalidate="novalidate">
                      <table border="0">
                        <tbody><tr>
                          <td width="30%">
                            Keyword : <input type="text" name="sh_keyword" id="sh_keyword" value="<?=$sh_keyword?>">
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
                    	<form action="">
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
                            for($i=0;$i<count($records);$i++) {
                            ?>
                                <tr>
                                    <td class="align-center"><?=($i+1)?></td>
                                    <td><a href="<?=$web_url?>adminusers?view=edit&id=<?=$records[$i]['id']?>" title="<?=$records[$i]['name']?>"><?=chop_string($records[$i]['name'],50)?></a></td>
                                    <td><?=chop_string($records[$i]['email'],50)?></td>
                                    <td><?=chop_string($records[$i]['role_name'])?></td>
                                    <td>
                                    	  <a href="javascript:void(0)" onClick="javascript:changeStatusAdminUser('<?=$records[$i]['id']?>','<?=$records[$i]['status']?>')"><img src="<?php echo facile::$theme_url;?>images/<?=(($records[$i]['status']==1)?'minus-':'tick-')?>circle.gif" tppabs="<?php echo facile::$theme_url;?>images/tick-circle.gif" width="16" height="16" alt="published" /></a>
                                        <a href="<?=$web_url?>adminusers?view=edit&id=<?=$records[$i]['id']?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" tppabs="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                    </td>
                                </tr>
                             <? } ?>
                            </tbody>
                        </table>
                      </form>
                        <div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="<?php echo facile::$theme_url;?>images/arrow-stop-180.gif" tppabs="images/arrow-stop-180.gif" alt="first"/>
                                <img class="prev" src="<?php echo facile::$theme_url;?>images/arrow-180.gif" tppabs="images/arrow-180.gif" alt="prev"/>
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="<?php echo facile::$theme_url;?>images/arrow.gif" tppabs="images/arrow.gif" alt="next"/>
                                <img class="last" src="<?php echo facile::$theme_url;?>images/arrow-stop.gif" tppabs="images/arrow-stop.gif" alt="last"/>
                                <select class="pagesize input-short align-center">
                                   <option value="50" selected="selected">50</option>
                        <option value="100">100</option>
                        <option value="150">150</option>
                        <option value="200">200</option>
                                </select>
                                </div>
                            </form>
                        </div>

                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->