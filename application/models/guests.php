<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Guests extends CI_Model{
	
	public $key = null;
	public $last_ip;
	public $last_visited;
	public $main_table = 'guests';
	public $images_table = 'images_guests';
	public $time_expire = 365;
	public $usertokeninfo = array();

	
	function init(){
		$data_create = date('Y-m-d H:i:s');

		if(isset($_REQUEST['token'])){
			$this->save_key($_REQUEST['token'],$data_create);	
			$this->usertokeninfo = $this->my_auth->get_user_by_token($_REQUEST['token']);
		}
		if(!$this->exists_key()){
			$this->save_key($this->get_hash($data_create),$data_create);	

		}
		else{
			if(!$this->key)
				$this->key = $_COOKIE['guest_key'];
			if(empty($_SESSION['userinfo'])){
				$this->set_userinfo($this->key,date('Y-m-d H:i:s'),true);
			}
		}	
				
	}
	
	function merge_files_by_guest_key($old_key,$new_key){
		
		$this->db->where('guest_key',$old_key);
		$res = $this->db->update($this->images_table,array('guest_key' => $new_key));
		return $res;
	}
	
	function delete_guest_by_key($key){
		$res = $this->db->delete($this->main_table,array('key' => $key));
	}
	
	function exists_key(){
		if($this->key)
			return true;
		if(isset($_COOKIE['guest_key']))
			return true;
		return false;
	}
	
	function exists_guest($key){
		$query = $this->db->get_where($this->main_table,array('key' => $key));
		if($query->row())
			return true;
		return false;
	}
	
	function get_hash($date){
		return md5($date.$_SERVER['REMOTE_ADDR']);
	}
	
	function save_key($hash,$date_create){
		$res_exists = $this->db->get_where($this->main_table,array('key' => $hash));		

		if(!$res_exists || $res_exists->num_rows() < 1){
			$data = array(
			'key' => $hash,
			'last_ip' => $_SERVER['REMOTE_ADDR'],
			'created' => $date_create,
			'last_visited' => '0000-00-00 00:00:00'
			);
			$res = $this->db->insert($this->main_table,$data);
			if($res){
				setcookie('guest_key',$hash,time() + (86400*$this->time_expire),'/');
				$this->set_userinfo($hash,$date_create);
				$this->key = $hash;
			return true;	
			
			}
		}
		else{
			if($hash == $_COOKIE['guest_key'])
				return true;
			$res_old_key = $this->db->get_where($this->images_table,array('guest_key' => $old_key));
			if(!$res_old_key || $res_old_key->num_rows() < 1){
				setcookie('guest_key',$hash,time() + (86400*$this->time_expire),'/');
				$this->delete_guest_by_key($old_key);
				return true;
			}
			else{
				$res_update = $this->merge_files_by_guest_key($old_key,$hash);
				if($res_update){
					setcookie('guest_key',$hash,time() + (86400*$this->time_expire),'/');
					$this->delete_guest_by_key($old_key);
				}
				return true;
			}
			
			
		}
		
		
		return false;
	}
	
	function set_userinfo($hash,$date,$update=false){
		$userinfo = array(
			'last_ip' => $_SERVER['REMOTE_ADDR'],
			'last_visited' => $date
		);
		$_SESSION['userinfo'] = $userinfo;
		if($update){
			$this->db->where('key',$hash);
			$this->db->update($this->main_table,$userinfo);
		}
	}
	
		
	
}
	
?>