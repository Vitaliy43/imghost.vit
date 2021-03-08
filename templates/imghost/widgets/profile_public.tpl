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
<div class="hr" style="margin-top: 2px;"></div>
<div id="user_avatar">
		<img src="{$avatar_src}" width="100" height="100"/>	
	
</div>
<div class="hr"></div>
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
{if isset($is_admin) && DEVELOPMENT == TRUE}
<div class="hr"></div>

<div id="block_messages">
	<div><a href="">{$language.INPUT_MSG}</a></div>
	<div><a href="">{$language.OUTPUT_MSG}</a></div>
	<div><a href="">{$language.DRAFT_MSG}</a></div>
	<div><a href="">{$language.RECYCLER_MSG}</a></div>
</div>
{/if}

<div class="hr"></div>
<div id="block_statistic">
	<div>{$language.STAT_USER}</div>
	<div>{$language.STAT_ALBUMS}: {$num_albums}</div>
	<div>{$language.STAT_IMAGES}: {$num_images}</div>
	<div>{$language.STAT_COMMENTS}: 0</div>
</div>

