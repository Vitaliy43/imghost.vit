<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output {


			
	function set_status_header($code = '200', $text = '', $json_output = false)
	{
		
			
		$stati = array(
							'200'	=> 'OK',
							'201'	=> 'Created',
							'202'	=> 'Accepted',
							'203'	=> 'Non-Authoritative Information',
							'204'	=> 'No Content',
							'205'	=> 'Reset Content',
							'206'	=> 'Partial Content',
							
							'300'	=> 'Multiple Choices',
							'301'	=> 'Moved Permanently',
							'302'	=> 'Found',
							'304'	=> 'Not Modified',
							'305'	=> 'Use Proxy',
							'307'	=> 'Temporary Redirect',
							
							'400'	=> 'Bad Request',
							'401'	=> 'Unauthorized',
							'403'	=> 'Forbidden',
							'404'	=> 'Not Found',
							'405'	=> 'Method Not Allowed',
							'406'	=> 'Not Acceptable',
							'407'	=> 'Proxy Authentication Required',
							'408'	=> 'Request Timeout',
							'409'	=> 'Conflict',
							'410'	=> 'Gone',
							'411'	=> 'Length Required',
							'412'	=> 'Precondition Failed',
							'413'	=> 'Request Entity Too Large',
							'414'	=> 'Request-URI Too Long',
							'415'	=> 'Unsupported Media Type',
							'416'	=> 'Requested Range Not Satisfiable',
							'417'	=> 'Expectation Failed',
		
							'500'	=> 'Internal Server Error',
							'501'	=> 'Not Implemented',
							'502'	=> 'Bad Gateway',
							'503'	=> 'Service Unavailable',
							'504'	=> 'Gateway Timeout',
							'505'	=> 'HTTP Version Not Supported'
						);

		if ($code == '' OR ! is_numeric($code))
		{
			show_error('Status codes must be numeric');
		}

		if (isset($stati[$code]) AND $text == '')
		{				
			$text = $stati[$code];
		}
		
		if ($text == '')
		{
			show_error('No status text available.  Please check your status code number or supply your own message text.');
		}
		
		$server_protocol = (isset($_SERVER['SERVER_PROTOCOL'])) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;
		
		if($json_output){
			/*
			if(isset($_POST['current_form']))
				$response['form_number'] = $_POST['current_form'];
			else
				$response['form_number'] = 'upload-multi-links';
			$response['error'] = $text;
			echo json_encode($response);
			exit;
			*/
			return $text;
		}
			

	
		if (substr(php_sapi_name(), 0, 3) == 'cgi')
		{
			header("Status: {$code} {$text}", TRUE);
		}
		elseif ($server_protocol == 'HTTP/1.1' OR $server_protocol == 'HTTP/1.0')
		{
			header($server_protocol." {$code} {$text}", TRUE, $code);
		}
		else
		{
			header("HTTP/1.1 {$code} {$text}", TRUE, $code);
		}
	}
    

}

?>