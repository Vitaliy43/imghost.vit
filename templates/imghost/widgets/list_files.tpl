<div style="font-weight: bold;padding-left: 5px; padding-top: 5px;">{$language.FILES_IN_ROOT}</div>
{if count($files) > 0}
<table width="97%">
	{foreach $files as $file}
		<tr class="row">
			<td style="background: #d7d8d8;">
			<div class="draggable" data-id="{$file.id}" data-type="{$file.type}">
			<a href="{$file.url}" rel="shadowbox[gallery]" onmouseover=" return overlib('<img src={$file.preview}   width=100 border=0>', RIGHT);" onmouseout="return nd();" class="link_file shadowbox" >
			<img src="{$file.preview}" width="20" height="20"/>&nbsp;
			<span>{$file.show_filename}</span>	
			</a>
			{if $file.type == 'user'}
				<a href="/images/delete/{$file.id}" style="padding-left:5px;" title="{$lang_main.DELETE}" onclick="delete_image_from_albums(this,{$file.id},'{$lang_images.CONFIRM_DELETE}');return false;" style="margin-left: 15px;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a>
			{else:}
				<a href="/images_guest/delete/{$file.id}" style="padding-left:5px;" title="{$lang_main.DELETE}" onclick="delete_image_from_albums(this,{$file.id},'{$lang_images.CONFIRM_DELETE}');return false;" style="margin-left: 15px;"><img src="/templates/administrator/images/icon_delete.png" width="10" height="10" /></a>
			{/if}
			<a style="padding-left:10px;" href="{$file.main_url}" title="{$lang_main.OPEN}" target="_blank"><img src="/templates/imghost/images/folder_open.png" width="10" height="10" /></a>
			</div>
			</td>
			
		</tr>
	
	{/foreach}
	
</table>
<div class="pagination" style="color: black !important;margin-top: 10px;">
	{$paginator}
</div>
{else:}


{/if}
<input type="hidden" id="current_type" />