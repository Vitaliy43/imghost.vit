<div id="container_edit_albums" style="background: #fff;padding: 10px;">
{if empty($is_net)}
	<form action="{site_url('albums_settings/show')}/{$settings.id}" method="POST" onsubmit="edit_album({$settings.id},this);return false;">
{else:}
	<form action="{$action}" method="POST" onsubmit="copy_album_to_local({$settings.id},this);return false;">
{/if}
<table cellpadding="0" cellspacing="0">
		<tr>
		<td>
			<div>
			{if empty($is_net)}
				<input type="text" size="20" maxlength="50" placeholder="{$language.NAME}" name="name" id="album_name" value="{$settings.name}"/>
			{else:}
				<input type="text" size="20" maxlength="50" placeholder="{$language.NAME}" name="name" id="album_name" value="{$settings.title}"/>
			{/if}
			</div>
			</td>
			<td style="padding-left: 5px;" valign="bottom">
				<div>{$language.ACCESS}:</div>
			</td>
			</tr>
			<tr>
				<td>
				<div style="margin-top: 5px;">
					<textarea rows="3" cols="20" placeholder="{$language.DESCRIPTION}" name="description" id="description" >{$settings.description}</textarea>
				</div>
				<div style="margin-top: 5px;">
					<div class="submit">
						{if empty($is_net)}
							<input class="black-button" type="submit" value="{$language.EDIT_ALBUM}" style="font-size: 11px;text-transform: lowercase;"/>
						{else:}
							<input class="black-button" type="submit" value="{$language.CREATE_ALBUM}" style="font-size: 11px;text-transform: lowercase;"/>
						{/if}
					</div>
				</div>
			</td>
			<td valign="top" style="padding-top: 5px;padding-left: 5px;" nowrap="">
			<table>
			<tr>
				<td nowrap="">
					<div>
					{if $settings.access == 'public'}
						<input type="radio" name="access" checked="" value="public" onclick="show_password(this);"/>
					{else:}
						<input type="radio" name="access" value="public" onclick="show_password(this);"/>
					{/if}
				</div>
				</td>
				<td>
					<label>{$language.PUBLIC}</label>

				</td>
			</tr>
			<tr>
				<td nowrap="">
				<div>
					{if $settings.access == 'private'}
						<input type="radio" name="access" checked="" value="private" onclick="show_password(this);"/>
					{else:}
						<input type="radio" name="access" value="private" onclick="show_password(this);"/>
					{/if}				
					</div>
				</td>
				<td>
					<label>{$language.PRIVATE}</label>
				</td>
			</tr>
			<tr>
				<td nowrap="">
				<div>
					{if $settings.access == 'protected'}
						<input type="radio" name="access" checked="" value="protected" onclick="show_password(this);"/>
					{else:}
						<input type="radio" name="access" value="protected" onclick="show_password(this);"/>
					{/if}	
				</div>
					<td>
						<label>{$language.PROTECTED}</label>
					</td>
				</td>
			</tr>
			{if $settings.access == 'protected'}
				<tr id="container_password">
					<td colspan="2">
						<span>{$language.NEW_PASSWORD}</span> <br/>
						<input size="12" maxlength="20" name="password" id="password" type="text"/>
					</td>

				</tr>		
			{else:}
				<tr style="display: none;" id="container_password">
					<td colspan="2">
						<input size="12" maxlength="20" name="password" id="password" type="password"/>
					</td>

				</tr>
			{/if}
				
				</table>
			</td>
			</tr>
			</table>
	{form_csrf()}

</form>
</div>
{if isset($is_net)}
	<input type="hidden" id="album_id" value="{$settings.id}"/>
	<input type="hidden" id="owner_id" value="{$settings.owner_id}"/>
{/if}