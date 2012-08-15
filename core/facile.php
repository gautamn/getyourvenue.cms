<?php
/**
* Framework core class - contains the definition and functionality at framework level.
*/
class facile{
	
	function __construct(){
		
	}
	
	//execute process in background
	function executeBg($file,$data, $extra = null ){
		$cachethread = md5($data); //create a unique key for data
		fCache::save($data,$file); //save the data in memory to be used by the thread
		$command = "$file $cachethread '$extra' &"; //create command passing the key to data
		shell_exec($command);
	}
	
	
	
	
	function __destruct(){
		
	}
}