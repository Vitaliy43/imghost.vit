<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Members extends Users {
	
	public $images_table = 'images';
	public $albums_table = 'albums';
	public $user_id;
	public $user_avatar;
	public $seedoff_token;
	public $vk_profile;
	public $fb_profile;
	public $ok_profile;
	public $google_profile;
	public $tablename = 'users';
	
	function init(){
		$this->user_id = $this->dx_auth->get_user_id();
		
		$this->db->select('avatar,vk,fb,ok,google,from_seedoff,token');
		$this->db->from('users');
		$this->db->where('id',$this->user_id);
		$query = $this->db->get();
		if($query){
			if($query->row()->avatar)
				$this->user_avatar = $query->row()->avatar;
			if($query->row()->vk)
				$this->vk_profile = $query->row()->vk;
			if($query->row()->fb)
				$this->fb_profile = $query->row()->fb;
			if($query->row()->ok)
				$this->ok_profile = $query->row()->ok;
			if($query->row()->google)
				$this->google_profile = $query->row()->google;
			if($query->row()->from_seedoff && $query->row()->token)
				$this->seedoff_token = $query->row()->token;
		}
	}
	
	function get_current_user(){
		return $this->get_user_by_id($this->user_id);
	}
	
	function update_from_seedoff($userid,$seedoff_info){
		
		$data = array(
		'from_seedoff' => 1,
		'role_id' => $seedoff_info['role']
		);
		if($seedoff_info['avatar'])
			$data['avatar'] = $seedoff_info['avatar'];
		$this->db->where('id',$userid);
		$res = $this->db->update($this->tablename,$data);
		return $res;
	}
	
	function get_password($user_id)
	{
		$buffer = $this->get_user_by_id($user_id);
		$user = $buffer->row();
		return $user->password;
	}
}
?>