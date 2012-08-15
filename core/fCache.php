<?php
define('DEFAULT_CACHE',120);
/**
* Framework core class - contains the definition and functionality at framework level.
*/
class fCache{
	public static $conn;
	public static $cache;
	
	function __construct(){
	}
	
	//connect to the cache server
	function connect(){		
		try{
			self::$cache = new Memcache;
			if(!isset(self::$conn['ip']) && is_array(self::$conn)){
				foreach(self::$conn as $con){
					self::$cache->addServer($con['ip'], $con['port']); 
				}
			}else{
				self::$cache->connect(self::$conn['ip'], self::$conn['port']);	
			}
		}catch(Exception $e){
			
		}
	}
	
	public static function set($key, $data, $expiry = DEFAULT_CACHE){
    if(count(self::$conn)<1){
      return false;
    }
		try{
			$cachekey = md5($key);
			self::$cache->set($cachekey, $data, true, $expiry);
			return $cachekey;	
		}catch(Exception $e){
		
		}
	}

	public static function get($key){
    if(count(self::$conn)<1){
      return false;
    }
		try{
			$cachekey = md5($key);
			$cachedata = self::$cache->get($cachekey);
			$return = $cachedata ? $cachedata : false;
			return $return;
		}catch(Exception $e){
		
		}
	}
	
	function remove($key){
    if(count(self::$conn)<1){
      return false;
    }
		try{
			$cachekey = md5($key);
			return self::$cache->delete($cachekey);		
		}catch(Exception $e){
		
		}
	}
	
	function __destruct(){
		
	}
}
