<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
 <meta name="description" content="{$site_description}" />
 <meta name="keywords" content="{$site_keywords}" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>{$msg_title}</title>
<link rel="stylesheet" type="text/css" href="{$THEME}css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$THEME}css/colorbox/colorbox.css" media="all" />
<link rel="icon" type="image/vnd.microsoft.icon" href="{echo siteinfo('siteinfo_favicon_url')}" />
<link rel="SHORTCUT ICON" href="favicon.ico" /><script type="text/javascript" src="{$THEME}js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="{$THEME}js/jquery.colorbox.js"></script>
 <script type="text/javascript" src="{$THEME}js/functions.js"></script>
 <script type="text/javascript">
 	
 {literal}
 	$(document).ready(function(){
	var msg = $('#msg').html();
	var title = $('#msg_title').html();
	$.colorbox({html: msg, open: true, opacity: 0.5, title: title});
}); 
{/literal}
 </script>

</head>
<body>
{if $type == 'private'}
	<div id="msg">{$msg}</div>
{elseif $type == 'protected'}	
	<div id="msg">
		{$content}
	</div>
{/if}
	<div id="msg_title">{$msg_title}</div>

</body>
</html>