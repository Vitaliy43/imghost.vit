<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Bitly extends CI_Model{
	
	public $key;
	public $login;
	
	function __construct(){
		
		$this->key = $this->config->item('bitly_key');
		$this->login = $this->config->item('bitly_user');	
	}
	
	function get_url($url){
        $apiURL = 'http://api.bit.ly/shorten?version=2.0.1&longUrl='.$url.'&login='.$this->login.'&apiKey='.$this->key; 
        $API = file_get_contents($apiURL);
        $bitlyInfo = json_decode(utf8_encode($API),true); 
		if (!($bitlyInfo['errorCode']==0)) return false;
		if (isset($bitlyInfo['results'][urldecode($url)]['shortUrl'])) return $bitlyInfo['results'][urldecode($url)]['shortUrl'];
        return false; 
	}
	
}

?>