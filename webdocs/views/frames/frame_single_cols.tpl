<div class="InnerContentWrapper">   
	<!------Start---------Hm LEFT Content-------3Columns---------->
	<div class="Lft_3ColmnWrapper Col5">
		<?php
			foreach ( $html['col1'] as $module_name => $module_html ) {
				echo "<div id='$module_name'>$module_html</div>";
			}			
		?>
	</div>
    <div class="cl"></div>
</div>