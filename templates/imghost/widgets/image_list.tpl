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
<style type="text/css">
	{literal}
a.sorter {
	text-decoration: none;
	color:#000;
	white-space: nowrap;
}

a.sorter:hover {
	text-decoration: underline;
}
{/literal}
</style>
{$transit_parameters}
{if $is_guest}
	<h1 align="center" style=";text-align: center; margin-top: -5px; margin-left: 25%; margin-bottom: 15px;">{$language.UPLOADED_IMAGES}</h1>
	<div class="container_image_list" style="width: 900px;">
{else:}
	<div class="container_image_list" style="width: 900px;">
	<div style="text-align: center;font-size: 20px;font-weight: bold;" class="header_image_list">{$language.UPLOADED_IMAGES}</div>
	{if $transit_parameters}
			<div style="text-align: center; margin-bottom: 10px;" id="block_search"><a href="/profile" onclick="reset_search_images(this);return false;">Сброс результатов поиска</a></div>
	{else:}
		<div style="text-align: center; margin-bottom: 10px;" id="block_search"><a href="/profile" onclick="show_search_images(this);return false;">{$language.SEARCH_BY_IMAGES}</a></div>
	{/if}
{/if}

<div id="container_modal" style="display: none;"></div>
<div class="image_list" >
{if count($files) > 0}
<table cellpadding="2" cellspacing="2" width="100%" height="100%" class="images_table">
{if !$is_guest}
<tr height="30">

	<td class="odd" width="100" align="center">{$language.PREVIEW}</td>
	<td class="even" width="100"><a href="{$order_link}?order=show_filename" class="sorter" title="{$language.ORDER_BY_FILENAME}" onclick="hash_change(this.href);return false;">{$language.FILENAME}</a></td>
	<td class="odd" width="100" align="center">{$language.LINKS}</td>
	<td class="even" width="100" align="center">{$language.TAG}</td>
	<td class="odd" width="100" align="center">{$language.ALBUM}</td>
	<td class="even" width="100">{$language.DESCRIPTION}</td>
	<td class="odd" width="100"><a href="{$order_link}?order=added" class="sorter" title="{$language.ORDER_BY_ADDED}" onclick="hash_change(this.href);return false;">{$language.DATA_UPLOADED}</a></td>
	<td class="even" width="100"><a href="{$order_link}?order=size" class="sorter" title="{$language.ORDER_BY_FILESIZE}" onclick="hash_change(this.href);return false;">{$language.FILESIZE}</a></td>
	<td class="odd" width="50">{$language.FILETYPE}</td>
	<td class="even" width="50">{$lang_upload.ACCESS}</td>
	<td class="odd" width="100" align="center">{$lang_main.ACTIONS}</td>
</tr>
{else:}	

	<td class="odd" width="100" align="center">{$language.PREVIEW}</td>
	<td class="even" width="100"><a href="{$order_link}?order=show_filename" class="sorter" title="{$language.ORDER_BY_FILENAME}" onclick="hash_change(this.href);return false;">{$language.FILENAME}</a></td>
	<td class="odd" width="100" align="center">{$language.LINKS}</td>
	<td class="even" width="100" align="center">{$language.TAG}</td>
	<td class="odd" width="100">{$language.DESCRIPTION}</td>
	<td class="even" width="100"><a href="{$order_link}?order=added" class="sorter" title="{$language.ORDER_BY_ADDED}" onclick="hash_change(this.href);return false;">{$language.DATA_UPLOADED}</a></td>
	<td class="odd" width="100"><a href="{$order_link}?order=size" class="sorter" title="{$language.ORDER_BY_FILESIZE}" onclick="hash_change(this.href);return false;">{$language.FILESIZE}</a></td>
	<td class="even" width="50">{$language.FILETYPE}</td>
	<td class="odd" width="50">{$lang_upload.ACCESS}</td>
	<td class="even" width="100" align="center">{$lang_main.ACTIONS}</td>

{/if}
{$counter = 0}
{foreach $files as $file}

	
	<tr id="row_{$file.id}" class="image_row">
		{if !$is_guest}
		<td class="odd" width="100" align="center" valign="middle">
			<a href="{$file.url}" class="file_preview" rel="shadowbox[mygallery]">{$file.preview}</a>
		</td>
		<td class="even file_name">
			<a href="{$file.main_url}" class="image-container-profile" onclick="open_main_url(this);return false;" data-position="{$counter}">{splitterWord($file.show_filename,30)}</a>
			<!--a href="{$file.main_url}" class="image-container-profile" target="_blank">{splitterWord($file.show_filename,30)}</a-->
		</td>
		<td class="odd" width="100" align="center">
		
			<div class="more-options">
				<a class="jsAction" href="#" onclick="show_links_profile(this);return false;" style="text-transform: lowercase;text-decoration: none;color: #000; border-bottom: 1px dashed #000;" title="{$lang_upload.SHOW_LINKS}">{$language.LINKS}</a>
			</div>
			<div class="modal-wnd inplace" style="display: none;">	
				{block_links($file,$lang_upload,$user.tiny_static)}		
			
		</div>
		</td>
		
		<td class="even tag_name" align="center">
			{if $file.tag_name}
				<a href="{site_url('gallery/tags')}/{$file.tag_id}" target="_blank">{splitterWord($file.tag_name,25)}</a>
			{/if}
		</td>
		<td class="odd album_name" align="center">
			{if $file.album_name && $file.type == 'user'}
				<a href="{site_url('albums')}/{$file.album_id}" target="_blank">{splitterWord($file.album_name,25)}</a>
			{elseif $file.album_name && $file.type == 'guest'}
				<a href="{site_url('torrents')}/{$file.album_id}" target="_blank">{splitterWord($file.album_name,25)}</a>
			{/if}
		</td>
		<td class="even file_comment" width="100">
			{$file.comment}
		</td>
		<td class="odd" width="100">
			{extract_date($file.added)}
		</td>
		<td class="even file_size" width="100" style="padding: 3px;">

			<table>
				<tr>
					<td nowrap="">{formatFileSize($file.size)}</td>
				</tr>
				<tr>
					<td style="padding-top:3px;" nowrap="">{$file.width} x {$file.height}</td>
				</tr>
			</table>
		</td>
		<td class="odd file_ext" width="50">
			{$file.ext}
		</td>
		<td class="even	file_access" width="50" align="center">
			<img src="{$THEME}images/access_{$file.access}.png" width="15" height="15" title="{$file.access_text}"/>
		</td>
		
		
		<td class="odd" align="center" width="50">
			<table>
				<tr>
					<td>
					{if isset($file.type) && $file.type == 'guest'}
						<a href="{site_url('images_guest/edit')}/{$file.id}" title="{$lang_main.EDIT}" onclick="edit_image(this,{$file.id});return false;" id="edit_{$file.id}">
<img src="{$THEME}images/icon_edit.png" width="15" height="15"/></a>
					{else:}
						<a href="{site_url('images/edit')}/{$file.id}" title="{$lang_main.EDIT}" onclick="edit_image(this,{$file.id});return false;" id="edit_{$file.id}">
<img src="{$THEME}images/icon_edit.png" width="15" height="15"/></a>
					{/if}
					</td>
					<td>
					{if isset($file.type) && $file.type == 'guest'}
						<a href="{site_url('images_guest/delete')}/{$file.id}" title="{$lang_main.DELETE}" onclick="delete_image(this,{$file.id},'{$message_confirm_delete}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
<img src="{$THEME}images/icon_delete.png" width="15" height="15"/></a>
					{else:}
						<a href="{site_url('images/delete')}/{$file.id}" title="{$lang_main.DELETE}" onclick="delete_image(this,{$file.id},'{$message_confirm_delete}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
<img src="{$THEME}images/icon_delete.png" width="15" height="15"/></a>
					{/if}
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
			<!--a href="{$file.main_url}" class="image-container-profile" onclick="open_main_url(this);return false;">{splitterWord($file.show_filename,30)}</a-->
			<a href="{$file.main_url}" class="image-container-profile" target="_blank">{splitterWord($file.show_filename,30)}</a>
		</td>
		<td class="odd	file_access" width="100" align="center">
		
			<div class="more-options">
				<a class="jsAction" href="#" onclick="show_links_profile(this);return false;" style="text-transform: lowercase;text-decoration: none;" title="{$lang_upload.SHOW_LINKS}">{$language.LINKS}</a>
			</div>
			<div class="modal-wnd inplace" style="display: none;">	
			{block_links($file,$lang_upload)}	
			
		</div>
		</td>
		
		<td class="even tag_name" align="center">
			{if $file.tag_name}
				<a href="{site_url('gallery/tags')}/{$file.tag_id}" target="_blank">{splitterWord($file.tag_name,25)}</a>
			{/if}
		</td>
		
		<td class="odd file_comment" width="100">
			{$file.comment}
		</td>
		<td class="even" width="100">
			{extract_date($file.added)}
		</td>
		<td class="even file_size" width="100" style="padding: 3px;">

			<table>
				<tr>
					<td>{formatFileSize($file.size)}</td>
				</tr>
				<tr>
					<td style="padding-top:3px;">{$file.width} x {$file.height}</td>
				</tr>
			</table>
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
							<a href="{site_url('images_guest/edit')}/{$file.id}" title="{$lang_main['EDIT']}" onclick="edit_image(this,'{$file.id}');return false;" id="edit_{$file.id}">
<img src="{$THEME}images/icon_edit.png" width="15" height="15"/></a>
						</td>
						<td>
							<a href="{site_url('images_guest/delete')}/{$file.id}" title="{$lang_main['DELETE']}" onclick="delete_image(this,'{$file.id}','{$message_confirm_delete}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
<img src="{$THEME}images/icon_delete.png" width="15" height="15"/>
				</a>
						</td>
					</tr>
				</table>
				
				
				<input type="hidden" class="preview_width" value="{$file.preview_width}"/>
				<input type="hidden" class="preview_height" value="{$file.preview_height}"/>

		</td>
		
		{/if}
		
	</tr>
{$counter ++}
{/foreach}
</table>
{else:}

	<div style="text-align: center;font-size: 16px;font-weight: bold;">{$language.NO_PICTURES}</div>
{/if}
</div>
</div>
<div class="pagination" style="color: black !important;">
	{$paginator}
</div>