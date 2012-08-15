<?php
class imagegrab {


	public $source_url;
	public $dest_path;

	public function download() {
	
		if($this->http_test_existance()) {
		
			if($file_data = $this->http_get_file()) {
				
				$handle = fopen($this->dest_path, 'w');
				fwrite($handle, $file_data);
				fclose($handle);
			}
		}
	}

	
	public function http_get_file() {
	
		$url_stuff = parse_url($this->source_url);
		$port = isset($url_stuff['port']) ? $url_stuff['port']:80;
		$fp = fsockopen($url_stuff['host'], $port);
		if (!$fp) {
			
			return false;
		} 
		else {
			
			$query = 'GET ' . $url_stuff['path'] . " HTTP/1.0\n";
			$query .= 'Host: ' . $url_stuff['host'];
			$query .= "\n\n";
			fwrite($fp, $query);
			while ($line = fread($fp, 1024)) {
				$buffer .= $line;
			}
			preg_match('/Content-Length: ([0-9]+)/', $buffer, $parts);
			fclose($fp);
			return substr($buffer, - $parts[1]);
		}
	}
	
	public function http_test_existance() {
		
		return (($fp = @fopen($this->source_url, 'r')) === false) ? false : @fclose($fp);
	}
			
}
	
/*$obj = new imagegrab();
$obj->source_url = 'http://userserve-ak.last.fm/serve/_/6021/Kishore+Kumar.jpg';
$obj->dest_path = 'as.png';
$obj->download();*/