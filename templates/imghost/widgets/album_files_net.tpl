
<div class="file_item" style="width:97px;height:72px;">
	
	<a href="{site_url('sync')}/{$net}" onclick="show_root(this);return false;">
		<img src="{$THEME}images/back_ru.png"/>
	</a>
	
</div>
{if count($files) > 0}

{foreach $files as $file}
	<div class="file_item draggable" data-id="{$file.id}" data-owner="{$file.owner_id}" data-album="{$file.album_id}">
		<a rel="shadowbox[mygallery]" href="{$file.image}" title="{$file.text}" class="shadowbox">
				<img src="{$file.image_preview}" class="{$net}"/>
			
		</a>
		
	</div>
{/foreach}
{/if}
<input type="hidden" id="net_owner_id" value="{$net_owner_id}"/>
<input type="hidden" id="net_album_id" value="{$net_album_id}"/>