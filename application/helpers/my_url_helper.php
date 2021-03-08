<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('media_url')) {

    function media_url($url = '') {
        $CI = & get_instance();
        $config = $CI->config;

        if (is_array($url)) {
            $uri = implode('/', $url);
        }

        $index_page = $config->slash_item('index_page');
        if ($index_page === '/')
            $index_page = '';

        $return = $config->slash_item('static_base_url') . $index_page . preg_replace("|^/*(.+?)/*$|", "\\1", $url);
        return $return;
    }

}


if (!function_exists('whereami')) {

    function whereami() {
        $CI = & get_instance();
        if ($CI->uri->segment(1)) {
            return 'inside';
        } else {
            return 'mainpage';
        }
    }

}

function check_url($url) {
 if (preg_match('#^http://#i', $url)) {
    $urlArray = parse_url($url);
       if (!$urlArray[port]) $urlArray[port] =  '80';
       if (!$urlArray[path]) $urlArray[path] =  '/';
       $sock = fsockopen($urlArray[host], $urlArray[port], $errnum, $errstr);
       if (!$sock) $res =  'DNS';
       else {
          $dump .=  "GET $urlArray[path] HTTP/1.1\r\n";
          $dump .=  "Host: $urlArray[host]\r\nConnection: close\r\n";
          $dump .=  "Connection: close\r\n\r\n";
          fputs($sock, $dump);
          while ($str = fgets($sock, 1024)) {
             if (preg_match("#^http/[0-9]+.[0-9]+ ([0-9]{3}) [a-z ]*#i", $str))
               $res[code] = trim(preg_replace('#^http/[0-9]+.[0-9]+
([0-9]{3})
[a-z ]*#i',  "\\1", $str));
             if (preg_match("#^Content-Type: #i", $str))
               $res[contentType] = trim(preg_replace("#^Content-Type: #i",
"",
$str));
          }
          fclose($sock);
          flush();
          return $res[code];
       }
 } else $res = "N/A";
 return $res;
}

function get_filename_from_url($url){
	
	$buffer = explode('/',$url);
	$buffer_filename = explode('.',$buffer[count($buffer)-1]);
	if(count($buffer_filename) < 1)
		return false;
	if(count($buffer_filename) > 2){
		array_pop($buffer_filename);
		return implode('.',$buffer_filename);
	}
	else{
		return $buffer_filename[0];
	}
}

function get_relative_url($url){

	$buffer = explode('/image',$url);
	return '/image'.$buffer[1];
}

function get_self_host($url){
	if(stristr($url,IMGURL) != false)
		return true;
	return false;
}

function check_http_status($url,$curl=false)
  {
  	
	if($curl){
		 $user_agent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)';
  		$ch = curl_init();
  		curl_setopt($ch, CURLOPT_URL, $url);
  		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($ch, CURLOPT_VERBOSE, false);
  		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  		$page = curl_exec($ch);

  		$err = curl_error($ch);
  		if (!empty($err))
    		return $err;

  		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  		curl_close($ch);
  		return $httpcode;
	}
	else{
		$headers = get_headers($url);
		$buffer = explode(' ',$headers[0]);
		list($protocol,$response,$text) = $buffer;
		$response = (int)$response;
		return $response;
	}
 

  }
  
  function getTinyUrl($url)  
{  
	  $tinyurl = file_get_contents('http://tinyurl.com/api-create.php?url=' . $url);
      return $tinyurl;
}

function get_show_filename($url){
	$buffer = explode('/',$url);
	if(count($buffer) < 2)
		return $url;
	return $buffer[count($buffer) - 1];
}
  
