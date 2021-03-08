<script type="text/javascript">
	{literal}
		$(document).ready(function() {
			var height_image_container = $('.image_list').height();
			var height_image_table = $('.image_list table').height();
			if(height_image_table > 540)
				$('.image_list').css({'overflow-y' : 'scroll'});

		});					
	{/literal}
</script>
{if $is_guest}
	<h1 align="center" style=";text-align: center; margin-top: -5px; margin-left: 25%; margin-bottom: 15px;">{$language.UPLOADED_IMAGES}</h1>
	<div class="container_image_list" style="width: 900px;">
{else:}
	<div class="container_image_list" style="width: 900px;">
	<div style="text-align: center;font-size: 20px;font-weight: bold;" class="header_image_list">{$language.UPLOADED_IMAGES}</div>
{/if}

<div id="container_modal" style="display: none;"></div>
<div class="image_list" >
{if count($files) > 0}
<table cellpadding="2" cellspacing="2" width="100%" height="100%" class="images_table">
{if isset($is_admin)}
<tr height="30">

	<td class="odd" width="100" align="center">{$language.PREVIEW}</td>
	<td class="even" width="100">{$language.FILENAME}</td>
	<td class="odd" width="100">{$language.TAG}</td>
	<td class="even" width="100">{$language.ALBUM}</td>
	<td class="odd" width="100">{$language.DESCRIPTION}</td>
	<td class="even" width="100">{$language.DATA_UPLOADED}</td>
	<td class="odd" width="100">{$language.FILESIZE}</td>
	<td class="even" width="50">{$language.FILETYPE}</td>
	<td class="odd" width="50">{$lang_upload.ACCESS}</td>
	<td class="even" width="100" align="center">{$lang_main.ACTIONS}</td>
</tr>
{else:}	

	<td class="odd" width="100" align="center">{$language.PREVIEW}</td>
	<td class="even" width="100">{$language.FILENAME}</td>
	<td class="odd" width="100">{$language.TAG}</td>
	<td class="even" width="100">{$language.DESCRIPTION}</td>
	<td class="odd" width="100">{$language.DATA_UPLOADED}</td>
	<td class="even" width="100">{$language.FILESIZE}</td>
	<td class="odd" width="50">{$language.FILETYPE}</td>

{/if}
{foreach $files as $file}

	<tr id="row_{$file.id}">
		{if isset($is_admin)}
		<td class="odd" width="100" align="center" valign="middle">
			<a href="{$file.url}" class="file_preview" rel="shadowbox[mygallery]">{$file.preview}</a>
		</td>
		<td class="even file_name">
			<a href="{$file.main_url}" target="_blank">{splitterWord($file.show_filename,30)}</a>
		</td>
		<td class="odd tag_name">
			{if $file.tag_name}
				<a href="{site_url('gallery/tags')}/{$file.tag_id}">{splitterWord($file.tag_name,25)}</a>
			{/if}
		</td>
		<td class="even album_name">
			{if $file.album_name}
				<a href="{site_url('albums')}/{$file.album_id}" target="_blank">{splitterWord($file.album_name,25)}</a>
			{/if}
		</td>
		<td class="odd file_comment" width="100">
			{$file.comment}
		</td>
		<td class="even" width="100">
			{extract_date($file.added)}
		</td>
		<td class="odd file_size" width="100">
			{formatFileSize($file.size)}
		</td>
		<td class="even file_ext" width="50">
			{$file.ext}
		</td>
		<td class="odd	file_access" width="50" align="center">
				<img src="{$THEME}images/access_{$file.access}.png" width="15" height="15" title="{$file.access_text}"/>
		</td>
		<td class="even" align="center" width="50">
			<table>
				<tr>
					<td>
						<a href="{site_url('images/edit')}/{$file.id}" title="{$lang_main['EDIT']}" onclick="edit_image(this,'{$file.id}');return false;" id="edit_{$file.id}">
<img src="{$THEME}images/icon_edit.png" width="15" height="15"/></a>
					</td>
					<td>
						<a href="{site_url('images/delete')}/{$file.id}" title="{$lang_main['DELETE']}" onclick="delete_image(this,'{$file.id}','{$message_confirm_delete}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
<img src="{$THEME}images/icon_delete.png" width="15" height="15"/>
				</a>
					</td>
				</tr>
			</table>
			
				
				<input type="hidden" class="preview_width" value="{$file.preview_width}"/>
				<input type="hidden" class="preview_height" value="{$file.preview_height}"/>
		</td>
		{else:}
		
			<td class="odd" width="100" align="center" valign="middle">
			<a href="{$file.url}" class="file_preview" rel="shadowbox[mygallery]">{$file.preview}</a>
		</td>
		<td class="even file_name">
			<a href="{$file.main_url}" target="_blank">{splitterWord($file.show_filename,30)}</a>
		</td>
		<td class="odd tag_name">
			{if $file.tag_name}
				<a href="{site_url('gallery/tags')}/{$file.tag_id}">{splitterWord($file.tag_name,25)}</a>
			{/if}
		</td>
		
		<td class="even file_comment" width="100">
			{$file.comment}
		</td>
		<td class="odd" width="100">
			{extract_date($file.added)}
		</td>
		<td class="even file_size" width="100">
			{formatFileSize($file.size)}
		</td>
		<td class="odd file_ext" width="50">
			{$file.ext}
		</td>
		
		{/if}
		
	</tr>
{/foreach}
</table>
{else:}
	<div style="text-align: center;font-size: 16px;font-weight: bold;">{$language.NO_PICTURES_PUBLIC}</div>
{/if}
</div>
</div>
<div class="pagination" style="color: black !important;">
	{$paginator}
</div>