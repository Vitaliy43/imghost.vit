<div class="file_item" style="width:97px;height:72px;">
	<a href="{site_url('sync')}" onclick="show_root(this);return false;">
		<img src="{$THEME}images/back_ru.png"/>
	</a>
</div>
{if count($files) > 0}
{foreach $files as $file}
	<div class="file_item draggable" data-id="{$file.id}" data-album="{$file.album_id}">
		<a rel="shadowbox[mygallery]" href="{$file.url}" title="{$file.show_filename}" class="shadowbox">
			<!--img src="{$file.thumbnail}"/-->
			<img src="{$file.thumbnail_80}" />

		</a>
	</div>
{/foreach}
{/if}