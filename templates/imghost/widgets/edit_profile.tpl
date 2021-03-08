{literal}
<style type="text/css">
	#block_birthday input {font-size: 12px;}
</style>
<script type="text/javascript">
	

</script>
{/literal}
<div id="container_edit_profile">
			<div class="block-title" style="text-align: center; font-size: 18px; margin-bottom: 15px;">{$language['EDIT_PROFILE']}</div>
        <div class="vertical-form w_50">
            {if validation_errors() OR $info_message}
                <div class="msg">
                    <div class="error"> 
                        <div class="text-el">
                            {validation_errors()}
                            {$info_message}
                        </div>
                    </div>
                </div>
            {/if}
			<!--div id="container_modal" style="display: none;"></div-->
            <form id="profile-form" onsubmit="ImageCMSApi.formAction('/authapi/edit_profile', '#sb-wrapper #profile-form');
                    return false;" method="POST">
                <label>
                    <span class="title">{$language['EMAIL']}</span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="email" id="email" value="{$user['email']}"/>
                    </span>
                </label>
                <label>
                    <span class="title">{$language['SHOW_NAME']}</span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="show_name" id="show_name" value="{$user['show_name']}"/>
                    </span>
                </label>
				<label>
					<span class="title">{$language['SHOW_PROFILE']}</span>
                    <span class="frame-form-field">
						{$access_roles}
                    </span>
				</label>
 				<label>
                    <span class="title">
					{$language['BIRTHDAY']}
					</span>
                    <span class="frame-form-field" id="block_birthday">
						{if count($birthday) > 0}
							<input type="text" size="2" name="birthday_day" id="birthday_day" value="{$birthday['day']}" maxlength="2" />&nbsp;-&nbsp;
                        	<input type="text" size="2" name="birthday_month" id="birthday_month" value="{$birthday['month']}" maxlength="2" onclick="antifocus(this);return false;"/>&nbsp;-&nbsp;
                        	<input type="text" size="4" name="birthday_year" id="birthday_year" value="{$birthday['year']}" maxlength="4" onclick="antifocus(this);return false;"/>
							<span style="font-size: 9px;margin-left: 5px;">{$language['LABEL_BIRTHDAY']}</span>
                        	
						{else:}
							<input type="text" size="2" name="birthday_day" id="birthday_day" value="" maxlength="2"/>
                        	<input type="text" size="2" name="birthday_month" id="birthday_month" value="" maxlength="2"/>
                        	<input type="text" size="4" name="birthday_year" id="birthday_year" value="" maxlength="4"/>
							<span style="font-size: 9px;margin-left: 5px;">{$language['LABEL_BIRTHDAY']}</span>
							
						{/if}
                    </span>
                </label>
				 <label>
                    <span class="title">{$language['TINY_STATIC']}
					&nbsp; <input type="checkbox" size="30" name="tiny_static" id="tiny_static" {if $user.tiny_static} checked {/if}/>
					</span>
                    <!--span class="frame-form-field">
                        <input type="checkbox" size="30" name="tiny_static" id="tiny_static" {if $user.tiny_static} checked {/if}/>
                    </span-->
                </label>
                <div class="frame-label">
                    <span class="frame-form-field">
                        <div class="btn">
                            <input type="submit" id="submit" class="submit" value="{lang('Отправить','corporate')}" />
                        </div>
                    </span>
                </div>
                <input type="hidden" name="refresh" value="false"/>
                <input type="hidden" name="redirect" value="{site_url('/')}"/>
                {form_csrf()}
            </form>
        </div>
	</div>
