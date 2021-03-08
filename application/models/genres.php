<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Genres extends CI_Model{
	
	public $tablename = 'torrent_genres';
	public $tablelist_name = 'genres_list';
	
	 public function __construct() {
        parent::__construct();
    }
	
	function get_names_by_ids($genres_list){
		$sql = "SELECT name FROM ".$this->tablelist_name." WHERE id IN ($genres_list)";
		$res = $this->db->query($sql);
		$arr = array();
		foreach($res->result_array() as $item){
			$arr[] = $item['name'];
		}
		$names = implode(', ',$arr);
		return $names;
	}
	
	function get_count_by_list($list){
		
	if($this->my_files->admin_mode == true)
			$access = 1;
		else
			$access = "access = 'public'";
		$where = " AND torrent_id IN (SELECT DISTINCT torrent_id FROM ".$this->genres->tablename." WHERE `genre_id` IN ($list))";
		$sql = "SELECT COUNT(*) AS num FROM ".$this->guests->images_table."  WHERE $access $where ";
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		return $res->row()->num;
		
	}

}

?>