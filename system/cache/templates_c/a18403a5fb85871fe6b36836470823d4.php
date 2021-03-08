<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
 <meta name="description" content="<?php if(isset($site_description)){ echo $site_description; } ?>" />
 <meta name="keywords" content="<?php if(isset($site_keywords)){ echo $site_keywords; } ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php if(isset($msg_title)){ echo $msg_title; } ?></title>
<link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/colorbox/colorbox.css" media="all" />
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo siteinfo('siteinfo_favicon_url')?>" />
<link rel="SHORTCUT ICON" href="favicon.ico" /><script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.colorbox.js"></script>
 <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/functions.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
	var msg = $('#msg').html();
	var title = $('#msg_title').html();
	$.colorbox({html: msg, open: true, opacity: 0.5, title: title});
}); 

 </script>

</head>
<body>
<?php if($type == 'private'): ?>
	<div id="msg"><?php if(isset($msg)){ echo $msg; } ?></div>
<?php elseif ($type == 'protected'): ?>	
	<div id="msg">
		<?php if(isset($content)){ echo $content; } ?>
	</div>
<?php endif; ?>
	<div id="msg_title"><?php if(isset($msg_title)){ echo $msg_title; } ?></div>

</body>
</html><?php $mabilis_ttl=1455269918; $mabilis_last_modified=1404816183; //d:\server\www\imghost.vit\templates\imghost\layouts\msg.tpl ?>