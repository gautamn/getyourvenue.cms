<div class="InnerContentWrapper">   
	<div class="lineBreak15p"></div>
	<!------Start---------Hm LEFT Content-------3Columns---------->
	<div class="Lft_3ColmnWrapper">
		<div class="Container180">
			<?php
				foreach ( $html['col1'] as $module_name => $module_html ) {
					echo "<div id='$module_name'>$module_html</div>";
				}			
			?>
			
		</div>
			
		<div class="Container180 mid">
			<?php
				foreach ( $html['col2'] as $module_name => $module_html ) {
					echo "<div id='$module_name'>$module_html</div>";
				}
			?>
		</div>          
		<div class="Container180">
			<?php
				foreach ( $html['col3'] as $module_name => $module_html ) {
					echo "<div id='$module_name'>$module_html</div>";
				}
			?>
		</div>        
	</div>
	<!------END-------Hm LEFT Content-------3Columns------->

	<!------START---------Hm Right Content----------------->
		<div class="Container300rght">
			<?php
				foreach ( $html['col4'] as $module_name => $module_html ) {
					echo "<div id='$module_name'>$module_html</div>";
				}
			?>			
		</div>    <div class="cl"></div>
	<!------END---------Hm Right Content----------------->
</div> <div class="cl"></div>