<!------ Start ----------------- 2Columns Profile ---------->
<div class="Lft_3ColmnWrapper Col5">
	<div>
		<div class="paymentMode">
			<div class="scrollfix"><h2 class="UserPage "><?php echo facile::$GLOBALS['profiletitle'];?></h2>

			<div class="innercontainer noMrg" id="profilefilter">
				<div class="FrenActivyLinks">
					<ul>
            <?php 
              $current = facile::$GLOBALS['coltabs']['current'];
              unset(facile::$GLOBALS['coltabs']['current']);
              foreach(facile::$GLOBALS['coltabs'] as $key=>$val){ 
                $class = ($current == $val)?'CurrentPG':'';
            ?>
              <li class="<?php echo $class;?>" id="tab_<?php echo str_replace(' ','_',$key);?>"><a href="<?php echo $val;?>"><?php echo $key;?></a></li>            
            <?php } ?>
					</ul>
				</div>
			</div></div>

			<div class="innercontainer">
				<div class="form profile">
					<div class="<?php echo facile::$GLOBALS['otherprofilecss'];?>ProfilePage">
						<div class="<?php echo facile::$GLOBALS['UserPageLeftWrapper'];?>">
							<?php
								foreach ( $html['col1'] as $module_name1 => $col1_module ) {
										echo "<div id='$module_name1'>$col1_module</div>";
								}
							?>
						</div>
						<div class="right info">
							<?php
								foreach ( $html['col2'] as $module_name2 => $col2_module ) {
										echo "<div id='$module_name2' ".((facile::$GLOBALS['UserPageLeftWrapper'])?"class='block'":"").">$col2_module</div>";
								}
							?>
						</div> 
						<div class="cl"></div>		
					</div>
				</div>
			</div>
			<div class="cl"></div>
		</div>       
	</div>
</div>
