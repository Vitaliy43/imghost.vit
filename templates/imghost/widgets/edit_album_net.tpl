<div id="container_edit_albums" style="background: #fff;padding: 10px;">
<form action="{$action}" method="POST" onsubmit="create_album_net({$settings.id},this);return false;">
<table cellpadding="0" cellspacing="0">
		<tr>
		<td>
			<div>
				<input type="text" size="20" maxlength="50" placeholder="{$language.NAME}" name="name" id="album_name" value="{$settings.name}"/>
			</div>
			</td>
			</tr>
			<tr>
				<td>
				<div style="margin-top: 5px;">
					<textarea rows="3" cols="20" placeholder="{$language.DESCRIPTION}" name="description" id="description" >{$settings.description}</textarea>
				</div>
				<div style="margin-top: 5px;">
					<div class="submit">
							<input class="black-button" type="submit" value="{$lang_sync.CREATE_ALBUM_NET}" style="font-size: 11px;text-transform: lowercase;"/>
					</div>
				</div>
			</td>
			</tr>
			</table>
	{form_csrf()}

</form>
</div>
	<input type="hidden" id="album_id" value="{$settings.id}"/>
	<input type="hidden" id="owner_id" value="{$settings.owner_id}"/>
	<input type="hidden" id="error_msg" value="{$lang_sync.ERROR_CREATE_ALBUM}"/>
