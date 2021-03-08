<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class My_Tags extends CI_Model{
	
	public $tablename = 'tags';
	public $current_tag_id;
	public $children;
	public $parent_id;
	protected $limit_popular = 10;
	
    public function __construct() {
        parent::__construct();
    }
	
	function get_main_tags(){
		$this->db->where('parent_id',0);
		$this->db->order_by('value');
		$query = $this->db->get($this->tablename);
		return $query->result_array();
	}
	
	function get_by_parent_tag($tag_id,$sort = false){
		if($sort)
			$this->db->order_by($sort);
		else
			$this->db->order_by('value');
		$query = $this->db->get_where($this->tablename,array('parent_id' => $tag_id));
		if(!$query)
			return false;
		return $query->result_array();

	}
	
	function get_tag_by_name($name){
		$query = $this->db->get_where($this->tablename,array('value' => $name));
		if(!$query)
			return false;
		return $query->row_array();
	}
	
	function get_tag_by_id($id){
		$query = $this->db->get_where($this->tablename,array('id' => $id));
		if(!$query)
			return false;
		return $query->row_array();
	}
	
	function get_popular_tags(){
		$this->db->where('images != ',0);
		$this->db->order_by('images','desc');
		$this->db->limit($this->limit_popular);
		$res = $this->db->get($this->tablename);
		if(!$res)
			return array();
		return $res->result_array();
	}
	
	function create_js_tags($link){
		$fh = fopen($link,'w+');
		$tags = $this->get_all_tags();
		$js = ' var tagnames = [';
		$count = 0;
		$js_tags = ' var tags = new Array();';
		foreach($tags as $tag){
			$count++;
			if(count($tags) == $count){
				$js .= '"'.htmlspecialchars($tag['value']).'"';
			}
			else{
				$js .= '"'.htmlspecialchars($tag['value']).'",';
			}
			$js_tags .= 'tags['.$tag['id'].'] = "'.$tag['value'].'";';

		}
		$js .= '];';
		
		fwrite($fh,$js);
		fwrite($fh,$js_tags);
		fclose($fh);
	}
	
	function get_all_tags($return_tree = false){
		if(!$return_tree){
			$res = $this->db->get($this->tablename);
			if(!$res)
				return false;
			return $res->result_array();
		}
		else{
			$arr = array();
			$res_parent = $this->db->get_where($this->tablename,array('parent_id' => 0));
			foreach($res_parent->result_array() as $elem){
				$arr[$elem['id']]['name'] = $elem['value'];
				$arr[$elem['id']]['children'] = $this->get_by_parent_tag($elem['id'],'value');
			}
			return $arr;
		}	
	}
	
	function get_tree_tags($arr){
		$html = '<ul id="tags_tree">';
		foreach($arr as $key=>$value){
			$html .= '<li><span class="folder" id="folder_'.$key.'">'.$value['name'].'</span><span><a style="padding-left:5px;" href="/admin/components/init_windows/tags/edit" onclick="show_edit_tag('.$key.',this);return false;" title="Редактировать" class="edit"><img src="/templates/administrator/images/icon_edit.png" width="10" height="10" /></a><a href="/admin/components/init_windows/tags/delete" style="padding-left:5px;" title="Удалить" onclick="delete_tag('.$key.',0,this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a></span><span style="display:none;margin-left:10px;"><span class="name" style="font-weight:bold;">Новое имя</span><input type="textbox" value="'.$value['name'].'" size="10" maxlength="30" style="margin-left:10px;" class="tag_name"><button onclick="submit_edit_tag('.$key.',this,0);" style="margin-left:10px;border:1px black solid;padding:3px;">Подтвердить</button><button onclick="reset_tags(this);return false;" style="margin-left:5px;border:1px black solid;padding:3px;">Сбросить</button></span>';
			$html .= '<ul class="children">';
			foreach($value['children'] as $elem){
				$html .= '<li><span class="file">'.$elem['value'].'</span><span><a style="padding-left:5px;" href="/admin/components/init_windows/tags/edit" title="Редактировать" onclick="show_edit_tag('.$elem['id'].',this);return false;" class="edit"><img src="/templates/administrator/images/icon_edit.png" width="10" height="10" /></a><a href="/admin/components/init_windows/tags/delete" style="padding-left:5px;" title="Удалить" onclick="delete_tag('.$elem['id'].','.$key.',this);return false;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a></span><span style="display:none;margin-left:10px;"><span class="name" style="font-weight:bold;">Новое имя</span><input type="textbox" value="'.$elem['value'].'" size="10" maxlength="30" style="margin-left:10px;" class="tag_name"><button onclick="submit_edit_tag('.$elem['id'].','.$key.',this);" style="margin-left:10px;border:1px black solid;padding:3px;">Подтвердить</button><button onclick="reset_tags(this);return false;" style="margin-left:5px;border:1px black solid;padding:3px;">Сбросить</button></span></li>';
			}
			$html .= '<li><span class="file" onclick="show_add_tag(this);" style="cursor:pointer;font-weight:bold;">Добавить тег</span><span style="display:none;margin-left:10px;"><input type="textbox" value="" size="15" maxlength="30"><button onclick="submit_add_tag('.$key.',this);" style="margin-left:10px;border:1px black solid;padding:3px;">Подтвердить</button></span></li>';
			$html .= '</ul>';
			$html .= '</li>';
		}
		$html .= '<li><span class="file" onclick="show_add_tag(this);" style="cursor:pointer;font-weight:bold;">Добавить тег</span><span style="display:none;margin-left:10px;"><input type="textbox" value="" size="15" maxlength="30"><button onclick="submit_add_tag(0,this);" style="margin-left:10px;border:1px black solid;padding:3px;">Подтвердить</button></span></li>';
		$html .= '</ul>';
		return $html;
	}
	
	function is_exists_tag($value){
		
		$res = $this->db->get_where($this->tablename,array('value' => $value));	
		if($res->num_rows() < 1)
			return false;
		$res_parent = $this->get_tag_by_id($res->row()->parent_id);
		if($res_parent && $res_parent['parent_id']){
			return $value;

		}
		else{
			return 1;
		}

	}
	
}

?>