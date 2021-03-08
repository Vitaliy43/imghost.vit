{literal}
<style type="text/css">
	.avatarForm {
		position:relative; /* позиционирование абсолютное элементов внутри формы */  
  		padding:0;   
  		margin:0;  
	}
	#mask
	{  
  		width:115px; /* ширина рисунка */    
  		height:30px;     
  		padding:4px 0 0 4px;     
	}  
	#fileInputAvatar
	 {
		position: absolute;
		cursor: pointer;
		 /* задаем нулевую видимость для разных браузеров*/
  		-ms-filter:"progid:DXImageTransFORM.Microsoft.Alpha(opacity=0)";
  		filter:progid:DXImageTransFORM.Microsoft.Alpha(opacity=0); 
  		-moz-opacity:0; 
  		-khtml-opacity:0; 
  		opacity:0;
	}
</style>
{/literal}
<div class="hr" style="margin-top: 24px;"></div>
<div id="user_avatar">
		<img src="{$avatar_src}" width="100" height="100"/>
	<!--div class="file-wrap"><a class="change" href="">{$language.CHANGE_AVATAR}</a></div-->
	<form class="ajaxForm avatarForm" method="POST" action="{site_url('set_avatar')}">
		<div id="container_filename">
			<div class="show_filename"></div>
			<div class="input_filename" style="display: none;margin-top: -4px;"><input type="submit" class="black-button" value="Готово"/></div>
		</div>
		<input id="fileInputAvatar" name="AVATAR_FILE" class="upload-fields-switcher" type="file" size="1" onchange="show_avatar(this);"/>
	<div id="mask">
		<span class="change">{$language.CHANGE_AVATAR}</span>
	</div>
	{form_csrf()}
	</form>
</div>
<div class="hr" style="margin-top: -5px;"></div>
<div id="user_brief_info">
	<div id="username">{$language.LOGIN}: {$user.username}</div>
	{if $user.show_name}
		<div id="show_name">{$language.NAME}: {$user.show_name}</div>
	{/if}
	<div id="email">{$language.EMAIL}: {$user.email}</div>
	{if $user.birthday}
		<div>{$language.BIRTHDAY}: {time_change_show_data($user.birthday)}</div>
	{/if}
</div>
<div id="link_edit" style="white-space: nowrap;" class="pseudobutton"><a href="{site_url('profile/edit')}" onclick="edit_profile(this);return false;">{$lang_auth.EDIT_PROFILE}</a></div>
{if DEVELOPMENT == true}
<div class="hr"></div>
<div id="block_messages">
	<div><a href="">{$language.WRITE_MSG}</a></div>
	<div><a href="">{$language.INPUT_MSG}</a></div>
	<div><a href="">{$language.OUTPUT_MSG}</a></div>
	<div><a href="">{$language.DRAFT_MSG}</a></div>
	<div><a href="">{$language.RECYCLER_MSG}</a></div>
</div>
{/if}
<div class="hr"></div>
<div id="block_statistic">
	<div id="link_statistic" style="white-space: nowrap;" class="pseudobutton"><a href="{site_url('profile/statistic')}" target="_blank" title="{$lang_main.DETAIL}" onclick="get_statistic(this);return false;">{$language.STAT}</a></div>
	<div>{$language.STAT_ALBUMS}: {$num_albums}</div>
	<div>{$language.STAT_IMAGES}: <span id="num_images">{$num_images}</span></div>
	{if DEVELOPMENT == true}
		<div>{$language.STAT_COMMENTS}: 0</div>
	{/if}
</div>
<div class="hr"></div>
<div id="block_upload_settings">
	<div id="link_upload_settings" style="white-space: nowrap;" class="pseudobutton"><a href="{site_url('profile/upload/templates')}" target="_blank" title="{$lang_main.DETAIL}" onclick="show_templates(this);return false;">{$language.UPLOAD_SETTINGS}</a></div>
	<div>{$language.NUM_TEMPLATES}: <span id="num_templates">{$num_templates}</span></div>

</div>
<div class="hr"></div>

<div id="block_favourite">
<div id="link_favourite" style="white-space: nowrap;" class="pseudobutton"><a href="{site_url('favourite_list')}" target="_blank" title="{$lang_main.DETAIL}" >Избранное</a></div>
	<div>{$language.STAT_ALBUMS}: {$favourites_albums}</div>
	<div>{$language.STAT_IMAGES}: {$favourites_images}</div>
</div>
<div class="hr"></div>
<div id="block_change_password">
	<a href="" class="change">{$language.CHANGE_PASSWORD}</a>
</div>
<div class="hr"></div>
<div id="block_subscribe">
	<div>{$language.MAIL_NOTIFY} <input type="checkbox"></div>
</div>
<div id="link_to_user_agreement" class="pseudobutton">
	<a href="">{$language.EULA}</a>
</div>
