{if isset($is_authorized)}

<div class="personal-top" >
	{if isset($avatar)}
		<div class="avatar"><a href="/profile"><img src="{$avatar}" alt="" width="50" height="50"></a></div>
	{/if}

	<ul class="user-links">
		{if isset($is_admin)}
			<li><a href="/admin">{$language.ADMIN}</a></li>
		{/if}
		<li><a href="/profile">{$login}</a></li>
		{if DEVELOPMENT == true}
		<li><a href="/profile/msg">{$language.PERSONAL_MSG}</a></li>
		{/if}
		<li><a href="/profile/albums">{$language.ALBUMS}</a></li>
	</ul>

	<div class="exit" style="margin-right: 10px;">
		
	<a href="/logout"><span>{$language.AUTH_LOGOUT}</span></a>
	</div>
</div>
{else:}
<form method="post" id="login_form" onsubmit="ImageCMSApi.formAction('/authapi/login', '#login_form'); return false;" >
	<input type="hidden" name="ACTION" value="auth" />
	<a  href="/register" data-page="1" id="register">{$language.HEADER_REGISTER}</a>
	<div class="field"><input id="msgEdit" class="edit" type="text" name="email" placeholder="{$language.AUTH_EMAIL}" value=""/></div>
	<div class="field"><input class="edit" type="password" name="password" placeholder="{$language.AUTH_PASSWORD}" value=""/></div>
	<div class="field"><input class="button" type="submit" value="{$language.AUTH_LOGIN}" style="width: 52px;"/></div>
	{form_csrf()}
</form>
<a class="forget" href="/forgot_password" data-page="2">{$language.HEADER_FORGET}</a>
{/if}
