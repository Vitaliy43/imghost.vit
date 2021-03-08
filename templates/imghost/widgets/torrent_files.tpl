
{if !$from_resort}
<div id="sync_info" style="text-align: center;display: none;">
	{$lang_upload.SYNC_INFO}
</div>
<div class="panel_iframe" style="width: {$width};height: {$height};">
{if count($files) > 0}
{$counter = 0}
{if $display == 'block'}
<table cellpadding="10" cellspacing="10" width="90%">
{foreach $files as $file}
	{if $counter == 0}<tr>{/if}
	<td align="center" valign="top">
	<table cellpadding="0" cellspacing="0" class="container_item">
	<tr>
			<td valign="top" align="center">
			<table>
				<tr>
					<td>
						<div style="text-align: center;margin-bottom:5px;" id="link_{$file.id}">
						{if $delete_without_confirm}
						<a href="{site_url('images_guest/delete')}/{$file.id}?token={$token}&torrent_id={$file.torrent_id}" onclick="delete_image_from_seedoff_without_confirm(this,{$file.id});return false;" title="{$language.DELETE_IMAGE}">
						{else:}
							<a href="{site_url('images_guest/delete')}/{$file.id}?token={$token}&torrent_id={$file.torrent_id}" onclick="delete_image_from_seedoff_edit(this,{$file.id},'{$lang_images.CONFIRM_DELETE}');return false;" title="{$language.DELETE_IMAGE}">
					{/if}
						<img src="/templates/administrator/images/icon_delete.png" width="15" height="15" />
					</a>
				</div>
					</td>
					
					
				</tr>
			</table>	
			
			</td>
		</tr>
		<tr>
			<td height="150" valign="top">
				<div class="file_item_edit" data-id="{$file.id}">
				<div>
					<a rel="shadowbox[mygallery]" href="{$file.url}" title="{$file.show_filename}" class="shadowbox" >
			<!--img src="{$file.thumbnail_80}" /-->
					<img src="{$file.thumbnail}" width="150px;"/>
					</a>
			</div>	
			</div>
			</td>
		
		</tr>
	</table>
	
	</td>
	{$counter ++}
	{if $counter > $cols}
	</tr>
	{$counter = 0}
	{/if}
{/foreach}
</table>
{else:}
<table cellpadding="5" cellspacing="5" width="100%" id="torrent_files" border="1">
{$counter = 1}
{foreach $files as $file}
<tr id="element_{$file.id}" style="cursor: move;" title="{$lang_image.CLICK_FOR_DRAG}">
	<td align="center" width="50">{$counter}</td>
	<td class="odd" width="100" align="center" valign="middle">
		<!--a href="{$file.url}" class="shadowbox" rel="shadowbox[mygallery]">{$file.preview}</a-->
		<a href="{$file.url}" class="shadowbox" rel="shadowbox[mygallery]" title="{$lang_image.TITLE_BIG}"><img src="{$file.thumbnail_80}"/>
</a>
	</td>
	<td width="50%">
		<a href="{$file.main_url}" target="_blank" style="font-size: 15px;">{$file.show_filename} - {$lang_image.SCREEN} {$counter}</a>
	</td>
	<td align="center" width="50">
		<table>
			<tr>
				
				<td align="center">
					<a href="{site_url('images_guest/delete')}/{$file.id}" title="{$lang_main.DELETE}" onclick="delete_image(this,'{$file.id}','{$lang_images.CONFIRM_DELETE}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
					</a>
				</td>
					</tr>
				</table>
	</td>
</tr>
{$counter++}
{/foreach}


</table>
{/if}
{/if}
</div>
{else:}
<table cellpadding="10" cellspacing="10" width="100%" id="torrent_files" border="1">
{$counter = 1}
{foreach $files as $file}
<tr id="element_{$file.id}" style="cursor: move;" title="{$lang_image.CLICK_FOR_DRAG}">
	<td align="center" width="50">{$counter}</td>
	<td class="odd" width="100" align="center" valign="middle">
		<!--a href="{$file.url}" class="shadowbox" rel="shadowbox[mygallery]">{$file.preview}</a-->
		<a href="{$file.url}" class="shadowbox" rel="shadowbox[mygallery]"><img src="{$file.thumbnail_80}"/></a>
	</td>
	<td width="50%">
		<a href="{$file.main_url}" target="_blank" style="font-size: 15px;">{$file.show_filename} - {$lang_image.SCREEN} {$counter}</a>
	</td>
	<td align="center" width="50">
		<table>
			<tr>
				<td align="center">
					<a href="{site_url('images_guest/delete')}/{$file.id}" title="{$lang_main.DELETE}" onclick="delete_image(this,'{$file.id}','{$lang_images.CONFIRM_DELETE}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
					</a>
				</td>
					</tr>
				</table>
	</td>
</tr>
{$counter++}
{/foreach}
</table>

{/if}