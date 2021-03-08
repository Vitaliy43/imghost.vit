<form id="enter-form" onsubmit="open_album(this);
                    return false;" method="POST" style="padding: 15px;" action="{site_url('albums')}/{$album_id}">
					<!--input type="hidden" id="album_id" value="{$album_id}"/-->
				<div>{$msg}</div> 

                <label>
                    <span class="title">{$language['AUTH_PASSWORD']}</span>
                    <span class="frame-form-field">
                        <input type="password" size="30" name="album_password" id="album_password" value="" />
                    </span>
                </label>

                <div class="frame-label" style="margin-top: 10px;">
                    <span class="frame-form-field">
                        <div class="btn">
                            <input type="submit" id="submit" class="submit" value="{lang('Отправить','corporate')}" />
                        </div>
                    </span>
                </div>
                {form_csrf()}
            </form>



