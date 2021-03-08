<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class FB extends Socialnet{
	
	public $main_domain = 'http://facebook.com';
	public $sync_to_local = false;
	protected $local_owner_id = '553850758073902';
	protected $prefix_table = 'fb';
	
	
	function __construct(){
		parent::__construct();
		$this->init();
		$this->load->library('facebook_api/src/facebook');
		$facebook = new Facebook(array(
  			'appId'  => $this->api_id,
  			'secret' => $this->api_key
		));

		$user_id = $facebook->getUser();
		if(!$user_id){
			unset($_SESSION['fb_owner_id']);
			$this->owner_id = $this->members->fb_profile;
			$this->num_albums = $this->count_albums();
			return false;
		}

		if(isset($_SESSION['fb_owner_id']))
			$owner_id = $_SESSION['fb_owner_id'];
		if(empty($owner_id)){
			
			$owner_id = $user_id;
			if(!$owner_id){
				$this->owner_id = $this->members->fb_profile;
				$this->num_albums = $this->count_albums();
				return false;
			}
			$_SESSION['fb_owner_id'] = $owner_id;

		}
		$this->owner_id = $owner_id;
		$this->num_albums = $this->count_albums();
		if(isset($_POST['set_user'])){
			return $this->set_current_user();
		}
		elseif(isset($_POST['set_albums'])){
			return $this->set_current_albums();

		}
		elseif(isset($_POST['set_photos']) && isset($_POST['album_id'])){
			return $this->set_photos_by_album($_POST['album_id']);
		}
	}
	
	function is_connected(){
		$facebook = new Facebook(array(
  		'appId'  => $this->api_id,
  		'secret' => $this->api_key
		));
		$user_id = $facebook->getUser();
		unset($facebook);
		if(!$user_id)
			unset($_SESSION['fb']);
		if($user_id)
			return true;
		return false;
			
	}
		
	
	protected function parse_photos($images){
		$max_height = 0;
		$max_width = 0;
		foreach($images as $image){
			if($image['height'] > $max_height)
				$max_height = $image['height'];
			if($image['width'] > $max_width)
				$max_width = $image['width'];
				
			if($image['width'] >= 2560 || $image['height'] >= 2560)
				$arr['photo_2560'] = $image['source'];
			elseif($image['width'] >= 1280 || $image['height'] >= 1280)
				$arr['photo_1280'] = $image['source'];
			elseif($image['width'] >= 807 || $image['height'] >= 807)
				$arr['photo_807'] = $image['source'];
			elseif($image['width'] >= 604 || $image['height'] >= 604)
				$arr['photo_604'] = $image['source'];
			elseif($image['width'] >= 360 || $image['height'] >= 360)
				$arr['photo_360'] = $image['source'];
			elseif($image['width'] >= 130 || $image['height'] >= 130)
				$arr['photo_130'] = $image['source'];
			elseif($image['width'] >= 75 || $image['height'] >= 75)
				$arr['photo_75'] = $image['source'];
			
		}
		
		if(empty($arr['photo_2560']))
			$arr['photo_2560'] = '';
		if(empty($arr['photo_1280']))
			$arr['photo_1280'] = '';
		if(empty($arr['photo_807']))
			$arr['photo_807'] = '';
		if(empty($arr['photo_604']))
			$arr['photo_604'] = '';	
		if(empty($arr['photo_360']))
			$arr['photo_360'] = '';
		if(empty($arr['photo_130']))
			$arr['photo_130'] = '';
		if(empty($arr['photo_75']))
			$arr['photo_75'] = '';
		
		
		if(!$max_height || !$max_width)
			return false;
		$arr['height'] = $max_height;
		$arr['width'] = $max_width;
		return $arr;
	}
	
	function set_photos_by_album($album_id){
		
		if(!$album_id)
			return false;
		$parameters = $_POST['parameters'];
		$photos = json_decode($parameters,true);

		if(count($photos['data']) > 0){
			foreach($photos['data'] as $photo){
				$images = $this->parse_photos($photo['images']);
				if(!$images)
					continue;
				if(isset($photo['name']))
					$text = $photo['name'];
				else
					$text = '';
					
				if(!$images['photo_75']){
					$ext = pathinfo($photo['picture'], PATHINFO_EXTENSION);
					if(strstr($ext,'?') != ''){
						$buffer = explode('?',$ext);
						$ext = $buffer[0];
					}

					$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR.'fb'.DIRECTORY_SEPARATOR.md5($photo['id']).'.'.$ext;
					$filename_destiny_url = IMGURL.'/thumbnails/fb/'.md5($photo['id']).'.'.$ext;
					if(!file_exists($filename_destiny))
						ImageHelper::resizeimg($photo['picture'],$filename_destiny,80);
					$photo_75 = $filename_destiny_url;
				}
				else
					$photo_75 = $images['photo_75'];
				$data = array(
				'id' => (int)$photo['id'],
				'album_id' => $album_id,
				'owner_id' => $this->owner_id,
				'photo_75' => $photo_75,
				'photo_130' => $images['photo_130'],
				'photo_360' => $images['photo_360'],
				'photo_604' => $images['photo_604'],
				'photo_807' => $images['photo_807'],
				'photo_1280' => $images['photo_1280'],
				'photo_2560' => $images['photo_2560'],
				'width' => $images['width'],
				'height' => $images['height'],
				'text' => $text,
				'date' => parse_fb_time($photo['created_time'])
				);
				$sql = $this->db->insert_string($this->photos_table,$data);
				$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
				
				$res = $this->db->query($sql);
				
			}
			return true;
		}
		return false;
	}
	
	function set_current_albums(){

		if($this->is_connected() && isset($_SESSION['fb']['set_albums']))
			return false;
		$parameters = $_POST['parameters'];
		$albums = json_decode($parameters,true);

		if(count($albums['data']) > 0){
			foreach($albums['data'] as $album){
				$created = parse_fb_time($album['created_time']);
				$updated = parse_fb_time($album['updated_time']);
				if($album['can_upload'])
					$can_upload = 1;
				else
					$can_upload = 0;
				$data = array(
				'id' => (int)$album['id'],
				'owner_id' => $this->owner_id,
				'title' => $album['name'],
				'link' => $album['link'],
				'location' => $album['location'],
				'privacy' => $album['privacy'],
				'count' => (int)$album['count'],
				'created' => $created,
				'updated' => $updated,
				'can_upload' => $can_upload
				);
				$sql = $this->db->insert_string($this->albums_table,$data);
				$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
				if($can_upload)
					$res = $this->db->query($sql);
				
			}
			$_SESSION['fb']['set_albums'] = 1;
			return true;
		}
		return false;
	}
	
	function set_current_user(){
	 	
		if($this->is_connected() && isset($_SESSION['fb']['set_user']))
			return false;
		$parameters = $this->input->post('parameters');
		$user_profile = json_decode($parameters,true);
		
		if(count($user_profile) > 0){
			if($user_profile['gender'] == 'male')
				$gender = 2;
			elseif($user_profile['gender'] == 'female')
				$gender = 1;
				
			$data = array(
			'id' => $user_profile['id'],
			'name' => $user_profile['name'],
			'first_name' => $user_profile['first_name'],
			'last_name' => $user_profile['last_name'],
			'gender' => $gender,
			'link' => $user_profile['link'],
			'locale' => $user_profile['locale'],
			'timezone' => (int)$user_profile['timezone'],
			'email' => $user_profile['email'],
			'verified' => (int)$user_profile['verified'],
			);
			$sql = $this->db->insert_string($this->users_table,$data);
			$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
			
			$res = $this->db->query($sql);
			if($res){
				$sql = "UPDATE users SET fb = '".$user_profile['id']."' WHERE id = ".$this->my_auth->user_id." AND (fb != '".$user_profile['id']."' OR fb IS NULL)";
				$res_update = $this->db->query($sql);
				if(!$this->members->fb_profile)
					$this->members->fb_profile = $user_id;
			}
			$_SESSION['fb']['set_user'] = 1;
			return $res;
		}
		return false;
	}
	
}


?>