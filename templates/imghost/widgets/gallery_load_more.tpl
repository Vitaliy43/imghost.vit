{$counter = 0}
{foreach $images as $image}
	<div class="list-item c7 gutter-margin-right-bottom privacy-public curpage_{$cur_page}" id="{$image.data_id}" data-type="image" data-page="{$cur_page}" data-number="{$counter}">
	<div class="list-item-image" style="position: relative;" onmouseover="show_magnify(this);" onmouseout="hide_magnify(this);">
		<!--a href="{$image.main_url}" class="image-container" onclick="show_main_url(this);return false;" style="width: 100%;height: 100%;"-->
		<a href="{$image.relative_url}" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;">
			<img src="{$image.url}" alt="{$image.show_filename}" style="width:100%;position: absolute;z-index: 3;" title="{$image.show_filename}"/>
		</a>
		<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%; text-align: left;margin-bottom: 15%;">
		<a href="{$image.url}" rel="shadowbox[mygallery]" class="shadowbox">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td valign="middle">
						<img src="{$THEME}images/magnify.png" width="24" height="24"/>
				</td>
				<td valign="middle" style="padding-left: 5px;padding-bottom: 10px;font-weight: bold;">
						{$lang_main.QUICK_VIEW}
				</td>
			</tr>
		</table>
		</a>
	</div>
	</div>
	{if $image.type == 'guest' }
		{if $image.torrent_name}
			<div class="list-item-desc" style="padding-bottom: {$image.torrent_name_length}px;">
		{else:}
			<div class="list-item-desc">
		{/if}
		
			<span>{$language.GUEST}</span>
			{if $image.enable_operation}
				<span style="margin-left: 5px;">
				<a href="{site_url('images/delete')}/{$image.id}" onclick="delete_image_from_gallery(this,{$image.id},'{$lang_images.CONFIRM_DELETE}');return false;" title="{$language.DELETE_IMAGE}">
				<img src="/templates/administrator/images/icon_delete.png" width="12" height="12" style="margin-top:3px"/>
				</a>
			</span>
			{/if}
			{if $image.torrent_name}
				<div>{$language.ALBUM}: <a href="{site_url('torrents')}/{$image.torrent_id}" target="_blank">{$image.torrent_name}</a></div>
			{/if}
			{if mb_strlen($image.comment) > 0}
				<div>{$image.comment}</div>
			{else:}
				<div>{$language.NO_COMMENTS}</div>
			{/if}
			{if $is_top}
			{if $top_sort == 'views'}
				<div>{$lang_top.NUM_VIEWS}: {$image.views}</div>
			{elseif $top_sort == 'rating'}
				<div>{$lang_top.RATING}: {$image.rating}</div>
			{/if}
			{else:}
				<div>{$language.ADDED} {$image.added}</div>
			{/if}
		</div>
	{else:}
			{if $image.album_name}
			<div class="list-item-desc" style="padding-bottom: 30px;">
		{else:}
			<div class="list-item-desc">
		{/if}
			<div>
			{if $type == 'user'}
				{if $image.enable_show}
					<a href="{site_url('user')}/{$image.uid}" target="_blank">{$image.username}</a>
				{else:}
					<span>{$lang_auth.USER}</span>
				{/if}
			{else:}
				{if $image.enable_show}
					<span>{$image.username}</span>
				{else:}
					<span>{$lang_auth.USER}</span>
				{/if}
			{/if}
			{if $image.enable_operation}
				<span style="margin-left: 5px;">
				<a href="{site_url('images/delete')}/{$image.id}" onclick="delete_image_from_gallery(this,{$image.id},'{$lang_images.CONFIRM_DELETE}');return false;" title="{$language.DELETE_IMAGE}">
				<img src="/templates/administrator/images/icon_delete.png" width="12" height="12" style="margin-top:3px"/>
				</a>
			</span>
			{/if}
			</div>
			{if $image.album_name}
				<div>{$language.ALBUM}: <a href="{site_url('albums')}/{$image.album_id}" target="_blank">{$image.album_name}</a></div>
			{/if}
			{if mb_strlen($image.comment) > 0}
				<div>{$image.comment}</div>
			{else:}
				<div>{$language.NO_COMMENTS}</div>
			{/if}
			{if $is_top}
			{if $top_sort == 'views'}
				<div>{$lang_top.NUM_VIEWS}: {$image.views}</div>
			{elseif $top_sort == 'rating'}
				<div>{$lang_top.RATING}: {$image.rating}</div>
			{/if}
		{else:}
			<div>{$language.ADDED} {$image.added}</div>
		{/if}
			
		</div>
	{/if}
</div>
{$counter++}
{/foreach}
{if $pages > 1}
<div data-template="content-listing" class="hidden">
	<div class="pad-content-listing"></div>
	<div class="content-listing-more">
		<button class="btn btn-big grey" data-action="load-more">{$language.LOAD_MORE}</button>
	</div>
	<div class="content-listing-loading"></div>
	<div class="content-listing-pagination"><a data-action="load-more">{$language.LOAD_MORE}</a></div>
</div>
<div data-template="content-listing-empty" class="hidden">
</div>
<div data-template="content-listing-loading" class="hidden">
	<div class="content-listing-loading"></div>
</div>
{/if}