   <!-- Initiate tablesorter script -->
 <!-- Example table -->
                <div class="module">

                  <h2><span> Search</span></h2>
                  <div class="module-table-body">
                    <form name="frmsearchcategories" id="frmsearchcategories" method="post" action="">
                      <table border="0" class="NoBorder">
                        <tr>
                          <td class="wid35prcnt">
                            <span class="FieldBox">Keyword: <input type="text" value="<?=$sh_keyword?>" id="sh_keyword" name="sh_keyword" />
                                      <input type="hidden" value="<?=$sh_type?>" id="sh_type" name="sh_type">
                            </span>
                            <span class="FieldBox">Parent Category: <?=get_dropdown($arr_category,'sh_parent_id',$sh_parent_id)?></span>
                            <span class="FieldBox">
                                <input type="button" id="searchCatBtn" value="Search" class="submit-green" onClick="searchCategory()">
                            </span>
                            <span class="FieldBox">
                            <input type="button" onclick="javascript:window.location='<?php echo facile::$web_url;?>categories?view=add'" id="addCatBtn" value="Add New" class="submit-green">
                            </span>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>

                <div class="module">
                    <h2>
                      <span> Categories :: <?=strtoupper($sh_type)?>
                        <img src="<?=facile::$theme_url?>images/spacer.gif" width="70%" height="1px">
                        <?php
                        if($arr_types){
                        $c = array();
                        foreach($arr_types as $tp){
                          $c[] = '<a href="categories?type='.$tp['id'].'">'.(($sh_type==$tp['id'])?'<b>'.$tp['name'].'</b>':$tp['name']).'</a>';
                        }
                        echo implode(', ', $c);
                        }
                        ?>
                      </span>
                    </h2>

                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th>Category</th>
                                    <th>Parent Category</th>
                                    <th>Priority</th>
                                    <th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            for($i=0;$i<count($records);$i++) {
                            ?>
                                <tr>
                                    <td class="align-center"><?=($i+1)?></td>
                                    <td><a href="<?=$web_url?>categories?view=edit&id=<?=$records[$i]['id']?>" title="<?=$records[$i]['name']?>"><?=chop_string($records[$i]['name'],50)?></a></td>
                                    <td><?php echo ($records[$i]['parent_name'])? chop_string($records[$i]['parent_name'],50) :'---';?></td>
                                    <td><?=$records[$i]['priority']?></td>
                                    <td>
                                    	<!--<input type="checkbox" />-->
                                       <a href="javascript:void(0)" onClick="javascript: changeStatusCategory('<?=$records[$i][id]?>','<?=$records[$i]['status']?>');"><img src="<?php echo facile::$theme_url;?>images/<?=(($records[$i]['status']==1)?'minus-':'tick-')?>circle.gif" tppabs="<?php echo facile::$theme_url;?>images/tick-circle.gif" width="16" height="16" alt="published" /></a>
                                       <a href="<?=$web_url?>categories?view=edit&id=<?=$records[$i]['id']?>"><img src="<?php echo facile::$theme_url;?>images/pencil.gif" tppabs="<?php echo facile::$theme_url;?>images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                       <?php if($_SESSION['admin_role_id']==1){ ?>
                                       <a href="javascript:void(0)" onClick="javascript: deleteCategory('<?=$records[$i][id]?>');"><img src="<?php echo facile::$theme_url;?>images/bin.gif" tppabs="<?php echo facile::$theme_url;?>images/bin.gif" width="16" height="16" title="Delete" alt="delete"/></a>
                                       <?php } ?>
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