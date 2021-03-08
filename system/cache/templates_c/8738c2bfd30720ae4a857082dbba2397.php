<html>
<head>
 <meta name="description" content="<?php if(isset($site_description)){ echo $site_description; } ?>" />
 <meta name="keywords" content="<?php if(isset($site_keywords)){ echo $site_keywords; } ?>" />
 <meta name="recreativ-verification" content="uFzNhms50k4UymgxqImSG3PDWRLsPP3vxzIs7DbK" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php if(isset($site_title)){ echo $site_title; } ?></title>
<link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/colorbox/colorbox.css" media="all" />
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo siteinfo('siteinfo_favicon_url')?>" />
<link rel="SHORTCUT ICON" href="favicon.ico" /><script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.colorbox.js"></script>
 <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/functions.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var image_height = $('#container_big_image img').height();
		set_margin_big_image(image_height);
	 });
	 
	 
		
</script>
</head>
<body>
<table width="100%" height="100%">
	<tr>
		<td valign="bottom">
			<div id="container_big_image" style="text-align: center; vertical-align: middle;">
				<a href="<?php if(isset($main_url)){ echo $main_url; } ?>" title="<?php echo $language['TITLE_MAIN_URL']; ?>" >
					<img src="<?php if(isset($image)){ echo $image; } ?>"/>
				</a>
			</div>
		</td>
	</tr>
</table>

</body>
</html>
<?php $mabilis_ttl=1454065576; $mabilis_last_modified=1450879729; //d:\server\www\imghost.vit\templates\imghost\layouts\big_image.tpl ?>