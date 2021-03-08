  <div style="margin: 20px;">
  	<form id="register_with_seedoff" onsubmit="submit_seedoff_data(this);return false;" method="POST" action="{site_url('register/seedoff_data')}">
                <label>
                    <span class="title">{$language['USERNAME_SEEDOFF']}</span>
                    <span class="frame-form-field">
                        <input type="text" size="30" name="username" id="username" value="{set_value('username')}"/>
                    </span>
                </label>
                <label>
                    <span class="title">{$language['AUTH_PASSWORD_SEEDOFF']}</span>
                    <span class="frame-form-field">
                        <input type="password" size="30" name="password" id="password" value="{set_value('password')}" />
                    </span>
                </label>
                <div class="frame-label" style="margin-top: 20px;">
                    <span class="frame-form-field">
                        <div class="btn">
                            <input type="submit" id="submit" class="submit" value="{lang('Отправить','corporate')}" />
                        </div>
                    </span>
                </div>
                {form_csrf()}
            </form>
  </div>
  