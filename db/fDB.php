<?php
/*
 * @desc Handles all Database communication with multiple servers
 * supports read write switch and multiple set of connections within single class
 *
 */

Class fDB
{
	static $_link = array();

	function __construct(){

	}

	/*
	* @desc Connect to MySQL Server
	* @param int $dsn_key  for $_dsn array key to select the database
	* @param char $query_type 'r' for read connection, 'w' for write connection
	*/
	private static function connect($dsn_key, $query_type) {
		global $DSN;
		if(!isset(fDB::$_link[$dsn_key][$query_type])){
			$dsninfo = $DSN[$dsn_key][$query_type];
			$_link[$dsn_key][$query_type] = mysql_connect($dsninfo['host'], $dsninfo['user'], $dsninfo['password']) or
			die(" Throwing exception DB_CONNECTION_FAILED | Message: Couldn't connect to Server");
			if(!mysql_select_db($dsninfo['db'], $_link[$dsn_key][$query_type])) {
				die(" Throwing exception DB_SELECTION_FAILED | Message: Couldn't connect to Database");
			}
			fDB::$_link[$dsn_key][$query_type] = $_link[$dsn_key][$query_type];
		}
	}

	private static function close($dsn_key, $query_type) {
		if(!mysql_close(fDB::$_link[$dsn_key][$query_type])){
			die(" Throwing exception DB_CLOSE_FAILED | Message: Connection close failed");
		}
	}

	/*
	* @desc to escape text/data
	* @param string/array $string
	* @return string/array escaped data
	*/
	private static function escapeData($string) {
		if(get_magic_quotes_runtime()){
			$string = stripslashes($string);
		}
		return mysql_real_escape_string($string);
	}

	/*
	* @desc to remove slashes from the text
	* @param string/array $string
	* @return string/array clean stripped data
	*/
	private static function removeSlashes($string) {
		if(!get_magic_quotes_runtime()){
			return is_array($string) ?
						array_map(array('fDB','removeSlashes'), $string) :
						stripslashes($string);
		}
	}

	/*
	* @desc Executes an SQL statement
	* @param string $sql is the required parameter
	* @param array $args for all variables in the query
	* @param int $dsn_key  for $_dsn array key to select the database
	* @param char $query_type 'r' for read connection, 'w' for write connection
	* @return string result set
	*/
	public static function query($sql, $args = array(), $dsn_key = 0, $query_type = '', $cache_life = '') { //Logger::log($sql);
		$matches = substr_count ($sql,'?');
		if($matches != count($args) && count($args > 0)){
			//Logger::log(" Throwing exception DB_DATAMATCH_FAILED | Message: Argument mismatch");
		}


		if($query_type == ''){
			$query_type = fDB::get_query_type($sql);
		}

		//get data from memcache if read query and cache can be used
		if($query_type == 'r' && $cache_life){
			$key = $sql . $dsn_key;
			$query_res = fCache::get($key);
			if($query_res) return $query_res;
		}

		fDB::connect($dsn_key, $query_type);
    foreach((array)$args as $k=>$v){
      $args[$k] = fDB::escapeData($v);
    }
		$sql = self::prepare_query($sql, $args);
    $sql_type = strtolower(substr(trim($sql),0,6));
    //echo "<br>SQL: ".$sql; if(strtolower(substr(trim($sql),0,6))=='insert' || strtolower(substr(trim($sql),0,6))=='update'){ die(); }
    if($sql_type !="" && $sql_type!='select'){
      cms_activity_log($sql_type, $sql);
    }
		$query = mysql_query($sql, fDB::$_link[$dsn_key][$query_type]);
    //echo "<br>".$sql;
		if (!$query) {
			die(mysql_error() . "<br/>Query:: $sql");
			//Logger::log(" Throwing exception DB_QUERY_FAILED | Message: ".mysql_error()." | Query: ".$sql);
			return 0;
		}
		//set the response in fCache
		if($query_type == 'r' && $cache_life)$query_res = fCache::set($sql.$dsn_key,$query,$cache_life);

		return $query;
	}

	/*
	* @desc to get the result array from SQL statement
	* @param string $sql is the required parameter
	* @param array $args for all variables in the query
	* @param int $dsn_key  for $_dsn array key to select the database
	* @param char $query_type 'r' for read connection, 'w' for write connection
	* @return array with number of records and data
	*/
	public static function fetch_assoc_all($sql, $args = array(), $dsn_key = 0, $query_type = ''){
		$result = self::query($sql, $args, $dsn_key, $query_type);

		if($result){
			$return = array();
			$affected_rows = mysql_affected_rows();
			while($row = mysql_fetch_assoc($result)){
				$return[] = fDB::removeSlashes($row);
			}
			fDB::free_result($result);
			return array('numRecords' => $affected_rows, 'result' => $return);
		}
	}

	/*
	* @desc to get the single row result array from SQL statement
	* @param string $sql is the required parameter
	* @param array $args for all variables in the query
	* @param int $dsn_key  for $_dsn array key to select the database
	* @param char $query_type 'r' for read connection, 'w' for write connection
	* @return array with result data
	*/
	public static function fetch_assoc_first($sql, $args = array(), $dsn_key = 0, $query_type = ''){
    $rows = self::fetch_assoc_all($sql, $args , $dsn_key, $query_type);
		if($rows['numRecords']>0){
			return $rows['result'][0];
		}
	}

	/*
	* @desc to get last inserted id
	* @return int inserted id
	*/
	public static function inserted_id($dsn_key = 0) {
		$id = fDB::fetch_assoc_first("SELECT LAST_INSERT_ID() as last", array(), 0, 'r');
		return $id['last'];
	}

	/**
     * Free query result resource.
     * @param string $query The query to take action.
     */
    private static function free_result($query) {
        return mysql_free_result($query);
    }

	/*
	* @desc parse sql query type
	* @param string sql query
	* @return char 'r' for read connection, 'w' for write connection
	*/
	private static function get_query_type($sql){
		$qtype = current(explode(' ',trim($sql)));
		if(strtoupper($qtype) == "SELECT"){
			return 'r';
		}else{
			return 'w';
		}
	}

	/*
	* @desc prepares the query with the parameters passed
	* @return string sql statement
	*/
	private static function prepare_query($sql, $args){
		$sql_res = '';
		if(count($args)){
			foreach($args as $v){
				$sql_ar = self::str_replace_once('?', "'$v'", $sql);
				$current_position = $sql_ar['position'] + strlen($v)+2;
				$sql_res .= substr($sql_ar['string'], 0, $current_position);
				$sql = substr($sql_ar['string'], $current_position);
			}
			$sql_res .= $sql;
		}else{
			$sql_res = $sql;
		}
		return $sql_res;
	}

	/*
	* @desc replace the first occurance of pattern in the given string
	* @return string with the replaced characters
	*/
	private static function str_replace_once($str_pattern, $str_replacement, $string){
		$occurrence = strpos($string, $str_pattern);
		if ($occurrence !== false){
			return array('string' => substr_replace($string, $str_replacement, $occurrence, strlen($str_pattern)), 'position' => $occurrence);
		}
		return $string;
	}

}
