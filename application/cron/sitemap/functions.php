<?php

function createsmt() {

  global $APPLICATION_PATH, $WEB_PATH;
  $maxinsitemapt = 10000;

  $resGetCount = mysql_query("SELECT count(id) as count FROM pictures") or die(mysql_error());
  $rowGetCount = mysql_fetch_assoc($resGetCount);
  $alcount = $rowGetCount["count"];

  unset($rowGetCount);
  mysql_free_result($resGetCount);

  $loopcount = ceil($alcount/$maxinsitemapt);
  if($loopcount < 1)
  	$loopcount = 1;
  $start = 0;


  for ($i=1; $i<=$loopcount; $i++)
  {
    if ($i==$loopcount)
    {
        $y = $alcount - $start;
        $limit = "LIMIT $start, $y";
    }
    else
    {
    	$tmpmax = $maxinsitemapt - 1;
    	$limit = "LIMIT $start, $tmpmax";
  	}
  	$start = $start + $maxinsitemapt;


  	// update sitemapt.xml
  	if ($i==1){
		 $sitemaptfilet = "$WEB_PATH/sitemap.xml";

	}
  	else{
		$num = $i - 1;
		$sitemaptfilet = "$WEB_PATH/sitemaps/$num.xml";

	}

  	ob_start(); // start the output buffer

  	print("<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">
  <url>
    <loc>".SITE_URL."/</loc>
    <changefreq>hourly</changefreq>
    <priority>0.8</priority>
  </url>");

  	$doGet = mysql_query("SELECT id, main_url, UNIX_TIMESTAMP(added) as added FROM pictures ORDER BY added DESC $limit") or die(mysql_error());

  	while($item=mysql_fetch_array($doGet))
  	{
    	$id=$item['id'];
    	$added=strip_tags(date("Y-m-d",$item['added']));
    	print("
  <url>
    <loc>".SITE_URL.$item['main_url']."</loc>
    <lastmod>$added</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.5</priority>
  </url>
");
  	}
  	print("</urlset>");

    unset($item);
    mysql_free_result($doGet);

  	$fpt = fopen($sitemaptfilet, 'w');
  	fwrite($fpt, ob_get_contents());
  	fclose($fpt);
  	ob_end_clean();
	$xml = '<?xml version="1.0" encoding="utf-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	$xml .= "<sitemap>
        <loc>http://www.imghost.pro/sitemap.xml</loc>
        <lastmod>$added</lastmod>
    </sitemap>";
	for ($i=1; $i<=$loopcount; $i++){
		$xml .= "<sitemap>
        <loc>http://www.imghost.pro/sitemaps/$i.xml</loc>
        <lastmod>$added</lastmod>
    </sitemap>";
	}
	$xml .= '</sitemapindex>';
	
	$fp = fopen("$WEB_PATH/sitemap_index.xml", 'w');
  	fwrite($fp, $xml);
  	fclose($fp);
  }
  
  }
  
  function write_log($text)
{
	$added = date('Y-m-d H:i:s');
	$text = mysql_real_escape_string($text);
  	mysql_query("INSERT INTO cron_logs (id, added, txt) VALUES(null, '$added', '$text')");

}

function get_categories(){
	
	global $sync_db;
	$arr = array();
	$res = mysql_query("SELECT id, name FROM ".$sync_db.".categories");
if (mysql_num_rows($res) > 0){
	while ($row = mysql_fetch_assoc($res))
    {
		$arr[$row['id']] = $row['name'];
	}
}
return $arr;

}

function get_tag_names(){
	$arr = array();
	$res = mysql_query("SELECT id, value FROM tags");
if (mysql_num_rows($res) > 0){
	while ($row = mysql_fetch_assoc($res))
    {
		$arr[$row['value']] = $row['id'];
	}
}
return $arr;

}

function set_categories(){
	
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	global $sync_db;
	$categories = get_categories();
	$tags = get_tag_names();
	$res = mysql_query("SELECT torrent_id, category FROM ".$sync_db.".torrent_info");
	if (mysql_num_rows($res) > 0){
		while ($row = mysql_fetch_assoc($res))
    	{
			$torrent_id = (int)$row['torrent_id'];
			$category = (int)$row['category'];
			$value = $categories[$category];
			$tag_id = (int)$tags[$value];
			if($tag_id)
				@mysql_query("UPDATE LOW_PRIORITY pictures SET tag_id = $tag_id WHERE torrent_id = $torrent_id AND tag_id IS NULL");
		}
}
	
	
}


?>