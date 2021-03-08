
<?php

if(isset($_GET['close'])){
	echo "
		<script type=\"text/javascript\">
	window.opener.location.reload();
	window.close();
</script>
	";
	exit;
}
$api_id = '1098385664';
$api_key = 'CBAKAJHCEBABABABA';
$api_private_key = '4976E1CC36B36A9612ECB447';
define('BASEPATH',$_SERVER['DOCUMENT_ROOT']);
require_once($_SERVER['DOCUMENT_ROOT'].'/application/libraries/ok_api.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/config/config.php');
session_start();
$res = mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']);
if(!$res)
	die();
mysql_select_db($db['default']['database']);
$user_id = $_SESSION['DX_user_id'];
$result = mysql_query("SELECT * FROM users WHERE id = $user_id");
$username = mysql_result($result,0,'username');
$password = mysql_result($result,0,'password');
	
	$key = $username.'_'.$user_id.'_key';
	$code = $_GET['code'];

	
//	if(empty($_SESSION[$key]) || $_SESSION[$key] != $password)
//		die();
/*
$ok = new OK_API(
		array(
			'client_id' => '1098385664',
			'application_key' => 'CBAKAJHCEBABABABA',
			'client_secret' => '4976E1CC36B36A9612ECB447'
		)
	);
	*/
//	var_dump($config);

	$ok = new OK_API(
		array(
			'client_id' => $api_id,
			'application_key' => $api_key,
			'client_secret' => $api_private_key
		)
	);
	
	
	$buffer = $_SESSION['token_expires'] - mktime();
	echo 'differ '.$buffer.'<br>';
	// закомментировать для получения нового
	if(mktime() < $_SESSION['token_expires']){
		$token = '{"token_type":"session","refresh_token":"'.$_SESSION['redresh_token'].'","access_token":"'.$_SESSION['access_token'].'","expires":'.$_SESSION['token_expires'].'}';
	}
	
	if($token) {
		$ok->setToken($token);
//		$ok->refreshToken();
	} else {
		$ok->setRedirectUrl('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
		if(isset($code)) {
			$ok->getToken($code);
			$_SESSION['refresh_token'] = $ok->token['refresh_token'];
			$_SESSION['access_token'] = $ok->token['access_token'];
			$_SESSION['token_expires'] = $ok->token['expires'];

		} else {
			print '<a href="' . $ok->getLoginUrl(array('VALUABLE ACCESS', 'SET STATUS')) . '">Login!</a>';
			exit();
		}
	}

	
	$user = $ok->api('users.getCurrentUser');
	if(!$user){
		unset($_SESSION['code']);

	}
//	$uid = $data['uid'];
	echo 'user <br>';
	print_r($user);
	echo '<br>';
	$data = $ok->api('group.getUserGroupsV2');
	$groupId = $data['groups'][0]['groupId'];
	$data = $ok->api('group.getMembers', array('uid' => $groupId));
	
	print_r($data);
	
	echo '<br> Albums <br>';
	$albums = $ok->api('photos.getAlbums');
	print_r($albums);
	echo '<br>';
	$albums2 = $ok->api('photos.getAlbums',array('fields' => 'album.photos_count'));
	
	print_r($albums2);
	

?>