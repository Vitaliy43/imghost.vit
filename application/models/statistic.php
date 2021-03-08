<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistic extends CI_Model{
	
	public $statistic_period = 12;
	public $uploaded_photo;
	public $created_albums;
	public $num_visitors;
	public $basename = 'imghost_statistic';
	public $views_table = 'images_views';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function init(){
		
		if($this->my_files->use_main_table_mode == 2){
			$this->uploaded_photo = $this->db->count_all($this->my_files->main_table);

		}
		else{
			$num1 = $this->db->count_all($this->members->images_table);
			$num2 = $this->db->count_all($this->guests->images_table);
			$this->uploaded_photo = $num1 + $num2;
			
		}
		
		$albums = $this->db->count_all($this->my_albums->tablename);
		$torrents = $this->db->count_all($this->seedoff_sync->info_table);
		
		$this->created_albums = $albums + $torrents;
//		$this->num_visitors = $this->get_day_statistic();
	}
	
	function footer_statistic($language){
		
		$language['UPDATED_STATISTIC'] = str_replace('%hours%',$this->statistic_period,$language['UPDATED_STATISTIC']);
//		$html = '<p>'.$language['UPLOADED_PHOTO'].': '.$this->uploaded_photo.'<br />'.$language['CREATED_ALBUMS'].': '.$this->created_albums.'<br />Количество посетителей: '.$this->num_visitors.'<br />(Обновляется раз в 12 часов)</p>';
		$html = '<p>'.$language['UPLOADED_PHOTO'].': '.$this->uploaded_photo.'<br />'.$language['CREATED_ALBUMS'].': '.$this->created_albums.'</p>';
		return $html;
	}
	
	function get_day_statistic(){
		$data = date('Y-m-d');
		$current_year = (int)date('Y');
		$query = $this->db->query("SELECT COUNT(*) AS num FROM $this->basename.$current_year WHERE brief_data = '$data'");
		if(!$query)
			return 0;
		return $query->row()->num;
	}
	
	function is_exists_view($id,$type){
		
		$key = $id.'-'.$type.'-'.$this->my_auth->user_id;
		$res = $this->db->get_where($this->views_table,array('key' => $key));

		if(!$res)
			return false;
		if($res->num_rows() < 1)
			return false;
		return true;
		
	}
	
	function set_view($id,$type,$owner_id=null){
		if(isset($_SESSION['image_visited'][$id]))
			return false;
		if($owner_id && $this->my_auth->user_id == $owner_id)
			return false; 
		if($type != 'user' && $type != 'guest')
			return false;
//		if($this->is_exists_view($id,$type)){
//			$_SESSION['image_visited'][$type][$id] = 1;
//			return false;
//		}
		if($this->my_files->use_main_table_mode == 2){
			$guests_table = $this->my_files->main_table;
			$members_table = $this->my_files->main_table;
		}
		else{
			$guests_table = $this->guests->images_table;
			$members_table = $this->members->images_table;
		}
		
		$key = $id.'-'.$type.'-'.$this->my_auth->user_id;
		$data = array(
		'id' => null,
		'user_id' => $this->my_auth->user_id,
		'object' => $type,
		'image_id' => $id,
		'key' => $key,
		'data' => time()
		);
			$query = $this->db->insert_string($this->views_table,$data);
			$query = str_replace('INSERT INTO', 'INSERT LOW_PRIORITY IGNORE INTO',$query);
			$res_insert = $this->db->query($query);
		if($res_insert){
			if($type == 'guest'){
				$this->db->where('id',$id);
				$this->db->set('views','views+1',false);
				$this->db->update($guests_table);
			}
			else{
				$this->db->where('id',$id);
				$this->db->set('views','views+1',false);
				$this->db->update($members_table);
			}
			$_SESSION['image_visited'][$id] = 1;
		}
		
	}
	
	function set_visit(){
		
		if(isset($_SESSION['visited']))
			return false;
		$current_year = (int)date('Y');
		if(!$this->db->table_exists("$this->basename.$current_year")){
			$res = $this->create_table_statistic($current_year);
			if(!$res)
				return false;
			$uniq = date('Y-m-d').' '.$_SERVER['REMOTE_ADDR'];
			$is_visited = $this->db->get_where("$this->basename.$current_year",array('uniq' => $uniq));
			if($is_visited->num_rows() > 0)
				return false;
			
			$data = array(
			'id' => null,
			'data' => date('Y-m-d H:i:s'),
			'brief_data' => date('Y-m-d'),
			'ip' => $_SERVER['REMOTE_ADDR'],
			'uniq' => $uniq
			);
			$query = $this->db->insert_string("$this->basename.$current_year",$data);
			$query = str_replace('INSERT INTO', 'INSERT LOW_PRIORITY IGNORE INTO',$query);
			$res_insert = $this->db->query($query);
			if($res_insert)
				$_SESSION['visited'] = TRUE;
		}
		else{
			
			
			$uniq = date('Y-m-d').' '.$_SERVER['REMOTE_ADDR'];
			$is_visited = $this->db->get_where("$this->basename.$current_year",array('uniq' => $uniq));
			if($is_visited->num_rows() > 0)
				return false;
			
			$data = array(
			'id' => null,
			'data' => date('Y-m-d H:i:s'),
			'brief_data' => date('Y-m-d'),
			'ip' => $_SERVER['REMOTE_ADDR'],
			'uniq' => $uniq
			);
			$query = $this->db->insert_string("$this->basename.$current_year",$data);
			$query = str_replace('INSERT INTO', 'INSERT IGNORE LOW_PRIORITY INTO',$query);
			$res_insert = $this->db->query($query);
			if($res_insert)
				$_SESSION['visited'] = TRUE;
		}
		
	}
	
	function create_table_statistic($tablename)
	{
		$sql = "
		CREATE TABLE IF NOT EXISTS $this->basename.`$tablename` (
  	`id` int(11) NOT NULL auto_increment,
  	`data` datetime NOT NULL,
  	`brief_data` date NOT NULL,
  	`ip` varchar(20) NOT NULL,
  	`uniq` varchar(30) NOT NULL,
  	PRIMARY KEY  (`id`),
  	UNIQUE KEY `uniq` (`uniq`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

	";
		$res = $this->db->query($sql);
		return $res;

	}
	
	function get_num_views_by_user_id($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->select_sum('views');
		$res = $this->db->get($this->members->images_table);
		if(!$res)
			return 0;
		return $res->row()->views;
	}
	
	function get_avg_rating_by_user_id($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->where('rating >',0);
		$this->db->select_avg('rating');
		$res = $this->db->get($this->members->images_table);
		if(!$res)
			return 0;
		return round($res->row()->rating,1);
	}
	
}
?>