<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Model {
	
	public $tablename = 'image_ratings';
	public $units = 10;
	public $rating_unitwidth = 20;
	public $objects = array('guest','user');
	
	public function __construct(){
		Language::load_language('poll');
	}
	
	function get_num_votes_by_image($id){
		$sql = "SELECT COUNT(*) AS num FROM $this->tablename WHERE image_id = $id";
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		return $res->row()->num;
	}
	
function rating_bar($id,$type,$owner_id=null) {
	
	$language = Language::get_languages('poll');

$this->db->select('rating');
if($type == 'guest')	
	$this->db->from($this->guests->images_table);
else
	$this->db->from($this->members->images_table);
$this->db->where('id',$id);
$res = $this->db->get();
if(!$res){
	$current_rating = 0;
}
else{
	$current_rating = $res->row()->rating;
}
if($current_rating > 0){
	if($this->is_exists_vote($this->my_auth->user_id,$id,$type)){
		$static = true;
	}
	else{
		$static = false;

	}
}
else{
	$static = false;

}

if($owner_id && $this->my_auth->user_id == $owner_id)
	$static = true;

$count = $this->get_num_votes_by_image($id);

// now draw the rating bar
$rating_width = $current_rating * $this->rating_unitwidth;

if ($static) {

		$rater = '<div class="h1_vote">'.sprintf("%01.1f",$current_rating).'</div>';
		$rater .= '<div class="vote_label">'.$language['COMMON_RATING'].'</div>';
		if($owner_id && $this->my_auth->user_id == $owner_id){
			
		}
		else{
			$rater .= '<div class="vote_count">'.$language['VOTE_COUNTED'].'</div>';
		}


} else {

      $rater ='<div style="margin-left: 20px;">';
      $rater.='<div class="ratingblock">';

      $rater.='<div id="unit_long'.$id.'">';
      $rater.='  <ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$this->rating_unitwidth*$this->units.'px;">';
      $rater.='     <li class="current-rating" style="width:'.$rating_width.'px;">Текущая '.$current_rating.'/'.$this->units.'</li>';

      for ($ncount = 1; $ncount <= $this->units; $ncount++) { // loop from 1 to the number of units
           if($this->my_auth->role != 'guest') { // if the user hasn't yet voted, draw the voting stars
              $rater.='<li><a href="/poll/set?vote='.$ncount.'&amp;id='.$id.'&amp;c='.$this->units.'&amp;type='.$type.'" title="'.$ncount.' из '.$this->units.'" class="r'.$ncount.'-unit rater" rel="nofollow" onclick="set_rating(this);return false;">'.$ncount.'</a></li>';
           }
		   else{
		   		$rater.='<li class="r'.$ncount.'-unit rater">'.$ncount.'</li>';
		   }
      }
      $ncount=0; // resets the count

      $rater.='  </ul>';
      $rater.='<div>';
	  if($count > 0)
      	$rater.='Оценка: <strong> '.$current_rating.' из '.$this->units.'.0 </strong><br> (Всего голосов: '.$count.')';
	  else
	  	$rater.='<div style="margin-top:3px;margin-left:60px;">Оценок нет</div>';
      $rater.='</div>';
      $rater.='</div>';
      $rater.='</div>';
      $rater.='</div>';
 }
      return $rater;

}

function is_exists_vote($user_id,$id,$type){
	$res = $this->db->get_where($this->tablename,array('user_id' => $user_id,'image_id' => $id, 'object' => $type));
	if(!$res)
		return false;
	if($res->num_rows() > 0)
		return true;
	return false;
}

function update_rating($id,$type,$vote,$user_id=null){
	if(!$user_id)
		$user_id = $this->my_auth->user_id;
	if(!in_array($type,$this->objects))
		return false;
	if($this->is_exists_vote($user_id,$id,$type))
		return false;
	if($vote < 1)
		$vote = 1;
	if($vote > $this->units)
		$vote = $this->units;
	
	$data = array(
	'id' => null,
	'rating' => $vote,
	'user_id' => $user_id,
	'object' => $type,
	'image_id' => $id,
	'data' => time()
	);
	$res = $this->db->insert($this->tablename,$data);
	if($res){
		$this->db->select_avg('rating');
		$this->db->where('image_id',$id);
		$this->db->where('object',$type);
		$res = $this->db->get($this->tablename);
		if(!$res)
			return false;
		$new_rating = $res->row()->rating;
		if($type == 'guest'){
			$this->db->where('id',$id);
			return $this->db->update($this->guests->images_table, array('rating' => $new_rating));

		}
		else{
			$this->db->where('id',$id);
			return $this->db->update($this->members->images_table, array('rating' => $new_rating));

		}	
			
	}
}

}

?>