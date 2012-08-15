<?php
//contains core configuration of framework//
//include the other config files for this installation
include 'installation_config.php';
//include 'project_config.php';
include 'constants.php';

facile::$path = $path = dirname(__file__) . '/../';
facile::$livecontent = $path . 'webdocs/livecontent/';
facile::$path_tpl = $path . 'webdocs/views/';
facile::$path_frame_tpl = $path . 'webdocs/views/frames/';

facile::$path_utilities = $path . 'utitlity/';
facile::$web_utilities_url = str_replace("/webdocs/","/",$web_static_url) . 'utitlity/';
facile::$path_classes = $path . 'classes/';
facile::$path_core = $path . 'core/';
facile::$path_config = $path . 'configs/';
facile::$path_includes = $path . 'webdocs/includes/';
facile::$path_assets = $path . 'webdocs/assets/';
facile::$path_controllers = $path . 'webdocs/controllers/';
facile::$path_actions = $path . 'webdocs/actions/';
facile::$path_modals = $path . 'webdocs/modals/';
facile::$path_blocks = $path . 'webdocs/blocks/';
facile::$web_static_url = $web_static_url;
facile::$web_assets_url = $web_static_url.'assets/';

facile::$regionIdName = array("0"=>"N/A","1"=>"North Delhi", "2"=>"South Delhi", "3"=>"East Delhi", "4"=>"West Delhi", "5"=>"Central Delhi", "6"=>"Ghaziabad", "7"=>"Noida", "8"=>"Gurgaon");

facile::$web_tempfile_url = $web_static_url . 'assets/images/tempimg/';
facile::$web_tempfile_path = $path . 'webdocs/assets/images/tempimg/';

facile::$web_userimage_relative_path = "../users/";  // relative to web_tempfile_path
facile::$web_userimage_url = $web_static_url . 'assets/images/users/';
facile::$web_userimage_path = $path . 'webdocs/assets/images/users/';

facile::$web_venueimage_url = $web_static_url . 'assets/venue/';
facile::$web_venueimage_path = $path . 'webdocs/assets/venue/';
facile::$web_venueimage_relative_path = '../../venue/';
facile::$venueImgSizes = array('large'=>array('w'=>275,'h'=>366),'medium'=>array('w'=>130,'h'=>73),'small'=>array('w'=>70,'h'=>38));

facile::$web_auserimage_url = $web_static_url . 'assets/ausers/';
facile::$web_auserimage_path = $path . 'webdocs/assets/ausers/';
facile::$web_auserimage_relative_path = '../../ausers/';

facile::$web_playerimage_url = $web_static_url . 'assets/players/images/';
facile::$web_playerimage_path = $path . 'webdocs/assets/players/images/';
facile::$web_playerimage_relative_path = '../../players/images/';
facile::$playerImgSizes = array('large'=>array('w'=>275,'h'=>366),'small'=>array('w'=>90,'h'=>90));

facile::$web_playerposter_url = $web_static_url . 'assets/players/posters/';
facile::$web_playerposter_path = $path . 'webdocs/assets/players/posters/';
facile::$web_playerposter_relative_path = '../../players/posters/';
facile::$playerPosterSizes = array('large'=>array('w'=>468,'h'=>398),'small'=>array('w'=>468,'h'=>398));

facile::$web_clipimage_url = $web_static_url . 'assets/clips/images/';
facile::$web_clipimage_path = $path . 'webdocs/assets/clips/images/';
facile::$web_clipimage_relative_path = '../../clips/images/';
facile::$clipImgSizes = array('small'=>array('w'=>120,'h'=>68));

facile::$web_clipposter_url = $web_static_url . 'assets/clips/posters/';
facile::$web_clipposter_path = $path . 'webdocs/assets/clips/posters/';
facile::$web_clipposter_relative_path = '../../clips/posters/';
facile::$clipPosterSizes = array('small'=>array('w'=>640,'h'=>360));

facile::$web_gutterskin_url = $web_url_ui . 'assets/gutterskin/';
facile::$web_gutterskin_path = $path . 'webdocs/assets/gutterskin/';

facile::$web_url = $web_url;
facile::$web_url_ui = $web_url_ui;
facile::$geo_api = $geo_api;
facile::$theme_url = $web_static_url."interface/skins/default/";
facile::$jsbaseurl = $web_static_url."interface/js/";
facile::$autenticationFreeURI = array('forgotpassword','resetpassword','forgetpassword');
facile::$Dynamaic_navigation = array();
facile::$auserPicSizes = array('large'=>array('w'=>275,'h'=>366),'small'=>array('w'=>117,'h'=>117));
facile::$arrGeo = array('in'=>'India','us'=>'Us');
facile::$arrSeasons = array(array('id'=>'4','name'=>'4'),array('id'=>'5', 'name'=>'5'));
facile::$arrZones = array(array('id'=>'in','name'=>'IN'),array('id'=>'us', 'name'=>'US'),array('id'=>'row', 'name'=>'ROW'),array('id'=>'me', 'name'=>'ME'),array('id'=>'uk', 'name'=>'UK'),array('id'=>'apac', 'name'=>'APAK'));

// akamai
/*
facile::$akamai_url = 'http://content.ipl.indiatimes.com.edgesuite.net/ipl2012/';
facile::$akamai_ftp_server = 'ipl2012.upload.akamai.com';
facile::$akamai_ftp_user_name = 'ipl2012primary'; // Username
facile::$akamai_ftp_user_pass = 'ipl2012primary'; // Password

facile::$akamai_ftp_root_path = '158179/ipl2012/';
facile::$akamai_sourcefile_path = 'tangerine/vodupload/';
facile::$akamai_destinationfile_path = 'videos/iplclips/';
facile::$akamai_mobilesourcefile_path = 'tangerine/mobileupload/Airtel-Indiatimes/';
facile::$akamai_sourcefile_url = facile::$akamai_url.'tangerine/vodupload/';
*/

/**
 * @desc set the session management
 */
if($FACILE['sessionmode'] == 'memcache'){
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
include $path . 'db/fDB.php';
include facile::$path_core . 'view.php';
include facile::$path_utilities. 'ImageResize/ImageResize.php';

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
	public static $geo_api;
	public static $web_static_url;
	public static $web_assets_url;

	public static $web_tempfile_url;
	public static $web_tempfile_path;
  public static $regionIdName;

	public static $web_userimage_url;
	public static $web_userimage_path;
	public static $web_userimage_relative_path;

	public static $web_venueimage_url;
	public static $web_venueimage_path;
  public static $web_venueimage_relative_path;
  public static $venueImgSizes;

	public static $web_auserimage_url;
	public static $web_auserimage_path;
	public static $web_auserimage_relative_path;

	public static $web_playerimage_url;
	public static $web_playerimage_path;
	public static $web_playerimage_relative_path;
	public static $playerImgSizes;

	public static $web_playerposter_url;
	public static $web_playerposter_path;
	public static $web_playerposter_relative_path;
	public static $playerPosterSizes;

	public static $web_clipimage_url;
	public static $web_clipimage_path;
	public static $web_clipimage_relative_path;
	public static $clipImgSizes;

	public static $web_clipposter_url;
	public static $web_clipposter_path;
	public static $web_clipposter_relative_path;
	public static $clipPosterSizes;

  public static $web_gutterskin_url;
  public static $web_gutterskin_path;

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

  public static $arrGeo;
  public static $arrSeasons;
  public static $arrZones;
  public static $web_url_ui;
  public static $livecontent;

	function facile(){
	}
}
