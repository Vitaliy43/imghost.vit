<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advert extends CI_Model{

	public $tablename = 'advertisement_blocks';
	public $positions = array('sidebar_left','sidebar_right','header','footer');
	public $positions_names = array(
	'sidebar_left' => 'Левый блок',
	'sidebar_right' => 'Правый блок',
	'header' => 'Шапка',
	'footer' => 'Подвал'
	);

function __construct()
	{
		parent::__construct();
		
	}
	
	function get_block($position,$name = null){
		
		$this->db->select('content');
		$this->db->where('position',$position);
		$this->db->where('active',1);
		if($name)
			$this->db->where('name',$name);
		$this->db->order_by('sortid');
		$res = $this->db->get($this->tablename);
		if(!$res)
			return '';
		if($res->num_rows() > 1){
			$str = '';
			foreach($res->result_array() as $row){
				$str .= $row['content'];
			}
			return $str;
		}
		else{
			return $res->row()->content;
		}
	}
	
	function get_blocks($parameters=array(),$limit = null){
		
		$this->db->select('name,position,sortid,active,description,id');
		if(count($parameters) > 0){
			if(isset($parameters['position']))
				$this->db->where('position',$parameters['position']);
		}
		$this->db->order_by('id');
		$res = $this->db->get($this->tablename);
		if(!$res)
			return '';
		$arr = $res->result_array();
		foreach($arr as $key=>$value){
			$selected_position = $value['position'];
			$arr[$key]['select_position'] = form_dropdown('POSITIONS',$this->positions_names,$selected_position,'class="tags combobox" style="width:110px;" onchange="set_position(this);return false;" id="pos_'.$value['id'].'"');

		}
		
		return $arr;
	}

}

?>