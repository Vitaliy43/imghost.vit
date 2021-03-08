<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Exif extends CI_Model{
	
	function parse($info){
		$arr = array();
		$language = Language::get_languages('exif');
		$buffer = explode(';',$info);
		
		foreach($buffer as $elem){
			$row = explode(':',$elem);
			$key = trim($row[0]);
			if(isset($language[$key])){
				$arr[$key]['value'] = trim($row[1]);
				$arr[$key]['name'] = $language[$key];
			}
		}
		return $arr;
	}
	
}

?>