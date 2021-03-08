<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
 <meta name="description" content="{$site_description}" />
 <meta name="keywords" content="{$site_keywords}" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>{$msg_title}</title>
<link rel="stylesheet" type="text/css" href="{$THEME}css/style.css" media="all" />
<link rel="icon" type="image/vnd.microsoft.icon" href="{echo siteinfo('siteinfo_favicon_url')}" />
<link rel="SHORTCUT ICON" href="favicon.ico" /><script type="text/javascript" src="{$THEME}js/jquery-1.8.3.min.js"></script>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<div id="login_button" onclick="VK.Auth.login(null, VK.access.PHOTOS);">VK</div>

<script language="javascript">
{if $is_album}
	var save_error = '{$language.VK_ERROR_PHOTOS_SAVE}';
	var save_success = '{$language.VK_SUCCESS_PHOTOS_SAVE}';

{else:}
	var save_error = '{$language.VK_ERROR_PHOTO_SAVE}';
	var save_success = '{$language.VK_SUCCESS_PHOTO_SAVE}';

{/if}

var result = {$result};

{$vk_init}
{literal}
function msg_success(){
	$('#msg_save').text(save_success);
}

function msg_error(){
	$('#msg_save').text(save_error);
}


function photos_save(){
VK.Api.call('photos.save',result , function(r) {
//	alert('Success!!!');
	window.opener.location.reload();
	window.opener.focus();
	window.close();
}); 	
		}

function authInfo(response) {
  if (response.session) {
	photos_save();
  } else {
    alert('not auth');
  }
}

VK.Auth.getLoginStatus(authInfo);


{/literal}
</script>
</head>

</html>