<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class VK extends Socialnet{
	
	public $main_domain = 'http://vk.com';
	public $sync_to_local = false;
	protected $local_owner_id = 6213805;
	protected $prefix_table = 'vk';
	protected $period_sync_photos = 60;
	protected $period_sync_albums = 120;
	
	function __construct(){
		parent::__construct();
		$this->init();
		if(!$this->config->item('is_work'))
			return;
		
		if(isset($_COOKIE['vk_owner_id']))
			$owner_id = $_COOKIE['vk_owner_id'];
		if(empty($owner_id) && isset($_SESSION['vk_owner_id']))
			$owner_id = $_SESSION['vk_owner_id'];
		if(empty($owner_id))
			return;
		$this->owner_id = $owner_id;
		$this->num_albums = $this->count_albums();
		$this->set_current_user();
	}
	
	function upload_server($uri,$buffer_photos){
		$this->db->select('url');
		$this->db->from($this->members->images_table);
		if(strpos($buffer_photos,',')){
			$photos_in = explode(',',$buffer_photos);
			$this->db->where_in('id',$photos_in);
			$type_result = 'multiple';
		}
		else{
			if(!$buffer_photos)
				return false;
			$this->db->where('id',$buffer_photos);
			$type_result = 'simple';

		}
		$res = $this->db->get();
		if(!$res)
			exit;
			
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,$uri); 
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$counter = 1;
		foreach($res->result_array() as $item){
			$field = 'file'.$counter;
			$photo = ImageHelper::url_to_realpath($item['url']);
			$postdata[$field] = "@".$photo;
			$counter++;
		}
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);  //$photo - прямая ссылка на изображение

    	$result = curl_exec($ch);
 
    	if (curl_errno($ch) != 0 && empty($result)) {
        	  curl_close($ch);
			  return false;

   		}
		if(isset($_SESSION['vk']['sync_photos']))
			unset($_SESSION['vk']['sync_photos']);
    	curl_close($ch);
		return $result;
}
	
	
	function get_owner_id_by_profile($profile){
		$url = "http://api.vk.com/method/users.get?v=5.3&user_ids=".$profile;
		$status = check_http_status($url);
		if($status != 200)
			return false;
		$buffer = file_get_contents($url);
		$result = json_decode($buffer,true);
		if(isset($result['response'][0]['id'])){
			return $result['response'][0]['id'];
			
		}
		return false;
	}
	
	function set_current_user(){
		if(isset($_COOKIE['vk_set_user']) && $this->members->vk_profile)
			return false;
		$url = "http://api.vk.com/method/users.get?v=5.3&user_ids=".$this->owner_id.'&fields=domain,photo_50,sex,verified';
		$status = check_http_status($url);
		if($status != 200)
			return false;
		$buffer = file_get_contents($url);
		$result = json_decode($buffer,true);
		if(isset($result['response'][0]['id'])){
			if(isset($result['response'][0]['hidden']))
				$hidden = $result['response'][0]['hidden'];
			else
				$hidden = 0;
			$data = array(
			'link' => $result['response'][0]['domain'],
			'owner_id' => (int)$result['response'][0]['id'],
			'photo_50' => $result['response'][0]['photo_50'],
			'first_name' => $result['response'][0]['first_name'],
			'last_name' => $result['response'][0]['last_name'],
			'gender' => $result['response'][0]['gender'],
			'hidden' => (int)$hidden,
			'verified' => (int)$result['response'][0]['verified']
			);
			$sql = $this->db->insert_string($this->users_table,$data);
			$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
			
			$res = $this->db->query($sql);
			if($res){
				$sql = "UPDATE users SET vk = '".$result['response'][0]['domain']."' WHERE id = ".$this->my_auth->user_id." AND (vk != '".$result['response'][0]['domain']."' OR vk IS NULL)";
				$res_update = $this->db->query($sql);
				if(!$this->members->vk_profile)
					$this->members->vk_profile = $result['response'][0]['domain'];
			}
			setcookie('vk_set_user',1,time()+86400,'/');
			return $res;
		}
		return false;
	}
	
	
	function set_current_photos($album_id){
		$url = "http://api.vk.com/method/photos.get?v=5.3&owner_id=".$this->owner_id."&album_id=$album_id";
		$status = check_http_status($url);
		if($status != 200)
			return false;
		$buffer = file_get_contents($url);
		if(isset($_SESSION['vk']['sync_photos']) && $_SESSION['vk']['sync_photos'] < time())
			return false;

		$result = json_decode($buffer,true);
		foreach($result['response']['items'] as $item){
			$data = array(
			'id' => (int)$item['id'],
			'album_id' => (int)$item['album_id'],
			'owner_id' => (int)$item['owner_id'],
			'width' => (int)$item['width'],
			'height' => (int)$item['height'],
			'text' => $item['text'],
			'date' => (int)$item['date']
			);
			if(isset($item['photo_75']))
				$data['photo_75'] = $item['photo_75'];
			if(isset($item['photo_130']))
				$data['photo_130'] = $item['photo_130'];
			if(isset($item['photo_604']))
				$data['photo_604'] = $item['photo_604'];
			if(isset($item['photo_807']))
				$data['photo_807'] = $item['photo_807'];
			if(isset($item['photo_1280']))
				$data['photo_1280'] = $item['photo_1280'];
			if(isset($item['photo_2560']))
				$data['photo_2560'] = $item['photo_2560'];
			$query = $this->db->insert_string($this->photos_table,$data);
			$query = str_ireplace('INSERT','REPLACE LOW_PRIORITY',$query);
			$res = $this->db->query($query);
			unset($data);
			$_SESSION['vk']['sync_photos'] = time() + $this->period_sync_photos;
		}
	}
	
	function create_album(){
		
		$data = array(
		'id' => (int)$this->input->post('id'),
		'thumb_id' => (int)$this->input->post('thumb_id'),
		'owner_id' => (int)$this->input->post('owner_id'),
		'title' => $this->input->post('title'),
		'description' => $this->input->post('description'),
		'created' => (int)$this->input->post('created'),
		'updated' => (int)$this->input->post('updated'),
		'size' => (int)$this->input->post('size'),
		'can_upload' => (int)$this->input->post('can_upload'),
		);

		$query = $this->db->insert_string($this->albums_table,$data);
		$query = str_ireplace('INSERT','REPLACE LOW_PRIORITY',$query);
		if(!$data['can_upload'])
			return false;
		if(isset($_SESSION['vk']['sync_photos']))
			unset($_SESSION['vk']['sync_photos']);
		return $this->db->query($query);
		
	}
	
	function set_current_user_albums(){
		$url = "http://api.vk.com/method/photos.getAlbums?v=5.3&owner_id=".$this->owner_id;
		$status = check_http_status($url);
		if($status != 200)
			return false;
		if(isset($_SESSION['vk']['sync_albums']) && $_SESSION['vk']['sync_albums'] < time())
			return false;
		$buffer = file_get_contents($url);
		$result = json_decode($buffer,true);
		foreach($result['response']['items'] as $elem){
			$data = array(
			'id' => (int)$elem['id'],
			'thumb_id' => (int)$elem['thumb_id'],
			'owner_id' => (int)$elem['owner_id'],
			'title' => $elem['title'],
			'description' => $elem['description'],
			'created' => $elem['created'],
			'updated' => $elem['updated'],
			'size' => $elem['size']
			);
			if(isset($elem['privacy_view']))
				$data['privacy_view'] = $elem['privacy_view'];
			if(isset($elem['privacy_comment']))
				$data['privacy_comment'] = $elem['privacy_comment'];
			if(isset($elem['can_upload']))
				$data['can_upload'] = $elem['can_upload'];
			if(isset($elem['thumb_src']))
				$data['thumb_src'] = $elem['thumb_src'];
			$query = $this->db->insert_string($this->albums_table,$data);
			$query = str_ireplace('INSERT','REPLACE LOW_PRIORITY',$query);
			if($data['can_upload'])
				$res = $this->db->query($query);
			unset($data);
			$_SESSION['vk']['sync_albums'] = time() + $this->period_sync_albums;

		}
		
	}	
	
	function parse_url_profile($url){
		if(strpos($url,'vkontakte.ru')){
			$buffer = explode('vkontakte.ru/',$url);
			$id = $buffer[1];
		}
		elseif(strpos($url,'vk.com')){
			$buffer = explode('vk.com/',$url);
			$id = $buffer[1];
		}
		if(empty($id))	
			return false;
		return $id;
	}
	
	function authOpenAPIMember() {
  $session = array();
  $member = FALSE;
  $valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
  $app_cookie = $_COOKIE['vk_app_'.$this->api_id];
  if ($app_cookie) {
    $session_data = explode ('&', $app_cookie, 10);
    foreach ($session_data as $pair) {
      list($key, $value) = explode('=', $pair, 2);
      if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
        continue;
      }
      $session[$key] = $value;
    }
    foreach ($valid_keys as $key) {
      if (!isset($session[$key])) return $member;
    }
    ksort($session);

$sign = '';
    foreach ($session as $key => $value) {
      if ($key != 'sig') {
        $sign .= ($key.'='.$value);
      }
    }
    $sign .= $this->api_key;
    $sign = md5($sign);
    if ($session['sig'] == $sign && $session['expire'] > time()) {
      $member = array(
        'id' => intval($session['mid']),
        'secret' => $session['secret'],
        'sid' => $session['sid']
      );
    }
  }
  return $member;
}
	
}
?>