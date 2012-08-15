<?php
//print_r($html);
?>
<!------Start---------Hm LEFT Content-------3Columns---------->
<div class="grid_3">
  <?php
  if($html['col1'])
    foreach ( $html['col1'] as $col1_module ) {
        echo $col1_module;
    }
  ?>
  &nbsp;
</div> 
    
<div class="grid_6">
  <?php
    if($html['col2'])
    foreach ( $html['col2'] as $col2_module ) {
        echo $col2_module;
    }
  ?>
  &nbsp;
</div>

<div class="grid_3">
  <?php
    if($html['col3'])
    foreach ( $html['col3'] as $col3_module ) {
        echo $col3_module;
    }
  ?>
  &nbsp;
</div> 
