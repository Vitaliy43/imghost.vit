<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
//////////////////////////// Класс, реализующий соединение с Picasa - Google+ //////////////////////////////////////////////////////	
class Pic extends Socialnet {
	
	public $main_domain = 'https://plus.google.com';
	protected $prefix_table = 'pic';
	protected $local_owner_id = '116729139880952900414';
	
	function __construct(){
		parent::__construct();
		$this->init();
		$this->load->library('picasa_api/picasa');
		if(isset($_COOKIE['google_owner_id']))
			$owner_id = $_COOKIE['google_owner_id'];
		elseif(isset($_SESSION['google_owner_id']))
			$this->owner_id = $_SESSION['google_owner_id'];
		elseif($this->members->google_profile)
			$this->owner_id = $this->members->google_profile;
		$this->owner_id = $owner_id;
		if($this->owner_id)
			$this->num_albums = $this->count_albums();
		if(isset($_POST['set_user'])){
			return $this->set_current_user();
		}
	}
	
	function set_current_user(){
		if(isset($_SESSION['pic']['set_user']) && $this->members->google_profile)
			return false;
		if($this->input->post('gender') == 'male')
			$gender = 2;
		elseif($this->input->post('gender') == 'female')
			$gender = 1;
		$data = array(
		'link' => $this->input->post('link'),
		'owner_id' => $this->input->post('id'),
		'image' => $this->input->post('image'),
		'name' => $this->input->post('name'),
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'gender' => $gender,
		'verified' => $this->input->post('verified')
		);
		$sql = $this->db->insert_string($this->users_table,$data);
		$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
			
		$res = $this->db->query($sql);
		if($res){
			$sql = "UPDATE users SET google = '".$this->input->post('id')."' WHERE id = ".$this->my_auth->user_id." AND (google != '".$this->input->post('id')."' OR google IS NULL)";
			$res_update = $this->db->query($sql);
			if(!$this->members->google_profile)
				$this->members->google_profile = $this->input->post('id');
		}
		$_SESSION['pic']['set_user'] = 1;
		if(!$this->owner_id)
			$this->owner_id = $this->input->post('id');
		return $res;
	}
	
	function set_current_albums(){
	
	  if(!$this->owner_id)	
	  	return false;
	  if(!class_exists('Picasa'))	
	  	return false;
	  if(isset($_SESSION['pic']['set_albums']))
			return false;
	  $pic = new Picasa();
	  $account = $pic->getAlbumsByUsername($this->owner_id);
	  $albums = $account->getAlbums();
	  foreach($albums as $album){
	  	$created = parse_fb_time((string)$album->getPublished());
	  	$updated = parse_fb_time((string)$album->getUpdated());
	  	$data = array(
		'id' => (string)$album->getIdnum(),
		'owner_id' => $this->owner_id,
		'title' => (string)$album->getTitle(),
		'link' => (string)$album->getWeblink(),
		'location' => (string)$album->getLocation(),
		'privacy' => (string)$album->getRights(),
		'count' => (string)$album->getNumphotos(),
		'created' => $created,
		'updated' => $updated,
		'can_upload' => 1
		);
		$sql = $this->db->insert_string($this->albums_table,$data);
		$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);
		$res = $this->db->query($sql);
	  }
	     $_SESSION['pic']['set_albums'] = 1;
			return true;

	}
	
	function set_photos_by_album($album_id){
		if(!$album_id)
			return false;
	if(!class_exists('Picasa'))	
	  	return false;
	 if(isset($_SESSION['pic']['set_photos']))
			return false;
	$pic = new Picasa();
	$album = $pic->getAlbumById($this->owner_id,$album_id,null,null,null,null,null,'1600');
	$images = $album->getImages();
	if(count($images) > 0){
		
	foreach($images as $image){
		$width = (int)$image->getWidth();
		$height = (int)$image->getHeight();
		$full_image = (string)$image->getContent();
		if($width > 2560){
			$photo_2560 = $full_image;
			$photo_1280 = null;
			$photo_807 = null;
			$photo_604 = null;
		}
		elseif($width > 1280){
			$photo_2560 = null;
			$photo_1280 = $full_image;
			$photo_807 = null;
			$photo_604 = null;
		}
		elseif($width > 807){
			$photo_2560 = null;
			$photo_1280 = null;
			$photo_807 = $full_image;
			$photo_604 = null;
		}
		elseif($width > 604){
			$photo_2560 = null;
			$photo_1280 = null;
			$photo_807 = null;
			$photo_604 = $full_image;
		}
		$date = (string)$image->getUpdated();
		
		$data = array(
		'id' => (string)$image->getIdnum(),
		'album_id' => $album_id,
		'owner_id' => $this->owner_id,
		'photo_75' => (string)$image->getSmallThumb(),
		'photo_130' => (string)$image->getMediumThumb(),
		'photo_604' => $photo_604,
		'photo_807' => $photo_807,
		'photo_1280' => $photo_1280,
		'photo_2560' => $photo_2560,
		'width' => $width,
		'height' => $height,
		'text' => (string)$image->getDescription(),
		'date' => parse_fb_time($date)
		);
		$sql = $this->db->insert_string($this->photos_table,$data);
		$sql = str_replace('INSERT','REPLACE LOW_PRIORITY',$sql);		
		$res = $this->db->query($sql);
		}
		$_SESSION['pic']['set_photos'] = 1;

		return true;
	}
	return false;	
	}

}

?>