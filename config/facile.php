<?php
//contains core configuration of framework//
//include the other config files for this installation
include 'installation_config.php';
//include 'project_config.php';
include 'constants.php';
$web_assets_path = dirname(__file__).'/../../';
facile::$path = $path = dirname(__file__).'/../';//'/homepages/0/d417307172/htdocs/cms/';

facile::$path_tpl = $path . 'webdocs/views/';
facile::$path_frame_tpl = $path . 'webdocs/views/frames/';

facile::$path_utilities = $path . 'utitlity/';
facile::$web_utilities_url = $web_static_url. 'utitlity/';
facile::$path_classes = $path . 'classes/';
facile::$path_core = $path . 'core/';
facile::$path_config = $path . 'configs/';
facile::$path_includes = $path . 'webdocs/includes/';

facile::$path_controllers = $path . 'webdocs/controllers/';
facile::$path_actions = $path . 'webdocs/actions/';
facile::$path_modals = $path . 'webdocs/modals/';
facile::$path_blocks = $path . 'webdocs/blocks/';
facile::$web_static_url = $web_static_url;

facile::$web_assets_url = $web_url_ui.'images/';
facile::$path_assets = $web_assets_path . 'images/';

facile::$regionIdName = array("0"=>"N/A","1"=>"North Delhi", "2"=>"South Delhi", "3"=>"East Delhi", "4"=>"West Delhi", "5"=>"Central Delhi", "6"=>"Ghaziabad", "7"=>"Noida", "8"=>"Gurgaon");

facile::$web_tempfile_url = facile::$web_assets_url . 'images/tempimg/';
facile::$web_tempfile_path = facile::$path_assets . 'images/tempimg/';

facile::$web_venueimage_url = facile::$web_assets_url ;
facile::$web_venueimage_path = facile::$path_assets ;
facile::$web_venueimage_relative_path = '../../../../images/';
facile::$venueImgSizes = array('large'=>array('w'=>275,'h'=>366),'medium'=>array('w'=>130,'h'=>73),'small'=>array('w'=>70,'h'=>38));

facile::$web_auserimage_url = facile::$web_assets_url . 'assets/ausers/';
facile::$web_auserimage_path = facile::$path_assets . 'webdocs/assets/ausers/';
facile::$web_auserimage_relative_path = '../../../../ausers/';

facile::$web_url = $web_url;
facile::$web_url_ui = $web_url_ui;

facile::$theme_url = $web_url."interface/skins/default/";
facile::$jsbaseurl = $web_url."interface/js/";
facile::$autenticationFreeURI = array('forgotpassword','resetpassword','forgetpassword');
facile::$Dynamaic_navigation = array();
facile::$auserPicSizes = array('large'=>array('w'=>275,'h'=>366),'small'=>array('w'=>117,'h'=>117));

/**
 * @desc set the session management
 */
if(isset($FACILE['sessionmode']) && $FACILE['sessionmode'] == 'memcache'){
  include facile::$path_core . 'fSession.php';
  $sessionObj = new fSession($FACILE['sessioncache']);
}
session_start();

$requestedPage = (isset($_GET['q']) && $_GET['q']!='')?$_GET['q']:'home';
$_SESSION['requestedPage'] = $requestedPage;


/**
* Include all framework core files here
*/
include facile::$path_core . 'fCache.php';
include_once $path . 'db/fDB.php';
include_once facile::$path_core . 'view.php';
include_once facile::$path_utilities. 'ImageResize/ImageResize.php';

//some variable configuration for view class
view::$tpl_path = facile::$path_tpl;
view::$tpl_frame_path = facile::$path_frame_tpl;
view::$block_path = facile::$path_blocks;
view::$modal_path = facile::$path_modals;

//if mecache is set connect to memcache
if(isset($FACILE['memcache'])){
	fCache::$conn = $FACILE['memcache'];
	fCache::connect();
}

class facile{
	public static $path;
	public static $path_images;
	public static $path_files;
	public static $path_tpl;
	public static $path_frame_tpl;

	public static $path_classes;
	public static $path_core;
	public static $path_config;
	public static $path_utilities;
	public static $web_utilities_url;
	public static $path_assets;
	public static $path_includes;
	public static $path_controllers;
	public static $path_modals;
	public static $path_blocks;
	public static $path_actions;
	public static $web_url;

	public static $web_static_url;
	public static $web_assets_url;

	public static $web_tempfile_url;
	public static $web_tempfile_path;
  public static $regionIdName;

	public static $web_venueimage_url;
	public static $web_venueimage_path;
  public static $web_venueimage_relative_path;
  public static $venueImgSizes;

	public static $web_auserimage_url;
	public static $web_auserimage_path;
	public static $web_auserimage_relative_path;

	public static $theme_url;
	public static $jsbaseurl;

	public static $main_menu;
	public static $media_type;
	public static $media_type_tv;


	public static $blockrepeat;
	public static $GLOBALS;

	public static $facebook_appId;
	public static $facebook_secret;
	public static $twitter_key;
	public static $twitter_secret;

  public static $autenticationFreeURI;
  public static $Dynamaic_navigation;
  public static $auserPicSizes;

  public static $akamai_url;
  public static $akamai_ftp_server;
  public static $akamai_ftp_user_name;
  public static $akamai_ftp_user_pass;
  public static $akamai_ftp_root_path;
  public static $akamai_sourcefile_path;
  public static $akamai_destinationfile_path;
  public static $akamai_mobilesourcefile_path;
  public static $akamai_sourcefile_url;

  public static $web_url_ui;

	function facile(){
	}
}
