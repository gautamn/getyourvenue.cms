<?php
require_once 'template.php';
/**
* @desc Renders View for the page, also used to render output in JSON format for componenet based layout.
*/
class view{
	public static $tpl_path;
	public static $tpl_frame_path;
	public static $block_path;
	public static $modal_path;

	public static $header_tpl;
	public static $footer_tpl;

	public static $blocks;
	public static $frames;
	public static $mainmenu;
	public static $submenu;
	public static $blocksHtml;
	public static $pageHtml;

	public static $outer_frame;
	public static $blockdepth;

	public static $title;
	public static $keywords;
	public static $description;
	public static $cssFiles;
	public static $jsFiles;

	public static $jsInPage;
	public static $cssInPage;

	public static $renderMode;
	public static $optimize;
	public static $usePackFiles;

	public static $callback;
	public static $lazyloading;
	public static $blockrepeat;
	public static $bodyclass;

  public static $topblockkeys;

	//constuctpr function, set params for intialization
	function view(){


	}

	//render the page output and return
	public static function render(){
		$middleHtml = self::renderBlocks(self::$blocks, '0');
		$headerHtml = self::renderHeader();
		$footerHtml = self::renderFooter();
		//
		$html = array('header'=>$headerHtml, 'footer'=>$footerHtml, 'content'=>$middleHtml);
		$outerFrame = self::$tpl_frame_path . self::$outer_frame;
		$template = new template($outerFrame, array('html'=>$html));
		self::$pageHtml = $template->fetch();
		$template = null;
		return self::$pageHtml;
	}
	//render the lazy loading request
	public static function renderBlockHtml($blocks,$config = ''){
		return self::renderBlocks($blocks, 0);
	}
	//render header of the page
	private function renderHeader(){
		$file = self::$tpl_frame_path . self::$header_tpl;
		$template = new template($file);
		$html = $template->fetch();
		$template = null;
		return $html;
	}

	//render footer of the page
	private function renderFooter(){
		$file = self::$tpl_frame_path . self::$footer_tpl;
		$template = new template($file);
		$html = $template->fetch();
		$template = null;
		return $html;
	}

	//prepare blocks in the pages
	function prepareBlocks(){


	}

	//detect outer template for the page
	private function detectFrame($cols, $frame = null){
		if(!$cols || view::$renderMode == 'lazyloading' ) return;
		if(!$frame || is_array($frame)){
			$translator = array('1'=>'single','2'=>'two','3'=>'three','4'=>'four');
			$frame = 'frame_'. $translator[$cols] . '_cols.tpl';
		}
		$frameFile = self::$tpl_frame_path . '/' . $frame;
		return $frameFile;
	}

	//check if using a multi-layer outer OR just block lists
	private function checkBlockDepth($blockDepth){
		if(!$blockDepth) $blockDepth = 1;
		foreach(self::$blocks as $b){
			if(is_array($b)){
				$blockDepth = 2;
			}
		}
		return $blockDepth;
	}
	//
  private function getTopBlockKeys($blocks){
    foreach($blocks as $blockname => $val){
      self::$topblockkeys[] = $blockname;
    }

  }
	//render output from blocks
	private function renderBlocks($blocks, $depth, $frame = null){
    if($depth <= 0){
        self::getTopBlockKeys($blocks);
    }
		if(!$frame){
			$frame = self::$frames;
		}
		$frametpl = self::detectFrame(count($blocks),$frame);
		foreach($blocks as $container => $block){
			$frame_ = (is_array($frame)) ? (isset($frame[$container]) ? $frame[$container] : '') : null;
			if(is_array($block)){
				$depth = $depth+1;
				$returnhtml[$container] = self::renderBlocks($block, $depth, $frame_);
			}else{
				$blockhtml = self::renderBlock($block);
				$cntr = (view::$blockrepeat[$block] > 1 ) ? view::$blockrepeat[$block] : '';
				$returnhtml[$block.$cntr] = $blockhtml;
				$blockhtml = null;
			}
			if(in_array($container, self::$topblockkeys)){
				$depth = 0;
			}
		}
		if($frametpl && $depth != 0){
			$returnhtml = self::renderFrame($frametpl, $returnhtml);
		}
		return $returnhtml;
	}

	//render outer tpl
	function renderFrame($file, $html){
		$template = new template($file, array('html'=>$html));
		$html = $template->fetch();
		$template = null;
		return $html;
	}

	//render a modal
	function renderModal($block){
		include_once self::$modal_path . $block . '.php';
		$blockobj = new $block;
    if(isset($_POST['form_name']) && $_POST['form_name'] == $block){
      $data = $blockobj->processForm();
    }
    $data = $blockobj->process();
    $data['tpl'] = (!$data['tpl']) ? $block . '_default.tpl' : $data['tpl'];
		$file = self::$tpl_path . '/modals/' . $data['tpl'] ;
		$template = new template($file, $data);
		$html = $template->fetch();
		$template = null;
		return $html;
	}

	//render a single block
	function renderBlock($block){
		isset(view::$blockrepeat[$block]) ? view::$blockrepeat[$block]++ : view::$blockrepeat[$block] = 1;
		include_once self::$block_path . $block . '.php';
		$blockobj = new $block;
		if(view::$callback){
			$cb = view::$callback;
			$r = $cb($block,$blockobj);
		}
    if(isset($_POST['form_name']) && $_POST['form_name'] == $block){
      $data = $blockobj->processForm();
    }
    $data = $blockobj->process();
    if(!isset($data['tpl']))  $data['tpl'] = $block . '_inner_default.tpl';
		$data['frame'] = (isset($data['frame'])) ? self::$tpl_path.'/frames/' . $data['frame'] : '';
		if(view::$renderMode == 'lazyloading' && !$blockobj->keep_frame) unset($data['frame']);
		$file = self::$tpl_path . '/' . $data['tpl'] ;
		$template = new template($file, $data);
		$html = $template->fetch();
		$template = null;
		return $html;
	}

	//render block in HTML format
	function renderHTML($block){


	}

	//render block in json format
	function renderJSON(){


	}

	//prepare debug information - used for mudule wise rendering information
	function debugInfo(){


	}

	//logs the visit information in DB for review
	function trackVisits(){


	}

	//used to optimize CSS and JS files input at runtime, optimizes once and cached for next requests
	private function optimize($content){



	}
}
