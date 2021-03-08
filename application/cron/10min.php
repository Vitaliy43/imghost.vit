<?php


require_once('config.php');
$APPLICATION_PATH=realpath(dirname(__FILE__).'/..');
$WEB_PATH=realpath(dirname(__FILE__).'/../..');

require_once("$APPLICATION_PATH/config/constants.php");
include_once('sitemap/functions.php');

//include_once('transfer_images.php');

//$res = mysql_query("SELECT value FROM ".$sync_db.".common_settings WHERE key = 'use_main_table_mode'");
//if(mysql_num_rows($res) == 1)
//	$use_main_table_mode = mysql_result($res,0,'value');
//else
	$use_main_table_mode = 2;


////////////////////////////////////////////// Создаем новые обложки /////////////////////////////
/*
$limit = 500;

//$res = mysql_query("SELECT i.url, of.torrent_id, of.image_size FROM ".$sync_db.".old_files_covers of INNER JOIN ".$sync_db.".image_covers i ON of.torrent_id = i.torrent_id LIMIT  $limit");

$res = mysql_query("SELECT i.url, of.torrent_id, of.image_size FROM ".$sync_db.".old_files_covers of INNER JOIN ".$sync_db.".image_covers i ON of.torrent_id = i.torrent_id LIMIT  $limit");
//echo mysql_num_rows($res).'<br>';
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		$torrent_id = (int)$arr['torrent_id'];
		$image_size = (int)$arr['image_size'];
		$filename_destiny = ImageHelper::url_to_realpath($arr['url']);
		$buffer_filename = explode(DIRECTORY_SEPARATOR,$filename_destiny);
		list($filename,$ext) = explode('.',$buffer_filename[count($buffer_filename) -1]);
		$buffer_filename[count($buffer_filename)-1] = $filename.'_'.$image_size.'.'.$ext;
		$filename_destiny_moder = implode(DIRECTORY_SEPARATOR,$buffer_filename);
		$filename_destiny_moder = str_replace('big','preview',$filename_destiny_moder);

		if(file_exists($filename_destiny) && $image_size != 150){
			if(file_exists($filename_destiny_moder))
				unlink($filename_destiny_moder);
			ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_moder,$image_size,0,0,0,false);

		}
			
		mysql_query("DELETE FROM ".$sync_db.".old_files_covers WHERE torrent_id = $torrent_id");

    }
	unset($arr);

}
mysql_free_result($res);
*/


////////////////////////////////////////////// Снятие привязки к torrent_id для картинок поставленных в очередь /////////////////////////////

$res = mysql_query("SELECT * FROM ".$sync_db.".torrent_queue WHERE type = 'delete'");
//echo mysql_num_rows($res).'<br>';
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		$torrent_id = (int)$arr['torrent_id'];
		if(!$torrent_id)
			continue;
		if($use_main_table_mode == 1){
			mysql_query("UPDATE LOW_PRIORITY images_guests SET torrent_id = null, access = 'private', position = 0, cover = 0 WHERE torrent_id = $torrent_id");
			mysql_query("UPDATE LOW_PRIORITY pictures SET torrent_id = null, access = 'private', position = 0, cover = 0 WHERE torrent_id = $torrent_id");

		}
		elseif($use_main_table_mode == 2){
			mysql_query("UPDATE LOW_PRIORITY pictures SET torrent_id = null, access = 'private', position = 0, cover = 0 WHERE torrent_id = $torrent_id");

		}
		mysql_query("DELETE FROM ".$sync_db.".torrent_queue WHERE torrent_id = $torrent_id");
    }
	unset($arr);

}
mysql_free_result($res);


//////////////////////////////////////////////////// Удаляем из imghost_seedoff.image_screens те картинки, которых нет в images_guests /////////////////

mysql_query("DELETE FROM imghost_seedoff.`new_image_screens` WHERE image_id NOT IN (SELECT id FROM imghostpro.pictures)");

//////////////////////////////////////////////////// Удаляем из imghost_seedoff.image_screens те картинки, к которым нет привязки к torrent_id в pictures] /////////////////

mysql_query("DELETE FROM imghost_seedoff.`new_image_screens` WHERE url NOT IN (SELECT url FROM imghostpro.pictures WHERE torrent_id IS NOT NULL)");

//////////////////////////////////////////////////// Вставляем в imghost_seedoff.image_screens те картинки, которые есть в pictures, и которых нет в image_screens /////////////////


mysql_query("INSERT IGNORE INTO imghost_seedoff.`new_image_screens` SELECT id, torrent_id, url, position FROM imghostpro.pictures WHERE torrent_id NOT IN (SELECT torrent_id FROM imghost_seedoff.`new_image_screens`) AND cover = 0");


/*
/////////////////////////////////////////////////////////// Разовое создание превью обложек на 500 /////////////////////
//write_log('Begin create big posters_preview');
//$res = mysql_query("SELECT url FROM imghost_seedoff.image_covers");
$res = mysql_query("SELECT url,torrent_id FROM imghost_seedoff.buffer_covers LIMIT 1000");

  while ($arr = mysql_fetch_assoc($res))
   {
       	$url = $arr["url"];
       	$torrent_id = (int)$arr["torrent_id"];
		$filename = ImageHelper::url_to_realpath($url);
		$date = ImageHelper::get_data_from_url($url);
		$filename_preview = str_replace('big','preview',$filename);
		$filename_preview_bigposter = ImageHelper::get_big_poster_preview_url($filename_preview);
//		echo 'bigposter '.$filename_preview_bigposter.'<br>';

		if(!file_exists($filename_preview_bigposter) && file_exists($filename))
			ImageHelper::make_thumbnail($filename,$filename_preview_bigposter,500,0,0,1,false,'Seedoff.net');
		mysql_query("DELETE FROM imghost_seedoff.buffer_covers WHERE torrent_id = $torrent_id");
		
   }
 mysql_free_result($res);
// write_log('End create big posters_preview');
*/

/*
  $res = mysql_query("SELECT id,url,torrent_id FROM images_guests WHERE torrent_id > 0  AND cover = 0 ORDER BY torrent_id");
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
			ImageHelper::make_thumbnail($filename,$filename_preview_overlib,150,0,0,1,false);
			
//		}
   }
 mysql_free_result($res);
 */
 //   */
//include_once('transfer_images.php');


?>