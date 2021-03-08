<form class="upload_template" action="{site_url('profile/upload/templates/set')}{$with_token}" onsubmit="set_upload_template(this);return false;">
<input type="hidden" class="proportion" value=""/>
<table style="font-weight: bold;" cellpadding="4" cellspacing="4">
	<tr>
		<td>{$language.NAME}</td>
		<td>
			<div class="input" style="margin-left: 15px;"><input class="edit" type="text" name="TEMPLATE_NAME" value="{if isset($template.NAME)}{$template.NAME}{/if}" style="width: 105px;" id="template_name"/></div>
		</td>
	</tr>
	<tr>
		<td valign="top"><label>{$language.COMMENTS}:</label></td>
		<td>
			<div class="input" style="margin-left: 15px;"><textarea class="memo" name="TEMPLATE_COMMENT" cols="35" rows="2" maxlength="100" id="template_comment">{if isset($template.COMMENT)}{$template.COMMENT}{/if}</textarea></div>
		</td>
	</tr>
</table>
<h3 style="margin-left: 5px;">{$language.OPTIONS}</h3>
<table width="100%" cellpadding="5" cellspacing="5" style="font-weight: bold;text-transform: lowercase;">
	<tr>
		<td valign="top">
			<table>
				<tr>
					<td colspan="2">{$language.RESIZE_TO}</td>
				</tr>
				<tr style="margin-top: 10px;">
					<td>
						{$language.WIDTH}:
					</td>
					<td>
						<div class="input">
							<input class="edit" type="text" name="RESIZE_TO_WIDTH" value="{if isset($template.RESIZE_TO_WIDTH)}{$template.RESIZE_TO_WIDTH}{else:}0{/if}" size="5" onchange="constrain_proportions(this,'width');" id="resize_to_width"/>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						{$language.HEIGHT}:
					</td>
					<td>
						<div class="input">
							<input class="edit" type="text" name="RESIZE_TO_HEIGHT" value="{if isset($template.RESIZE_TO_HEIGHT)}{$template.RESIZE_TO_HEIGHT}{else:}0{/if}" size="5" onchange="constrain_proportions(this,'height');" id="resize_to_height"/>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						{$language.ALIGN}
					</td>
					<td>
						<div class="input">
							<select class="combobox" name="ALIGN_SIZE" onchange="set_align(this);" id="align_size">
							<option value="0">{$language.NO}</option>
							<option value="by_width" {if isset($template.RESIZE_TO_WIDTH) && empty($template.RESIZE_TO_HEIGHT)} selected {/if}>{$language.BY_WIDTH}</option>
							<option value="by_height" {if isset($template.RESIZE_TO_HEIGHT) && empty($template.RESIZE_TO_WIDTH)} selected {/if}>{$language.BY_HEIGHT}</option>
						</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						{$language.PROPORTION}
					</td>
					<td>
						<div class="input">
							<input class="edit" type="text" value="0.75" size="5" id="set_proportion" onchange="constrain_proportions(this,'width');"/>
						</div>
					</td>
				</tr>
			
			</table>			
		
		</td>
		
	</tr>
	<tr>
	<td valign="top">
	<table>
		<tr>
			<td>{$language.PREVIEW}</td>
			<td>
			<div class="input" style="margin-left: 5px;">
				<input class="edit" type="text" name="PREVIEW_WIDTH" value="{if isset($template.PREVIEW_WIDTH)}{$template.PREVIEW_WIDTH}{/if}" size="5" placeholder="Ш" id="preview_width"/>
				<input class="edit" type="text" name="PREVIEW_HEIGHT" value="{if isset($template.PREVIEW_HEIGHT)}{$template.PREVIEW_HEIGHT}{/if}" size="5" placeholder="В" id="preview_height"/>
			</div>
			</td>
		</tr>
	</table>
	</td>
	
	</tr>
	<tr style="margin-top: 5px;">
		<td valign="top">
				<table>
					<tr>
						<td valign="top">
							{$language.TURN}
						</td>
						<td valign="top">
							<div class="input">
							<select class="combobox" name="ROTATE" onchange="free_rotate_template(this);" id="rotate">
							<option value="0" {if empty($template.ROTATE)} selected {/if}>0</option>
							<option value="90" {if $template.ROTATE == 90} selected {/if}>90°</option>
							<option value="180" {if $template.ROTATE == 180} selected {/if}>180°</option>
							<option value="270" {if $template.ROTATE == 270} selected {/if}>270°</option>
							<option value="free" >{$language.FREE_ROTATE}</option>
						</select>
						<div class="free_rotate" style="display: none;margin-top:5px;">
							<input type="text" name="FREE_ROTATE" onchange="set_rotate(this);" size="3" id="free_rotate" {if $template.ROTATE != 90 && $template.ROTATE != 180 && $template.ROTATE != 270 } value = "{$template.ROTATE}" {/if}/>
						</div>
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
							<option value="0"></option>
							<option value="public" {if $template.ACCESS == 'public'} selected {/if}>{$lang_albums.ALBUM_PUBLIC}</option>
							<option value="private" {if $template.ACCESS == 'private'} selected {/if}>{$lang_albums.ALBUM_PRIVATE}</option>
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
					<td>
						{$language.WATERMARK}:
					</td>
					<td>
						<div class="input"><input class="edit" type="text" name="WATERMARK" value="{if isset($template.WATERMARK)}{$template.WATERMARK}{/if}" size="16" maxlength="16" id="watermark"/></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
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
					<td>{$language.TO_CONVERT}:</td>
					<td>
						<div class="input">
						<select class="combobox" name="CONVERT_TO" style="text-transform: uppercase;" id="convert_to">
							<option value=""></option>
							<option value="jpg" {if $template.TO_CONVERT == 'jpg'} selected {/if}>JPG</option>
							<option value="png" {if $template.TO_CONVERT == 'png'} selected {/if}>PNG</option>
							<option value="gif" {if $template.TO_CONVERT == 'gif'} selected {/if}>GIF</option>
						</select>
					</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	{if $enable_compression}
	<tr>
		<td>
			<table>
				<tr>
					<td>{$language.JPEG_QUALITY}:</td>
					<td>
						<div class="input">
							{$compression_jpeg_box}
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
					<td>{$language.TINYURL}:</td>
					<td>
						<div class="input"><input id="tiny_url" type="checkbox" name="TINYURL" value="Y" {if isset($template.TINYURL) && $template.TINYURL} checked {/if}/></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	{if $albums && !$with_token}
	<tr>
		<td>
			<table>
				<tr>
					<td>{$language.DOWNLOAD_TO_ALBUM_TEMPLATE}:</td>
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
	<table width="100%">
		<tr>
			<td>
			{if isset($template_id)}
				<input type="hidden" name="TEMPLATE_ID" id="template_id" value="{$template_id}"/>
			{/if}
				<div class="submit" style="margin-top: 15px;">
					<input class="black-button" type="submit" value="{if $is_edit}{$language.EDIT}{else:}{$language.ADD}{/if}" style="font-size: 11px;"/>
				</div>
			</td>
		</tr>
	</table>	
	{form_csrf()}
	</form>