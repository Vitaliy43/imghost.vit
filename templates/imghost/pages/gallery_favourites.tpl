<link rel="stylesheet" type="text/css" href="{$THEME}css/jquery.minimalect.css" media="all" />
<script type="text/javascript" src="{$THEME}js/jquery.minimalect.js"></script>
{literal}
<script type="text/javascript">
	$(document).ready(function() {
		if(document.location.hash){
			load_more_hash();
			}
		else{
			var current_url = document.location.href;
			var buffer = current_url.split('/');
			if(buffer.length == 2)
				load_more(buffer[buffer.length - 1]);
		}
		});

	$( function() {		
		$("#TAGS").minimalect();
		$("#TAGS_CHILDREN").minimalect();
	});

</script>
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
	<h1>{$language.TITLE_FAVOURITES}</h1>
</div>

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
		<a href="{$image.relative_url}" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;" >
			<img src="{$image.url}" alt="{$image.show_filename}" style="width:100%;position: absolute;z-index: 3;"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;;text-align: left;margin-bottom: 15%;">
		<a href="{$image.url}" rel="shadowbox[mygallery]" title="{$image.show_filename}">
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
	{if !$image.username}
		<div class="list-item-desc">
			<div>{$language.GUEST}</div>
			{if mb_strlen($image.comment) > 0}
				<div>{$image.comment}</div>
			{else:}
				<div>{$language.NO_COMMENTS}</div>
			{/if}
				<div>{$language.ADDED} {$image.added}</div>
		</div>
	{else:}
		{if $image.album_name}
			<div class="list-item-desc" style="padding-bottom: 30px;">
		{else:}
			<div class="list-item-desc">
		{/if}
			<div><a href="{site_url('user')}/{$image.uid}" target="_blank">{$image.username}</a></div>
			{if $image.album_name}
				<div>{$language.ALBUM}: <a href="{site_url('albums')}/{$image.album_id}" target="_blank">{splitterWord($image.album_name,20)}</a></div>
			{/if}
			{if mb_strlen($image.comment) > 0}
				<div>{$image.comment}</div>
			{else:}
				<div>{$language.NO_COMMENTS}</div>
			{/if}
				<div>{$language.ADDED} {$image.added}</div>
			
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
{else:}
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;">{$language.NOT_FOUND}</div>
{/if}
</div>
</div>