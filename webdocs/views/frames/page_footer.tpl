 <!-- Footer -->
<?php global $web_url;?>

 <div id="footer">
        	<div class="container_12">
            	<div class="grid_12">
                	<!-- You can change the copyright line for your own -->
                	<p>&copy; 2012 <a href="<?php echo $web_url; ?>" title="GYV@2012">GYV.com</a></p>
        		</div>
            </div>
            <div style="clear:both;"></div>
        </div> <!-- End #footer -->
<?php if(!empty(view::$jsFiles)) {
  foreach(view::$jsFiles as $jsfile){ ?>
<script src="<?php echo facile::$jsbaseurl . $jsfile; ?>.js" type="text/javascript" language="javascript"></script>
<?php }
}?>
<script>
    var urlstr = '';
    <?php if(view::$jsInPage!=""){?>
	$(document).ready(function() {
		<?php echo view::$jsInPage; ?>
	});<?php }?>
</script>
<?php if(view::$lazyloading) { ?>
<script type="text/javascript" language="javascript">
  <?php
    ///////set the custom lazyloading params for seo request/////
    view::$lazyloading['cpage'] = isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : 1;
    view::$lazyloading['pages'] = isset($_GET['numpages']) ? $_GET['numpages'] : 10;
  ?>
	lazyloader.init(<?php echo json_encode(view::$lazyloading); ?>);
</script>
<?php } ?>