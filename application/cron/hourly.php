<?php

require_once('config.php');
$APPLICATION_PATH=realpath(dirname(__FILE__).'/..');
$WEB_PATH=realpath(dirname(__FILE__).'/../..');

require_once("$APPLICATION_PATH/config/constants.php");
include_once('sitemap/functions.php');


//$res = mysql_query("SELECT value FROM ".$sync_db.".common_settings WHERE key = 'use_main_table_mode'");
//if(mysql_num_rows($res) == 1)
//	$use_main_table_mode = mysql_result($res,0,'value');
//else
	$use_main_table_mode = 2;
	
if($use_main_table_mode == 2){
	$images_guest_table = 'pictures';
	$images_user_table = 'pictures';
	$sync_screens = 'new_image_screens';
}
else
	$sync_screens = 'image_screens';


/////////////////////////////////////////////////////// Создание карты сайта //////////////////////////////////////////////
$hour = date('H');
$h1 = 6;
$h2 = 7;
if($hour >= $h1 && $hour < $h2){
	write_log('Begin create sitemap');
	createsmt();
	write_log('End create sitemap');

}

////////////////////////////////////////////////////// Назначение тегов для картинок с торрент_ид там, где нет тегов ////////////////////////
$h1 = 8;
$h2 = 9;
if($hour >= $h1 && $hour < $h2){
	write_log('Begin set_categories');
	set_categories();
	write_log('End set_categories');

}



/*
///////////////////////////////////////// Удаление из базы картинки, которых нет на сервере ////////////////////////////////////////////////////////////
$res = mysql_query("SELECT id,url FROM images");
  while ($arr = mysql_fetch_assoc($res))
   {
       	$id=$arr["id"];
       	$url=$arr["url"];
		$filename=ImageHelper::url_to_realpath($url);
		if(!file_exists($filename))
       		mysql_query("DELETE LOW_PRIORITY FROM images WHERE id = $id");
   }
 mysql_free_result($res);
 
 $res = mysql_query("SELECT id,url FROM images_guests");
  while ($arr = mysql_fetch_assoc($res))
   {
       	$id=$arr["id"];
       	$url=$arr["url"];
		$filename=ImageHelper::url_to_realpath($url);
		if(!file_exists($filename))
       		mysql_query("DELETE LOW_PRIORITY FROM images_guests WHERE id = $id");
   }
 mysql_free_result($res);
 */
 
//////////////////////////////////////////// Создаем таблицу позиций юзеров ///////////////////////////////////////////////////////////////////
 
$sql = "DROP TABLE IF EXISTS members_alphabet_asc;
SET @counter := 0;
CREATE TABLE members_alphabet_asc ENGINE=MyISAM SELECT (@counter := @counter + 1) AS position,id,username from users ORDER BY username ASC;
ALTER TABLE `members_alphabet_asc` CHANGE `position` `position` BIGINT(21) NOT NULL;
ALTER TABLE `members_alphabet_asc` ADD PRIMARY KEY(`position`);";
mysql_query($sql);


/////////////////////////////////////////// Обновляем кол-во картинок по каждому тегу ////////////////////////////////////////////////////////
$res = mysql_query("SELECT id,parent_id FROM tags");
if (mysql_num_rows($res) > 0){
	while ($arr = mysql_fetch_assoc($res))
    {
		$id = $arr["id"];
		$parent_id = $arr["parent_id"];
		if(!$parent_id){
			if($use_main_table_mode == 2){
				$res_count = mysql_query("SELECT COUNT(*) AS 'num' FROM $images_guest_table WHERE tag_id IN (SELECT id FROM tags WHERE parent_id = $id) ");
					$num_images = mysql_result($res_count,0,'num');
					mysql_query("UPDATE LOW_PRIORITY tags SET images = $num_images WHERE id = $id");
			}
			
			mysql_free_result($res_count);
			}
			else{
				$res_count = mysql_query("SELECT COUNT(*) AS 'num' FROM $images_guest_table WHERE tag_id IN (SELECT id FROM tags WHERE parent_id = $id) UNION SELECT COUNT(*) AS 'num' FROM $images_user_table WHERE tag_id IN (SELECT id FROM tags WHERE parent_id = $id)");
				if(mysql_num_rows($res_count) > 0){
					if(mysql_num_rows($res_count) == 2)
						$num_images = mysql_result($res_count,0,'num') + mysql_result($res_count,1,'num');
					else
						$num_images = mysql_result($res_count,0,'num');
					mysql_query("UPDATE LOW_PRIORITY tags SET images = $num_images WHERE id = $id");
				}
			
			mysql_free_result($res_count);
			}
					
			
		}
	
		
			if($use_main_table_mode == 2){
				
				$res_count = mysql_query("SELECT COUNT(*) AS 'num' FROM $images_guest_table WHERE tag_id = $id");

			if(mysql_num_rows($res_count) > 0){
				$num_images = mysql_result($res_count,0,'num');
				mysql_query("UPDATE LOW_PRIORITY tags SET images = $num_images WHERE id = $id");
			}
			mysql_free_result($res_count);
			}
			else{
				$res_count = mysql_query("SELECT COUNT(*) AS 'num' FROM $images_guest_table WHERE tag_id = $id UNION SELECT COUNT(*) AS 'num' FROM $images_user_table WHERE tag_id = $id");

			if(mysql_num_rows($res_count) > 0){
				if(mysql_num_rows($res_count) == 2)
					$num_images = mysql_result($res_count,0,'num') + mysql_result($res_count,1,'num');
				else
					$num_images = mysql_result($res_count,0,'num');
				mysql_query("UPDATE LOW_PRIORITY tags SET images = $num_images WHERE id = $id");
			}
			mysql_free_result($res_count);
			}
			

		}
		
////////////////////////////////////////////// Обновление файла tags.js /////////////////////////////

$res = mysql_query("SELECT * FROM tags WHERE images > 0");
$tagnames = array();
$tags = array();
//echo mysql_num_rows($res).'<br>';
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		$tagnames[] = $arr['value'];
		$tags[$arr['id']] = $arr['value'];
    }
	unset($arr);
	$html = 'var tagnames = [';
	$count = 1;
	foreach($tagnames as $tagname){
		$html .= '"'.$tagname.'"';
		if(count($tagnames) != $count)
			$html .= ',';
		$count++;
	}
	$html .= '];';
	
	$html .= 'var tags = new Array();';
	foreach($tags as $key=>$value){
		$html .= 'tags['.$key.'] = "'.$value.'";';
	}
	
	$fh = fopen("$WEB_PATH/templates/imghost/js/tags.js","w+");
	fwrite($fh,$html);
	fclose($fh);
}
mysql_free_result($res);
		

//ini_set('gd.jpeg_ignore_warning', 1);

$h1 = 4;
$h2 = 5;
if($hour >= $h1 && $hour < $h2){
	//////////////////////////////////////////////////////// Перезаливка превью для обложек на 150 пикселей //////////////////////////////////////////////////////////////

write_log('Begin create posters_preview');
$res = mysql_query("SELECT url FROM imghost_seedoff.image_covers");

  while ($arr = mysql_fetch_assoc($res))
   {
       	$url=$arr["url"];
		$filename=ImageHelper::url_to_realpath($url);
		$date = ImageHelper::get_data_from_url($url);
		$filename_preview = str_replace('big','preview',$filename);
		$filename_preview_overlib = ImageHelper::get_poster_preview_url($filename_preview);

		if(!file_exists($filename_preview_overlib) && file_exists($filename))
			ImageHelper::make_thumbnail($filename,$filename_preview_overlib,150,0,0,0,false);
		
   }
 mysql_free_result($res);
 write_log('End create posters_preview');

}


//ini_set('gd.jpeg_ignore_warning', 0);


/////////////////////////////////////////////////////// Создаем превью если они по какой-либо причине не были созданы ////////////////////////////////////////////////
/*
$res = mysql_query("SELECT id,url FROM images");

  while ($arr = mysql_fetch_assoc($res))
   {
       	$id=$arr["id"];
       	$url=$arr["url"];
		$filename=ImageHelper::url_to_realpath($url);
		$date = ImageHelper::get_data_from_url($url);
		$filename_preview_80 = str_replace('big','preview_80',$filename);
		

		if(!file_exists($filename_preview_80)){
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$date['year'])){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$date['year']);
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$date['year'].DIRECTORY_SEPARATOR.$date['monthday'])){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.$date['monthday']);
			}
			ImageHelper::resizeimg($filename,$filename_preview_80,80);
		}
		
		
   }
 mysql_free_result($res);
 */
 
 //////////////////////////////////////////////////// Удаляем из imghost_seedoff.image_screens те картинки, которые были заглушены в имгхост /////////////////


$res = mysql_query("SELECT ig.torrent_id, ig.position, ig.cover, iis.image_id FROM imghost_seedoff.".$sync_screens." iis JOIN imghostpro.pictures ig ON ig.id = iis.image_id");
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		$torrent_id = ($arr['torrent_id']);
		$position = (int)($arr['position']);
		$image_id = (int)($arr['image_id']);
		$cover = (int)($arr['cover']);
		if($torrent_id){
			if($position)
				mysql_query("UPDATE LOW_PRIORITY imghost_seedoff.".$sync_screens." SET position = $position WHERE image_id = $image_id");
		}
		else{
			mysql_query("DELETE LOW_PRIORITY FROM imghost_seedoff.".$sync_screens." WHERE image_id = $image_id");
		}


    }
}
unset($arr);
mysql_free_result($res);

 
 /*
 $res = mysql_query("SELECT id,url,torrent_id FROM images_guests WHERE torrent_id > 0  AND url LIKE '%big/2015/0729%' ORDER BY torrent_id");
// $res = mysql_query("SELECT id,url,torrent_id FROM images_guests");
  while ($arr = mysql_fetch_assoc($res))
   {
       	$id=$arr["id"];
       	$url=$arr["url"];
		$torrent_id=(int)$arr['torrent_id'];
		$date = ImageHelper::get_data_from_url($url);
		$filename=ImageHelper::url_to_realpath($url);
		$filename_preview_80 = str_replace('big','preview_80',$filename);
		$filename_preview = str_replace("big",'preview',$filename);
		$filename_preview_overlib = ImageHelper::get_moder_preview_url($filename_preview);
		if(!file_exists($filename_preview_80)){
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$date['year'])){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$date['year']);
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$date['year'].DIRECTORY_SEPARATOR.$date['monthday'])){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.$date['monthday']);
			}
			ImageHelper::resizeimg($filename,$filename_preview_80,80);
			
		}
		
//		if(!file_exists($filename_preview_overlib)){
	
			if(file_exists($filename_preview_overlib))
				unlink($filename_preview_overlib);
			ImageHelper::make_thumbnail($filename,$filename_preview_overlib,150,0,0,0,false);
			
//		}
   }
 mysql_free_result($res);
 */
 
 
 ///////////////////////////////////////////////////// Удаляем гостей, которые слишком долго не заходили на сервер /////////////////////////////////////////
$time_expire = time() - $config['expire_guest'];
$sql = "DELETE FROM guests WHERE UNIX_TIMESTAMP(created) < $time_expire AND last_visited = '0000-00-00 00:00:00'";
mysql_query($sql);
$sql = "DELETE FROM guests WHERE UNIX_TIMESTAMP(last_visited) < $time_expire AND last_visited != '0000-00-00 00:00:00'";
mysql_query($sql);

//////////////////////////////////////////////////// Назначение токенов таблице юзеров ///////////////////////////////////////////////////////////////////
$res = mysql_query("SELECT username,email,token FROM $sync_db.seedoff_users");
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		$username = mysql_real_escape_string($arr['username']);
		$email = mysql_real_escape_string($arr['email']);
		$token = mysql_real_escape_string($arr['token']);
		$sql = "UPDATE users SET token = '$token' WHERE username = '$username'";
		mysql_query($sql);

    }
}
unset($arr);
mysql_free_result($res);

//////////////////////////////////////////////////// Костыль для коррекции токенов в таблице юзеров и картинок /////////////////////////////////////////////////////////////////
$res = mysql_query("SELECT f.id AS torrent_id,f.uploader,u.token FROM $sync_db.seedoff_files f JOIN $sync_db.seedoff_users u ON f.uploader = u.id");
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		$torrent_id = (int)($arr['torrent_id']);
		$uploader = (int)($arr['uploader']);
		$token = mysql_real_escape_string($arr['token']);
		if(!$torrent_id)
			continue;
		if($use_main_table_mode == 2){
			$sql = "UPDATE pictures SET guest_key = '$token' WHERE torrent_id = $torrent_id";
			mysql_query($sql);
		}
		elseif($use_main_table_mode == 1){
			$sql = "UPDATE images_guests SET guest_key = '$token' WHERE torrent_id = $torrent_id";
			mysql_query($sql);
			$sql = "UPDATE pictures SET guest_key = '$token' WHERE torrent_id = $torrent_id";
			mysql_query($sql);

		}

    }
}
unset($arr);
mysql_free_result($res);


//write_log('Begin set_search_result');
include_once('search_result.php');
//write_log('End set_search_result');


//include_once('transfer_images.php');


?>