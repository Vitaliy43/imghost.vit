{if !$is_ajax}
<link rel="stylesheet" type="text/css" href="{$THEME}css/jquery.minimalect.css" media="all" />
<script type="text/javascript" src="{$THEME}js/jquery.minimalect.js"></script>
{literal}
<script type="text/javascript">
	var from_layout = true;

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
		
	window.onpopstate = function(event) {
		var is_top = $('#is_top').val();

	if(supportsHistoryAPI == false)
		return false;
	if(from_layout)
		return false;
	if(is_top == 0)
		return false;
	load_top(document.location.href);

};

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
	#container_gallery ul {list-style: none;}
	#container_gallery ol {list-style: decimal;}
	
	ul#navigation {
	height: 36px;
	padding: 20px 20px 0 30px;
	width: 904px;
	margin: 0 auto;
	position: relative;
	overflow: hidden;
	}

ul#navigation li {
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	float: left;
	width: 200px;
	margin: 0 10px 0 0;
	background-color: #2B477D;
	border: solid 1px #415F9D;
	position: relative;
	z-index: 1;
}

ul#navigation li.selected {
	z-index: 3;
}

ul#navigation li.shadow {
	width: 100%;
	height: 2px;
	position: absolute;
	bottom: -3px;
	left: 0;
	border: none;
	background: none;
	z-index: 2;
	-webkit-box-shadow: #111 0 -2px 6px;
	-moz-box-shadow: #111 0 -2px 6px;
	box-shadow: #111 0 -2px 6px;
}

ul#navigation li a:link, ul#navigation li a:visited {
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	display: block;
	text-align: center;
	width: 200px;
	height: 40px;
	line-height: 36px;
	font-family: Arial, Helvetica, sans-serif;
	text-transform: uppercase;
	text-decoration: none;
	font-size: 13px;
	font-weight: bold;
	color: #fff;
	letter-spacing: 1px;
	outline: none;
	float: left;
	background: #2B477D;
	-webkit-transition: background-color 0.3s linear;
	-moz-transition: background-color 0.3s linear;
	-o-transition: background-color 0.3s linear;
}

ul#navigation li a:hover {
	background-color: #5a87dd;
}

ul#navigation li.selected a:link, ul#navigation li.selected a:visited {
	color: #2B477D;
	border: solid 1px #fff;
	-webkit-transition: background-color 0.2s linear;
	background: -moz-linear-gradient(top center, #d1d1d1, #f2f2f2 80%) repeat scroll 0 0 #f2f2f2;
	background: -webkit-gradient(linear,left bottom,left top,color-stop(.2, #f2f2f2),color-stop(.8, #d1d1d1));
	background-color: #f2f2f2;
}
	
	ul#navigation li.selected a:link, ul#navigation li.selected a:visited {
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#d1d1d1', endColorstr='#f2f2f2'); /* IE6,IE7 */
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#d1d1d1', endColorstr='#f2f2f2')"; /* IE8 */
}
</style>

{/literal}
<div id="container_gallery">
<input type="hidden" id="is_top" value="{$is_top}"/>
<div id="header_gallery" style="text-align: center;margin-top: -60px;">
	{if !$is_top}
		<h1>{$language.TITLE}</h1>
	{else:}
		<h1>{$lang_top.TITLE}</h1>
	{/if}
</div>
{if $tag }
<div id="images_with_tag">
	<span>{$language.IMAGES_WITH_TAG}: {$tag.value}</span>
</div>
{/if}
<div id="search_panel">
	{$search_panel}
</div>
{if $is_top}
<ul id="navigation">
	<li class="one {if $top_sort == 'views'} selected {/if}"><a href="{if $top_sort == 'views'}#{else:}/gallery/top{/if}" >{$lang_top.MOST_POPULAR}</a></li>
	{if DEVELOPMENT == true}
		<li class="two {if $top_sort == 'comments'} selected {/if}"><a href="{if $top_sort == 'comments'}#{else:}/gallery/top/comments{/if}" >{$lang_top.MOST_COMMENTED}</a></li>
	{/if}
	<li class="three {if $top_sort == 'rating'} selected {/if}"><a href="{if $top_sort == 'rating'}#{else:}/gallery/top/rating{/if}" >{$lang_top.MOST_RATING}</a></li>
	
</ul>
{/if}
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
			<img src="{$image.url}" alt="{$image.show_filename}" style="width:100%;position: absolute;z-index: 3;" title="{$image.show_filename}"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;text-align: left;margin-bottom: 15%;">
		<!--a href="{$image.url}" onclick="show_image_gallery(this);return false;"-->
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
			<div class="list-item-desc" style="padding-bottom: {$image.album_name_length}px;">
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
{else:}
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;">{$language.NOT_FOUND}</div>
{/if}
</div>
</div>
{else:}

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
			<img src="{$image.url}" alt="{$image.show_filename}" style="width:100%;position: absolute;z-index: 3;" title="{$image.show_filename}"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;text-align: left;margin-bottom: 15%;">
		<!--a href="{$image.url}" onclick="show_image_gallery(this);return false;"-->
		<a href="{$image.url}" rel="shadowbox[mygallery]" >
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
		<div class="list-item-desc">
		
			<div>{$language.GUEST}</div>
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
		
			<div><a href="{site_url('user')}/{$image.uid}" target="_blank">{$image.username}</a></div>
			{if $image.album_name}
				<div>{$language.ALBUM}: <a href="{site_url('albums')}/{$image.album_id}" target="_blank">{splitterWord($image.album_name,20)}</a></div>
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
{else:}
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;">{$language.NOT_FOUND}</div>
{/if}
</div>

{/if}