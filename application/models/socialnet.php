<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Socialnet extends CI_Model{
	
	public $api_id;
	protected $api_key;
	protected $prefix_table;
	public $owner_id;
	public $activity;
	public $users_table = 'users';
	public $albums_table = 'albums';
	public $photos_table = 'photos';
	public $num_albums;
	protected $local_owner_id;

	
	 public function __construct() {
	 	parent::__construct();

	}	
	
	function init(){
		if(!$this->prefix_table)
			return false;
		$settings = $this->get_settings($this->prefix_table);
		if($settings){
			$this->api_id = $settings['api_id'];
			$this->api_key = $settings['api_key'];
			if($settings['api_private_key'])
				$this->api_private_key = $settings['api_private_key'];
			$this->activity = $settings['active'];
		}
		else{
			$this->api_id = $this->config->item($this->prefix_table.'_id'); // Insert here id of your application
			$this->api_key = $this->config->item($this->prefix_table.'_key'); // Insert here secret key of your application
			if($this->prefix_table == 'ok')
				$this->api_private_key = $this->config->item($this->prefix_table.'_private_key');
			$this->activity = 1; 
		}
		
		$this->users_table = $this->prefix_table.'_'.$this->users_table;
		$this->albums_table = $this->prefix_table.'_'.$this->albums_table;
		$this->photos_table = $this->prefix_table.'_'.$this->photos_table;
		if(!$this->config->item('is_work')){
			$this->owner_id = $this->local_owner_id;
			$this->num_albums = $this->count_albums();
		}
		
	}
	
	function is_empty_album($owner_id){
		$sql = "SELECT COUNT(*) AS num FROM ".$this->photos_table." WHERE owner_id = $owner_id";
		$res = $this->db->query($sql);
		if(!$res || !$res->row()->num)
			return true;
		return false;
	}
	
	function get_photos_by_album_id($album_id){
		$this->db->order_by('date','DESC');
		$res = $this->db->get_where($this->photos_table,array('album_id' => $album_id));
		if(!$res || $res->num_rows() < 1)
			return array();
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			if($value['photo_2560'])
				$arr[$key]['image'] = $value['photo_2560'];
			elseif($value['photo_1280'])
				$arr[$key]['image'] = $value['photo_1280'];
			elseif($value['photo_807'])
				$arr[$key]['image'] = $value['photo_807'];
			elseif($value['photo_604'])
				$arr[$key]['image'] = $value['photo_604'];
			
			if(strlen($value['photo_75']) > 1)
				$arr[$key]['image_preview'] = $value['photo_75'];
			elseif(strlen($value['photo_130']) > 1)
				$arr[$key]['image_preview'] = $value['photo_130'];
		}
		
		return $arr;
		
	}
	
	
	function count_albums(){
		$this->db->where('owner_id',$this->owner_id);
		$this->db->from($this->albums_table);
		$num = $this->db->count_all_results();
		return $num;
	}
	
	function get_album_by_id($id){
		$res = $this->db->get_where($this->albums_table,array('id' => $id, 'owner_id' => $this->owner_id));
		if(!$res || $res->num_rows() < 1)
			return false;
		return $res->row_array();
	}
	
	function get_current_albums_ids(){
		$this->db->select('id');
		$this->db->from($this->albums_table);
		$this->db->where('owner_id',$this->owner_id);
		$res = $this->db->get();
		if($res->num_rows() > 0){
			$arr = array();
			foreach($res->result_array() as $elem){
				$arr[] = $elem['id'];
			}
			if(count($arr) > 0)
				return $arr;
		}
		return false;
	}
	
	function is_exists_user_albums(){
		$this->db->where('owner_id',$this->owner_id);
		$this->db->from($this->albums_table);
		if($this->db->count_all_results() > 0)
			return true;
		return false;
	}
	
	function is_exists_user_photos(){
		$this->db->where('owner_id',$this->owner_id);
		$this->db->from($this->photos_table);
		if($this->db->count_all_results() > 0)
			return true;
		return false;
	}
	
	function get_current_albums(){
		$this->db->select('id,owner_id,title');
		$this->db->from($this->albums_table);
		$this->db->where('owner_id',$this->owner_id);
		$this->db->order_by('created','DESC');
		$res = $this->db->get();
		if(!$res || $res->num_rows() < 1)
			return array();
		return $res->result_array();
	}
	
	function copy_photo($id=null,$owner_id,$album_id,$local_album_id=null){
		if($id)
			$res = $this->db->get_where($this->photos_table,array('id' => $id, 'owner_id' => $owner_id, 'album_id' => $album_id));
		else
			$res = $this->db->get_where($this->photos_table,array('owner_id' => $owner_id, 'album_id' => $album_id));
		$res_select = $res;
		if(!$res || $res->num_rows() < 1)
			return false;
		if(!$id){
			$res_album = $this->db->get_where($this->albums_table,array('id' => $album_id));
			if(!$res_album || $res_album->num_rows() < 1)
				return false;
			$album_net = $res_album->row();
			if($album_net->owner_id != $owner_id)
				return false;
				$album = $this->my_albums->get_album_by_name($album_net->title,$this->my_auth->user_id);
			if(!$album){
				$is_exists_album = false;	
				if(isset($_POST['name']))
					$name = $_POST['name'];
				else
					$name = $album_vk->title;
					
				if(isset($_POST['description']))
					$description = $_POST['description'];
				else
					$description = $album_vk->description;
				if(isset($_POST['access']) && in_array($_POST['access'],array('public','protected','private')))
					$access_album = $_POST['access']	;
				else
					$access_album = 'private';
				if(isset($_POST['password']))
					$password = md5($_POST['password']);
				else
					$password = null;
				
				$data_album = array(
				'id' => null,
				'name' => $name,
				'description' => $description,
				'added' => date('Y-m-d H:i:s'),
				'access' => $access_album,
				'user_id' => $this->my_auth->user_id,
				'password' => $password,
				'net_id' => $album_id,
				'type_net' => $this->prefix_table
				);
				$res_insert = $this->db->insert($this->my_albums->tablename,$data_album);
				if(!$res_insert)
					return false;
				$local_album_id = $this->db->insert_id();
				if(!$local_album_id)
					return false;
			}
			else{
				$is_exists_album = true;	
				if($album->net_id)
					$local_album_id = $album->id;
				else
					return false;

			}
			
		}
		
		$access_album = $this->my_albums->get_access_album($local_album_id);
		$counter = 1;
		
		foreach($res->result() as $image):
			
		$id = $image->id;
		
		if($image->photo_2560)
			$src_big = $image->photo_2560;
		elseif($image->photo_1280)
			$src_big = $image->photo_1280;
		elseif($image->photo_807)
			$src_big = $image->photo_807;
		elseif($image->photo_604)
			$src_big = $image->photo_604;
		elseif($image->photo_130)
			$src_big = $image->photo_130;
			
		if(empty($src_big))
			continue;
		if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
			mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
		}
		if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
			mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
		}
		$filename = get_filename_from_url($src_big);
		if($this->prefix_table == 'ok'){
			$ext = 'jpg';
		}
		else{
			$ext = pathinfo($src_big, PATHINFO_EXTENSION);
			if(strstr($ext,'?') != ''){
				$buffer = explode('?',$ext);
				$ext = $buffer[0];
			}
		}
		
		$hash = $this->members->user_id.'_'.md5($filename.'.'.$ext);
		$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
		$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;
		$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
		$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
		$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
		$filename_src_html = '/image/'.$buffer_filename_url;
		$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";

		if(copy($src_big,$filename_destiny)){
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
			}
			ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview);
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
			}
			if($image->photo_75)
				$res_preview = copy($image->photo_75,$filename_destiny_preview_80);
			else
				$res_preview = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);
			$data_create = date('Y-m-d H:i:s');
			////////////////////////////////////////// Проверяем, существует ли запись о картинке в таблице /////////////////////
			$this->db->where('user_id',$this->my_auth->user_id);
			$this->db->where('net_id',$id);
			$this->db->from($this->members->images_table);
			$sql_count = "SELECT COUNT(*) AS num FROM ".$this->members->images_table." WHERE user_id = ".$this->my_auth->user_id." AND net_id = $id AND album_id = $local_album_id";
			$res_count = $this->db->query($sql_count);
			
			if(!$res_count || $res_count->row()->num == 0)	{
				
				$parameters = array(
				'id' => null,
				'url' => $filename_src_big,
				'main_url' => $filename_src_html,
				'filename' => $hash,
				'show_filename' => $hash,
				'size' => filesize($filename_destiny),
				'width' => $image->width,
				'height' => $image->height,
				'user_id' => $this->members->user_id,
				'added' => $data_create,
				'comment' => $image->description,
				'exif' => null,
				'tag_id' => null,
				'album_id' => $local_album_id,
				'access' => $access_album,
				'net_id' => $id
				);
				$sql = $this->db->insert_string($this->members->images_table,$parameters);
				$res_insert = $this->db->query($sql);
				if(!$res_insert)
					$sql .= " ON DUPLICATE KEY UPDATE album_id = $local_album_id";
				$res_insert = $this->db->query($sql);		
				
			}
			else{
				$parameters = array(
				'size' => filesize($filename_destiny),
				'width' => $image->width,
				'height' => $image->height,
				'comment' => $image->text,
				);
				$res_update = $this->db->update($this->members->images_table,$parameters);

			}
		}
		$counter++;
		endforeach;
		
		return $res_select;
	}
	
	
	function get_settings($net = null){
		if($net){
			$res = $this->db->get_where('socialnet_settings',array('prefix' => $net));
		}
		else{
			$res = $this->db->get('socialnet_settings');
		}
		if(!$res)
			return false;
		if($net)
			return $res->row_array();
		else
			return $res->result_array();
	}
	
	function set_settings($net,$data){
		$arr = array(
		'api_key' => $data['api_key'],
		'api_id' => $data['api_id'],
		'api_private_key' => $data['api_private_key']
		);
		if(isset($data['use']))
			$arr['active'] = 1;
		else
			$arr['active'] = 0;
		$this->db->where('prefix',$net);
		$res = $this->db->update('socialnet_settings',$arr);
		return $res;
		
	}
	
	function get_api_id($net){
		$this->db->select('api_id');
		$this->db->where('prefix',$net);
		$res = $this->db->get('socialnet_settings');
		if(!$res)
			return false;
		return $res->row()->api_id;
	}
	
}
?>