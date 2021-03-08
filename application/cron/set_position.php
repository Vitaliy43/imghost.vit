<?php

$limit = 100;

$sql = "SELECT torrent_id FROM pictures WHERE position = 0 AND cover = 0 AND torrent_id IS NOT NULL ORDER BY id LIMIT $limit";

$res = mysql_query($sql);
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		
		$torrent_id = (int)$arr['torrent_id'];
//		echo '<br>torrent_id <b>'.$torrent_id.'</b><br>';
		if(!$torrent_id)
			continue;
		$res_torrent = mysql_query("SELECT id FROM pictures WHERE torrent_id = $torrent_id");
		for($i = 0; $i < mysql_num_rows($res_torrent); $i++){
			$image_id = mysql_result($res_torrent,$i,'id');
			$position = $i+1;
			$sql = "UPDATE pictures SET position = $position WHERE torrent_id = $torrent_id AND id = $image_id";
			echo $sql.';<br>';
		}
		
		echo '<br><br>';
		
		
    }
}
unset($arr);
mysql_free_result($res);


?>