<?php
if(!defined('BASEPATH'))
	define('BASEPATH','/');

if(!defined('FROM_CRON'))
	define('FROM_CRON',1);

//$PATH = '/home/services/imghost/www';
$PATH = 'd:\server\www\imghost.vit';
//$PATH = $_SERVER['DOCUMENT_ROOT'];
//die('136');
/*
require_once($PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

require_once($PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'constants.php');
require_once($PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'image_helper.php');
require_once($PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'my_url_helper.php');
mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']);
mysql_select_db($db['default']['database']);
@mysql_query ("SET NAMES `utf8`");
*/
$images_user_table = 'images';
$images_guest_table = 'images_guests';
$maxlength_show_filename = 50;
$limit = 200;
$prefix_source = "";
$local_source = 'g:\torrentimg';
//$local_source = '/home/services/torrentimg';


$res = mysql_query("SELECT * FROM {$prefix_source}old_files_images LIMIT $limit");

   	if (mysql_num_rows($res) > 0)
   	{
       	while ($arr = mysql_fetch_assoc($res))
       	{
       		$torrent_id = (int)$arr["torrent_id"];
       		$image_size = (int)$arr["image_size"];
       		$genres_list = $arr["genres_list"];
       		$tag_id = (int)$arr["category"];
			$show_filename = $arr['filename'];

			if(!$tag_id)
				$tag_id = null;
			
       	
			$vars = array('image' => $arr["image"], 'screen1' => $arr['screen1'], 'screen2' => $arr["screen2"], 'screen3' => $arr["screen3"], 'screen4' => $arr["screen4"], 'screen5' => $arr["screen5"], 'screen6' => $arr["screen6"]);
			$pictures = 0;
			foreach($vars as $var){
				if($var)
					$pictures++;
			}

       		$data = $arr["data"];
       		$token = $arr["imgtoken"];
			$buffer_date = explode(' ',$data);
			list($year,$month,$day) = explode('-',$buffer_date[0]);
			
			$insert = false;
			
	foreach($vars as $key=>$var){
				
	$buffer_ext = explode('.',$var);
	
	if(!$var)
		continue;
	$ext = $buffer_ext[count($buffer_ext) - 1];
	if($ext == 'jpeg')
		$ext = 'jpg';
		  
	$hash = $token.'_'.md5($var.'.'.$ext.(rand(0,1000)+time()));
	$remote_url = filter_var($var,FILTER_VALIDATE_URL);
	if(!$remote_url){
		$url = $local_source.DIRECTORY_SEPARATOR.$var;
		if(!file_exists($url))
			continue;
	}
	else{
		$http_status = check_http_status($var,true);
		if($http_status != 200)
			continue;
	
		$url = $var;

	}
	$old_url = $var;
	
	
$buffer_filename = $year.DIRECTORY_SEPARATOR.$month.$day.DIRECTORY_SEPARATOR.$hash;
$buffer_filename_url = $year.'/'.$month.$day.'/'.$hash;

if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$year)){
	mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$year);
}
if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day)){
	$m1 = mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day);
	@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
}
			
if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$year)){
	$m2 = mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$year);

}
if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day)){
	$m3 = mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day);
	@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day,0777);
}
			
if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$year)){
	$m4 = mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$year);

}
if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day)){
	$m5 = mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day);

	@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day,0777);
}
			
$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";
$filename_destiny_preview_moder_cover = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_".$image_size.".$ext";
$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
$filename_src_html = '/image/'.$buffer_filename_url;

				
if(copy($url,$filename_destiny)){
//	echo 'url '.$url.'<br>';
//	echo 'filename_destiny '.$filename_destiny.'<br>';
			ImageHelper::$preview_mode = true;
				
			$res1 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview);
				
			$res2 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);
				
				if($res1){
					$sizes = getimagesize($filename_destiny);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					$image_proportion = $file_height / $file_width;

//					$show_filename = get_show_filename($old_url);
					
					$pixels = $file_height * $file_width;
					if($pixels > ImageHelper::$web_pixel_size){
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$year)){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$year);
				
						}	
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day)){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day);
							@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.$day,0777);
						}
						$filename_destiny_web = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
						ImageHelper::$preview_mode = true;
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_web,ImageHelper::$web_width);

					}
					

						$access = 'public';
						
//					if(mb_strlen($show_filename) > $maxlength_show_filename)
//						$show_filename = mb_substr($show_filename,0,$maxlength_show_filename);
						
						$data_create = date('Y-m-d H:i:s');
						if($key != 'image'){
							$position = mb_substr($key,-1);
							$cover = 0;
						}
						else{
							$position = 0;
							$cover = 1;

						}
						if($cover){
							if($image_size)
								ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder_cover,$image_size,0,0,0,false);
							else
								ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder_cover,ImageHelper::$default_width_cover,0,0,0,false);

						}
						
						$sql = "INSERT INTO images_guests (id, url, main_url, filename, show_filename, size, width, height, guest_key, added, access, tag_id, rating, views, torrent_id, position, cover) VALUES (null, ".sqlesc($filename_src_big).", ".sqlesc($filename_src_html).", ".sqlesc($hash).", ".sqlesc($show_filename).", ".filesize($filename_destiny).", $file_width, $file_height,".sqlesc($token).", ".sqlesc($data_create).", 'public', $tag_id, 0, 0, $torrent_id, $position, $cover)";
						echo 'sql '.$sql.'<br>';
						$res3 = mysql_query($sql);
						$last_id = mysql_insert_id();

						if(!$insert && $res3)
							$insert = true;
						
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_moder,150,true);	
						if($insert){
							if($cover && $last_id)
								mysql_query("REPLACE INTO imghost_seedoff.image_covers (torrent_id, url, image_size, added) VALUES ($torrent_id, ".sqlesc($filename_src_big).",$image_size, ".sqlesc($data_create).")");
							else
								mysql_query("REPLACE INTO imghost_seedoff.image_screens (image_id, torrent_id, url, position) VALUES ($last_id, $torrent_id, ".sqlesc($filename_src_big).",$position)");
						}
					
				}
				else{

				}
			}

}		
		
			if($insert){
				$sql = "INSERT INTO torrents (id, updated, pictures, max_position, owner_key ) VALUES ($torrent_id, '$data_create', $pictures, 7, '$token')";
				mysql_query($sql);
				
				$arr_genres = explode(',',$genres_list);
				/*
				foreach($arr_genres as $genre){
					$genre = (int)$genre;
					$uniq = sqlesc($torrent_id.' - '.$genre);
					$sql = "INSERT INTO torrent_genres (torrent_id, genre_id, data, uniq) VALUES ($torrent_id, $genre, ".sqlesc($data_create).", ".$uniq.")";
					if($genre)
						$res_genre = mysql_query($sql);
					
					
				}
				*/

			}
			mysql_query("DELETE FROM {$prefix_source}old_files_images WHERE torrent_id = $torrent_id");
	
	 	}
   	}
	mysql_free_result($res);		
	
	
function sqlesc($x)
{
  return '\''.mysql_real_escape_string($x).'\'';
}

function get_tag_by_name($arr,$name){
	
	foreach($arr as $key=>$value){
		if($value == $name)
			return $key;
	}
}
			

?>