<?php

////////////////////////////////////////////////////////////// Блок вставки данных в таблмцу поиска /////////////////////////////////
// Теги 

$res_tags = mysql_query("SELECT id, parent_id, value FROM tags WHERE images > 0");
if (mysql_num_rows($res_tags) > 0)
{
	while ($tags = mysql_fetch_assoc($res_tags))
    {
		$tag_id = (int)$tags['id'];
		$tag_name = $tags['value'];
		$uniq = 'tag-'.$tag_id;
		if(!$uniq)
			continue;

		if(!$tags['parent_id']){
			$sql = "REPLACE LOW_PRIORITY INTO search_result (`id`, `name`, `object_id`, `type`, `views`,`uniq`) SELECT null, '$tag_name', $tag_id, 'tag', SUM(views) AS views, '$uniq' FROM pictures WHERE tag_id = $tag_id OR tag_id IN (SELECT id FROM tags WHERE parent_id = $tag_id)";
		}
		else{
			$sql = "REPLACE LOW_PRIORITY INTO search_result (`id`, `name`, `object_id`, `type`, `views`, `uniq`) SELECT null, '$tag_name', $tag_id, 'tag', SUM(views) AS views, '$uniq' FROM pictures WHERE tag_id = $tag_id";

		}
		$res_buffer = mysql_query($sql);
    }
	unset($tags);

}
mysql_free_result($res_tags);

// Альбомы
$res_albums = mysql_query("SELECT id, name FROM albums WHERE access = 'public'");
if (mysql_num_rows($res_albums) > 0)
{
	while ($albums = mysql_fetch_assoc($res_albums))
    {
		$album_id = (int)$albums['id'];
		$album_name = $albums['name'];
		$uniq = 'album-'.$album_id;

		$sql = "REPLACE LOW_PRIORITY INTO search_result (`id`, `name`, `object_id`, `type`, `views`, `uniq`) SELECT null, '$album_name', $album_id, 'album', SUM(views) AS views, '$uniq' FROM pictures WHERE album_id = $album_id";

		
		$res_buffer = mysql_query($sql);
    }
	unset($albums);

}
mysql_free_result($res_albums);

$res_albums = mysql_query("SELECT torrent_id, filename FROM ".$sync_db.".torrent_info");
if (mysql_num_rows($res_albums) > 0)
{
	while ($albums = mysql_fetch_assoc($res_albums))
    {
		$torrent_id = (int)$albums['torrent_id'];
		$torrent_name = $albums['filename'];
		$uniq = 'torrent-'.$torrent_id;

		$sql = "REPLACE LOW_PRIORITY INTO search_result (`id`, `name`, `object_id`, `type`, `views`,`uniq`) SELECT null, '$torrent_name', $torrent_id, 'torrent', SUM(views) AS views, '$uniq' FROM pictures WHERE torrent_id = $torrent_id";

		
		$res_buffer = mysql_query($sql);
    }
	unset($albums);

}
mysql_free_result($res_albums);

?>