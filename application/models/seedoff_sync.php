<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Seedoff_Sync extends CI_Model{
	
	public $dbase = 'imghost_seedoff';
	public $user_table = 'seedoff_users';
	public $images_table = 'image_screens';
	public $covers_table = 'image_covers';
	public $info_table = 'torrent_info';
	public $settings_table = 'common_settings';
	public $levels = array(3=>2,4=>2,5=>2,6=>3,7=>1,8=>1);
	public $trusted_ips = array('127.0.0.1','185.10.208.92');
	public $period_upload = 3600;
	public $user = array();
	public $admin_level = 6;
	public $domain;
	
	
	 public function __construct() {
	 	if($this->config->item('is_work'))
			$this->domain = 'http://www.seedoff.tv';
		else
			$this->domain = 'http://www.seedoff.vit';
        parent::__construct();
		$this->images_table = $this->dbase.'.'.$this->images_table;
		$this->covers_table = $this->dbase.'.'.$this->covers_table;
		$this->info_table = $this->dbase.'.'.$this->info_table;
		$this->settings_table = $this->dbase.'.'.$this->settings_table;
	}
	
	public function set_use_main_table_mode(){
		
		$this->db->select('value');
		$this->db->from($this->settings_table);
		$this->db->where('key','use_main_table_mode');
		$res = $this->db->get();
		if(!$res)
			return 0;
		return (int)$res->row()->value;
	}
	
	function authorize($username,$password){
		
		$res = $this->db->get_where($this->dbase.'.'.$this->user_table,array('username' => $username,'password' => md5($password)));
		if(!$res)
			return false;
		if($res->num_rows() > 0){
			return $res->row_array();
		}
	}
	
	function add_file_to_torrent($file_id,$torrent_id){
		
		if(!$this->members->seedoff_token)
			return false;
			
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		if(empty($_POST['table_type']) || $_POST['table_type'] == 'guest')
			$table_data = 'guest';
		else
			$table_data = 'user';
			
			
		$this->db->select_max('position');
		$this->db->select_avg('tag_id');
		$this->db->where('torrent_id',$torrent_id);
		$res_position = $this->db->get($guest_table);
		$position = $res_position->row()->position + 1;
		$tag_id = (int)$res_position->row()->tag_id;
		$data = array(
		'torrent_id' => $torrent_id,
		'position' => $position,
		'access' => 'public',
		'tag_id' => $tag_id
		);
		
		$torrent_id = (int)$torrent_id;
		
				
		if($this->my_files->use_main_table_mode == 2){
			$this->db->where('id',$file_id);
			$this->db->where('guest_key',$this->members->seedoff_token);
			$this->db->or_where('user_id',$this->my_auth->user_id);
			$data['guest_key'] = $this->members->seedoff_token;
			$data['user_id'] = null;
			$res = $this->db->update($this->my_files->main_table, $data);
			$sql = "UPDATE ".$this->my_files->main_table." SET torrent_id = $torrent_id, position = $position, access = 'public', tag_id = $tag_id, guest_key = '".$this->members->seedoff_token."', user_id = null WHERE (guest_key = '".$this->members->seedoff_token."' OR user_id = ".$this->my_auth->user_id.") AND id = $file_id";
			$this->db->query($sql);

		}
		elseif($this->my_files->use_main_table_mode == 1){
			if($table_data == 'guest'){
				$this->db->where('id',$file_id);
				$res = $this->db->update($this->guests->images_table, $data);
				$sql = "UPDATE ".$this->my_files->main_table." SET torrent_id = $torrent_id, position = $position, access = 'public', tag_id = $tag_id WHERE old_image_id = $file_id AND guest_key = '".$this->members->seedoff_token."'";
				$this->db->query($sql);
			}
			else{
				$sql = "INSERT INTO ".$this->guests->images_table." (`id`, `url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `size`, `width`, `height`, `guest_key`, `added`, `comment`, `exif`, `tag_id`, `access`, `rating`, `views`, `torrent_id`, `position`, `cover`) SELECT null,url,main_url,tiny_url,filename,show_filename,size,width,height,'".$this->members->seedoff_token."',added,comment,exif,tag_id,'public',rating,views,$torrent_id,$position,0 FROM ".$this->members->images_table." WHERE id = $file_id";
				$res = $this->db->query($sql);
				$this->db->delete($this->members->images_table, array('id' => $file_id, 'user_id' => $this->my_auth->user_id));
				$sql = "UPDATE ".$this->my_files->main_table." SET torrent_id = $torrent_id, position = $position, access = 'public', tag_id = $tag_id WHERE old_image_id = $file_id AND user_id = ".$this->my_auth->user_id;
				$this->db->query($sql);
			}

		}
		else{
			
			if($table_data == 'guest'){
				
				$res = $this->db->update($guest_table, $data);
				
			}
			else{
				$sql = "INSERT INTO ".$this->guests->images_table." (`id`, `url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `size`, `width`, `height`, `guest_key`, `added`, `comment`, `exif`, `tag_id`, `access`, `rating`, `views`, `torrent_id`, `position`, `cover`) SELECT null,url,main_url,tiny_url,filename,show_filename,size,width,height,'".$this->members->seedoff_token."',added,comment,exif,tag_id,'public',rating,views,$torrent_id,$position,0 FROM ".$this->members->images_table." WHERE id = $file_id";
				$res = $this->db->query($sql);
				$this->db->delete($this->members->images_table, array('id' => $file_id, 'user_id' => $this->my_auth->user_id));
				
			}
			
		}

		if($res){
			$this->add_screen($file_id);

		}
		return $res;
	}
	
	function get_count_files_in_torrent($torrent_id){
		
		$this->db->where('torrent_id',$torrent_id);
		$this->db->from($this->guests->images_table);
		return $this->db->count_all_results();
	}
	
	function get_torrent_info($torrent_id){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		$sql = "SELECT ti.filename AS name,ig.tag_id, t.value AS tag_name FROM ".$guest_table." ig LEFT JOIN  $this->info_table ti ON ig.torrent_id = ti.torrent_id LEFT JOIN tags t ON ig.tag_id = t.id WHERE ig.torrent_id = $torrent_id";
		$res = $this->db->query($sql);
		if(!$res)
			return false;
		return $res->row_array();
	}
	
	function get_image_size($torrent_id){
		
		$this->db->select('image_size');
		$this->db->from($this->covers_table);
		$this->db->where('torrent_id',$torrent_id);
		$res = $this->db->get();
		if(!$res)
			return ImageHelper::$default_width_cover;
		if(!$res->row()->image_size)
			return ImageHelper::$default_width_cover;
		return $res->row()->image_size;

	}
	
	function count_torrents_by_token($token){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
			$sql = "SELECT COUNT(DISTINCT ig.torrent_id) AS num FROM ".$guest_table." ig JOIN ".$this->info_table." tf ON tf.torrent_id = ig.torrent_id WHERE ig.`guest_key` = '$token' AND ig.`torrent_id` > 0";
		$res = $this->db->query($sql);
		if(!$res || $res->row()->num < 1)
			return 0;
		return $res->row()->num;
	}
	
	function delete_images_by_torrent_id($torrent_id,$token){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		$data = array(
		'torrent_id' => null,
		'access' => 'private'
		);
		$this->db->where('torrent_id',$torrent_id);
		$this->db->where('guest_key',$token);
		if($this->my_files->use_main_table_mode == 1){
			$res = $this->db->update($guest_table, $data);
			$this->db->update($this->my_files->main_table, $data);
		}
		if($res){
			$this->delete_cover($torrent_id);
			$this->delete_screens_by_torrent_id($torrent_id);
			$this->db->delete('torrents',array('id' => $torrent_id));
			$this->db->delete($this->info_table,array('torrent_id' => $torrent_id));
		}
		return $res;
	}
	
	function is_owner_torrent_id($torrent_id,$token){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		$res = $this->db->get_where($guest_table,array('torrent_id' => $torrent_id, 'guest_key' => $token));
		if(!$res || $res->num_rows() < 1)
			return false;
		return true;
	}
	
	function is_exists_torrent($torrent_id,$upload=true){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		if($upload)
			$sql = "SELECT COUNT(*) AS num FROM ".$guest_table." WHERE torrent_id = $torrent_id AND ((UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(added)) <= ".$this->period_upload.')';
		else
			$sql = "SELECT COUNT(*) AS num FROM ".$guest_table." WHERE torrent_id = $torrent_id";
		$res = $this->db->query($sql);
		if(!$res || $res->row()->num < 1)
			return false;
		return $res->row()->num;
	}
	
	function get_level_uploader($torrent_id){
		
		if(!$torrent_id)
			return false;
		$uploader_token = $this->get_key_by_torrent_id($torrent_id);
		if(!$uploader_token)
			return false;
		$level = $this->get_level_by_key($uploader_token);
		return $level;
	}
	
	function write_delete_log($token,$image_id,$torrent_id){
		
		$data = array(
		'id' => null,
		'image_id' => $image_id,
		'torrent_id' => $torrent_id,
		'moder_key' => $token
		);
		
		$res = $this->db->insert('picture_logs',$data);
		return $res;
	}
	
	function get_level_by_key($token){
		
		$sql = "SELECT id_level FROM ".$this->dbase.".seedoff_users WHERE token = '$token'";
		$res_sync = $this->db->query($sql);
		if(!$res_sync || $res_sync->num_rows() < 1)
			return false;
		return $res_sync->row()->id_level;
	}
	
	function get_key_by_torrent_id($torrent_id){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		$sql = "SELECT guest_key FROM ".$guest_table." WHERE torrent_id = $torrent_id LIMIT 1";
		$res = $this->db->query($sql);
		if(!$res || $res->num_rows() < 1)
			return false;
		return $res->row()->guest_key;
	}
	
	function set_user($token){
		if(!$token)
			return false;
		$sql = "SELECT id_level,lastconnect,cip,token FROM ".$this->dbase.".seedoff_users WHERE token = '$token'";
		$res = $this->db->query($sql);
		if(!$res || $res->num_rows() <1)
			return false;
			
		$this->user = $res->row_array();
		return true;
	}
	
	function get_torrents_by_key($key){
		
		$sql = "SELECT ti.torrent_id AS id, ti.filename AS name,'public','torrent' AS type FROM ".$this->my_albums->torrents_tablename." ti WHERE torrent_id IN (SELECT DISTINCT torrent_id FROM ".$this->my_files->main_table." WHERE guest_key = '".$key."' AND torrent_id IS NOT NULL) ORDER BY name";
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		return $res->result_array();
	}
	
	function get_files_by_torrent($torrent_id, $limit = '', $offset = ''){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		if($limit == '' && $offset == '')
			$sql = "SELECT i.url,i.comment,i.main_url,i.url,i.show_filename,i.torrent_id,i.added,i.id,i.width,i.height FROM ".$guest_table." i WHERE i.torrent_id = $torrent_id ORDER BY i.added DESC, i.id DESC";
		else
			$sql = "SELECT i.url,i.comment,i.main_url,i.url,i.show_filename,i.torrent_id,i.added,i.id,i.width,i.height FROM ".$guest_table." i WHERE i.torrent_id = $torrent_id ORDER BY i.added DESC, i.id DESC LIMIT $offset,$limit";
			

		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			$arr[$key]['data_id'] = $value['type'].'-'.$value['id'];
			$image_proportion = $value['width'] / $value['height'];
			$pixels = $value['width'] * $value['height'];
			if($pixels > ImageHelper::$web_pixel_size){
				$buffer_file = ImageHelper::url_to_realpath($value['url']);
				$buffer_file = str_replace('big','web',$buffer_file);
				if(file_exists($buffer_file))
					$value['url'] = str_replace('big','web',$value['url']);
			}
			$arr[$key]['thumbnail'] = IMGURL.str_replace('big','preview',$value['url']);
			$arr[$key]['thumbnail_80'] = IMGURL.str_replace('big','preview_80',$value['url']);
			$arr[$key]['thumbnail_height'] = ImageHelper::$height_gallery;
			$arr[$key]['thumbnail_width'] = round(ImageHelper::$height_gallery * $image_proportion);
			$arr[$key]['related_url'] = $value['main_url'];
			$arr[$key]['url'] = IMGURL.$value['url'];
			$arr[$key]['main_url'] = SITE_URL.$value['main_url'];
		}
		return $arr;
	}
	
	function images_list_by_torrent($torrent_id){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		$this->db->select('url,cover');
		$this->db->from($guest_table);
		$this->db->where('torrent_id',$torrent_id);
		$this->db->order_by('position');
		$res = $this->db->get();
		$counter = 1;
		$html = '';

		if(!$res || $res->num_rows() < 1)
			return '';
		foreach($res->result_array() as $item){
			if($item['cover'])
				$html .= $counter.'-'.IMGURL.$item['url'].'-cover;';
			else
				$html .= $counter.'-'.IMGURL.$item['url'].'-screen;';

			$filename_destiny = ImageHelper::url_to_realpath($item['url']);
			$filename = $buffer[0];
			$ext = $buffer[1];
			$filename_preview = $filename.'_150.'.$ext;
			$filename_preview = ImageHelper::url_to_realpath($filename_preview);
			$filename_preview = str_replace('big','preview',$filename_preview);

			if(!file_exists($filename_preview)){
				ImageHelper::make_thumbnail($filename_destiny,$filename_preview,150,0,0,1,false);
			}
			$counter++;
		}
		$html = substr($html,0,-1);
		return $html;
	}
	
	function torrents_list($torrent_id){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		if(isset($_REQUEST['with_type']))
			$with_type = true;
		else
			$with_type = false;
		if(!$with_type)
			$this->db->select('url');
		else
			$this->db->select('url,cover');
		$this->db->from($guest_table);
		$this->db->where('torrent_id',$torrent_id);
		if(!$with_type)
			$this->db->where('cover',0);
		$this->db->order_by('position');
        $uploader_level = $this->get_level_uploader($torrent_id);
	    $res = $this->db->get();
		$counter = 1;
		$html = '';

		if(!$res || $res->num_rows() < 1)
			return '';
		foreach($res->result_array() as $item){
			if($with_type){
				if($item['cover'])
					$html .= IMGURL.$item['url'].'-cover;';
				else
					$html .= IMGURL.$item['url'].'-screen;';

			}
			else
				$html .= IMGURL.$item['url'].';';
			$buffer = explode('.',$item['url']);
			$filename_destiny = ImageHelper::url_to_realpath($item['url']);
			$filename = $buffer[0];
			$ext = $buffer[1];
			$filename_preview = $filename.'_150.'.$ext;
			$filename_preview = ImageHelper::url_to_realpath($filename_preview);
			$filename_preview = str_replace('big','preview',$filename_preview);

			if(!file_exists($filename_preview)){
				ImageHelper::resizeimg($filename_destiny,$filename_preview,150,true);

			}
			$counter++;
		}
		$html = substr($html,0,-1);
		return $html;
	}
	
	function set_screen($image_id,$parameters){
		
		if(!$image_id)
			return false;
		
		if(empty($parameters['torrent_id']) || !$parameters['torrent_id'])
			return false;
		
		$data = array(
		'image_id' => $image_id,
		'torrent_id' => (int)$parameters['torrent_id'],
		'url' => $parameters['url'],
		'position' => $parameters['position']
		);

		$res = $this->db->insert($this->images_table,$data);

		return $res;
	}
	
	function update_screen($image_id,$parameters){
		
		if(!image_id)
			return false;
		$this->db->where('image_id',$image_id);
		$res = $this->db->update($this->images_table,$parameters);
		return $res;
	}
	
	function set_cover($parameters,$size){
				
		if(empty($parameters['torrent_id']) || !$parameters['torrent_id'])
			return false;
		
		$data = array(
		'torrent_id' => $parameters['torrent_id'],
		'url' => $parameters['url'],
		'image_size' => $size,
		'added' => $parameters['added']
		);
		$res = $this->db->insert($this->covers_table,$data);
		return $res;
	}
	
	function add_screen($image_id){
		if($this->my_files->use_main_table_mode == 2)
			$sql = "REPLACE INTO ".$this->images_table." SELECT id,torrent_id,url,position FROM ".$this->my_files->main_table." WHERE id = $image_id";
		else
			$sql = "REPLACE INTO ".$this->images_table." SELECT id,torrent_id,url,position FROM ".$this->guests->images_table." WHERE id = $image_id";
		$res = $this->db->query($sql);
		return $res;
	}
	
	function delete_screen($image_id){
		
		$res = $this->db->delete($this->images_table,array('image_id' => $image_id));
		return $res;
	}
	
	function delete_screens_by_torrent_id($torrent_id){
		
		$res = $this->db->delete($this->images_table,array('torrent_id' => $torrent_id));
		return $res;
	}
	
	function delete_cover($torrent_id){
		
		$res = $this->db->delete($this->covers_table,array('torrent_id' => $torrent_id));
		return $res;
	}
	
	function get_branch($torrent_id,$language,$lang_album){
		
		if($this->my_files->use_main_table_mode == 2)
			$guest_table = $this->my_files->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		$sql = "SELECT id,show_filename,main_url,url,added,torrent_id FROM ".$guest_table." WHERE torrent_id = $torrent_id ORDER BY show_filename DESC";	
		$res = $this->db->query($sql);
		$html = '';
		if(!$res)
			return false;
		if($res->num_rows() > 0){
			$counter = 0;
			$num_rows = count($res->result_array());
			foreach($res->result_array() as $elem){
				$preview = IMGURL.str_replace('big','preview',$elem['url']);
				if($counter == $num_rows - 1)
					$html .= "<li class=\"last\"><span class=\"file\"><a href=\"".IMGURL.$elem['url']."\" class=\"shadowbox\" rel=\"shadowbox[gallery]\" onmouseover=\" return overlib('<img src=".$preview."   width=100 border=0>', RIGHT);\" onmouseout=\"return nd();\">".$elem['show_filename'].'</a></span><span class="operations" style="padding-top:5px;"><a href="/torrents/file/delete/'.$elem['id'].'" style="padding-left:5px;" title="'.$language['DELETE'].'" onclick="delete_file('.$elem['id'].',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a><a style="padding-left:10px;" href="'.$elem['main_url'].'" title="'.$language['OPEN'].'" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a></span></li>';
				else
					$html .= "<li><span class=\"file\"><a href=\"".IMGURL.$elem['url']."\" class=\"shadowbox\" rel=\"shadowbox[gallery]\" onmouseover=\" return overlib('<img src=".$preview."   width=100 border=0>', RIGHT);\" onmouseout=\"return nd();\">".$elem['show_filename'].'</a></span><span class="operations" style="padding-top:5px;"><a href="/torrents/file/delete/'.$elem['id'].'" style="padding-left:5px;" title="'.$language['DELETE'].'" onclick="delete_file('.$elem['id'].',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a><a style="padding-left:10px;" href="'.$elem['main_url'].'" title="'.$language['OPEN'].'" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a></span></li>';
				$counter++;
			}
			return $html;
		}
		return false;
		
		}
	
}

?>