<?php if(isset($is_authorized)): ?>

<div class="personal-top" >
	<?php if(isset($avatar)): ?>
		<div class="avatar"><a href="/profile"><img src="<?php if(isset($avatar)){ echo $avatar; } ?>" alt="" width="50" height="50"></a></div>
	<?php endif; ?>

	<ul class="user-links">
		<?php if(isset($is_admin)): ?>
			<li><a href="/admin"><?php echo $language['ADMIN']; ?></a></li>
		<?php endif; ?>
		<li><a href="/profile"><?php if(isset($login)){ echo $login; } ?></a></li>
		<?php if(DEVELOPMENT == true): ?>
		<li><a href="/profile/msg"><?php echo $language['PERSONAL_MSG']; ?></a></li>
		<?php endif; ?>
		<li><a href="/profile/albums"><?php echo $language['ALBUMS']; ?></a></li>
	</ul>

	<div class="exit" style="margin-right: 10px;">
		
	<a href="/logout"><span><?php echo $language['AUTH_LOGOUT']; ?></span></a>
	</div>
</div>
<?php else:?>
<form method="post" id="login_form" onsubmit="ImageCMSApi.formAction('/authapi/login', '#login_form'); return false;" >
	<input type="hidden" name="ACTION" value="auth" />
	<a  href="/register" data-page="1" id="register"><?php echo $language['HEADER_REGISTER']; ?></a>
	<div class="field"><input id="msgEdit" class="edit" type="text" name="email" placeholder="<?php echo $language['AUTH_EMAIL']; ?>" value=""/></div>
	<div class="field"><input class="edit" type="password" name="password" placeholder="<?php echo $language['AUTH_PASSWORD']; ?>" value=""/></div>
	<div class="field"><input class="button" type="submit" value="<?php echo $language['AUTH_LOGIN']; ?>" style="width: 52px;"/></div>
	<?php echo form_csrf (); ?>
</form>
<a class="forget" href="/forgot_password" data-page="2"><?php echo $language['HEADER_FORGET']; ?></a>
<?php endif; ?>
<?php $mabilis_ttl=1545381219; $mabilis_last_modified=1445584754; //d:\server\www\archive\imghost.vit\templates\imghost\blocks\auth.tpl ?>