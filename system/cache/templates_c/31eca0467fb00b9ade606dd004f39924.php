
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

<div class="hr" style="margin-top: 24px;"></div>
<div id="user_avatar">
		<img src="<?php if(isset($avatar_src)){ echo $avatar_src; } ?>" width="100" height="100"/>
	<!--div class="file-wrap"><a class="change" href=""><?php echo $language['CHANGE_AVATAR']; ?></a></div-->
	<form class="ajaxForm avatarForm" method="POST" action="<?php echo site_url ('set_avatar'); ?>">
		<div id="container_filename">
			<div class="show_filename"></div>
			<div class="input_filename" style="display: none;margin-top: -4px;"><input type="submit" class="black-button" value="Готово"/></div>
		</div>
		<input id="fileInputAvatar" name="AVATAR_FILE" class="upload-fields-switcher" type="file" size="1" onchange="show_avatar(this);"/>
	<div id="mask">
		<span class="change"><?php echo $language['CHANGE_AVATAR']; ?></span>
	</div>
	<?php echo form_csrf (); ?>
	</form>
</div>
<div class="hr" style="margin-top: -5px;"></div>
<div id="user_brief_info">
	<div id="username"><?php echo $language['LOGIN']; ?>: <?php echo $user['username']; ?></div>
	<?php if($user['show_name']): ?>
		<div id="show_name"><?php echo $language['NAME']; ?>: <?php echo $user['show_name']; ?></div>
	<?php endif; ?>
	<div id="email"><?php echo $language['EMAIL']; ?>: <?php echo $user['email']; ?></div>
	<?php if($user['birthday']): ?>
		<div><?php echo $language['BIRTHDAY']; ?>: <?php echo time_change_show_data ( $user['birthday'] ); ?></div>
	<?php endif; ?>
</div>
<div id="link_edit" style="white-space: nowrap;" class="pseudobutton"><a href="<?php echo site_url ('profile/edit'); ?>" onclick="edit_profile(this);return false;"><?php echo $lang_auth['EDIT_PROFILE']; ?></a></div>
<?php if(DEVELOPMENT == true): ?>
<div class="hr"></div>
<div id="block_messages">
	<div><a href=""><?php echo $language['WRITE_MSG']; ?></a></div>
	<div><a href=""><?php echo $language['INPUT_MSG']; ?></a></div>
	<div><a href=""><?php echo $language['OUTPUT_MSG']; ?></a></div>
	<div><a href=""><?php echo $language['DRAFT_MSG']; ?></a></div>
	<div><a href=""><?php echo $language['RECYCLER_MSG']; ?></a></div>
</div>
<?php endif; ?>
<div class="hr"></div>
<div id="block_statistic">
	<div id="link_statistic" style="white-space: nowrap;" class="pseudobutton"><a href="<?php echo site_url ('profile/statistic'); ?>" target="_blank" title="<?php echo $lang_main['DETAIL']; ?>" onclick="get_statistic(this);return false;"><?php echo $language['STAT']; ?></a></div>
	<div><?php echo $language['STAT_ALBUMS']; ?>: <?php if(isset($num_albums)){ echo $num_albums; } ?></div>
	<div><?php echo $language['STAT_IMAGES']; ?>: <span id="num_images"><?php if(isset($num_images)){ echo $num_images; } ?></span></div>
	<?php if(DEVELOPMENT == true): ?>
		<div><?php echo $language['STAT_COMMENTS']; ?>: 0</div>
	<?php endif; ?>
</div>
<div class="hr"></div>
<div id="block_upload_settings">
	<div id="link_upload_settings" style="white-space: nowrap;" class="pseudobutton"><a href="<?php echo site_url ('profile/upload/templates'); ?>" target="_blank" title="<?php echo $lang_main['DETAIL']; ?>" onclick="show_templates(this);return false;"><?php echo $language['UPLOAD_SETTINGS']; ?></a></div>
	<div><?php echo $language['NUM_TEMPLATES']; ?>: <span id="num_templates"><?php if(isset($num_templates)){ echo $num_templates; } ?></span></div>

</div>
<div class="hr"></div>

<div id="block_favourite">
<div id="link_favourite" style="white-space: nowrap;" class="pseudobutton"><a href="<?php echo site_url ('favourite_list'); ?>" target="_blank" title="<?php echo $lang_main['DETAIL']; ?>" >Избранное</a></div>
	<div><?php echo $language['STAT_ALBUMS']; ?>: <?php if(isset($favourites_albums)){ echo $favourites_albums; } ?></div>
	<div><?php echo $language['STAT_IMAGES']; ?>: <?php if(isset($favourites_images)){ echo $favourites_images; } ?></div>
</div>
<div class="hr"></div>
<div id="block_change_password">
	<a href="" class="change"><?php echo $language['CHANGE_PASSWORD']; ?></a>
</div>
<div class="hr"></div>
<div id="block_subscribe">
	<div><?php echo $language['MAIL_NOTIFY']; ?> <input type="checkbox"></div>
</div>
<div id="link_to_user_agreement" class="pseudobutton">
	<a href=""><?php echo $language['EULA']; ?></a>
</div>
<?php $mabilis_ttl=1478593638; $mabilis_last_modified=1452836975; //d:\server\www\imghost.vit\templates\imghost\widgets\profile.tpl ?>