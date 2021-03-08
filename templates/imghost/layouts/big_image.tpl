<html>
<head>
 <meta name="description" content="{$site_description}" />
 <meta name="keywords" content="{$site_keywords}" />
 <meta name="recreativ-verification" content="uFzNhms50k4UymgxqImSG3PDWRLsPP3vxzIs7DbK" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>{$site_title}</title>
<link rel="stylesheet" type="text/css" href="{$THEME}css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$THEME}css/colorbox/colorbox.css" media="all" />
<link rel="icon" type="image/vnd.microsoft.icon" href="{echo siteinfo('siteinfo_favicon_url')}" />
<link rel="SHORTCUT ICON" href="favicon.ico" /><script type="text/javascript" src="{$THEME}js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="{$THEME}js/jquery.colorbox.js"></script>
 <script type="text/javascript" src="{$THEME}js/functions.js"></script>
<script type="text/javascript">
	{literal}
	$(document).ready(function() {
		var image_height = $('#container_big_image img').height();
		set_margin_big_image(image_height);
	 });
	 
	 {/literal}
		
</script>
</head>
<body>
<table width="100%" height="100%">
	<tr>
		<td valign="bottom">
			<div id="container_big_image" style="text-align: center; vertical-align: middle;">
				<a href="{$main_url}" title="{$language.TITLE_MAIN_URL}" >
					<img src="{$image}"/>
				</a>
			</div>
		</td>
	</tr>
</table>

</body>
</html>
