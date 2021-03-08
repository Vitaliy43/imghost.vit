<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class My_Auth extends CI_Model{
	
	public $roles = array();
	public $role;
	public $login;
	public $user_id;
	protected $table = 'roles';
	
	 public function __construct() {
		$this->get_roles();
	}
	
	function get_roles(){
		$query = $this->db->get('roles');
		foreach($query->result_array() as $row)
			$this->roles[$row['id']] = $row;	
		
	}
	
	function get_admin_email(){
		$res = $this->db->get_where('roles',array('name' => 'admin'));
		if(!$res){
			$role_id = 1;
		}
		else{
			$role_id = $res->row()->id;

		}
		unset($res);
		$this->db->limit(1);
		$this->db->where('role_id',$role_id);
		$this->db->select('email');
		$this->db->from('users');
		$res = $this->db->get();
		if(!$res)
			return false;
		return $res->row()->email;
	}
	
	function get_profile(){
		if($this->auth->role == 'guest')
			return false;
		$res = $this->db->get_where('users',array('id' => $this->user_id));
		if(!$res || $res->num_rows() < 1)
			return false;
		return $res->row_array();
	}
	
	function edit_profile($user,$available_email){
		$show_name = $this->input->post('show_name');
		$show_name = strip_tags($show_name);
		$access_role = $this->input->post('ACCESS_ROLE');
		if($show_name){
			$data['show_name'] = $show_name;
		}
		$birthday_year = (int)$this->input->post('birthday_year');
		$birthday_month = (int)$this->input->post('birthday_month');
		$birthday_day = (int)$this->input->post('birthday_day');
		if($birthday_day && $birthday_month && $birthday_year){
			$data['birthday'] = $birthday_year.'-'.$birthday_month.'-'.$birthday_day;
		}
		if($user->row()->email == $this->input->post('email')){
			
		}
		else{
			if($available_email)
				$data['email'] = $this->input->post('email');
		}
		if($access_role)
			$data['access_role'] = $access_role;
		if(isset($_POST['tiny_static']))
			$data['tiny_static'] = 1;
		else
			$data['tiny_static'] = 0;

		if(count($data) > 0){
			$this->db->where('id',$user->row()->id);
			$res = $this->db->update($this->members->_table,$data);
			return $res;
		}
		return false;
	}
	
function get_user_by_token($token){
		$res = $this->db->get_where('users',array('token' => $token));
		if(!$res || $res->num_rows() < 1)
			return array();
		return $res->row_array();
	}
}


?>