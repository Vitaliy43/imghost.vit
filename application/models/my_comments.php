<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class My_Comments extends CI_Model {

	public $main_table = 'image_comments';

	function get_comments_by_image_id($image_id){
		$sql = "SELECT ic.id,ic.user_id,u.username,u.avatar FROM ".$this->main_table." ic JOIN users u ON ic.user_id = u.id ORDER BY data";
		$res = $this->db->query($sql);
	}

}

?>