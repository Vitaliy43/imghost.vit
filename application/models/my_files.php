<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class My_Files extends CI_Model{
	
	public $count_images;
	public $count_albums;
	protected $positions_table_asc = 'members_alphabet_asc';
	protected $parameter_keys = array(
	'tags' => 'i.tag_id'
	);
	protected $parameter_types = array(
	'tags' => 'int'
	);
	public $admin_mode = false;
	public $show_type = 'all';
	public $favourite_tablename = 'favourite_images';
	public $is_top = false;
	public $count_top = 100;
	public $top_sort = 'views';
	public $gallery_temp_table = 'images_for_gallery';
	public $use_view = false;
	public $main_table = 'pictures';
	public $use_main_table_mode;
	public $tiny_mode = false;
	public $navigation_limit = 1;
	public $browse_mode = false;
	public $list_for_browse = array();
	public $show_actions = false;
	
	function transit_parameters(){
		
		$html = '';
		if(isset($_POST['IS_SEARCH'])){
					$html .= '<div id="block_parameters">';

				if(isset($_REQUEST['FILENAME']) && $_REQUEST['FILENAME'])
					$html .= '<input type="hidden" name="FILENAME" id="filename" value="'.$_REQUEST['FILENAME'].'" />';
				
				if(isset($_REQUEST['COMMENT']) && $_REQUEST['COMMENT'])
					$html .= '<input type="hidden" name="COMMENT" id="comment" value="'.$_REQUEST['COMMENT'].'" />';
				
				if(isset($_REQUEST['ACCESS']) && $_REQUEST['ACCESS']){
					$html .= '<input type="hidden" name="ACCESS" id="access" value="'.$_REQUEST['ACCESS'].'" />';
				}
			
				if(isset($_REQUEST['ALBUMS']) && $_REQUEST['ALBUMS']){
					$html .= '<input type="hidden" name="ALBUMS" id="albums" value="'.$_REQUEST['ALBUMS'].'" />';
				}
				if(isset($_REQUEST['FROM_WIDTH']) && $_REQUEST['FROM_WIDTH']){
					$html .= '<input type="hidden" name="FROM_WIDTH" id="from_width" value="'.$_REQUEST['FROM_WIDTH'].'" />';
				}
				if(isset($_REQUEST['TO_WIDTH']) && $_REQUEST['TO_WIDTH']){
					$html .= '<input type="hidden" name="TO_WIDTH" id="to_width" value="'.$_REQUEST['TO_WIDTH'].'" />';
				}
				if(isset($_REQUEST['FROM_HEIGHT']) && $_REQUEST['FROM_HEIGHT']){
					$html .= '<input type="hidden" name="FROM_HEIGHT" id="from_height" value="'.$_REQUEST['FROM_HEIGHT'].'" />';
				}
				if(isset($_REQUEST['TO_HEIGHT']) && $_REQUEST['TO_HEIGHT']){
					$html .= '<input type="hidden" name="TO_HEIGHT" id="to_height" value="'.$_REQUEST['TO_HEIGHT'].'" />';
				}
				
				if(isset($_REQUEST['TAGS']) && $_REQUEST['TAGS']){
					$html .= '<input type="hidden" name="TAGS" id="tags" value="'.$_REQUEST['TAGS'].'" />';
				}
				if(isset($_REQUEST['TAGS_CHILDREN']) && $_REQUEST['TAGS_CHILDREN']){
					$html .= '<input type="hidden" name="TAGS_CHILDREN" id="tags_children" value="'.$_REQUEST['TAGS_CHILDREN'].'" />';
				}		
				if(isset($_REQUEST['TINYURL']) && $_REQUEST['TINYURL']){
					$html .= '<input type="hidden" name="TINYURL" id="tinyurl" value="'.$_REQUEST['TINYURL'].'" />';
				}	
				$html .= '</div>';

			}
			
			return $html;
	}
	
	function count_files_by_key($key){
		$where = '';
		if(isset($_POST['IS_SEARCH'])){
			
			if(isset($_REQUEST['FILENAME']) && $_REQUEST['FILENAME'])
				$where .= " AND show_filename LIKE '%".$_REQUEST['FILENAME']."%'";
				
			if(isset($_REQUEST['COMMENT']) && $_REQUEST['COMMENT'])
				$where .= " AND comment LIKE '%".$_REQUEST['COMMENT']."%'";
				
			if(isset($_REQUEST['ACCESS']) && $_REQUEST['ACCESS']){
				$where .= " AND access = '".$_REQUEST['ACCESS']."'";
				$access = '';
			}
			
			if(isset($_REQUEST['ALBUMS']) && $_REQUEST['ALBUMS']){
				list($type,$album_id) = explode('/',$_REQUEST['ALBUMS']);
				$album_id = (int)$album_id;
				if($type == 'torrent')
					$where .= ' AND torrent_id = '.$album_id;
				else
					$where .= ' AND album_id = '.$album_id;

			}
			
			if(isset($_REQUEST['FROM_WIDTH']) && $_REQUEST['FROM_WIDTH'] && isset($_REQUEST['TO_WIDTH']) && $_REQUEST['TO_WIDTH']){
				$where .= ' AND width BETWEEN '.(int)$_REQUEST['FROM_WIDTH'].' AND '.(int)$_REQUEST['TO_WIDTH'];
			}
			elseif(isset($_REQUEST['FROM_WIDTH']) && $_REQUEST['FROM_WIDTH']){
				$where .= ' AND width >= '.(int)$_REQUEST['FROM_WIDTH'];
			}
			elseif(isset($_REQUEST['TO_WIDTH']) && $_REQUEST['TO_WIDTH']){
				$where .= ' AND width < '.(int)$_REQUEST['TO_WIDTH'];
			}
			
			if(isset($_REQUEST['FROM_HEIGHT']) && $_REQUEST['FROM_HEIGHT'] && isset($_REQUEST['TO_HEIGHT']) && $_REQUEST['TO_HEIGHT']){
				$where .= ' AND height BETWEEN '.(int)$_REQUEST['FROM_HEIGHT'].' AND '.(int)$_REQUEST['TO_HEIGHT'];
			}
			elseif(isset($_REQUEST['FROM_HEIGHT']) && $_REQUEST['FROM_HEIGHT']){
				$where .= ' AND height >= '.(int)$_REQUEST['FROM_HEIGHT'];
			}
			elseif(isset($_REQUEST['TO_HEIGHT']) && $_REQUEST['TO_HEIGHT']){
				$where .= ' AND height < '.(int)$_REQUEST['TO_HEIGHT'];
			}
			
			if(isset($_REQUEST['TINYURL']) && $_REQUEST['TINYURL'])
				$where .= " AND tiny_url IS NOT NULL AND tiny_url != ''";
				
			if(isset($_REQUEST['TAGS']) && $_REQUEST['TAGS'] && isset($_REQUEST['TAGS_CHILDREN']) && $_REQUEST['TAGS_CHILDREN']){
				$where .= ' AND tag_id = '.(int)$_REQUEST['TAGS_CHILDREN'];
			}
			elseif(isset($_REQUEST['TAGS']) && $_REQUEST['TAGS']){
				$where .= ' AND tag_id IN (SELECT id FROM '.$this->my_tags->tablename.' WHERE parent_id = '.(int)$_REQUEST['TAGS'].')';
			}
			if($this->use_main_table_mode == 2)
				$guest_table = $this->main_table;
			else
				$guest_table = $this->guests->images_table;
				
			$sql = "SELECT COUNT(*) AS num FROM $guest_table WHERE guest_key = '$key' $where";
			$res = $this->db->query($sql);
			if(!$res || $res->num_rows() < 1)
				return 0;
			return $res->row()->num;
			
		}
		else{
			$this->db->where('guest_key',$key);
			if($this->use_main_table_mode == 2)
				$this->db->from($this->main_table);
			else
				$this->db->from($this->guests->images_table);
			return $this->db->count_all_results();
		}
		
	}
    
    function set_filename_by_torrent_id($name,$torrent_id,$token){
        $data = array('show_filename' => $name);
        $this->db->where('torrent_id',$torrent_id);
        $this->db->where('guest_key',$token);
		if($this->use_main_table_mode == 2)
		    $res = $this->db->update($this->main_table,$data);
		else
        	$res = $this->db->update($this->guests->images_table,$data);
        return $res;
    }
	
	function count_files_by_userid($user_id,$where = ''){
		
		if(isset($_POST['IS_SEARCH'])):
		
			$query = '';
			if(isset($_POST['FILENAME']) && $_POST['FILENAME'])
				$where .= " AND show_filename LIKE '%".$_POST['FILENAME']."%'";
				
			if(isset($_POST['COMMENT']) && $_POST['COMMENT'])
				$where .= " AND comment LIKE '%".$_POST['COMMENT']."%'";
				
			if(isset($_POST['ACCESS']) && $_POST['ACCESS']){
				$where .= " AND access = '".$_POST['ACCESS']."'";
				$access = '';
			}
			
			if(isset($_POST['ALBUMS']) && $_POST['ALBUMS']){
				list($type,$album_id) = explode('/',$_POST['ALBUMS']);
				$album_id = (int)$album_id;
				if($type == 'torrent')
					$where .= ' AND torrent_id = '.$album_id;
				else
					$where .= ' AND album_id = '.$album_id;

			}
			
			if(isset($_POST['FROM_WIDTH']) && $_POST['FROM_WIDTH'] && isset($_POST['TO_WIDTH']) && $_POST['TO_WIDTH']){
				$where .= ' AND width BETWEEN '.(int)$_POST['FROM_WIDTH'].' AND '.(int)$_POST['TO_WIDTH'];
			}
			elseif(isset($_POST['FROM_WIDTH']) && $_POST['FROM_WIDTH']){
				$where .= ' AND width >= '.(int)$_POST['FROM_WIDTH'];
			}
			elseif(isset($_POST['TO_WIDTH']) && $_POST['TO_WIDTH']){
				$where .= ' AND width < '.(int)$_POST['TO_WIDTH'];
			}
			
			if(isset($_POST['FROM_HEIGHT']) && $_POST['FROM_HEIGHT'] && isset($_POST['TO_HEIGHT']) && $_POST['TO_HEIGHT']){
				$where .= ' AND height BETWEEN '.(int)$_POST['FROM_HEIGHT'].' AND '.(int)$_POST['TO_HEIGHT'];
			}
			elseif(isset($_POST['FROM_HEIGHT']) && $_POST['FROM_HEIGHT']){
				$where .= ' AND height >= '.(int)$_POST['FROM_HEIGHT'];
			}
			elseif(isset($_POST['TO_HEIGHT']) && $_POST['TO_HEIGHT']){
				$where .= ' AND height < '.(int)$_POST['TO_HEIGHT'];
			}
			
			if(isset($_POST['TINYURL']) && $_POST['TINYURL'])
				$where .= " AND tiny_url IS NOT NULL AND tiny_url != ''";
				
			if(isset($_POST['TAGS']) && $_POST['TAGS'] && isset($_POST['TAGS_CHILDREN']) && $_POST['TAGS_CHILDREN']){
				$where .= ' AND tag_id = '.(int)$_POST['TAGS_CHILDREN'];
			}
			elseif(isset($_POST['TAGS']) && $_POST['TAGS']){
				$where .= ' AND tag_id IN (SELECT id FROM '.$this->my_tags->tablename.' WHERE parent_id = '.(int)$_POST['TAGS'].')';
			}
			if($this->use_main_table_mode == 2)
				$users_table = $this->main_table;
			else
				$users_table = $this->members->images_table;
			
			if($this->members->seedoff_token)
				$sql = "SELECT COUNT(*) AS num FROM $users_table WHERE (user_id = $user_id OR  guest_key = '".$this->members->seedoff_token."') $where";
			else	
				$sql = "SELECT COUNT(*) AS num FROM $users_table WHERE user_id = $user_id $where";
//			echo $sql;
			$res = $this->db->query($sql);
			if(!$res || $res->num_rows() < 1)
				return 0;
			return $res->row()->num;
		
		else:
		
			if($this->use_main_table_mode == 2 && $this->members->seedoff_token){
			$this->db->where('user_id',$user_id);
			$this->db->or_where('guest_key',$this->members->seedoff_token);

			}
			else{
				$this->db->where('user_id',$user_id);

			}

			if($user_id == $this->members->user_id || $this->admin_mode){
				$admin = true;
			}
			else{
				$this->db->where('access','public');
				$admin = false;
			}
			if($where)
				$this->db->where($where);
			if($this->use_main_table_mode == 2){
				$this->db->from($this->main_table);
				$count = $this->db->count_all_results();
				if($this->count_images > 0 && !$where)
					$this->count_images = $count;
			}
			else{
				$this->db->from($this->members->images_table);
				$count = $this->db->count_all_results();

				if($this->members->seedoff_token){
					if($where == 'album_id IS NULL')
						$where = 'torrent_id IS NULL';
					$count2 = $this->count_files_by_token($this->members->seedoff_token,$where,$admin);
					if($count2)
						$count += $count2;

				}
			if($this->count_images > 0 && !$where)
				$this->count_images = $count;
			}
		
			return $count;
		
		endif;
		
		
	}
	
	
	function count_files_by_token($token,$where='',$admin=false){
		
		if($this->use_main_table_mode == 2)
			$sql = "SELECT COUNT(*) AS num FROM ".$this->main_table." WHERE guest_key = '$token'";
		else
			$sql = "SELECT COUNT(*) AS num FROM ".$this->guests->images_table." WHERE guest_key = '$token'";
		if(!$admin){
			$sql .= " AND access = 'public' $where";
		}
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		return $res->row()->num;
		
	}
	
	function count_albums_by_userid($user_id){
		
		if($this->use_main_table_mode == 2):
			$sql = "SELECT COUNT(*) AS num FROM ".$this->members->albums_table." WHERE user_id = $user_id UNION SELECT COUNT(DISTINCT p.torrent_id) AS num FROM ".$this->my_files->main_table." p JOIN ".$this->my_albums->torrents_tablename." t ON t.torrent_id = p.torrent_id WHERE p.guest_key = '".$this->members->seedoff_token."'";
			$res = $this->db->query($sql);
			if(!$res)
				return 0;
			$arr = $res->result_array();	
			return $arr[0]['num'] + $arr[1]['num'];
			
		else:
		
		if($this->members->seedoff_token){
			$sql = "SELECT COUNT(*) AS num FROM ".$this->members->albums_table." WHERE user_id = $user_id UNION SELECT COUNT(DISTINCT i.torrent_id) AS num FROM ".$this->guests->images_table." i JOIN ".$this->my_albums->torrents_tablename." t ON t.torrent_id = i.torrent_id WHERE i.guest_key = '".$this->members->seedoff_token."'";
			$res = $this->db->query($sql);
			if(!$res)
				return 0;
			$arr = $res->result_array();	
			return $arr[0]['num'] + $arr[1]['num'];
		}
		else{
			$sql = "SELECT COUNT(*) AS num FROM ".$this->members->albums_table." WHERE user_id = $user_id";
			$res = $this->db->query($sql);
			if(!$res)
				return 0;
			return $res->row()->num;
		}
		endif;

	}
	
	function delete_guest_file($id,$key){
		if(!$id)
			return false;
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;

		if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id'])){
			$torrent_id = (int)$_REQUEST['torrent_id'];
			$uploader_level = $this->seedoff_sync->get_level_uploader($torrent_id);
			if(!$uploader_level)
				$uploader_level = 2;
		
//			if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level && ((int)$this->seedoff_sync->user['id_level']) >= $uploader_level)
			if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level)
				$query = $this->db->get_where($guest_table,array('id' => $id, 'torrent_id' => $torrent_id));
			else
				$query = $this->db->get_where($guest_table,array('id' => $id, 'guest_key' => $key, 'torrent_id' => $torrent_id));

		}
		else{
			if($this->my_auth->role == 'admin')
				$query = $this->db->get_where($guest_table,array('id' => $id));
			else
				$query = $this->db->get_where($guest_table,array('id' => $id, 'guest_key' => $key));
		}
		$image = $query->row_array();
		if(count($image) > 0){
			if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id'])){
				$this->db->where('id',$id);
				$res = $this->db->update($guest_table,array('torrent_id' => null, 'access' => 'private',  'position' => 0, 'cover' => 0));
				$this->seedoff_sync->write_delete_log($key,$id,$torrent_id);
				if($this->use_main_table_mode == 1){
					$this->db->where('old_image_id',$id);
					$this->db->where('guest_key',$_REQUEST['token']);
					$this->db->update($this->main_table,array('torrent_id' => null, 'access' => 'private', 'position' => 0, 'cover' => 0));

				}
				if($image['cover'])
					$this->seedoff_sync->delete_cover($image['torrent_id']);
				else
					$this->seedoff_sync->delete_screen($id);
				return $res;		
			}
			else{
				
				$res = $this->db->delete($guest_table,array('id' => $id));
				if($this->use_main_table_mode == 1){
					
					$this->db->query("DELETE FROM ".$this->main_table." WHERE old_image_id = $id AND user_id IS NULL");

				}
				if($image['torrent_id']):
					if($image['cover'])
						$this->seedoff_sync->delete_cover($image['torrent_id']);
					else
						$this->seedoff_sync->delete_screen($id);
				endif;
				if($res){
				$filename = ImageHelper::url_to_realpath($image['url']);
				$res_delete = unlink($filename);
				if(!$res_delete){
					$filename_preview = str_replace('big','preview',$filename);
					$filename_preview_80 = str_replace('big','preview_80',$filename);
					unlink($filename_preview);
					unlink($filename_preview_80);
					return false;
				}
				return true;
				}
				else{
					return false;
				}
			}
		}
		else{
			return false;
		}
	}
	
	function delete_file($id,$user_id){
		
		if($this->use_main_table_mode == 2)
			$members_table = $this->main_table;
		else
			$members_table = $this->members->images_table;

		if(!$id)
			return false;
		if($this->my_auth->role == 'admin')
			$query = $this->db->get_where($members_table,array('id' => $id));
		else
			$query = $this->db->get_where($members_table,array('id' => $id, 'user_id' => $user_id));
		$image = $query->row_array();
		if(count($image) > 0){
			$res = $this->db->delete($members_table,array('id' => $id));
			if($this->use_main_table_mode == 1){
				$res = $this->db->delete($this->main_table,array('old_image_id' => $id, 'user_id' => $user_id));

			}
			if($res){
				$filename = ImageHelper::url_to_realpath($image['url']);
				$res_delete = unlink($filename);
			if($res_delete){
				$filename_preview = str_replace('big','preview',$filename);
				$filename_preview_80 = str_replace('big','preview_80',$filename);
				unlink($filename_preview);
				unlink($filename_preview_80);
				return true;
			}
				return false;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	function get_popular_tags_query($tag_id,$type){
		if(empty($_POST['popular_tags']))
			return false;
		$tags = $_POST['popular_tags'];
		$tags = rtrim($tags,',');
		$tags = explode(',',$tags);
		$spec = array_flip($tags);
		if(isset($spec[$tag_id]))
			unset($tags[$spec[$tag_id]]);
		$this->db->where_in('id',$tags);
		$res = $this->db->get($this->my_tags->tablename);
		if(!$res)
			return false;
		$str = '';
		foreach($res->result_array() as $elem){
			$id = $elem['id'];
			$parent_id = $elem['parent_id'];
			$str .= "$id,";
			if($parent_id == 0){
				$children = $this->my_tags->get_by_parent_tag($id);
				if($children){
					foreach($children as $child)
						$buffer[] = $child['id'];
					$str .= implode(',',$buffer);
				unset($buffer);
				unset($children);
				}
			}
			
		}
		$str = rtrim($str,',');
		$arr = explode(',',$str);
		$arr = array_unique($arr);
		if($arr[0] == '')
			$arr = array();
		
		if(count($arr) > 0){
			if($type == 'IN')
				$sql = implode(',',$arr);
			else
				$sql = ' AND i.tag_id IN ('.implode(',',$arr).')';
			if(count($arr) == 1)
				$sql = $arr[0];
		}
		else{
			$sql = false;
		}
		if($sql == ',')
			$sql = false;

		return $sql;

	}
	
	
	function get_files_for_top($type,  $offset = '', $limit = ''){
		

		if($type == 'views'){
			if($this->use_main_table_mode)
				$sql = "SELECT i.url,i.views,i.main_url,i.show_filename, i.width, i.height,i.added,i.id,i.old_image_id FROM ".$this->main_table." i WHERE i.access = 'public' AND i.views > 0 ORDER BY views DESC, id DESC LIMIT $offset,$limit";
			else
				$sql = "SELECT i.url,i.views,i.main_url,i.show_filename, i.width, i.height,i.added,i.id FROM ".$this->guests->images_table." i WHERE i.access = 'public' AND i.views > 0 UNION SELECT i.url,i.views,i.main_url,i.show_filename, i.width, i.height, i.added,i.id FROM ".$this->members->images_table." i WHERE i.access = 'public' AND i.views > 0 ORDER BY views DESC, id DESC LIMIT $offset,$limit";
		}
		elseif($type == 'rating'){
			if($this->use_main_table_mode)
				$sql = "SELECT i.url,i.rating,i.main_url,i.show_filename, i.width, i.height, i.added,i.id,i.old_image_id FROM ".$this->main_table." i WHERE i.access = 'public' AND i.rating > 0  ORDER BY rating DESC, id DESC LIMIT $offset,$limit";
			else
				$sql = "SELECT i.url,i.rating,i.main_url,i.show_filename, i.width, i.height, i.added,i.id FROM ".$this->guests->images_table." i WHERE i.access = 'public' AND i.rating > 0 UNION SELECT i.url,i.rating,i.main_url,i.show_filename, i.width, i.height, i.added,i.id FROM ".$this->members->images_table." i WHERE i.access = 'public' AND i.rating > 0 ORDER BY rating DESC, id DESC LIMIT $offset,$limit";
		}
		
		else{
			
		}
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			$arr[$key]['url_preview'] = str_replace('big','preview_80',$value['url']);
			$arr[$key]['url_preview'] = IMGURL.$arr[$key]['url_preview'];
			$arr[$key]['url'] = IMGURL.$arr[$key]['url'];
			if($offset == 0 && ($key + 1) < 4)
				$arr[$key]['point'] = $key + 1;
			$zoomWidth = $value['width'] / 2;
			$zoomHeight = $value['height'] / 2;
			if($zoomWidth > ImageHelper::$zoomMaxWidth)
				$zoomWidth = ImageHelper::$zoomMaxWidth;
			if($zoomHeight > ImageHelper::$zoomMaxHeight)
				$zoomHeight = ImageHelper::$zoomMaxHeight;
				
			if($zoomWidth < ImageHelper::$zoomMinWidth)
				$zoomWidth = ImageHelper::$zoomMinWidth;
			if($zoomHeight < ImageHelper::$zoomMinHeight)
				$zoomHeight = ImageHelper::$zoomMinHeight;
				
			$arr[$key]['zoom_width'] = $zoomWidth;
			$arr[$key]['zoom_height'] = $zoomHeight;
				
		}
		return $arr;
	}
	
	function get_files_favourites($user_id, $limit = '', $offset = ''){
		
			if($this->use_main_table_mode == 2)
				$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,a.name AS 'album_name',a.id AS 'album_id',i.tag_id,t.value AS 'tag_name',u.id AS uid, u.username AS 'username' FROM ".$this->main_table." i LEFT JOIN users u ON u.id = i.user_id LEFT JOIN albums a ON a.id = i.album_id LEFT JOIN tags t ON i.tag_id = t.id WHERE i.id IN (SELECT image_id FROM ".$this->favourite_tablename." WHERE user_id = $user_id AND type = 'user') ORDER BY added DESC, id DESC LIMIT $offset,$limit";
			else
				$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,a.name AS 'album_name',a.id AS 'album_id',i.tag_id,t.value AS 'tag_name',u.id AS uid, u.username AS 'username' FROM ".$this->members->images_table." i LEFT JOIN users u ON u.id = i.user_id LEFT JOIN albums a ON a.id = i.album_id LEFT JOIN tags t ON i.tag_id = t.id WHERE i.id IN (SELECT image_id FROM ".$this->favourite_tablename." WHERE user_id = $user_id AND type = 'user') UNION SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,'' AS 'album_name',0 AS 'album_id',i.tag_id,t.value AS 'tag_name',0 AS uid, '' AS 'username' FROM ".$this->guests->images_table." i LEFT JOIN tags t ON i.tag_id = t.id WHERE i.id IN (SELECT image_id FROM ".$this->favourite_tablename." WHERE user_id = $user_id AND type = 'guest') ORDER BY added DESC, id DESC LIMIT $offset,$limit";
			
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			
			$arr[$key]['ext'] = pathinfo($value['url'], PATHINFO_EXTENSION);
			$image_proportion = $value['width'] / $value['height'];
			$image_preview = IMGURL.str_ireplace('big','preview',$value['url']);
			$arr[$key]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
			$arr[$key]['thumbnail_height'] = ImageHelper::$height_gallery;
			$arr[$key]['thumbnail_width'] = round(ImageHelper::$height_gallery * $image_proportion);
			$arr[$key]['relative_url'] = $value['main_url'];
			$arr[$key]['url'] = IMGURL.$value['url'];
			$arr[$key]['main_url'] = SITE_URL.$value['main_url'];
		}
		return $arr;
	}
	
	function get_files_by_genres($limit = '', $offset = '',$genres_list){
		
		if($this->admin_mode)
			$access = 1;
		else
			$access = "i.access = 'public'";
		$order_by = 'i.position';
		$where = " AND i.torrent_id IN (SELECT DISTINCT torrent_id FROM ".$this->genres->tablename." WHERE `genre_id` IN ($genres_list))";
		if($this->use_main_table_mode)
			$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height, u.username, a.name AS 'album_name', a.id AS 'album_id',i.tag_id,t.value AS 'tag_name', u.access_role, u.id AS uid $sort_filed FROM ".$this->main_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN users u ON i.user_id = u.id LEFT JOIN albums a ON i.album_id = a.id WHERE $access $where ORDER BY $order_by LIMIT $offset,$limit";
		else
			$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,'guest' AS type,'guest' AS username,null AS 'album_name',null AS 'album_id',i.tag_id,t.value AS 'tag_name',null AS access_role, null AS uid $sort_filed FROM ".$this->guests->images_table." i LEFT JOIN tags t ON i.tag_id = t.id WHERE $access $where ORDER BY $order_by LIMIT $offset,$limit";
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			
			$pixels = $value['width'] * $value['height'];
			if($pixels > ImageHelper::$web_pixel_size){
				$buffer_file = ImageHelper::url_to_realpath($value['url']);
				$buffer_file = str_replace('big','web',$buffer_file);
				if(file_exists($buffer_file))
					$value['url'] = str_replace('big','web',$value['url']);
			}
			if($this->use_main_table_mode){
				if(!$value['uid'])
					$arr[$key]['type'] = 'user';
				else
					$arr[$key]['type'] = 'guest';
				if(!$value['username'])
					$arr[$key]['username'] = 'guest';

			}
			
			$arr[$key]['data_id'] = $value['type'].'-'.$value['id'];
			$arr[$key]['ext'] = pathinfo($value['url'], PATHINFO_EXTENSION);
			$image_proportion = $value['width'] / $value['height'];
			$image_preview = IMGURL.str_ireplace('big','preview',$value['url']);
			$arr[$key]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
			$arr[$key]['thumbnail_height'] = ImageHelper::$height_gallery;
			$arr[$key]['thumbnail_width'] = round(ImageHelper::$height_gallery * $image_proportion);
			$arr[$key]['relative_url'] = $value['main_url'];
			$arr[$key]['url'] = IMGURL.$value['url'];
			$arr[$key]['main_url'] = SITE_URL.$value['main_url'];
			if($arr[$key]['access_role']){
				if($this->my_auth->role == 'admin'){
					$arr[$key]['enable_show'] = 1;
				}
				else{
					if($this->my_auth->role == 'user' && ($arr[$key]['access_role'] == 'user' || $arr[$key]['access_role'] == 'guest'))
						$arr[$key]['enable_show'] = 1;
					else	
						$arr[$key]['enable_show'] = 0;

				}
			}
			if($value['uid'] && ($value['uid'] == $this->my_auth->user_id || $this->my_auth->role == 'admin'))
				$arr[$key]['enable_operation'] = 1;
			else
				$arr[$key]['enable_operation'] = 0;
	
		}
		return $arr;
	}
	
	function set_picture($type,$parameters,&$last_id){
		if(!$last_id)
			return false;
		$this->db->delete($this->main_table,array('filename' => $parameters['filename']));

		if($type == 'user'){
			$data = array(
			'id' => null,
			'url' => $parameters['url'],
			'main_url' => $parameters['main_url'],
			'tiny_url' => $parameters['tiny_url'],
			'filename' => $parameters['filename'],
			'show_filename' => $parameters['show_filename'],
			'comment' => $parameters['comment'],
			'exif' => $parameters['exif'],
			'size' => $parameters['size'],
			'width' => $parameters['width'],
			'height' => $parameters['height'],
			'guest_key' => null,
			'user_id' => $parameters['user_id'],
			'added' => $parameters['added'],
			'tag_id' => $parameters['tag_id'],
			'access' => $parameters['access'],
			'rating' => $parameters['rating'],
			'views' => 0,
			'album_id' => $parameters['album_id'],
			'torrent_id' => null,
			'position' => null,
			'cover' => null
			);
			if($last_id)
				$data['old_image_id'] = $last_id;
		}
		else{
			
			$data = array(
			'id' => null,
			'url' => $parameters['url'],
			'main_url' => $parameters['main_url'],
			'tiny_url' => $parameters['tiny_url'],
			'filename' => $parameters['filename'],
			'show_filename' => $parameters['show_filename'],
			'comment' => $parameters['comment'],
			'exif' => $parameters['exif'],
			'size' => $parameters['size'],
			'width' => $parameters['width'],
			'height' => $parameters['height'],
			'guest_key' => $parameters['guest_key'],
			'user_id' => null,
			'added' => $parameters['added'],
			'tag_id' => $parameters['tag_id'],
			'access' => $parameters['access'],
			'rating' => $parameters['rating'],
			'views' => 0,
			'album_id' => null,
			'torrent_id' => $parameters['torrent_id'],
			'position' => $parameters['position'],
			'cover' => $parameters['cover']
			);
			if($last_id)
				$data['old_image_id'] = $last_id;
			
		}
		$query = $this->db->insert_string($this->main_table,$data);
		$query = str_replace('INSERT','INSERT LOW_PRIORITY',$query);
		
		$res = $this->db->query($query);
		return $res;
	}
	
	function get_files($limit = '', $offset = '',$parameters = array()){
		
		if(count($parameters) > 0){
			$where = " AND ";
			foreach($parameters as $key=>$value){
				if(empty($this->parameter_keys[$key]))
					continue;
				if($this->parameter_types[$key] == 'int')
					$value = (int)$value;
				if($key == 'tags'){
					$children = $this->my_tags->children;
					if(!$children){
						$popular_tags = $this->get_popular_tags_query($value,'IN');
						if($popular_tags)
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.$popular_tags.')';
						else
							$where .= $this->parameter_keys[$key].' = '.$value;

					}
					else{
						$arr = array();
						foreach($children as $child){
							$arr[] = $child['id'];
						}
						$popular_tags = $this->get_popular_tags_query($value,'IN');
						if($popular_tags){

								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).','.$popular_tags.')';

						}
						else
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).')';
					}
						
				}
				else{
					$where .= $this->parameter_keys[$key].' = '.$value;
				}
				if(count($parameters) == $counter + 1){
					
				}
				else
					$where .= ' AND ';
				$counter++;
			}
		}
		else
			$where = "";
		if($this->admin_mode)
			$access = 1;
		else
			$access = "i.access = 'public'";
			
		if($this->show_type == 'tags'){
			$where .= ' AND i.tag_id > 0';
			
		}
		if(!$this->is_top){
			$order_by = ' added DESC, id DESC';
			$sort_filed = '';
		}
		else{
			$order_by = ' '.$this->top_sort.' DESC, id DESC';
			$sort_filed = ',i.'.$this->top_sort;
		}
		
		if($this->use_main_table_mode == 2){
			$members_table = $this->main_table;
			$guests_table = $this->main_table;

		}
		else{
			$members_table = $this->members->images_table;
			$guests_table = $this->guests->images_table;
		}
		
		
		if($this->show_type == 'users'){
			$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,'user' AS type,u.username,a.name AS 'album_name',a.id AS 'album_id',i.tag_id,t.value AS 'tag_name',u.id, u.access_role AS uid $sort_filed FROM ".$members_table." i JOIN users u ON u.id = i.user_id LEFT JOIN albums a ON a.id = i.album_id LEFT JOIN tags t ON i.tag_id = t.id WHERE $access $where ORDER BY $order_by LIMIT $offset,$limit";
		}
			
		else{
			if(isset($_REQUEST['is_cover'])){
				$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,'guest' AS type,'guest' AS username,null AS 'album_name',null AS 'album_id',i.tag_id,t.value AS 'tag_name',null AS access_role, null AS uid $sort_filed FROM ".$guests_table." i LEFT JOIN tags t ON i.tag_id = t.id WHERE $access $where AND i.cover = 1 ORDER BY $order_by LIMIT $offset,$limit";
			}
				
			else{
					if($this->use_main_table_mode && $this->db->count_all($this->main_table) > 0)
						$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height, u.username,tf.filename AS 'torrent_name',i.torrent_id, i.album_id,i.tag_id,t.value AS 'tag_name', u.access_role, u.id AS uid $sort_filed FROM ".$this->main_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN ".$this->seedoff_sync->info_table." tf ON i.torrent_id = tf.torrent_id LEFT JOIN users u ON u.id = i.user_id LEFT JOIN albums a ON a.id = i.album_id WHERE $access $where ORDER BY $order_by LIMIT $offset,$limit";	
					else
						$sql = "SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,'guest' AS type,'guest' AS username,tf.filename AS 'torrent_name', i.torrent_id, null  AS 'album_id', null AS album_name, i.tag_id,t.value AS 'tag_name', null AS access_role, null AS uid $sort_filed FROM ".$this->guests->images_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN ".$this->seedoff_sync->info_table." tf ON i.torrent_id = tf.torrent_id WHERE $access $where UNION 
								SELECT i.url,i.comment,i.size,i.main_url,i.show_filename,i.access,i.added,i.id,i.width,i.height,'user' AS type,u.username, null AS 'torrent_name', null AS 'torrent_id', a.id AS 'album_id', a.name AS 'album_name', i.tag_id, t.value AS 'tag_name', u.access_role, u.id AS uid $sort_filed FROM ".$this->members->images_table." i JOIN users u ON u.id = i.user_id LEFT JOIN albums a ON a.id = i.album_id LEFT JOIN tags t ON i.tag_id = t.id WHERE $access $where ORDER BY $order_by LIMIT $offset,$limit";	
					
			}
				
		}
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			
			$pixels = $value['width'] * $value['height'];
			if($pixels > ImageHelper::$web_pixel_size){
				$buffer_file = ImageHelper::url_to_realpath($value['url']);
				$buffer_file = str_replace('big','web',$buffer_file);
				if(file_exists($buffer_file))
					$value['url'] = str_replace('big','web',$value['url']);
			}
			if(isset($value['album_name'])){
				if(mb_strlen($value['album_name']) < 20)
					$arr[$key]['album_name_length'] = 30;
				else
					$arr[$key]['album_name_length'] = 30 + (mb_strlen($value['album_name']) - 20) / 2;
			}
			elseif(isset($value['torrent_name'])){
				if(mb_strlen($value['torrent_name']) < 20)
					$arr[$key]['torrent_name_length'] = 30;
				else
					$arr[$key]['torrent_name_length'] = 30 + (mb_strlen($value['torrent_name']) - 20) / 2;
			}
			
			if($this->use_main_table_mode){
				if(is_null($value['uid']))
					$arr[$key]['type'] = 'guest';
				else
					$arr[$key]['type'] = 'user';
				if(is_null($value['username']))
					$arr[$key]['username'] = 'guest';

			}
			
			
			$arr[$key]['data_id'] = $value['type'].'-'.$value['id'];
			$arr[$key]['ext'] = pathinfo($value['url'], PATHINFO_EXTENSION);
			$image_proportion = $value['width'] / $value['height'];
			$image_preview = IMGURL.str_ireplace('big','preview',$value['url']);
			$arr[$key]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
			$arr[$key]['thumbnail_height'] = ImageHelper::$height_gallery;
			$arr[$key]['thumbnail_width'] = round(ImageHelper::$height_gallery * $image_proportion);
			$arr[$key]['relative_url'] = $value['main_url'];
			$arr[$key]['url'] = IMGURL.$value['url'];
			$arr[$key]['main_url'] = SITE_URL.$value['main_url'];
			if($arr[$key]['access_role']){
				if($this->my_auth->role == 'admin'){
					$arr[$key]['enable_show'] = 1;
				}
				else{
					if($this->my_auth->role == 'user' && ($arr[$key]['access_role'] == 'user' || $arr[$key]['access_role'] == 'guest'))
						$arr[$key]['enable_show'] = 1;
					else	
						$arr[$key]['enable_show'] = 0;

				}
			}
			if(($value['uid'] && ($value['uid'] == $this->my_auth->user_id) || $this->my_auth->role == 'admin'))
				$arr[$key]['enable_operation'] = 1;
			else
				$arr[$key]['enable_operation'] = 0;
	
		}
		
		return $arr;
	}
	
	function get_link_for_navigation_seedoff($image, $direct){
		
		if($this->use_main_table_mode == 2){
			$guests_table = $this->main_table;
		}
		else{
			$guests_table = $this->guests->images_table;
		}
		
		$use_position = true;
		if($this->browse_mode)
			$this->navigation_limit = 4;
		
		if(is_null($image->position))
			$use_position = false;
		
		if(!$image->position && !$image->cover)
			$use_position = false;
		
		if(!$use_position){
			if($direct == 'prev')
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id < $image->id AND torrent_id = $image->torrent_id AND access = 'public' ORDER BY id DESC LIMIT $this->navigation_limit";
			else
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id > $image->id AND torrent_id = $image->torrent_id AND access = 'public' ORDER BY id LIMIT $this->navigation_limit";
				
		}
		else{
			if($direct == 'prev')
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE position < $image->position AND torrent_id = $image->torrent_id AND access = 'public' ORDER BY position DESC LIMIT $this->navigation_limit";
			else
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE position > $image->position AND torrent_id = $image->torrent_id AND access = 'public' ORDER BY position LIMIT $this->navigation_limit";
			
		}
		$res = $this->db->query($sql);
		if(!$res || $res->num_rows() < 1)
			return '';
		if($this->browse_mode){
			if($res->num_rows() > 1)
				$buffer = $res->result_array();
			else
				$buffer = array();
			if($direct == 'prev'){
				$ind = $buffer[count($buffer)];
				foreach($buffer as $key=>$value){
					$buffer[$key]['direct'] = 'prev';
				}
				$this->list_for_browse = array_merge($buffer,array($ind => array('id' => $image->id, 'main_url' => $image->main_url, 'url' => $image->url, 'current' => 1)));
			}
			else{
				foreach($buffer as $key=>$value){
					$buffer[$key]['direct'] = 'next';
				}
				
				$this->list_for_browse = array_merge($this->list_for_browse,$buffer);
			}
			if($this->tiny_mode)
				return $buffer[0]['id'];
			return $buffer[0]['main_url'];
		}
		else{
			if($this->tiny_mode)
				return '/image/'.$res->row()->id;
			return $res->row()->main_url;
		}
	}
	
	function get_link_for_navigation($image, $direct, $user_id = null){
		
		if($this->use_main_table_mode == 2){
			$guests_table = $this->main_table;
			$members_table = $this->main_table;
		}
		else{
			$guests_table = $this->guests->images_table;
			$members_table = $this->members->images_table;
		}
		
		if($this->browse_mode)
			$this->navigation_limit = 4;
		
		$id = $image->id;
		if($image->album_id)
			$album_query = " AND album_id = ".$image->album_id;
		else
			$album_query = '';
			
		if($user_id){
			if($direct == 'prev'){
				$sql = "SELECT id,main_url,url,UNIX_TIMESTAMP(added) AS added FROM ".$members_table." WHERE id < $id AND user_id = $user_id AND access = 'public' $album_query ORDER BY id DESC LIMIT $this->navigation_limit";

			}
			else{
				$sql = "SELECT id,main_url,url,UNIX_TIMESTAMP(added) FROM ".$members_table." WHERE id > $id AND user_id = $user_id AND access = 'public' $album_query ORDER BY id LIMIT $this->navigation_limit";
				
			}
		}
		else{
			if($direct == 'prev'){
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id < $id AND access = 'public' ORDER BY id DESC LIMIT $this->navigation_limit";

			}
			else{
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id > $id AND access = 'public' ORDER BY id LIMIT $this->navigation_limit";

			}
		}
		$res = $this->db->query($sql);
		if(!$res)
			return false;

		if($res->num_rows() < 1 && !$image->album_id){
			if($user_id && $direct == 'prev'){
				$buffer_res_user = $this->db->get_where('users',array('id' => $user_id));
				$res_user = $buffer_res_user->result_array();
				if($this->db->table_exists($this->positions_table_asc)){
					$buffer = $this->db->get_where($this->positions_table_asc,array('id' => $user_id));
					if(!$buffer){
						$res_user = array();

					}
					else{
						if($buffer->row()->position == 1){
							$res_user = array();
						}
						else{
							$neighbor_position = $buffer->row()->position - 1;
							$buffer_neightbor = $this->db->get_where($this->positions_table_asc,array('position' => $neighbor_position));
							if(!$buffer_neightbor)
								$res_user = array();
							else
								$neghbor_user_id = $buffer_neightbor->row()->id;
							
						}
					}
				}
				else{
					$res_user = array();
				}
				if(count($res_user) < 1){
					$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id = (SELECT MAX(id) FROM ".$guests_table." AND access = 'public') LIMIT $this->navigation_limit";

				}
				else{
					$sql = "SELECT id,main_url,url FROM ".$members_table." WHERE id = (SELECT MAX(id) FROM ".$members_table." WHERE user_id = $neghbor_user_id AND access = 'public') AND user_id = $neghbor_user_id LIMIT $this->navigation_limit";	
					
					}
			}
			elseif($user_id && $direct != 'prev'){
				$buffer_res_user = $this->db->get_where('users',array('id' => $user_id));
				$res_user = $buffer_res_user->result_array();
				if($this->db->table_exists($this->positions_table_asc)){
					$buffer = $this->db->get_where($this->positions_table_asc,array('id' => $user_id));
					if(!$buffer){
						$res_user = array();
					}
					else{
						if($buffer->row()->position == $this->db->count_all($this->positions_table_asc)){
							$res_user = array();
						}
						else{
							$neighbor_position = $buffer->row()->position + 1;
							$buffer_neightbor = $this->db->get_where($this->positions_table_asc,array('position' => $neighbor_position));

							if(!$buffer_neightbor)
								$res_user = array();
							else
								$neghbor_user_id = $buffer_neightbor->row()->id;
						}
					}
				}
				else{
					$res_user = array();
				}
				if(count($res_user) < 1){
					$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id = (SELECT MIN(id) FROM ".$guests_table." AND access = 'public') LIMIT $this->navigation_limit";

				}
				else{
					$sql = "SELECT id,main_url,url FROM ".$members_table." WHERE id = (SELECT MIN(id) FROM ".$members_table." WHERE user_id = $neghbor_user_id AND access = 'public') AND user_id = $neghbor_user_id LIMIT $this->navigation_limit";				}
				
			}
			elseif(!$user_id && $direct == 'prev'){
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id = (SELECT MAX(id) FROM ".$guests_table." AND access = 'public') LIMIT $this->navigation_limit";

			}
			elseif(!$user_id && $direct != 'prev'){
				$sql = "SELECT id,main_url,url FROM ".$guests_table." WHERE id = (SELECT MIN(id) FROM ".$guests_table." AND access = 'public') LIMIT $this->navigation_limit";

			}
			$res = $this->db->query($sql);
			if(!$res)
				return '';

		}
		if($this->browse_mode){
			if($res->num_rows() > 1)
				$buffer = $res->result_array();
			else
				$buffer = array();
			if($direct == 'prev'){
				$ind = $buffer[count($buffer)];
				foreach($buffer as $key=>$value){
					$buffer[$key]['direct'] = 'prev';
				}
				$this->list_for_browse = array_merge($buffer,array($ind => array('id' => $image->id, 'main_url' => $image->main_url, 'url' => $image->url, 'current' => 1)));
			}
			else{
				foreach($buffer as $key=>$value){
					$buffer[$key]['direct'] = 'next';
				}
				$this->list_for_browse = array_merge($this->list_for_browse,$buffer);
			}
			if($this->tiny_mode)
				return $buffer[0]['id'];
			return $buffer[0]['main_url'];
		}
		else{
			if($this->tiny_mode)
				return '/image/'.$res->row()->id;
			return $res->row()->main_url;
		}
				

	}
	
	function get_files_history($limit = '', $offset = '',$parameters = array()){
		$counter = 0;
		if(count($parameters) > 0){
			$where = ' AND ';
			foreach($parameters as $key=>$value){
				if(empty($this->parameter_keys[$key]))
					continue;
				if($this->parameter_types[$key] == 'int')
					$value = (int)$value;
				if($key == 'tags'){
					$children = $this->my_tags->children;
					if(!$children){
						$where .= $this->parameter_keys[$key].' = '.$value;
					}
					else{
						$arr = array();
						foreach($children as $child){
							$arr[] = $child['id'];
						}
						$where .= $this->parameter_keys[$key].' IN ('.implode(',',$arr).')';
					}
						

				}
				if(count($parameters) == $counter + 1){
					
				}
				else
					$where .= ' AND ';
				$counter++;
			}
		}
		else
			$where = '';
		if($this->use_main_table_mode)
			$sql = "SELECT i.url,i.main_url,i.added,i.id,'guest' AS type FROM ".$this->main_table." i WHERE i.access = 'public' $where ORDER BY added DESC, id DESC LIMIT $offset,$limit";
		else
			$sql = "SELECT i.url,i.main_url,i.added,i.id,'guest' AS type FROM ".$this->guests->images_table." i WHERE i.access = 'public' $where UNION SELECT i.url,i.main_url,i.added,i.id,'user' AS type FROM ".$this->members->images_table." i JOIN users u ON u.id = i.user_id WHERE i.access = 'public' $where ORDER BY added DESC, id DESC LIMIT $offset,$limit";
		$res = $this->db->query($sql);
		if(!$res)
			return array();
		$arr = $res->result_array();
		return $arr;
	}
	
	function count_all_files_user($parameters = array()){
		$counter = 0;
		if(count($parameters) > 0){
			$where = ' AND ';
			foreach($parameters as $key=>$value){
				if(empty($this->parameter_keys[$key]))
					continue;
				if($this->parameter_types[$key] == 'int')
					$value = (int)$value;
				if($key == 'tags'){
					$children = $this->my_tags->children;
					if(!$children){
						$popular_tags = $this->get_popular_tags_query($value,'AND');
						if($popular_tags)
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.$popular_tags.')';
						else
							$where .= $this->parameter_keys[$key].' = '.$value;

					}
					else{
						$arr = array();
						foreach($children as $child){
							$arr[] = $child['id'];
						}
						$popular_tags = $this->get_popular_tags_query($value,'IN');
						if($popular_tags){
							if(strstr($popular_tags,',') != '')
								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).$popular_tags.')';
							else
								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).','.$popular_tags.')';

						}
						else
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).')';
					}
						
				}
				else{
					$where .= $this->parameter_keys[$key].' = '.$value;
				}				if(count($parameters) == $counter + 1){
					
				}
				else
					$where .= ' AND ';
				$counter++;
			}
		}
		else
			$where = '';
			
		if($this->admin_mode)
			$access = 1;
		else
			$access = "i.access = 'public'";
		if($this->use_main_table_mode == 2)	
			$sql = 'SELECT COUNT(*) AS num FROM '.$this->main_table." i JOIN users u ON u.id = i.user_id WHERE $access ".$where;
		else
			$sql = 'SELECT COUNT(*) AS num FROM '.$this->members->images_table." i JOIN users u ON u.id = i.user_id WHERE $access ".$where;
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		$arr = $res->result_array();
		$num = $arr[0]['num'] + $arr[1]['num'];
		return $num;
	}
	
	function count_all_files_tag($parameters = array()){
		$counter = 0;
		if(count($parameters) > 0){
			$where = ' AND ';
			foreach($parameters as $key=>$value){
				if(empty($this->parameter_keys[$key]))
					continue;
				if($this->parameter_types[$key] == 'int')
					$value = (int)$value;
				if($key == 'tags'){
					$children = $this->my_tags->children;
					if(!$children){
						$popular_tags = $this->get_popular_tags_query($value,'AND');
						if($popular_tags)
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.$popular_tags.')';
						else
							$where .= $this->parameter_keys[$key].' = '.$value;

					}
					else{
						$arr = array();
						foreach($children as $child){
							$arr[] = $child['id'];
						}
						$popular_tags = $this->get_popular_tags_query($value,'IN');
						if($popular_tags){
							if(strstr($popular_tags,',') != '')
								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).$popular_tags.')';
							else
								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).','.$popular_tags.')';

						}
						else
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).')';
					}
						
				}
				else{
					$where .= $this->parameter_keys[$key].' = '.$value;
				}				if(count($parameters) == $counter + 1){
					
				}
				else
					$where .= ' AND ';
				$counter++;
			}
		}
		else
			$where = '';
			
		if($this->admin_mode)
			$access = 1;
		else
			$access = "i.access = 'public'";
			
		if($this->use_main_table_mode == 2)
			$sql = 'SELECT COUNT(*) AS num FROM '.$this->main_table." i WHERE $access AND tag_id > 0 ".$where;
		else
			$sql = 'SELECT COUNT(*) AS num FROM '.$this->guests->images_table." i WHERE $access AND tag_id > 0 ".$where.' UNION SELECT COUNT(*) AS num FROM '.$this->members->images_table." i JOIN users u ON u.id = i.user_id WHERE $access AND tag_id > 0 ".$where;
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		$arr = $res->result_array();
		if($this->use_main_table_mode == 2)
			$num = $arr[0]['num'];
		else
			$num = $arr[0]['num'] + $arr[1]['num'];
		return $num;
	}
	
	function count_all_files_top($type){
		
		if($type == 'views'){
			if($this->use_main_table_mode == 2)
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->main_table." WHERE views > 0";
			else
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->guests->images_table." WHERE views > 0 UNION SELECT COUNT(*) AS num FROM ".$this->members->images_table." WHERE views > 0";
//			echo $sql;exit;
			$res = $this->db->query($sql);
			if(!$res)
				return 0;
			$arr = $res->result_array();
			if($this->use_main_table_mode == 2)
				$num = $arr[0]['num'];
			else
				$num = $arr[0]['num'] + $arr[1]['num'];
			return $num;
		}
		elseif($type == 'rating'){
			if($this->use_main_table_mode == 2)
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->main_table." WHERE rating > 0";
			else
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->guests->images_table." WHERE rating > 0 UNION SELECT COUNT(*) AS num FROM ".$this->members->images_table." WHERE rating > 0";
			$res = $this->db->query($sql);
			if(!$res)
				return 0;
			$arr = $res->result_array();
			
			if($this->use_main_table_mode == 2)
				$num = $arr[0]['num'];
			else
				$num = $arr[0]['num'] + $arr[1]['num'];
			return $num;
		}
		else{
			
		}
	}
	
	function count_all_files_favourite($user_id){
		
		$sql = 'SELECT COUNT(*) AS num FROM '.$this->my_files->favourite_tablename." i JOIN users u ON u.id = i.user_id WHERE i.user_id = $user_id";
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		return $res->row()->num;
	}
	
	function count_all_files($parameters = array()){
		$counter = 0;
		if(count($parameters) > 0){
			$where = ' AND ';
			foreach($parameters as $key=>$value){
				if(empty($this->parameter_keys[$key]))
					continue;
				if($this->parameter_types[$key] == 'int')
					$value = (int)$value;
				if($key == 'tags'){
					$children = $this->my_tags->children;
					if(!$children){
						$popular_tags = $this->get_popular_tags_query($value,'AND');
						if($popular_tags)
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.$popular_tags.')';
						else
							$where .= $this->parameter_keys[$key].' = '.$value;

					}
					else{
						$arr = array();
						foreach($children as $child){
							$arr[] = $child['id'];
						}
						$popular_tags = $this->get_popular_tags_query($value,'IN');
						if($popular_tags){
							if(strstr($popular_tags,',') != '')
								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).$popular_tags.')';
							else
								$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).','.$popular_tags.')';

						}
						else
							$where .= $this->parameter_keys[$key].' IN ('.$value.','.implode(',',$arr).')';
					}
						
				}
				else{
					$where .= $this->parameter_keys[$key].' = '.$value;
				}				if(count($parameters) == $counter + 1){
					
				}
				else
					$where .= ' AND ';
				$counter++;
			}
		}
		else
			$where = '';
			
		if($this->admin_mode)
			$access = 1;
		else
			$access = "i.access = 'public'";
		if(isset($_REQUEST['is_cover'])){
			if($this->use_main_table_mode == 2)
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->main_table." i WHERE $access ".$where.' AND cover = 1';
			else
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->guests->images_table." i WHERE $access ".$where.' AND cover = 1';

		}
		else{
			if($this->use_main_table_mode)
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->main_table." i WHERE $access ".$where;
			else
				$sql = 'SELECT COUNT(*) AS num FROM '.$this->guests->images_table." i WHERE $access ".$where.' UNION SELECT COUNT(*) AS num FROM '.$this->members->images_table." i JOIN users u ON u.id = i.user_id WHERE $access ".$where;
		}
			
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		if(isset($_REQUEST['is_cover'])){
			$num = $res->row()->num;
		}
		else{
			$arr = $res->result_array();
			if($this->use_main_table_mode == 2)
				$num = $arr[0]['num'];
			else
				$num = $arr[0]['num'] + $arr[1]['num'];
		}	
	
		return $num;
	}
	
	function get_number_screen_by_torrent_id($image){
		$torrent_id = $image->torrent_id;
		$id = $image->id;
		$position = $image->position;
		if(!is_null($position))
			$field = 'position';
		else
			$field = 'id';
		$this->db->select('*');
		if($this->use_main_table_mode == 2)
			$this->db->from($this->main_table);
		else
			$this->db->from($this->guests->images_table);
		$this->db->where('torrent_id',$torrent_id);
		$res = $this->db->get();
		if(!$res || $res->num_rows() < 1)
			return false;
		$arr = array();
		foreach($res->result_array() as $item){
			if($item['cover'])
				continue;
			$arr[] = (int)$item[$field];
				
		}

		if(count($arr) < 1)
			return false;
		sort($arr);
		if(!is_null($position))
			$key = array_search($position,$arr);
		else
			$key = array_search($id,$arr);
		$key++;
		return $key;
	}
	
	function get_file_guest_by_id($id, $feedback = false){
		
		$id = (int)$id;
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		if($feedback)
			$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.show_filename,i.torrent_id FROM ".$guest_table." i LEFT JOIN tags t ON i.tag_id = t.id WHERE i.id = $id";
		else
			$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,i.tag_id,i.exif,t.value AS 'tag_name',i.access,i.guest_key,i.views, i.torrent_id FROM ".$guest_table." i LEFT JOIN tags t ON i.tag_id = t.id WHERE i.id = $id";
		$query = $this->db->query($sql);
		if($query)
			return $query->row_array();
		return false;
	}
	
	function get_file_by_id($id){
		
		$id = (int)$id;
		$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,i.tag_id,i.exif,t.value AS 'tag_name',i.access,i.guest_key,i.user_id,u.username,i.views, i.torrent_id, i.position, i.cover, tf.filename AS torrent_filename, tf.category, fi.id AS fvid FROM ".$this->main_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN ".$this->seedoff_sync->dbase.".torrent_info  tf ON i.torrent_id = tf.torrent_id LEFT JOIN users u ON i.user_id = u.id LEFT JOIN favourite_images fi ON i.id = fi.id WHERE i.id = $id";
		$query = $this->db->query($sql);
		if(!$query)
			return false;
		$arr = $query->row();
		$ext = pathinfo($arr->url, PATHINFO_EXTENSION);
		$arr->old_url = $arr->url;
		$arr->old_main_url = $arr->main_url;
		$arr->url = '/b/'.$arr->id.'.'.$ext;
		$image_preview = IMGURL.str_replace('b','p',$arr->url);
		$arr->main_url = '/image/'.$arr->id;
		$arr->album_id = $arr->torrent_id;
		$arr->album_name = $arr->torrent_filename;
		$arr->preview_url_html = htmlspecialchars('<a href="'.SITE_URL.$arr->main_url.'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
		$arr->preview_url_bb = '[URL='.SITE_URL.$arr->main_url.'][IMG]'.$image_preview.'[/IMG][/URL]';
		$arr->preview_url = $image_preview;
		if($arr->torrent_filename)
			$arr->show_filename = $arr->torrent_filename;
		
		if(class_exists('Genres') && $arr->torrent_id){
			$block_genres = '';
			$sql = "SELECT tg.genre_id AS genre_id,gl.name AS genre_name FROM ".$this->genres->tablename." tg JOIN ".$this->genres->tablelist_name." gl ON gl.id = tg.genre_id WHERE tg.torrent_id = ".$arr->torrent_id;
			$res_genres = $this->db->query($sql);
			if(!$res_genres || $res_genres->num_rows() < 1){
			}
			else{
				
				foreach($res_genres->result_array() as $item){
					$block_genres .= '<a href="'.site_url('gallery/genres').'?genres_list='.$item['genre_id'].'" target="_blank" style="color:#fff;font-size:12px;">'.$item['genre_name'].'</a> ';
				}
				$arr->block_genres = $block_genres;
			}

		}
		if($query)
			return $arr;
		return false;
	}
	
	function get_file_guest_by_main_url($url){
		
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,i.tag_id,i.exif,t.value AS 'tag_name',i.access,i.guest_key,i.views, i.torrent_id, i.position, i.cover, tf.filename AS torrent_filename, tf.category, fi.id AS fvid FROM ".$guest_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN ".$this->seedoff_sync->dbase.".torrent_info  tf ON i.torrent_id = tf.torrent_id LEFT JOIN favourite_images fi ON i.id = fi.id WHERE main_url = '$url'";
		
		$query = $this->db->query($sql);
		if(!$query)
			return false;
		$arr = $query->row();
		$image_preview = IMGURL.str_replace('big','preview',$arr->url);
		$arr->album_id = $arr->torrent_id;
		$arr->album_name = $arr->torrent_filename;
		$arr->preview_url_html = htmlspecialchars('<a href="'.SITE_URL.$arr->main_url.'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
		$arr->preview_url_bb = '[URL='.SITE_URL.$arr->main_url.'][IMG]'.$image_preview.'[/IMG][/URL]';
		$arr->preview_url = $image_preview;
		if($arr->torrent_filename)
			$arr->show_filename = $arr->torrent_filename;
		
		if(class_exists('Genres') && $arr->torrent_id){
			$block_genres = '';
			$sql = "SELECT tg.genre_id AS genre_id,gl.name AS genre_name FROM ".$this->genres->tablename." tg JOIN ".$this->genres->tablelist_name." gl ON gl.id = tg.genre_id WHERE tg.torrent_id = ".$arr->torrent_id;
			$res_genres = $this->db->query($sql);
			if(!$res_genres || $res_genres->num_rows() < 1){
			}
			else{
				
				foreach($res_genres->result_array() as $item){
					$block_genres .= '<a href="'.site_url('gallery/genres').'?genres_list='.$item['genre_id'].'" target="_blank" style="color:#fff;font-size:12px;">'.$item['genre_name'].'</a> ';
				}
				$arr->block_genres = $block_genres;
			}

		}
		if($query)
			return $arr;
		return false;
	}
	
	function is_owner_image($image){
		if((isset($image->user_id) && $image->user_id == $this->my_auth->user_id) || (isset($image->guest_key) && $this->members->seedoff_token == $image->guest_key))
			return true;
		return false;
	}
	
	function get_file_user_by_main_url($url){
		
		if($this->use_main_table_mode == 2)
			$members_table = $this->main_table;
		else
			$members_table = $this->members->images_table;
		
		$sql = "SELECT i.id,i.views,i.access,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,u.username,i.exif,i.user_id,i.tag_id,t.value AS 'tag_name',i.album_id,a.name AS 'album_name',u.access_role, fi.id AS fvid FROM ".$members_table." i JOIN users u ON i.user_id = u.id LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN albums a ON a.id = i.album_id LEFT JOIN favourite_images fi ON i.id = fi.image_id WHERE main_url = '$url'";
		$query = $this->db->query($sql);
		if(!$query)
			return false;
		$arr = $query->row();
		$image_preview = IMGURL.str_replace('big','preview',$arr->url);
		$arr->preview_url_html = htmlspecialchars('<a href="'.SITE_URL.$arr->main_url.'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
		$arr->preview_url_bb = '[URL='.SITE_URL.$arr->main_url.'][IMG]'.$image_preview.'[/IMG][/URL]';
		$arr->preview_url = $image_preview;
		if($query)
			return $arr;
		return false;
	}
	
	
	function get_files_by_userid_simple($user_id, $limit = '', $offset = ''){
		
		if($limit == '' && $offset == ''){
			$limit = '';
		}
		else{
			$limit = ' LIMIT '.$limit.','.$offset;
		}
		
		if($this->members->seedoff_token){
			if($this->use_main_table_mode == 2)
				$sql = "SELECT id,url,main_url,added,show_filename,guest_key FROM ".$this->main_table." WHERE (user_id = ".((int)$user_id)." AND album_id IS NULL) OR (guest_key = '".$this->members->seedoff_token."' AND torrent_id IS NULL) ORDER BY added DESC $limit";
			else
				$sql = "SELECT id,url,main_url,added,show_filename,'user' AS type FROM ".$this->members->images_table." WHERE user_id = ".((int)$user_id)." AND album_id IS NULL UNION SELECT id,url,main_url,added,show_filename, 'guest' AS type FROM ".$this->guests->images_table." WHERE guest_key = '".$this->members->seedoff_token."' AND torrent_id IS NULL ORDER BY added DESC $limit";
		}
		else{
			if($this->use_main_table_mode == 2)
				$sql = "SELECT id,url,main_url,added,show_filename FROM ".$this->main_table." WHERE user_id = ".((int)$user_id)." AND album_id IS NULL ORDER BY added DESC $limit";
			else
				$sql = "SELECT id,url,main_url,added,show_filename FROM ".$this->members->images_table." WHERE user_id = ".((int)$user_id)." AND album_id IS NULL ORDER BY added DESC $limit";
		}
		
		$query = $this->db->query($sql);
		if(!$query)
			return array();
		$arr = $query->result_array();
		foreach($arr as $k=>$v){
			if($this->use_main_table_mode == 2){
				if(is_null($v['guest_key']))
					$arr[$k]['type'] = 'user';
				else
					$arr[$k]['type'] = 'guest';

			}
			$image_preview = IMGURL.str_ireplace('big','preview',$v['url']);
			$arr[$k]['preview'] = $image_preview;
			$arr[$k]['url'] = IMGURL.$v['url'];
		}
		return $arr;
	}
	
	function get_files_by_userid($user_id, $limit = '', $offset = '', $token = ''){
		
		if($limit == '' && $offset == ''){
			$limit = '';
		}
		else{
			$limit = ' LIMIT '.$limit.','.$offset;
		}
		
		if($user_id == $this->my_auth->user_id || $this->admin_mode)
			$access = '';
		else
			$access = " AND i.access = 'public' ";
		if(empty($_REQUEST['order']) || $_REQUEST['order'] == 'added')
			$order = 'ADDED';
		else
			$order = $_REQUEST['order'];
			
		$where = '';
			
		if(isset($_POST['IS_SEARCH'])){
			if(isset($_REQUEST['FILENAME']) && $_REQUEST['FILENAME'])
				$where .= " AND i.show_filename LIKE '%".$_REQUEST['FILENAME']."%'";
				
			if(isset($_REQUEST['COMMENT']) && $_REQUEST['COMMENT'])
				$where .= " AND i.comment LIKE '%".$_REQUEST['COMMENT']."%'";
				
			if(isset($_REQUEST['ACCESS']) && $_REQUEST['ACCESS']){
				$where .= " AND i.access = '".$_REQUEST['ACCESS']."'";
				$access = '';
			}
			
			if(isset($_REQUEST['ALBUMS']) && $_REQUEST['ALBUMS']){
				list($type,$album_id) = explode('/',$_REQUEST['ALBUMS']);
				$album_id = (int)$album_id;
				if($type == 'torrent')
					$where .= ' AND i.torrent_id = '.$album_id;
				else
					$where .= ' AND i.album_id = '.$album_id;

			}
			
			if(isset($_REQUEST['FROM_WIDTH']) && $_REQUEST['FROM_WIDTH'] && isset($_REQUEST['TO_WIDTH']) && $_REQUEST['TO_WIDTH']){
				$where .= ' AND i.width BETWEEN '.(int)$_REQUEST['FROM_WIDTH'].' AND '.(int)$_REQUEST['TO_WIDTH'];
			}
			elseif(isset($_REQUEST['FROM_WIDTH']) && $_REQUEST['FROM_WIDTH']){
				$where .= ' AND i.width >= '.(int)$_REQUEST['FROM_WIDTH'];
			}
			elseif(isset($_REQUEST['TO_WIDTH']) && $_REQUEST['TO_WIDTH']){
				$where .= ' AND i.width < '.(int)$_REQUEST['TO_WIDTH'];
			}
			
			if(isset($_REQUEST['FROM_HEIGHT']) && $_REQUEST['FROM_HEIGHT'] && isset($_REQUEST['TO_HEIGHT']) && $_REQUEST['TO_HEIGHT']){
				$where .= ' AND i.height BETWEEN '.(int)$_REQUEST['FROM_HEIGHT'].' AND '.(int)$_REQUEST['TO_HEIGHT'];
			}
			elseif(isset($_REQUEST['FROM_HEIGHT']) && $_REQUEST['FROM_HEIGHT']){
				$where .= ' AND i.height >= '.(int)$_REQUEST['FROM_HEIGHT'];
			}
			elseif(isset($_REQUEST['TO_HEIGHT']) && $_REQUEST['TO_HEIGHT']){
				$where .= ' AND i.height < '.(int)$_REQUEST['TO_HEIGHT'];
			}
			
			if(isset($_REQUEST['TINYURL']) && $_REQUEST['TINYURL'])
				$where .= " AND i.tiny_url IS NOT NULL AND i.tiny_url != ''";
				
			if(isset($_REQUEST['TAGS']) && $_POST['TAGS'] && isset($_REQUEST['TAGS_CHILDREN']) && $_REQUEST['TAGS_CHILDREN']){
				$where .= ' AND i.tag_id = '.(int)$_POST['TAGS_CHILDREN'];
			}
			elseif(isset($_REQUEST['TAGS']) && $_REQUEST['TAGS']){
				$where .= ' AND i.tag_id IN (SELECT id FROM '.$this->my_tags->tablename.' WHERE parent_id = '.(int)$_REQUEST['TAGS'].')';
			}
		}
		
			
		if($token){
			if($this->use_main_table_mode == 2)
				$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.album_id,a.name AS 'album_name',i.access,i.torrent_id,ti.filename AS 'torrent_name',i.guest_key FROM ".$this->main_table." i LEFT JOIN tags t ON t.id = i.tag_id LEFT JOIN albums a ON a.id = i.album_id LEFT JOIN ".$this->seedoff_sync->info_table." ti ON ti.torrent_id = i.torrent_id WHERE (i.user_id = ".((int)$user_id)." OR i.guest_key = '$token')  $access  $where ORDER BY $order DESC $limit";
			else
				$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.album_id,a.name AS 'album_name',i.access,'user' AS 'type',null AS guest_key FROM ".$this->members->images_table." i LEFT JOIN tags t ON t.id = i.tag_id LEFT JOIN albums a ON a.id = i.album_id WHERE i.user_id = ".((int)$user_id)." $access UNION SELECT i.id,i.url,i.main_url,i.tiny_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name', ti.torrent_id AS 'album_id',ti.filename AS 'album_name', i.access, 'guest' AS 'type',i.guest_key FROM ".$this->guests->images_table." i LEFT JOIN tags t ON t.id = i.tag_id LEFT JOIN ".$this->seedoff_sync->info_table." ti ON ti.torrent_id = i.torrent_id WHERE i.guest_key = '$token' $where ORDER BY $order DESC $limit";
		}
		else{
			if($this->use_main_table_mode == 2)
				$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.album_id,a.name AS 'album_name',i.access FROM ".$this->main_table." i LEFT JOIN tags t ON t.id = i.tag_id LEFT JOIN albums a ON a.id = i.album_id  WHERE i.user_id = ".((int)$user_id)." $access  $where ORDER BY $order DESC $limit";
			else
				$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.album_id,a.name AS 'album_name',i.access FROM ".$this->members->images_table." i LEFT JOIN tags t ON t.id = i.tag_id LEFT JOIN albums a ON a.id = i.album_id WHERE i.user_id = ".((int)$user_id)." $access  $where ORDER BY $order DESC $limit";
		}
		
		if(isset($_POST['is_ajax']) && isset($_POST['IS_SEARCH'])){
//			echo $sql;
		}
		
		$query = $this->db->query($sql);
		if(!$query)
			return array();
		$arr = $query->result_array();
		foreach($arr as $k=>$v){
			$arr[$k]['ext'] = pathinfo($v['url'], PATHINFO_EXTENSION);
			$image_preview = IMGURL.str_ireplace('big','preview',$v['url']);
			$image_proportion = $v['height'] / $v['width'];
			if($this->use_main_table_mode == 2){
				if($v['torrent_name'] && is_null($v['album_name']))
					$arr[$k]['album_name'] = $v['torrent_name'];
				
				if($v['torrent_id'] && is_null($v['album_id']))
					$arr[$k]['album_id'] = $v['torrent_id'];
					
				if(!is_null($v['guest_key']))
					$arr[$k]['type'] = 'guest';
				else
					$arr[$k]['type'] = 'user';
		
				
			}
			
			$arr[$k]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
			$arr[$k]['preview_width'] = round(ImageHelper::$size_fast_upload*2.5);
			$arr[$k]['preview_height'] = round((ImageHelper::$size_fast_upload*2.5)*$image_proportion);
			$arr[$k]['url'] = IMGURL.$v['url'];
			$arr[$k]['imglink'] = IMGURL.$v['url'];
			$arr[$k]['main_url'] = $v['main_url'];
			$arr[$k]['imglink_html'] = SITE_URL.$v['main_url'];
			$arr[$k]['main_url_link'] = SITE_URL.$v['main_url'];
			$arr[$k]['preview_url_html'] = htmlspecialchars('<a href="'.SITE_URL.$v['main_url'].'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
			$arr[$k]['imglink_preview_html'] = htmlspecialchars('<a href="'.SITE_URL.$v['main_url'].'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
			$arr[$k]['imglink_preview_html'] = htmlspecialchars('<a href="'.SITE_URL.$v['main_url'].'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
			$arr[$k]['preview_url_bb'] = '[URL='.SITE_URL.$v['main_url'].'][IMG]'.$image_preview.'[/IMG][/URL]';
			$arr[$k]['imglink_preview_bb'] = '[URL='.SITE_URL.$v['main_url'].'][IMG]'.$image_preview.'[/IMG][/URL]';
			$arr[$k]['preview_url'] = $image_preview;
		}
		return $arr;	
		
	}
	
	
	function get_files_by_torrent_id($torrent_id, $key){
		
		if($limit == '' && $offset == ''){
			$limit = '';
		}
		else{
			$limit = ' LIMIT '.$limit.','.$offset;
		}
		$uploader_level = $this->seedoff_sync->get_level_uploader($torrent_id);
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		if(!$uploader_level)
				$uploader_level = 2;
//		if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level && ((int)$this->seedoff_sync->user['id_level']) >= $uploader_level)
		if(count($this->seedoff_sync->user) > 0 && ((int)$this->seedoff_sync->user['id_level']) >= $this->seedoff_sync->admin_level && $uploader_level)
			$sql = "SELECT i.id,i.url,i.main_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.access,i.torrent_id FROM ".$guest_table." i LEFT JOIN tags t ON t.id = i.tag_id WHERE i.torrent_id = $torrent_id AND i.cover != 1 ORDER BY position $limit";
		else
			$sql = "SELECT i.id,i.url,i.main_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.access,i.torrent_id FROM ".$guest_table." i LEFT JOIN tags t ON t.id = i.tag_id WHERE i.guest_key = '$key' AND i.torrent_id = $torrent_id AND i.cover != 1 ORDER BY position $limit";

		$query = $this->db->query($sql);
		if(!$query || $query->num_rows() < 1)
			return array();
		$arr = $query->result_array();
		
		foreach($arr as $k=>$v){
			$arr[$k]['ext'] = pathinfo($v['url'], PATHINFO_EXTENSION);
			$image_preview = IMGURL.str_ireplace('big','preview',$v['url']);
			$image_proportion = $v['height'] / $v['width'];
			if(isset($_REQUEST['display']) && $_REQUEST['display'] == 'table')
				$arr[$k]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'" border="1">';
			else
				$arr[$k]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
			$arr[$k]['preview_width'] = round(ImageHelper::$size_fast_upload*2.5);
			$arr[$k]['preview_height'] = round((ImageHelper::$size_fast_upload*2.5)*$image_proportion);
			$arr[$k]['url'] = IMGURL.$v['url'];
			$arr[$k]['thumbnail_80'] = IMGURL.str_replace('big','preview_80',$v['url']);
			$arr[$k]['thumbnail'] = IMGURL.str_replace('big','preview',$v['url']);
			$arr[$k]['thumbnail'] = ImageHelper::get_moder_preview_url($arr[$k]['thumbnail']);
			$arr[$k]['main_url'] = SITE_URL.$v['main_url'];
		}
		return $arr;	
	}
	
	function get_files_by_key($key, $limit = '', $offset = ''){
		
		if($limit == '' && $offset == ''){
			$limit = '';
		}
		else{
			$limit = ' LIMIT '.$limit.','.$offset;
		}
		
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;
			
		if(empty($_REQUEST['order']) || $_REQUEST['order'] == 'added')
			$order = 'ADDED';
		else
			$order = $_REQUEST['order'];
		
		$sql = "SELECT i.id,i.url,i.main_url,i.tiny_url,i.comment,i.added,i.height,i.width,i.show_filename,i.size,i.tag_id,t.value AS 'tag_name',i.access FROM ".$guest_table." i LEFT JOIN tags t ON t.id = i.tag_id WHERE i.guest_key = '$key' ORDER BY $order DESC $limit";
		$query = $this->db->query($sql);
		$arr = $query->result_array();
		
		foreach($arr as $k=>$v){
			$arr[$k]['ext'] = pathinfo($v['url'], PATHINFO_EXTENSION);
			$image_preview = IMGURL.str_ireplace('big','preview',$v['url']);
			$image_proportion = $v['height'] / $v['width'];
			$arr[$k]['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
			$arr[$k]['preview_width'] = round(ImageHelper::$size_fast_upload*2.5);
			$arr[$k]['preview_height'] = round((ImageHelper::$size_fast_upload*2.5)*$image_proportion);
			$arr[$k]['url'] = IMGURL.$v['url'];
			$arr[$k]['main_url'] = $v['main_url'];
			$arr[$k]['main_url_link'] = SITE_URL.$v['main_url'];
			$arr[$k]['preview_url_html'] = htmlspecialchars('<a href="'.SITE_URL.$v['main_url'].'" target="_blank"><img src="'.$image_preview.'" border="0" /></a>');
			$arr[$k]['preview_url_bb'] = '[URL='.SITE_URL.$v['main_url'].'][IMG]'.$image_preview.'[/IMG][/URL]';
			$arr[$k]['preview_url'] = $image_preview;
		}
		return $arr;	
		
	}
	
	function update_file_guest($id,$key,&$modify_url){
		
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;
		
		$query = $this->db->get_where($guest_table, array('id' => $id, 'guest_key' => $key));
		if(!$query->row())
			return false;
		$image = $query->row();
		$real_path = ImageHelper::url_to_realpath($image->url);
		if(!file_exists($real_path))
			return false;
		$empty = '';
		if($this->my_auth->role != 'guest' && $this->members->seedoff_token)
			$res_update = $this->my_upload->modify_existing_image($image,$modify_url,'fast',TRUE);
		else
			$res_update = $this->my_upload->modify_existing_image($image,$modify_url);

		if($res_update){
			return true;
		}
		return false;
	}
	
	function update_file($id,$user_id,&$modify_url){
		
		if($this->use_main_table_mode == 2)
			$members_table = $this->main_table;
		else
			$members_table = $this->members->images_table;
		
		if($this->dx_auth->is_admin())
			$query = $this->db->get_where($members_table, array('id' => $id));
		else
			$query = $this->db->get_where($members_table, array('id' => $id, 'user_id' => $user_id));
		if(!$query->row())
			return false;
		$image = $query->row();
		$real_path = ImageHelper::url_to_realpath($image->url);
		if(!file_exists($real_path))
			return false;
		$empty = '';


			if($this->my_upload->modify_existing_image($image,$modify_url)){
				return true;
			}
	
		return false;
	}
	
	function get_file_guest($id,$key){
		
		if($this->use_main_table_mode == 2)
			$guest_table = $this->main_table;
		else
			$guest_table = $this->guests->images_table;

		$sql = "SELECT i.id,i.guest_key,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,i.comment,i.tag_id,t.value AS 'tag_name',t.parent_id AS 'tag_parent_id',(SELECT value FROM ".$this->my_tags->tablename." WHERE id = t.parent_id) AS 'parent_tag_name',i.access,i.torrent_id,i.cover FROM ".$guest_table." i LEFT JOIN tags t ON i.tag_id = t.id WHERE i.id = $id AND i.guest_key = '$key'";
		$query = $this->db->query($sql);
		if($query){
			$obj = $query->row();
			$obj->url = IMGURL.$obj->url;
			$obj->main_url = SITE_URL.$obj->main_url;
			return $obj;
		}
		return false;		
	}
	
	function get_file($id,$user_id){
		
		if($this->use_main_table_mode == 2)
			$members_table = $this->main_table;
		else
			$members_table = $this->members->images_table;
		
		if($this->dx_auth->is_admin())
			$sql = "SELECT i.id,i.user_id,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,i.comment,i.tag_id,t.value AS 'tag_name',t.parent_id AS 'tag_parent_id',(SELECT value FROM ".$this->my_tags->tablename." WHERE id = t.parent_id) AS 'parent_tag_name',i.album_id,a.name AS 'album_name',i.access FROM ".$members_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN albums a ON i.album_id = a.id WHERE i.id = $id";
		else
			$sql = "SELECT i.id,i.user_id,i.url,i.main_url,i.tiny_url,i.width,i.height,i.show_filename,i.added,i.size,i.comment,i.tag_id,t.value AS 'tag_name',t.parent_id AS 'tag_parent_id',(SELECT value FROM ".$this->my_tags->tablename." WHERE id = t.parent_id) AS 'parent_tag_name',i.album_id,a.name AS 'album_name',i.access FROM ".$members_table." i LEFT JOIN tags t ON i.tag_id = t.id LEFT JOIN albums a ON i.album_id = a.id WHERE i.id = $id AND i.user_id = $user_id";
		$query = $this->db->query($sql);
	if($query){
			$obj = $query->row();
			$obj->url = IMGURL.$obj->url;
			$obj->main_url = SITE_URL.$obj->main_url;
			return $obj;
		}
		return false;
		
	}
	
	function is_favourite($type,$image_id,$user_id=null){
		
		if(!$user_id)
			$user_id = $this->my_auth->user_id;
		$this->db->select('id');
		$this->db->from($this->favourite_tablename);
		$this->db->where('type',$type);
		$this->db->where('image_id',$image_id);
		$this->db->where('user_id',$user_id);
		$res = $this->db->get();
		if(!$res)
			return false;
		if($res->num_rows() < 1)
			return false;
		return true;
	}
	
	function get_num_favourite_by_user_id($user_id,$type){
		
		if($type == 'image'){
			$this->db->where('user_id',$user_id);
			$this->db->from($this->favourite_tablename);
			return $this->db->count_all_results();
		}
		else{
			$this->db->where('user_id',$user_id);
			$this->db->from($this->my_albums->favourite_tablename);
			return $this->db->count_all_results();
		}
	}
	
	function add_favourite($type,$image_id,$user_id=null){
		
		if(!$user_id)
			$user_id = $this->my_auth->user_id;
		$uniq = $user_id.'-'.$type.'-'.$image_id;
		$data = array(
		'id' => null,
		'type' => $type,
		'image_id' => $image_id,
		'user_id' => $user_id,
		'uniq' => $uniq,
		'data' => time()
		);
		$query = $this->db->insert_string($this->favourite_tablename,$data);
		$query = str_replace('INSERT INTO', 'INSERT IGNORE INTO',$query);
		$res = $this->db->query($query);
		return $res;
	}
	
	function delete_favourite($type,$image_id,$user_id=null){
		
		if(!$user_id)
			$user_id = $this->my_auth->user_id;
		$uniq = $user_id.'-'.$type.'-'.$image_id;
		$this->db->where('uniq',$uniq);
		$res = $this->db->delete($this->favourite_tablename);
		return $res;
	}
	
	
	
}

?>