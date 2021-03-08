<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class My_Albums extends CI_Model {
	
	public $accesses = array('public','protected','private');
	public $tablename = 'albums';
	public $access;
	public $favourite_tablename = 'favourite_albums';
	public $torrents_tablename = 'imghost_seedoff.torrent_info';
	public $db_prefix;
	
	public function __construct(){
		$this->access = 'public';
	}
	
	function get_albums_by_userid($userid,$get_all = false){
		
		if($this->my_files->use_main_table_mode == 2){
			$guest_table = $this->db->database.'.'.$this->my_files->main_table;
			$members_table = $this->my_files->main_table;
		}
		else{
			$guest_table = $this->db->database.'.'.$this->guests->images_table;
			$members_table = $this->members->images_table;

		}
		
		if($get_all){
			
				$sql = "SELECT show_filename,main_url,url,added,album_id FROM ".$members_table." WHERE album_id IN (SELECT id FROM ".$this->tablename." WHERE user_id = $userid ORDER BY name)";
			
		}
		else{

			if($this->members->seedoff_token)
				$sql = "SELECT a.id, a.name, a.access,'album' AS type FROM ".$this->db->database.'.'.$this->tablename." a WHERE user_id = $userid UNION SELECT ti.torrent_id AS id, ti.filename AS name,'public','torrent' AS type FROM ".$this->torrents_tablename." ti WHERE torrent_id IN (SELECT DISTINCT torrent_id FROM ".$guest_table." WHERE guest_key = '".$this->members->seedoff_token."') ORDER BY name";
			else
				$sql = "SELECT id,name,access,'album' AS type FROM ".$this->tablename." WHERE user_id = $userid ORDER BY name";
		}	
			$res = $this->db->query($sql);
			if(!$res)
				return false;
			if($res->num_rows() > 0){
				return $res->result_array();
			}
			return false;
	
	}
	
	function get_access_album($album_id){
		
		if(!$album_id)
			return 'public';
		$this->db->select('access');
		$this->db->from($this->tablename);
		$this->db->where('id',$album_id);
		$res = $this->db->get();
		if(!$res)
			return 'public';
		return $res->row()->access;
	}
	
	function get_files_history($limit = '', $offset = '',$album_id){
		
		$counter = 0;
		
		$sql = "SELECT i.url,i.main_url,i.added,i.id FROM ".$this->members->images_table." i WHERE i.album_id = $album_id ORDER BY added DESC, id DESC LIMIT $offset,$limit";
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		return $arr;
	}
	
	function get_files_by_album($album_id,$userid,$limit = '', $offset = ''){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
		
		if($limit == '' && $offset == '')
			$sql = "SELECT i.url,i.comment,i.main_url,i.url,i.show_filename,i.album_id,i.added,i.id,i.width,i.height,'user' AS 'type' FROM ".$members_table." i WHERE album_id = $album_id ORDER BY i.added DESC, i.id DESC";
		else
			$sql = "SELECT i.url,i.comment,i.main_url,i.url,i.show_filename,i.album_id,i.added,i.id,i.width,i.height,'user' AS 'type' FROM ".$members_table." i WHERE album_id = $album_id ORDER BY i.added DESC, i.id DESC LIMIT $offset,$limit";
			

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
	
	function get_count_file_in_album($album_id,$userid){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
			
		$this->db->where('album_id',$album_id);
		$this->db->from($members_table);
		return $this->db->count_all_results();
	}
	
	function get_album_by_name($name,$userid=null){
		
		if($userid){
			$res = $this->db->get_where($this->tablename,array('name' => $name, 'user_id' => $userid));
			if($res)
				return $res->row();
		}
		return false;
	}
	
	function get_album_by_id($album_id,$userid){
		
		$res = $this->db->get_where($this->tablename,array('id' => $album_id, 'user_id' => $userid));
		if(!$res)
			return false;
		return $res->row_array();
	}
	
	function delete_album_by_id($album_id,$userid){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
		
		$res = $this->db->delete($this->tablename,array('id' => $album_id, 'user_id' => $userid));
		if($res){
			$res_delete = $this->db->delete($members_table,array('album_id' => $album_id, 'user_id' => $userid));
		}
		if($res && $res_delete)
			return true;
		return false;
	}
	
	function get_album_info($album_id){
		
		$sql = "SELECT a.name,a.description,a.added,a.access,a.user_id,u.username FROM ".$this->tablename." a JOIN users u ON a.user_id = u.id WHERE a.id = $album_id";
		$res = $this->db->query($sql);
		if(!$res)
			return false;
		return $res->row_array();
	}
	
	function update_file_access($album_id,$access){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
		
		$this->db->where('album_id',$album_id);
		$res = $this->db->update($members_table,array('access' => $access));
		return $res;
	}
	
	function exclude_file($album_id,$file_id,$userid){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
		
		$this->db->where('id',$file_id);
		$this->db->where('album_id',$album_id);
		$this->db->where('user_id',$userid);
		$res = $this->db->update($members_table,array('album_id' => null,'access' => 'public'));
		return $res;
	}
	
	function delete_file($file_id,$userid){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
		
		$res = $this->db->delete($members_table,array('id' => $file_id, 'user_id' => $userid));
		if($res)
			return true;
		return false;
	}
	
	
	function get_branch($album_id,$userid,$language,$lang_album){
		
		if($this->my_files->use_main_table_mode == 2)
			$members_table = $this->my_files->main_table;
		else
			$members_table = $this->members->images_table;
		
		$sql = "SELECT id,show_filename,main_url,url,added,album_id FROM ".$members_table." WHERE album_id = $album_id AND user_id = $userid ORDER BY show_filename DESC";	
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
					$html .= "<li class=\"last\"><span class=\"file\"><a href=\"".IMGURL.$elem['url']."\" class=\"shadowbox\" rel=\"shadowbox[gallery]\" onmouseover=\" return overlib('<img src=".$preview."   width=100 border=0>', RIGHT);\" onmouseout=\"return nd();\">".$elem['show_filename'].'</a></span><span class="operations" style="padding-top:5px;"><a href="/albums/file/delete" style="padding-left:5px;" title="'.$language['DELETE'].'" onclick="delete_file('.$elem['id'].',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a><a style="padding-left:5px;" href="/albums/file/exclude" onclick="exclude_file('.$elem['id'].',this);return false;" title="'.$lang_album['EXCLUDE_FROM_ALBUM'].'" class="edit"><img src="/templates/imghost/images/icon_exclude.png" width="10" height="10" /></a><a style="padding-left:10px;" href="'.$elem['main_url'].'" title="'.$language['OPEN'].'" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a></span></li>';
				else
					$html .= "<li><span class=\"file\"><a href=\"".IMGURL.$elem['url']."\" class=\"shadowbox\" rel=\"shadowbox[gallery]\" onmouseover=\" return overlib('<img src=".$preview."   width=100 border=0>', RIGHT);\" onmouseout=\"return nd();\">".$elem['show_filename'].'</a></span><span class="operations" style="padding-top:5px;"><a href="/albums/file/delete" style="padding-left:5px;" title="'.$language['DELETE'].'" onclick="delete_file('.$elem['id'].',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a><a style="padding-left:5px;" href="/albums/file/exclude" onclick="exclude_file('.$elem['id'].',this);return false;" title="'.$lang_album['EXCLUDE_FROM_ALBUM'].'" class="edit"><img src="/templates/imghost/images/icon_exclude.png" width="10" height="10" /></a><a style="padding-left:10px;" href="'.$elem['main_url'].'" title="'.$language['OPEN'].'" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a></span></li>';
				$counter++;
			}
			return $html;
		}
		return false;
		
		}
		
	
	
function get_tree_albums($arr,$language){
		$html = '<ul id="albums_tree" >';
		foreach($arr as $key=>$value){
			$icon_access = '<img src="/templates/imghost/images/access_'.$value['access'].'.png" width="10" height="10" />';
			if($value['type'] == 'torrent'){
				$html .= '<li><span class="folder" id="folder_'.$key.'" onclick="show_branch(this,'.$key.',\''.$value['type'].'\');" title="'.$value['description'].'" data-type="torrent">'.$value['name'].'&nbsp;'.$icon_access.'</span><span class="operations" style="padding-top:5px;"><a href="/torrents/delete/'.$key.'" style="padding-left:15px;" title="'.$language['DELETE'].'" onclick="delete_album('.$key.',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a>
			<a style="padding-left:10px;" href="/torrents/'.$key.'" title="'.$language['OPEN'].'" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a>
			</span>';
			}
			else{
				$html .= '<li><span class="folder" id="folder_'.$key.'" onclick="show_branch(this,'.$key.',\''.$value['type'].'\');" title="'.$value['description'].'" data-type="album">'.$value['name'].'&nbsp;'.$icon_access.'</span><span class="operations" style="padding-top:5px;"><a href="/albums/delete/'.$key.'" style="padding-left:15px;" title="'.$language['DELETE'].'" onclick="delete_album('.$key.',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a><a style="padding-left:5px;" href="/albums_settings/show/'.$key.'" onclick="show_edit_album('.$key.',this);return false;" title="'.$language['EDIT'].'" class="edit"><img src="/templates/administrator/images/icon_edit.png" width="10" height="10" /></a>
			<a style="padding-left:10px;" href="/albums/'.$key.'" title="'.$language['OPEN'].'" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a>
			</span>';
			}
			
			$html .= '<ul class="children">';
			
			$html .= '</ul>';
			$html .= '</li>';
		}

		$html .= '</ul>';
		return $html;
	}
	
		
function add_file_to_album($file_id,$album_id){
	
	$access = $this->get_access_album($album_id);
	
	if($this->my_files->use_main_table_mode == 2){
		$members_table = $this->my_files->main_table;
		$data = array(
		'album_id' => $album_id,
		'access' => $access,
		'torrent_id' => null,
		'guest_key' => null,
		'user_id' => $this->my_auth->user_id
		);

	}
	else{
		$members_table = $this->members->images_table;
		
		$data = array(
		'album_id' => $album_id,
		'access' => $access
		);
	}
			
	if(empty($_POST['table_type']) || $_POST['table_type'] == 'guest')
		$table_data = 'guest';
	else
		$table_data = 'user';
	
	if($this->my_files->use_main_table_mode == 2 && $this->members->seedoff_token){
		if($table_data == 'guest'){
			$this->db->where('guest_key',$this->members->seedoff_token);
			$this->db->where('id',$file_id);
		}
		else{
			$this->db->where('user_id',$this->my_auth->user_id);
			$this->db->where('id',$file_id);
		}
		$res = $this->db->update($members_table, $data);
		return $res;
	}
	else{
		$this->db->where('user_id',$this->my_auth->user_id);
		$this->db->where('id',$file_id);
		$res = $this->db->update($members_table, $data);
		return $res;
	}
	
}

function set_password($album_id){
	$password = $this->input->post('album_password');
	$res = $this->db->get_where($this->tablename,array('id' => $album_id));
	if(!$res)
		return false;
	if($res->row()->password == md5($password)){
		$_SESSION['album_password'][$album_id] = $password;
		return true;
	}
	return false;
	
}
	
	}

?>