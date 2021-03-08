<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//////////////////////////// Класс, реализующий соединение с Одноклассниками //////////////////////////////////////////////////////	
	
class OK extends Socialnet{
	
	public $main_domain = 'http://odnoklassniki.ru';
	public $sync_to_local = false;
	protected $prefix_table = 'ok';
	protected $api_private_key;
	protected $local_owner_id = 566335622587;
	public $instance;
	
	
	function __construct(){
		parent::__construct();
		$this->init();
		$this->load->library('ok_api');
		if(isset($_SESSION['ok_owner_id']))
			$this->owner_id = $_SESSION['ok_owner_id'];
		elseif($this->members->ok_profile)
			$this->owner_id = $this->members->ok_profile;
		if($this->owner_id)	
			$this->num_albums = $this->count_albums();
	}
	
	function get_configs(){

		$response['api_id'] = $this->api_id;
		$response['api_key'] = $this->api_key;
		$response['api_private_key'] = $this->api_private_key;
		return $response;
	}
	
	function get_object(){
		$ok = new OK_API(
		array(
			'client_id' => $this->api_id,
			'application_key' => $this->api_key,
			'client_secret' => $this->api_private_key
		)
	);
		$this->instance = $ok;
	}
	
	function set_current_user(){
		if(!$this->instance)
			return false;
		if(isset($_SESSION['ok']['set_user']) && $this->members->ok_profile)
			return false;
		$ok = $this->instance;
		try {
			$user = $ok->api('users.getCurrentUser');
			if(count($user) > 0){
				if($user['gender'] == 'male')
					$gender = 2;
				elseif($user_profile['gender'] == 'female')
					$gender = 1;
				if(count($user['location']) > 0){
					$location = '';
					if(isset($user['location']['city']))
						$location .= $user['location']['city'].' ';
					if(isset($user['location']['countryName']))
						$location .= $user['location']['countryName'].' ';
				}
				else{
					$location = '';
				}
				$data = array(
				'id' => $user['uid'],
				'name' => $user['name'],
				'first_name' => $user['first_name'],
				'last_name' => $user['last_name'],
				'gender' => $gender,
				'link' => $this->main_domain.'/profile/'.$user['uid'],
				'location' => $location,
				'birthday' => $user['birthday']
				);
				$sql = $this->db->insert_string($this->users_table,$data);
				$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
			
				$res = $this->db->query($sql);
				if($res){
					$sql = "UPDATE users SET ok = '".$user['uid']."' WHERE id = ".$this->my_auth->user_id." AND (ok != '".$user['uid']."' OR ok IS NULL)";
					$res_update = $this->db->query($sql);
					if(!$this->members->ok_profile)
						$this->members->ok_profile = $user['uid'];
				}
				$_SESSION['ok']['set_user'] = 1;
				if(!$this->owner_id)
					$this->owner_id = $user['uid'];
				return $res;
			}
		}
		catch(Exception $e){
			return false;
		}
		
	}
	
	function set_current_albums(){
		if(!$this->instance)
			return false;
		if(isset($_SESSION['ok']['set_albums']))
			return false;
		$ok = $this->instance;
		try{
			$albums = $ok->api('photos.getAlbums',array('fields' => 'album.aid,album.user_id,album.title,album.description,album.created_ms,album.comments_count,album.photos_count,album.type,album.like_summary'));
			if(count($albums['albums']) > 0){
				foreach($albums['albums'] as $album){
					
					$data = array(
					'id' => (int)$album['aid'],
					'owner_id' => (int)$album['user_id'],
					'title' => $album['title'],
					'description' => $album['description'],
					'created' => $album['created_ms'],
					'size' => (int)$album['photos_count'],
					'comments_count' => (int)$album['comments_count']
					);
					$sql = $this->db->insert_string($this->albums_table,$data);
					$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
					$res = $this->db->query($sql);

				}
				$_SESSION['ok']['set_albums'] = 1;

			}
		}
		catch(Exception $e){
			return false;
		}
	}
	
	function get_photo_info($ok,$photo_id){
		try{
			$photo = $ok->api('photos.getPhotoInfo',array('photo_id' => $photo_id,'fields' => 'photo.created_ms,photo.pic1024x768,photo.standard_width,photo.standard_height,photo.text'));
			return $photo['photo'];
		}
		catch(Exception $e){
			return false;
		}

	}
	
	function set_photos_by_album($ok,$album_id){
		
		
		if(isset($_SESSION['ok']['set_photos']))
			return false;

		try{
			$photos = $ok->api('photos.getPhotos',array('aid' => $album_id));

			foreach($photos['photos'] as $photo){

					$photoInfo = $this->get_photo_info($ok,$photo['id']);
					if(!$photoInfo)
						continue;
						
					if(isset($photoInfo['text']))
						$text = $photoInfo['text'];
					else
						$text = '';
							
					if($photoInfo['pic1024x680'])	{
						$width = $photoInfo['standard_width'];
						$height = $photoInfo['standard_height'];
					}
					
					$data = array(
					'id' => (int)$photo['id'],
					'album_id' => (int)$album_id,
					'owner_id' => (int)$this->owner_id,
					'photo_75' => $photo['pic50x50'],
					'photo_130' => $photo['pic128x128'],
					'photo_360' => null,
					'photo_604' => null,
					'photo_807' => $photo['pic640x480'],
					'photo_1280' => $photoInfo['pic1024x768'],
					'photo_2560' => null,
					'width' => $photoInfo['standard_width'],
					'height' => $photoInfo['standard_height'],
					'text' => $text,
					'date' => $photoInfo['created_ms']
					);
					$sql = $this->db->insert_string($this->photos_table,$data);
					$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
					$res = $this->db->query($sql);
				}
					$_SESSION['ok']['set_photos'] = 1;
	
		}
		catch(Exception $e){
			return false;
		}
	}
	
}

?>