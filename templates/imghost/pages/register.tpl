{if $with_seedoff}
	<script type="text/javascript">
		{literal}
			$(document).ready(function() {
				use_seedoff_data_ready();
			});
		{/literal}
	</script>
{/if}
    <div class="wrap960">
	{if isset($special_msg)}
		<div>{$special_msg}</div>
	{/if}
<div id="container_registration">
			<!--h1 style="text-align: center; margin-bottom: 15px;margin-left:30%;margin-top: -5px;">{lang('Регистрация','corporate')}</h1-->
			<div class="block-title" style="text-align: center; font-size: 18px; margin-bottom: 15px;">{lang('Регистрация','corporate')}</div>
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
            <form id="register-form" onsubmit="ImageCMSApi.formAction('/authapi/register', '#register-form');
                    return false;" method="POST">
					<label>
						<span class="title" id="use_seedoff">
					     <a href="{site_url('register/seedoff_data')}" onclick="use_seedoff_data(this);return false;">{$language.USE_SEEDOFF_DATA}</a>
					</span>
					<span class="frame-form-field">
                    </span>
				</label>
                <label>
                    <span class="title">{$language['EMAIL']}</span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="email" id="email" value="{set_value('email')}" />
                    </span>
                </label>
                <label>
                    <span class="title">{$language['USERNAME']}</span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="username" id="username" value="{set_value('username')}"/>
                    </span>
                </label>
                <label>
                    <span class="title">{$language['AUTH_PASSWORD']}</span>
                    <span class="frame-form-field">
                        <input type="password" size="30" name="password" id="password" value="{set_value('password')}" />
                    </span>
                </label>
                <label>
                    <span class="title">{$language['CONFIRM_PASSWORD']}</span>
                    <span class="frame-form-field">
                        <input type="password" class="text" size="30" name="confirm_password" id="confirm_password" />
                    </span>
                </label>

                {if $cap_image}
                    <label>
                        <span class="title">&nbsp;</span>
                        <span class="frame-form-field">
                            <input type="text" name="captcha" id="captcha"/>
                        </span>
                        {$cap_image}
                    </label>
                {/if}

                <div class="frame-label">
                    <span class="frame-form-field">
                        <div class="btn">
                            <input type="submit" id="submit" class="submit" value="{lang('Отправить','corporate')}" />
                        </div>
                    </span>
                </div>
                <button class="d_l" data-drop=".drop-forgot" data-source="{site_url('auth/forgot_password')}">{lang('Забыли Пароль?','corporate')}</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="d_l" data-drop=".drop-enter" data-source="{site_url('auth')}">Вход</button>
                <input type="hidden" name="refresh" value="false"/>
                <input type="hidden" name="redirect" value="{site_url('/')}"/>
                {form_csrf()}
            </form>
			<div id="container_modal" style="display: none;"></div>
        </div>
    </div>
</div>