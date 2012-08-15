<!-- Dashboard icons -->
<?php
if ($_SESSION['admin_role_id'] == 1){
?>
<div class="grid_12">
    <a href="venue" class="dashboard-module">
      <img src="<?php echo facile::$theme_url;?>images/venue.png" tppabs="<?php echo facile::$theme_url;?>images/venue.png" width="64" height="64" alt="edit" />
      <span>Venue List</span>
    </a>

    <a href="readerscorner" class="dashboard-module">
      <img src="<?php echo facile::$theme_url;?>images/gift.png" tppabs="<?php echo facile::$theme_url;?>images/gift.png" width="64" height="64" alt="edit" />
      <span>Readers Corner</span>
    </a>

    <a href="alliedservices" class="dashboard-module">
      <img src="<?php echo facile::$theme_url;?>images/Crystal_Clear_editorial.png" tppabs="<?php echo facile::$theme_url;?>images/Crystal_Clear_editorial.png" width="64" height="64" alt="edit" />
      <span>Allied Services</span>
    </a>

    <a href="leads" class="dashboard-module">
      <img src="<?php echo facile::$theme_url;?>images/Crystal_Clear_blog.png" tppabs="<?php echo facile::$theme_url;?>images/Crystal_Clear_blog.png" width="64" height="64" alt="edit" />
      <span>Daily Leads</span>
    </a>

    <div style="clear: both"></div>
</div> 
<?php
}else{
?>
<div class="grid_12">
  <h2>Welcome</h2>
  <div style="clear: both"></div>
</div>
<div class="grid_6">
  <div style="clear: both"></div>
</div>
<?php
}
?>
<div style="clear: both"></div>