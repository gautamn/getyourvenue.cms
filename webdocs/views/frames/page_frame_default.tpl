<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo view::$title; ?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo facile::$theme_url;?>images/favicon.ico" />
<script>
var JSWebURLUI = '<?php echo facile::$web_url_ui;?>'
var JSWebURL = '<?php echo facile::$web_url;?>'
var JSWebStaticURL = '<?php echo facile::$web_static_url;?>'
var JSThemeURL = '<?php echo facile::$theme_url;?>'
var isLoggedIn = <?php echo ((isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id']>0)?'true':'false'); ?>;
var LoggedInUserId = parseInt('<?php echo ((isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id']>0)?$_SESSION['admin_user_id']:'0'); ?>');
var requestedPage = "<?php echo $_SESSION['requestedPage'];?>";
var userEvent = "";
</script>
<!-- CSS Includes section -->
<?php
	foreach(view::$cssFiles as $css){
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".facile::$theme_url."css/$css".'.css'."\" />\n";
	}
?>
<!--[if IE 7]> <html class="ie8"> <![endif]-->

<!-- JS Includes section -->
<?php
  foreach(view::$jsFiles as $js_files){
    //echo "<script type=\"text/javascript\" language=\"javascript\" src=\"".facile::$jsbaseurl."$js_files".".js\"></script>\n";
  }
?>
</head>
<body class="<?php echo view::$bodyclass?>">

	<?php //print_r($html);
		echo $html['header'];
  ?>
  <div class="wrapper">
  <div class="container_12">
	<div class="OuterMostWrapper">

      <?php
        foreach($html['content'] as $content){
          if(is_array($content)){
            foreach ( $content as $module_name => $module_html ) {
              echo "<div id='$module_name'>$module_html</div>";
            }
          }else{
            echo $content;
          }
        }
      ?>

	</div>
  <div style="clear:both;"></div>
  </div>
	<?php
		echo $html['footer'];
	?>
<div id="tooltip"></div>
</div>
</body>
