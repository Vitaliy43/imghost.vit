<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Image CMS
 */

class Admin  extends BaseAdminController {

	function __construct()
	{
		parent::__construct();
                  $lang = new MY_Lang();
            $lang->load('tags');
			
    	$this->load->library('DX_Auth');
		$this->load->model('dx_auth/users');
		$this->load->model('guests');
		$this->load->model('members');
		$this->load->model('my_tags');

        //cp_check_perm('module_admin');	
	}

    public function index()
    {
        $this->load->module('tags');
		$tags = $this->my_tags->get_all_tags(true);
		$tree = $this->my_tags->get_tree_tags($tags);

		$this->template->assign('tree',$tree);

        $this->display_tpl('tags_viewer');
    }

	public function add(){
		
		$tag_name = $this->input->post('tag_name');
		$parent_id = $this->input->post('parent_id');
		$tag_exists = $this->my_tags->is_exists_tag($tag_name);

		if($tag_exists != false){
			$response['error'] = 'Данный тег уже существует';
			if(strlen($tag_exists) > 1)
				$response['error'] .= ' в категории "'.$tag_exists.'"';
			echo json_encode($response);
			exit;
		}
		$data = array(
		'id' => null,
		'parent_id' => $parent_id,
		'value' => $tag_name,
		'images' => 0
		);
		$res = $this->db->insert($this->my_tags->tablename,$data);
		if($res){
			$this->my_tags->create_js_tags(SITE_DIR.DIRECTORY_SEPARATOR.$this->theme_path.'js'.DIRECTORY_SEPARATOR.'tags.js');
			$tags = $this->my_tags->get_all_tags(true);
			$tree = $this->my_tags->get_tree_tags($tags);
			$response['content'] = $tree;
			$response['error'] = '';
			echo json_encode($response);
			exit;
		}
	}
	
	public function edit(){
		$tag_name = $this->input->post('tag_name');
		$tag_id = $this->input->post('tag_id');
		if(empty($tag_id))
			return false;
		$parent_id = $this->input->post('parent_id');
		$tag_exists = $this->my_tags->is_exists_tag($tag_name);

		if($tag_exists != false){
			$response['error'] = 'Данный тег уже существует';
			if(strlen($tag_exists) > 1)
				$response['error'] .= ' в категории "'.$tag_exists.'"';
			echo json_encode($response);
			exit;
		}
		$this->db->where('id',$tag_id);
		$res = $this->db->update($this->my_tags->tablename,array('value' => $tag_name));
		if($res){
			$tags = $this->my_tags->get_all_tags(true);
			$tree = $this->my_tags->get_tree_tags($tags);
			$response['content'] = $tree;
			$response['error'] = '';
			echo json_encode($response);
			exit;
		}
	}
	
	public function delete(){
		
		$tag_id = $this->input->post('tag_id');
		if(empty($tag_id))
			return false;
		$parent_id = $this->input->post('parent_id');
		if($parent_id == 0){
			$children = $this->my_tags->get_by_parent_tag($tag_id);
			$arr = array();
			$arr[] = $tag_id; 
			foreach($children as $child){
				$arr[] = $child['id'];
			}
			$this->db->where_in('tag_id',$arr);
			$res = $this->db->update($this->guests->images_table,array('tag_id' => null));
			if($res)
				$this->db->update($this->members->images_table,array('tag_id' => null));
			$this->db->where_in('id',$arr);
			$res_delete = $this->db->delete($this->my_tags->tablename);
			if($res_delete){
				$tags = $this->my_tags->get_all_tags(true);
				$tree = $this->my_tags->get_tree_tags($tags);
				$response['content'] = $tree;
				$response['error'] = '';
				echo json_encode($response);
				exit;
			}
			else{
				$response['error'] = 'Тег не удалось удалить';
			}
			
		}
		else{
			$this->db->where('tag_id',$tag_id);
			$res = $this->db->update($this->guests->images_table,array('tag_id' => null));
			if($res)
				$this->db->update($this->members->images_table,array('tag_id' => null));
			$this->db->where('id',$tag_id);
			$res_delete = $this->db->delete($this->my_tags->tablename);
			if($res_delete){
				$tags = $this->my_tags->get_all_tags(true);
				$tree = $this->my_tags->get_tree_tags($tags);
				$response['content'] = $tree;
				$response['error'] = '';
				echo json_encode($response);
				exit;
			}
			else{
				$response['error'] = 'Тег не удалось удалить';
			}
		}
	}

    /**
     * Display template file
     */ 
	private function display_tpl($file = '')
	{
        $file =  realpath(dirname(__FILE__)).'/templates/admin/'.$file.'.tpl';  
		$this->template->display('file:'.$file);
	}

    /**
     * Fetch template file
     */ 
	private function fetch_tpl($file = '')
	{
        $file =  realpath(dirname(__FILE__)).'/templates/admin/'.$file.'.tpl';  
		return $this->template->fetch('file:'.$file);
	}

}
/* End of file admin.php */
