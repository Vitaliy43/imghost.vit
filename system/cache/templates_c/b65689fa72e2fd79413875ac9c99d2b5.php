
<style type="text/css">
	#block_birthday input {font-size: 12px;}
</style>
<script type="text/javascript">
	

</script>

<div id="container_edit_profile">
			<div class="block-title" style="text-align: center; font-size: 18px; margin-bottom: 15px;"><?php echo $language['EDIT_PROFILE']; ?></div>
        <div class="vertical-form w_50">
            <?php if(validation_errors() OR $info_message): ?>
                <div class="msg">
                    <div class="error"> 
                        <div class="text-el">
                            <?php echo validation_errors (); ?>
                            <?php if(isset($info_message)){ echo $info_message; } ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
			<!--div id="container_modal" style="display: none;"></div-->
            <form id="profile-form" onsubmit="ImageCMSApi.formAction('/authapi/edit_profile', '#sb-wrapper #profile-form');
                    return false;" method="POST">
                <label>
                    <span class="title"><?php echo $language['EMAIL']; ?></span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="email" id="email" value="<?php echo $user['email']; ?>"/>
                    </span>
                </label>
                <label>
                    <span class="title"><?php echo $language['SHOW_NAME']; ?></span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="show_name" id="show_name" value="<?php echo $user['show_name']; ?>"/>
                    </span>
                </label>
				<label>
					<span class="title"><?php echo $language['SHOW_PROFILE']; ?></span>
                    <span class="frame-form-field">
						<?php if(isset($access_roles)){ echo $access_roles; } ?>
                    </span>
				</label>
 				<label>
                    <span class="title">
					<?php echo $language['BIRTHDAY']; ?>
					</span>
                    <span class="frame-form-field" id="block_birthday">
						<?php if(count($birthday) > 0): ?>
							<input type="text" size="2" name="birthday_day" id="birthday_day" value="<?php echo $birthday['day']; ?>" maxlength="2" />&nbsp;-&nbsp;
                        	<input type="text" size="2" name="birthday_month" id="birthday_month" value="<?php echo $birthday['month']; ?>" maxlength="2" onclick="antifocus(this);return false;"/>&nbsp;-&nbsp;
                        	<input type="text" size="4" name="birthday_year" id="birthday_year" value="<?php echo $birthday['year']; ?>" maxlength="4" onclick="antifocus(this);return false;"/>
							<span style="font-size: 9px;margin-left: 5px;"><?php echo $language['LABEL_BIRTHDAY']; ?></span>
                        	
						<?php else:?>
							<input type="text" size="2" name="birthday_day" id="birthday_day" value="" maxlength="2"/>
                        	<input type="text" size="2" name="birthday_month" id="birthday_month" value="" maxlength="2"/>
                        	<input type="text" size="4" name="birthday_year" id="birthday_year" value="" maxlength="4"/>
							<span style="font-size: 9px;margin-left: 5px;"><?php echo $language['LABEL_BIRTHDAY']; ?></span>
							
						<?php endif; ?>
                    </span>
                </label>
				 <label>
                    <span class="title"><?php echo $language['TINY_STATIC']; ?>
					&nbsp; <input type="checkbox" size="30" name="tiny_static" id="tiny_static" <?php if($user['tiny_static']): ?> checked <?php endif; ?>/>
					</span>
                    <!--span class="frame-form-field">
                        <input type="checkbox" size="30" name="tiny_static" id="tiny_static" <?php if($user['tiny_static']): ?> checked <?php endif; ?>/>
                    </span-->
                </label>
                <div class="frame-label">
                    <span class="frame-form-field">
                        <div class="btn">
                            <input type="submit" id="submit" class="submit" value="<?php echo lang ('Отправить','corporate'); ?>" />
                        </div>
                    </span>
                </div>
                <input type="hidden" name="refresh" value="false"/>
                <input type="hidden" name="redirect" value="<?php echo site_url ('/'); ?>"/>
                <?php echo form_csrf (); ?>
            </form>
        </div>
	</div>
<?php $mabilis_ttl=1453880148; $mabilis_last_modified=1453795066; //d:\server\www\imghost.vit\templates\imghost\widgets\edit_profile.tpl ?>