<?php


$limit = 100;
$sql = "SELECT torrent_id FROM remove_queue ORDER BY pictures DESC LIMIT $limit";
$table = 'pictures';

$res = mysql_query($sql);
if (mysql_num_rows($res) > 0)
{
	while ($arr = mysql_fetch_assoc($res))
    {
		
		$torrent_id = (int)$arr['torrent_id'];
//		echo '<br>torrent_id <b>'.$torrent_id.'</b><br>';
		if(!$torrent_id)
			continue;
		$res_torrent = mysql_query("SELECT id,size FROM $table WHERE torrent_id = $torrent_id");
		$buffer_arr = array();
		while($arr_torrent = mysql_fetch_assoc($res_torrent)){
			$buffer_arr[$arr_torrent['id']] = $arr_torrent['size'];
		}
//		var_dump($buffer_arr);
//		echo '<br> <b>Unique</b><br>';
		$arr_unique = array_unique($buffer_arr);
		$keys_unique = array_keys($arr_unique);
//    	var_dump($arr_unique);
//		echo '<br>';
//		var_dump($keys_unique);
		if(count($arr_unique) < count($buffer_arr)){
			$sql = "DELETE FROM $table WHERE torrent_id = $torrent_id AND id NOT IN (".implode(',',$keys_unique).")";
//			echo $sql.'; <br>';
			mysql_query($sql);
			
		}
		
		mysql_query("DELETE FROM test.remove_queue WHERE torrent_id = $torrent_id");
		unset($buffer_arr);
		
    }
}
unset($arr);
mysql_free_result($res);

?>