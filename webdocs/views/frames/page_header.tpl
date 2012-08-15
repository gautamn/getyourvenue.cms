<script>
function togelmenu(did){
  $('#'+did).toggle('slow');
}
</script>
<div id="header">
    <!-- Header. Main part -->
   	<div id="header-main" class="rel">
    
    <!-- Header. Status part --> 
    <div id="header-status"  class="rightalign">
	<div>
    
         <?php
         if(isset($_SESSION[_ADMIN_ID])) { ?>
            <div class="">
              <span><a href="javascript:void(0);" id="logout">Logout</a></span>
              <span id="admin" <?php if($_SESSION['admin_user_img']){?> style="background:none"<?php } ?> > Welcome : <a href="home">Admin</a> 
                <?php if($_SESSION['admin_user_img']){?> <img src="<?php echo $_SESSION['admin_user_img']; ?>" width="16px"><?php } ?>
              </span>

            </div>
        <? } ?>
        </div>
        <!--<div style="clear:both;"></div>-->
    </div>
    <!-- End #header-status -->

<!-- Header. Main part -->
<div>
	<div id="logo"><img src="interface/skins/default/images/logoipl.jpg" alt="IPL Admin" /></div>
</div>

<div class="float-left">
		<div id="hdtxt"><img src="interface/skins/default/images/adminhdtxt.png" alt="admin control" /></div>

<div class="iplMainNav">
                    <ul id="nav" style="display:block; float:none;">
                        <?php
                        if(isset($_SESSION[_ADMIN_ID])) {
                        ?>

<li style="float:right;"> 
<div class="menuLink">        
<?php
if(facile::$Dynamaic_navigation['group']['CMS_EXTRA'] || facile::$Dynamaic_navigation['group']['USER']){
?>
<a href="javascript:void(0);" onclick="togelmenu('fdv');">Menu</a>
  <div id="fdv" style="position:absolute; background:#fff; width:200px; border:1px solid #999; padding:10px; margin:34px 0 0 -163px; display:none; font-size:12px; color:#0063BE">
                          <div class="clear"></div>
<!--
<a class="noHover" href="<?php echo facile::$web_url;?>changepassword" style="background:url('<?php echo facile::$theme_url;?>/images/arrow.gif') no-repeat 5px; padding-left:28px; color:#000;">Change Password</a> -->
                            <?php
                            if(facile::$Dynamaic_navigation['group']['CMS_EXTRA']){
                              foreach(facile::$Dynamaic_navigation['group']['CMS_EXTRA'] as $cms_module1){
                                $cms_module = strtolower($cms_module1);
                                $controler = facile::$Dynamaic_navigation[$cms_module][0];
                                $modArr = explode('^~~^',$controler);
                                if($_SESSION['requestedPage']==$modArr[1] || $_SESSION['requestedPage']==$cms_module){
                                     $cms_module_selected = $cms_module;
                                }
                                ?>
                                <div class="clear"></div>
<a class="noHover" href="<?php echo facile::$web_url.$modArr[1]; ?>" style="background:url('<?php echo facile::$theme_url;?>/images/arrow.gif') no-repeat 5px; padding-left:28px; color:#000;"><?php echo $cms_module1;?></a>
                                <?php
                              }
                            }
                            if(facile::$Dynamaic_navigation['group']['USER']){
                              foreach(facile::$Dynamaic_navigation['group']['USER'] as $cms_module1){
                                $cms_module = strtolower($cms_module1);
                                $controler = facile::$Dynamaic_navigation[$cms_module][0];
                                $modArr = explode('^~~^',$controler);
                                if($_SESSION['requestedPage']==$modArr[1] || $_SESSION['requestedPage']==$cms_module){
                                     $cms_module_selected = $cms_module;
                                }
                                ?>
                                <div class="clear"></div>

<a class="noHover"  href="<?php echo facile::$web_url.$modArr[1]; ?>" style="background:url('<?php echo facile::$theme_url;?>/images/arrow.gif') no-repeat 5px; padding-left:28px; color:#000;"><?php echo $cms_module1;?></a>
                                <?php
                              }
                            }
                            ?>
                          </div>
<?php } ?>
</div>
</li>

<li <?=(($_SESSION['requestedPage']=='home' || !isset($_SESSION[_ADMIN_ID]))?'id="current"':'')?>><a href="<?=facile::$web_url?>">Home</a></li>
                        <?php
                        }
                        if(facile::$Dynamaic_navigation['group']['CMS']){
                          foreach(facile::$Dynamaic_navigation['group']['CMS'] as $cms_module1){
                            $cms_module = strtolower($cms_module1);
                            $controler = facile::$Dynamaic_navigation[$cms_module][0];
                            $modArr = explode('^~~^',$controler);
                            if($_SESSION['requestedPage']==$modArr[1] || $_SESSION['requestedPage']==$cms_module){
                                 $cms_module_selected = $cms_module;
                            }
                            ?>
                            <li <?=(($_SESSION['requestedPage']==$modArr[1] || $_SESSION['requestedPage']==$cms_module || view::$mainmenu==$cms_module)?'id="current"':'')?>><a href="<?php echo facile::$web_url.$modArr[1]; ?>"><?php echo $cms_module1;?></a></li>
                            <?php
                          }
                        } 
                        ?>
                    </ul>

</div>
<!---SUBNAVIGATION--->
<?php
$cms_module_selected = (view::$mainmenu)?strtolower(view::$mainmenu):$cms_module_selected;
if(facile::$Dynamaic_navigation[$cms_module_selected]){
?>
<div id="subnav">    
        <div class="">
            <div class="float-right ">
                <ul>
                    <?php
                      foreach((array)facile::$Dynamaic_navigation[$cms_module_selected] as $k=>$controler){
                        //if($k==0) { continue; }
                        $contrArr = explode('^~~^',$controler);
                        if($contrArr[1]!=""){
                          $selectedCls = (strtolower(trim(view::$submenu)) == strtolower(trim($contrArr[1])))?' id="selected-submenu" ':'';
                          echo '<li><a'.$selectedCls.' href="'.facile::$web_url.$contrArr[1].'">'.$contrArr[0].'</a></li>';
                        }
                      }
                    ?>
                </ul>

            </div><!-- End. .grid_12-->
        </div><!-- End. .container_12 -->
        <div style="clear: both;"></div>
    </div> <!-- End #subnav -->
    <?php
    }
    ?>
</div>
<div style="clear: both;"></div>