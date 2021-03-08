<div class="item_cover">
	{if $type == 'edit'}
		<form class="ajaxForm uploadForm" action="{site_url('images_guest/edit')}/{$image_id}?token={$token}&torrent_id={$torrent_id}&cover=1&image_size={$image_size}" method="post" id="form1">
	{else:}
		<form class="ajaxForm uploadForm" action="{site_url('upload/fast')}?token={$token}&torrent_id={$torrent_id}&cover=1&image_size={$image_size}" method="post" id="form1">
	{/if}
		<input type="hidden" name="current_form" value="1" id="current_form"/>
		<input type="hidden" class="is_uploaded" value="0"/>
		<input type="hidden" class="is_progress" value="0"/>
		<input type="hidden" class="proportion" value=""/>
		<input type="hidden" id="current_url" value="" />
		<input type="hidden" value="1" name="is_update"/>
		<div class="choose-source" style="margin-bottom: 15px; {if $type == 'edit'} display:none; {/if}" >
			<div class="black-button source-local file-wrap">
				<span>{$language.UPLOAD_FROM_COMPUTER}</span>
				<input class="upload-fields-switcher" type="file" size="1" name="UPLOADED_FILE" id="UPLOADED_FILE"/>
				<input type="hidden" name="{$upload_progress}" value="fast"/>
			</div>
			<a class="black-button source-remote" href="#">{$language.UPLOAD_FROM_INTERNET}</a>
		</div>
		<div id="sync_info" style="text-align: center;display: none;">
				{$language.SYNC_INFO}
		</div>
		<fieldset class="source-remote-url hidden">
			<div class="field wide">
				<div class="input"><textarea class="memo" name="FILE_URL" cols="37" rows="2" placeholder="{$language.LINK_TO_FILE}"></textarea></div>
			</div>
		</fieldset>
		<div class="source-local-fields" style="overflow: hidden;">
			<div class="filename">
				<table>
					<tr>
						<td class="cell" valign="top">
							{if $type == 'edit'}
								<a onclick="show_image(this);return false;" href="{$imglink}"><img width="{$preview_width}" height="{$preview_height}" src="{$imglink_preview}"></a>
							{/if}
						</td>
						<td class="cimage" valign="top">
						{if $type == 'edit'}
							<a onclick="delete_cover_from_seedoff_edit(this,'Вы уверены, что хотите удалить данный файл?');return false;" href="{$delete_link}" style="margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" title="Удалить изображение"/></a>
						{/if}
						</td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="ACTION" value="upload_file" />
			{if $iframe == 0}
			<fieldset >
				<div class="resize" style="display: none;">
				<div class="field">
					<label>{$language.RESIZE_TO}:</label>
				</div>
				
				<div class="field">
					<label>{$language.WIDTH}</label>
					<div class="input">
						<input class="edit" type="text" name="RESIZE_TO_WIDTH" value="0" size="5" onchange="constrain_proportions(this,'width');"/>
					</div>
				</div>
				<div class="field" style="margin-bottom: 20px;">
					<label>{$language.HEIGHT}</label>
					<div class="input">
						<input class="edit" type="text" name="RESIZE_TO_HEIGHT" value="0" size="5" onchange="constrain_proportions(this,'height');"/>
					</div>
				</div>
				
				<div class="field container_constrain">
					<label>{$language.CONSTRAIN_PROPORTIONS}</label>
					<div class="input">
						<input class="edit" type="checkbox" id="constrain" checked=""/>
					</div>
				</div>
				</div>
				<div class="field">
					<label>{$language.TURN}:</label>
					<div class="input">
						<select class="combobox" name="ROTATE" onchange="free_rotate(this);">
							<option value="0">0</option>
							<option value="90">90°</option>
							<option value="180">180°</option>
							<option value="270">270°</option>
							<option value="free">{$language.FREE_ROTATE}</option>
						</select>
						<div class="free_rotate" style="display: none;margin-top:5px;">
							<input type="text" name="FREE_ROTATE" onchange="set_rotate(this);" size="3"/>
						</div>
					</div>
				</div>

			</fieldset>
			<fieldset class="more-options-block">
				<div class="field">
					<label>{$language.WATERMARK}:</label>
					<div class="input"><input class="edit" type="text" name="WATERMARK" value="" size="16" maxlength="16"/></div>
				</div>
				
				<div class="field">
					<label style="text-transform: lowercase;">{$language.SELECT_TAG}:</label>
					<div class="input">
						{$tags}
					</div>
				</div>
				<div class="field children_tags" style="display: none;">
					<div class="input">
					</div>
				</div>
				<div class="field">
					<label>{$language.TO_CONVERT}:</label>
					<div class="input">
						<select class="combobox" name="CONVERT_TO">
							<option value=""></option>
							<option value="jpg">JPG</option>
							<option value="png">PNG</option>
							<option value="gif">GIF</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="tinyurl">{$language.TINYURL}:</label>
					<div class="input"><input id="tinyurl" type="checkbox" name="TINYURL" value="Y" /></div>
				</div>
				{if $enable_compression}
				<div class="field">
					<label for="tinyurl">{$language.JPEG_QUALITY}:</label>
					<div class="input">
						{$compression_jpeg_box} %
					</div>
				</div>
				{/if}
				<div class="field">
					<label>{$language.PREVIEW}:</label>
					<div class="input">
						<input class="edit" type="text" name="PREVIEW_WIDTH" value="" size="5" placeholder="Ш" />
						<input class="edit" type="text" name="PREVIEW_HEIGHT" value="" size="5" placeholder="В" />
					</div>
				</div>
				
				{if !$is_guest}
				<div class="field">
					<label>{$language.DOWNLOAD_TO_ALBUM}:</label>
					<div class="input">
						{$albums}
					</div>
				</div>
				{/if}
			</fieldset>
			{/if}
			{if $type == 'edit'}
				<div class="submit" style="margin-top: 15px;">
					<input class="black-button" type="submit" value="{$language.EDIT}" id="form_action"/>
				</div>
			{else:}
				<div class="submit" style="margin-top: 15px;">
					<input class="black-button" type="submit" value="{$language.UPLOAD}" id="form_action"/>
				</div>
			{/if}
		</div>
		
		{form_csrf()}
	</form>
</div>

