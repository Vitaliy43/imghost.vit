<form class="search_images" action="{site_url('profile/')}" onsubmit="search_images(this);return false;" style="padding: 10px;">
<input type="hidden" id="is_search" name="IS_SEARCH" value="1"/>

<table width="100%" cellpadding="5" cellspacing="5" style="font-weight: bold;text-transform: lowercase; margin-top: 10px;">
	<tr>
		<td valign="top">
			<table>
				<tr>
					<td valign="top">
						{$language.WIDTH}: 
					</td>
					<td>
						<div class="input">
							{$lang_main.FROM}
							<input class="edit" type="text" name="FROM_WIDTH" value="" size="4" id="from_width"/>
							&nbsp;
							{$lang_main.TO}
							<input class="edit" type="text" name="TO_WIDTH" value="" size="4" id="to_width"/>

						</div>
					</td>
				</tr>
				<tr>
					<td valign="top">
						{$language.HEIGHT}:
					</td>
					<td>
						<div class="input">
							{$lang_main.FROM}
							<input class="edit" type="text" name="FROM_HEIGHT" value="" size="4" id="from_height"/>
							&nbsp;
							{$lang_main.TO}
							<input class="edit" type="text" name="TO_HEIGHT" value="" size="4" id="to_height"/>
						</div>
					</td>
				</tr>
				
			</table>			
		
		</td>
		
	</tr>
	{if !$with_token}
	<tr>
		<td>
			<table>
				<tr>
					<td>
						{$language.ACCESS}:
					</td>
					<td>
						<div class="input">
							<select class="combobox" name="ACCESS" style="width: 110px;" id="access">
							<option value="0" selected></option>
							<option value="public">{$lang_albums.ALBUM_PUBLIC}</option>
							<option value="private">{$lang_albums.ALBUM_PRIVATE}</option>
						</select>
						</div>
					</td>
				</tr>
			</table>
		</td>
	
	</tr>
	{/if}
	
	<tr>
		<td>
			<table>
				<tr>
					<td><label >{$language.SELECT_TAG}:</label></td>
					<td>
						<div class="input">
							{$tags}
						</div>
						<div class="field children_tags" style="display: none;">
							<div class="input">
							</div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>{$language.WITH_TINYURL}: &nbsp;</td>
					<td>
						<div class="input"><input id="tiny_url" type="checkbox" name="WITH_TINYURL" value="Y"/></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	{if $albums}
	<tr>
		<td>
			<table>
				<tr>
					<td>{$language.FIND_TO_ALBUM_TEMPLATE}:</td>
					<td>
						<div class="input">
							{$albums}
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	{/if}
</table>
	
	<table style="font-weight: bold;" cellpadding="4" cellspacing="4">
	<tr>
		<td>{$language.NAME}</td>
		<td>
			<div class="input" style="margin-left: 15px;"><input class="edit" type="text" name="FILENAME" value="{if isset($template.NAME)}{$template.NAME}{/if}" style="width: 105px;" id="filename"/></div>
		</td>
	</tr>
	<tr>
		<td valign="top"><label>{$language.COMMENTS}:</label></td>
		<td>
			<div class="input" style="margin-left: 15px;"><textarea class="memo" name="COMMENT" cols="35" rows="2" maxlength="100" id="comment">{if isset($template.COMMENT)}{$template.COMMENT}{/if}</textarea></div>
		</td>
	</tr>
</table>	
<table width="100%">
		<tr>
			<td>
			{if isset($template_id)}
				<input type="hidden" name="TEMPLATE_ID" id="template_id" value="{$template_id}"/>
			{/if}
				<div class="submit" style="margin-top: 15px;">
					<input class="black-button" type="submit" value="{$lang_main.FIND}" style="font-size: 11px;"/>
				</div>
			</td>
		</tr>
	</table>

	{form_csrf()}

</form>
