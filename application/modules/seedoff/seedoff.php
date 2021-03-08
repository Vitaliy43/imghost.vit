<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Seedoff extends MY_Controller {
	
	public $upload_path;
	public $edit_path;
	public $torrents_table = 'torrents';
	public $work_domain = 'seedoff.tv';
	public $local_domain = 'seedoff.vit';
	
	 public function __construct() {
	 	if($this->config->item('is_work')){
			$this->upload_path = 'http://'.$this->work_domain.'/index.php?page=upload&from_imghost=1';
			$this->edit_path = 'http://'.$this->work_domain.'/index.php?page=edit&from_imghost=1';
		}
		else{
			$this->upload_path = 'http://'.$this->local_domain.'/index.php?page=upload&from_imghost=1';
			$this->edit_path = 'http://'.$this->local_domain.'/index.php?page=edit&from_imghost=1';
		}
        parent::__construct();
		$this->load->module('core');
		$this->load->model('seedoff_sync');

        $this->load->language('auth');
        $this->load->helper('url');
        $this->load->library('Form_validation');
        
        $lang = new MY_Lang();
        $lang->load('auth');
		$this->load->library('DX_Auth');
		$this->setUserRole();
		$this->beforeFilter();

    }
    
    function set_filename(){
  		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[2];
        $token = $_REQUEST['token'];
        $filename = $_REQUEST['filename'];
        if($this->my_files->set_filename_by_torrent_id($filename,$torrent_id,$token)){
           $response['answer'] = 1; 
        }
        else{
            $response['answer'] = 0;
        }
        echo json_encode($response);
    }
	
	function torrents_list(){
		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[3];
		if(in_array($_SERVER['REMOTE_ADDR'],$this->seedoff_sync->trusted_ips) && $uriSegments[1] == 'seedoff'){
			$torrents_list = $this->seedoff_sync->images_list_by_torrent($torrent_id);

		}
		elseif(isset($_REQUEST['access_transfer']) && $_REQUEST['access_transfer'] == 'vEBZ)G3Pp'){
			$torrents_list = $this->seedoff_sync->images_list_by_torrent($torrent_id);

		}
		else{
			$torrents_list = $this->seedoff_sync->torrents_list($torrent_id);

		}
		$response = $torrents_list;
		echo $response;
		exit;
	}
	
	
	function remove_cover(){
		
		$torrent_id = $_REQUEST['torrent_id'];
		$token = $_REQUEST['token'];
		$this->seedoff_sync->set_user($token);
		$uploader_level = $this->seedoff_sync->get_level_uploader($torrent_id);
		$is_owner_torrent_id = $this->seedoff_sync->is_owner_torrent_id($torrent_id,$token);

			if(!$uploader_level)
				$uploader_level = 2;

			if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level)
				$enable_remove = true;
			else
				$enable_remove = false;
			if($is_owner_torrent_id)
				$enable_remove = true;
			if(!$enable_remove)
				return false;
				
		$link = $this->edit_path.'&token='.$_REQUEST['token'].'&torrent_id='.$_REQUEST['torrent_id'].'&remove_cover=1';
		$str = file_get_contents($link);
		echo $str;
		exit;
		
	}
	
	function cover(){
		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[3];
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		$sql = "SELECT url FROM ".$guest_table." WHERE id = (SELECT image_id FROM image_covers WHERE torrent_id = $torrent_id)";
		$res = $this->db->query($sql);
		if(!$res || $res->num_rows() < 1){
			echo '';
			exit;
		}
		echo $res->url;
		exit;
	}
	
	function check_torrent(){
		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[2];
		if($this->seedoff_sync->is_exists_torrent($torrent_id))
			$response['answer'] = 1;
		else
			$response['answer'] = 0;
		echo json_encode($response);
		exit;
		
	}
	
	function upload(){
		
		if(empty($_REQUEST['token']) || empty($_REQUEST['number']) || empty($_REQUEST['torrent_id']))
			return false;
		$link = $this->upload_path.'&token='.$_REQUEST['token'].'&number_image='.$_REQUEST['number'].'&torrent_id='.$_REQUEST['torrent_id'];
		if(isset($_REQUEST['cover'])){
			$link .= '&cover='.urlencode($_REQUEST['cover']);
		}
		
		for($i=1;$i<ImageHelper::$max_number_of_files_iframe+1;$i++){
			$index = 'link_'.$i;
			if(isset($_REQUEST[$index])){
				$link .= '&'.$index.'='.urlencode($_REQUEST[$index]);
			}
		}
		
		$str = file_get_contents($link);
		echo $str;
		exit;
	}
	
	function resort_position(){
		
		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[3];
		$token = $_REQUEST['token'];
		$this->seedoff_sync->set_user($token);
		$uploader_level = $this->seedoff_sync->get_level_uploader($torrent_id);
		$is_owner_torrent_id = $this->seedoff_sync->is_owner_torrent_id($torrent_id,$token);
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;

			if(!$uploader_level)
				$uploader_level = 2;

			if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level)
				$enable_resort = true;
			else
				$enable_resort = false;
			if($is_owner_torrent_id)
				$enable_resort = true;

			if(!$enable_resort)
				return false;
				
		$arr = array();
		foreach($_POST as $key=>$value){
			list($empty,$id) = explode('_',$key);
			$position = $value + 1;
			$sql = "UPDATE ".$guest_table." SET position = $position WHERE id = $id";
			$res = $this->db->query("UPDATE ".$guest_table." SET position = $position WHERE id = $id");
			if($res)
				$this->seedoff_sync->update_screen($id, array('position' => $position));
		}
		$this->define_position($torrent_id,$token);
		
		Language::load_language('imagelist');
		Language::load_language('image');
		$lang_main = Language::get_languages('main');
		$lang_images = Language::get_languages('imagelist');
		$lang_image = Language::get_languages('image');
		$files = $this->my_files->get_files_by_torrent_id($torrent_id,$token);
		$data = array(
		'files' => $files,
		'language' => $lang_main,
		'lang_images' => $lang_images,
		'lang_image' => $lang_image,
		'lang_main' => $lang_main,
		'token' => $token,
		'THEME' => $this->theme_path.'/',
		'from_resort' => 1
		);
			if(isset($_REQUEST['display']) && $_REQUEST['display'] == 'table')
				$data['display'] = 'table';
			else
				$data['display'] = 'block';

			
		$response['content'] = $this->get_widget('torrent_files',$data);
		echo json_encode($response);
		exit;
		
	}
	
	protected function define_genres($torrent_id,$token,$arr){
		$data = date('Y-m-d H:i:s');
		if(count($arr) > 0):
			$this->db->delete($this->genres->tablename,array('torrent_id' => $torrent_id));

		foreach($arr as $genre_id){
			$uniq = $torrent_id.' - '.$genre_id;
			$sql = "REPLACE INTO ".$this->genres->tablename." (id,torrent_id,genre_id,data,uniq) VALUES (null,$torrent_id,$genre_id,'$data','$uniq')";
			$res = $this->db->query($sql);	
		}
		endif;
		
		return $res;
	}
	
	protected function define_tags($torrent_id,$token,$tag_id){
	
		$tag_id = (int)$tag_id;
		$torrent_id = (int)$torrent_id;
		if($this->my_files->use_main_table_mode == 2){
			$sql = "UPDATE LOW_PRIORITY ".$this->my_files->main_table." SET tag_id = $tag_id WHERE torrent_id = $torrent_id";
			$res_update = $this->db->query($sql);

		}
		elseif($this->my_files->use_main_table_mode == 1){
			$sql = "UPDATE LOW_PRIORITY ".$this->guests->images_table." SET tag_id = $tag_id WHERE torrent_id = $torrent_id";
			$res_update = $this->db->query($sql);
			$this->db->query("UPDATE LOW_PRIORITY ".$this->my_files->main_table." SET tag_id = $tag_id WHERE torrent_id = $torrent_id");

		}
		else{
			$sql = "UPDATE LOW_PRIORITY ".$this->guests->images_table." SET tag_id = $tag_id WHERE torrent_id = $torrent_id";
			$res_update = $this->db->query($sql);

		}
		
		if($res_update)
			return 'Success';
		else
			return 'Unknown error';	
	}
	
	protected function define_position($torrent_id,$token){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		$sql = "SELECT MAX(position) AS position, COUNT(*) AS num,guest_key FROM ".$guest_table." WHERE torrent_id = $torrent_id";
		$res = $this->db->query($sql);
		$owner_key = $res->row()->guest_key;
		if($owner_key == $_REQUEST['token']){
			$access = true;
		}
		else{
			$level_token = $this->seedoff_sync->get_level_by_key($token);
			if($level_token >= 7)
				$access = true;
			else
				$access;
			
		}
		if(!$access){
			return 'Access denied!!!';
		}
		$res_torrent = $this->db->get_where($this->torrents_table,array('id' => $torrent_id));

		if(!$res_torrent || $res_torrent->num_rows() < 1){
			$data = array(
			'id' => $torrent_id,
			'updated' => date('Y-m-d H:i:s'),
			'pictures' => $res->row()->num,
			'max_position' => $res->row()->position,
			'owner_key' => $owner_key
			);
			$res_set = $this->db->insert($this->torrents_table,$data);
		}
		else{
			
			$this->db->where('id',$torrent_id);
			$data = array(
			'updated' => date('Y-m-d H:i:s'),
			'pictures' => $res->row()->num,
			'max_position' => $res->row()->position
			);
			$res_set = $this->db->update($this->torrents_table,$data);
			
		}
		if($res_set)
			return 'Success';
		else
			return 'Unknown error';
	}
	
	function set_cover(){
		
		$torrent_id = $_REQUEST['torrent_id'];
		$token = $_REQUEST['token'];
		$this->seedoff_sync->set_user($token);
		$uploader_level = $this->seedoff_sync->get_level_uploader($torrent_id);
		$is_owner_torrent_id = $this->seedoff_sync->is_owner_torrent_id($torrent_id,$token);
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;

		if(!$uploader_level)
			$uploader_level = 2;

		if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level)
			$enable_recover = true;
		else
			$enable_recover = false;
		if($is_owner_torrent_id)
			$enable_recover = true;

		if(!$enable_recover)
				return false;
		
		$response = array();
		$res = $this->db->get_where($guest_table, array('torrent_id' => $torrent_id, 'cover' => 1));
		if(!$res){
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		$image = $res->row();
		$filename = ImageHelper::url_to_realpath($image->url);
		$res_delete = unlink($filename);
		if(!$res_delete){
			$filename_preview = str_replace('big','preview',$filename);
			$filename_preview_80 = str_replace('big','preview_80',$filename);
			unlink($filename_preview);
			unlink($filename_preview_80);
		}
		$this->my_upload->fast($response);
		echo json_encode($response);
		exit;
	}
	
	function set_position(){
		
		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[3];
		$token = $_REQUEST['token'];
		$res_set = $this->define_position($torrent_id,$token);
		
		if($res_set == 'Success'){
			$response['answer'] = 1;
		}
		else{
			$response['answer'] = 0;
		}	

		echo json_encode($response);
		exit;
		
	}
	
	function set_tags(){
		
		$this->load->model('genres');
		$uriSegments = $this->uri->segment_array();
		$torrent_id = (int)$uriSegments[3];
		$token = $_REQUEST['token'];
		if(empty($_REQUEST['category']) && empty($_REQUEST['genres_list'])){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		
		$sql = "SELECT guest_key FROM ".$this->guests->images_table." WHERE torrent_id = $torrent_id";
		$res = $this->db->query($sql);
		$owner_key = $res->row()->guest_key;
		if($owner_key == $_REQUEST['token']){
			$access = true;
		}
		else{
			$level_token = $this->seedoff_sync->get_level_by_key($token);
			if($level_token >= 7)
				$access = true;
			else
				$access;
			
		}
		if(!$access){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		if(isset($_REQUEST['category']) && $_REQUEST['category']){
			$category = $_REQUEST['category'];
			$sql = "SELECT id FROM tags WHERE value = '$category'";
			$res = $this->db->query($sql);
			if(!$res || $res->num_rows() < 1){
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			$tag_id = $res->row()->id;

			$res_update = $this->define_tags($torrent_id,$token,$tag_id);

		}
		if(isset($_REQUEST['genres_list'])){
			$genres_list = $_REQUEST['genres_list'];
			$buffer = explode(',',$genres_list);
			if(count($buffer) > 0){
				$res_update = $this->define_genres($torrent_id,$token,$buffer);
			}
		}
		
		if($res_update == 'Success'){
			$response['answer'] = 1;
		}
		else{
			$response['answer'] = 0;
		}	

		echo json_encode($response);
		exit;
	}
	
	function change_poster_thumbnail(){
		
		$torrent_id = $_REQUEST['torrent_id'];
		$token = $_REQUEST['token'];
		$old_image_size = (int)$_REQUEST['old_image_size'];
		$new_image_size = (int)$_REQUEST['image_size'];
		if($old_image_size == $new_image_size)
			return false;
		$this->seedoff_sync->set_user($token);
		$uploader_level = $this->seedoff_sync->get_level_uploader($torrent_id);
		$is_owner_torrent_id = $this->seedoff_sync->is_owner_torrent_id($torrent_id,$token);
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;

		if(!$uploader_level)
			$uploader_level = 2;

		if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level)
			$enable_change = true;
		else
			$enable_change = false;
		if($is_owner_torrent_id)
			$enable_change = true;

		if(!$enable_change)
				return false;
		
		$response = array();
		$res = $this->db->get_where($guest_table, array('torrent_id' => $torrent_id, 'cover' => 1));
		if(!$res){
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		$image = $res->row();
		$old_image_preview = ImageHelper::get_moder_preview_url($image->url,$old_image_size);
		$new_image_preview = ImageHelper::get_moder_preview_url($image->url,$new_image_size);
		$old_image_preview = str_replace('big','preview',$old_image_preview);;
		$new_image_preview = str_replace('big','preview',$new_image_preview);;
		$filename_big = ImageHelper::url_to_realpath($image->url);
		$filename_preview = ImageHelper::url_to_realpath($new_image_preview);
		$filename_old_preview = ImageHelper::url_to_realpath($old_image_preview);
		$res = ImageHelper::make_thumbnail($filename_big,$filename_preview,$new_image_size,0,0,1,false,'Seedoff.net');
		if(file_exists($filename_old_preview))
			unlink($filename_old_preview);
		if($res)
			$response['answer'] = 1;
		else
			$response['answer'] = 0;

		echo json_encode($response);
		exit;
		
	}
	
}




?>
