{literal}
<style type="text/css">
	.list-item-privacy {
		background: #fff;
		filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70); /* IE 5.5+*/
		-moz-opacity: 0.7; /* Mozilla 1.6 и ниже */
		-khtml-opacity: 0.7; /* Konqueror 3.1, Safari 1.1 */
		opacity: 0.7; /* CSS3 - Mozilla 1.7b +, Firefox 0.9 +, Safari 1.2+, Opera 9 */	
		border-radius: 10px 0 0 10px;
	}
	.list-item-privacy table {margin: 5px;}
	.list-item-privacy a {text-decoration: none;color:inherit;}
</style>
{/literal}
<div id="container_gallery">
<div id="header_gallery" style="text-align: center;margin-top: -60px;">
	<h1>{$language.ALBUM}</h1>
</div>
<input type="hidden" id="album_id" value="{$album_id}"/>
{$album_info}

<div id="content-listing-tabs" class="tabbed-listing" style="margin-top: 20px;">
<input type="hidden" id="all_uploaded" value="{$all_uploaded}"/>
{if $cur_page > 0}
	<input type="hidden" id="current_page" value="{$cur_page}"/>
{else:}
	<input type="hidden" id="current_page" value="1"/>
{/if}
{$counter = 0}
{if count($images) > 0}
{foreach $images as $image}
	<div class="list-item c7 gutter-margin-right-bottom privacy-public curpage_1" id="{$image.data_id}" data-type="image" style="background: #E7EFF3;" data-page="1" data-number="{$counter}">
	<div class="list-item-image" style="position: relative;" onmouseover="show_magnify(this);" onmouseout="hide_magnify(this);">
		<!--a href="{$image.main_url}" class="image-container" onclick="show_main_url_album(this);return false;" style="width: 100%;height: 100%;" -->
		<a href="{$image.related_url}" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;" >
		<!--a href="{$image.main_url}" class="image-container"-->
			<img src="{$image.url}" alt="{$image.show_filename}" style="width:100%;position: absolute;z-index: 3;"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;;text-align: left;margin-bottom: 15%;">
		<a href="{$image.url}" rel="shadowbox[mygallery]">
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

		<div class="list-item-desc">
				
				{if $is_owner}
				<div>
				<span>{splitterWord($image.show_filename, 20)}</span>
				<span style="margin-left: 5px;">
				<a href="{site_url('images/delete')}/{$image.id}" onclick="delete_image_from_album_gallery(this,{$image.id},{$album_id},'{$type}','{$lang_images.CONFIRM_DELETE}');return false;" title="{$lang_main.DELETE_IMAGE}">
				<img src="/templates/administrator/images/icon_delete.png" width="12" height="12" style="margin-top:3px"/>
				</a>
			</span>
			</div>
			{/if}
			{if mb_strlen($image.comment) > 0}
				<div>{$image.comment}</div>
			{else:}
				<div>{$language.NO_COMMENTS}</div>
			{/if}
				<div>{$language.ADDED} {$image.added}</div>
		</div>
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
{else:}
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;">{$language.NOT_FOUND_ALBUM}</div>
{/if}
</div>
</div>