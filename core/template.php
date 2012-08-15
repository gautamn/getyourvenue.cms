<?php
/**
* @desc render
*
*/
class template{
	public $frame;
	public $file;
	public $data;
	public $framedata;
	
	//
	function __construct($file, $array= array()){		
		$this->file = $file;	
		if($array) $this->set($array);	
	}
	
	//
	function set($array){
		$this->data = $array;	
		if(isset($array['framedata']) && $array['framedata']){
			$this->framedata = $array['framedata'];			
		}
		if(isset($array['frame'])) $this->frame = $array['frame'];
	}
	
	//
	function fetch(){
		if(isset($this->frame) && $this->frame){ 
			$block = $this->process();
			$this->framedata['innerhtml'] = $block;
			$this->file = $this->frame;
			$this->data = $this->framedata;
			$return = $this->process();
		}else{
			$return = $this->process();
		}	
		return $return;
	}
	//
	private function process(){
		ob_start();
		if($this->data) extract($this->data);
		require $this->file;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function __destruct(){	
	
	}	
}
