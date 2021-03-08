<?php if(!$is_ajax): ?>
<link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/jquery.minimalect.css" media="all" />
<script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery.minimalect.js"></script>
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


<div id="container_gallery">
<input type="hidden" id="is_top" value="<?php if(isset($is_top)){ echo $is_top; } ?>"/>
<div id="header_gallery" style="text-align: center;margin-top: -60px;">
	<?php if(!$is_top): ?>
		<h1><?php echo $language['TITLE']; ?></h1>
	<?php else:?>
		<h1><?php echo $lang_top['TITLE']; ?></h1>
	<?php endif; ?>
</div>
<?php if($tag): ?>
<div id="images_with_tag">
	<span><?php echo $language['IMAGES_WITH_TAG']; ?>: <?php echo $tag['value']; ?></span>
</div>
<?php endif; ?>
<div id="search_panel">
	<?php if(isset($search_panel)){ echo $search_panel; } ?>
</div>
<?php if($is_top): ?>
<ul id="navigation">
	<li class="one <?php if($top_sort == 'views'): ?> selected <?php endif; ?>"><a href="<?php if($top_sort == 'views'): ?>#<?php else:?>/gallery/top<?php endif; ?>" ><?php echo $lang_top['MOST_POPULAR']; ?></a></li>
	<?php if(DEVELOPMENT == true): ?>
		<li class="two <?php if($top_sort == 'comments'): ?> selected <?php endif; ?>"><a href="<?php if($top_sort == 'comments'): ?>#<?php else:?>/gallery/top/comments<?php endif; ?>" ><?php echo $lang_top['MOST_COMMENTED']; ?></a></li>
	<?php endif; ?>
	<li class="three <?php if($top_sort == 'rating'): ?> selected <?php endif; ?>"><a href="<?php if($top_sort == 'rating'): ?>#<?php else:?>/gallery/top/rating<?php endif; ?>" ><?php echo $lang_top['MOST_RATING']; ?></a></li>
	
</ul>
<?php endif; ?>
<div id="content-listing-tabs" class="tabbed-listing" style="margin-top: 20px;">
<input type="hidden" id="all_uploaded" value="<?php if(isset($all_uploaded)){ echo $all_uploaded; } ?>"/>
<?php if($cur_page > 0): ?>
	<input type="hidden" id="current_page" value="<?php if(isset($cur_page)){ echo $cur_page; } ?>"/>
<?php else:?>
	<input type="hidden" id="current_page" value="1"/>
<?php endif; ?>
<?php $counter = 0?>
<?php if(count($images) > 0): ?>
<?php if(is_true_array($images)){ foreach ($images as $image){ ?>
	<div class="list-item c7 gutter-margin-right-bottom privacy-public curpage_1" id="<?php echo $image['data_id']; ?>" data-type="image" style="background: #E7EFF3;" data-page="1" data-number="<?php if(isset($counter)){ echo $counter; } ?>">
	<div class="list-item-image" style="position: relative;" onmouseover="show_magnify(this);" onmouseout="hide_magnify(this);">
		<a href="<?php echo $image['relative_url']; ?>" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;" >
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['show_filename']; ?>" style="width:100%;position: absolute;z-index: 3;" title="<?php echo $image['show_filename']; ?>"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;text-align: left;margin-bottom: 15%;">
		<!--a href="<?php echo $image['url']; ?>" onclick="show_image_gallery(this);return false;"-->
		<a href="<?php echo $image['url']; ?>" rel="shadowbox[mygallery]" title="<?php echo $image['show_filename']; ?>">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td valign="middle">
						<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/magnify.png" width="24" height="24"/>
				</td>
				<td valign="middle" style="padding-left: 5px;padding-bottom: 10px;font-weight: bold;">
						<?php echo $lang_main['QUICK_VIEW']; ?>
				</td>
			</tr>
		</table>
		</a>
	</div>
	</div>
	<?php if($image['type']  == 'guest'): ?>
		<?php if($image['torrent_name']): ?>
			<div class="list-item-desc" style="padding-bottom: <?php echo $image['torrent_name_length']; ?>px;">
		<?php else:?>
			<div class="list-item-desc">
		<?php endif; ?>
		
			<span><?php echo $language['GUEST']; ?></span>
			<?php if($image['enable_operation']): ?>
				<span style="margin-left: 5px;">
				<a href="<?php echo site_url ('images/delete'); ?>/<?php echo $image['id']; ?>" onclick="delete_image_from_gallery(this,<?php echo $image['id']; ?>,'<?php echo $lang_images['CONFIRM_DELETE']; ?>');return false;" title="<?php echo $language['DELETE_IMAGE']; ?>">
				<img src="/templates/administrator/images/icon_delete.png" width="12" height="12" style="margin-top:3px"/>
				</a>
			</span>
			<?php endif; ?>
			<?php if($image['torrent_name']): ?>
				<div><?php echo $language['ALBUM']; ?>: <a href="<?php echo site_url ('torrents'); ?>/<?php echo $image['torrent_id']; ?>" target="_blank"><?php echo $image['torrent_name']; ?></a></div>
			<?php endif; ?>
			<?php if(mb_strlen( $image['comment'] ) > 0): ?>
				<div><?php echo $image['comment']; ?></div>
			<?php else:?>
				<div><?php echo $language['NO_COMMENTS']; ?></div>
			<?php endif; ?>
			<?php if($is_top): ?>
			<?php if($top_sort == 'views'): ?>
				<div><?php echo $lang_top['NUM_VIEWS']; ?>: <?php echo $image['views']; ?></div>
			<?php elseif ($top_sort == 'rating'): ?>
				<div><?php echo $lang_top['RATING']; ?>: <?php echo $image['rating']; ?></div>
			<?php endif; ?>
			<?php else:?>
				<div><?php echo $language['ADDED']; ?> <?php echo $image['added']; ?></div>
			<?php endif; ?>
		</div>
	<?php else:?>

		<?php if($image['album_name']): ?>
			<div class="list-item-desc" style="padding-bottom: <?php echo $image['album_name_length']; ?>px;">
		<?php else:?>
			<div class="list-item-desc">
		<?php endif; ?>
			<div>
			<?php if($type == 'user'): ?>
				<?php if($image['enable_show']): ?>
					<a href="<?php echo site_url ('user'); ?>/<?php echo $image['uid']; ?>" target="_blank"><?php echo $image['username']; ?></a>
				<?php else:?>
					<span><?php echo $lang_auth['USER']; ?></span>
				<?php endif; ?>
			<?php else:?>
				<?php if($image['enable_show']): ?>
					<span><?php echo $image['username']; ?></span>
				<?php else:?>
					<span><?php echo $lang_auth['USER']; ?></span>
				<?php endif; ?>
			<?php endif; ?>
			<?php if($image['enable_operation']): ?>
				<span style="margin-left: 5px;">
				<a href="<?php echo site_url ('images/delete'); ?>/<?php echo $image['id']; ?>" onclick="delete_image_from_gallery(this,<?php echo $image['id']; ?>,'<?php echo $lang_images['CONFIRM_DELETE']; ?>');return false;" title="<?php echo $language['DELETE_IMAGE']; ?>">
				<img src="/templates/administrator/images/icon_delete.png" width="12" height="12" style="margin-top:3px"/>
				</a>
			</span>
			<?php endif; ?>
			</div>
			<?php if($image['album_name']): ?>
				<div><?php echo $language['ALBUM']; ?>: <a href="<?php echo site_url ('albums'); ?>/<?php echo $image['album_id']; ?>" target="_blank"><?php echo $image['album_name']; ?></a></div>
			<?php endif; ?>
			<?php if(mb_strlen( $image['comment'] ) > 0): ?>
				<div><?php echo $image['comment']; ?></div>
			<?php else:?>
				<div><?php echo $language['NO_COMMENTS']; ?></div>
			<?php endif; ?>
			<?php if($is_top): ?>
			<?php if($top_sort == 'views'): ?>
				<div><?php echo $lang_top['NUM_VIEWS']; ?>: <?php echo $image['views']; ?></div>
			<?php elseif ($top_sort == 'rating'): ?>
				<div><?php echo $lang_top['RATING']; ?>: <?php echo $image['rating']; ?></div>
			<?php endif; ?>
		<?php else:?>
			<div><?php echo $language['ADDED']; ?> <?php echo $image['added']; ?></div>
		<?php endif; ?>
			
		</div>
	<?php endif; ?>
</div>
<?php $counter++?>
<?php }} ?>
<?php if($pages > 1): ?>
<div data-template="content-listing" class="hidden">
	<div class="pad-content-listing"></div>
	<div class="content-listing-more">
		<button class="btn btn-big grey" data-action="load-more"><?php echo $language['LOAD_MORE']; ?></button>
	</div>
	<div class="content-listing-loading"></div>
	<div class="content-listing-pagination"><a data-action="load-more"><?php echo $language['LOAD_MORE']; ?></a></div>
</div>
<div data-template="content-listing-empty" class="hidden">
</div>
<div data-template="content-listing-loading" class="hidden">
	<div class="content-listing-loading"></div>
</div>
<?php endif; ?>
<?php else:?>
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;"><?php echo $language['NOT_FOUND']; ?></div>
<?php endif; ?>
</div>
</div>
<?php else:?>

<input type="hidden" id="all_uploaded" value="<?php if(isset($all_uploaded)){ echo $all_uploaded; } ?>"/>
<?php if($cur_page > 0): ?>
	<input type="hidden" id="current_page" value="<?php if(isset($cur_page)){ echo $cur_page; } ?>"/>
<?php else:?>
	<input type="hidden" id="current_page" value="1"/>
<?php endif; ?>
<?php $counter = 0?>
<?php if(count($images) > 0): ?>
<?php if(is_true_array($images)){ foreach ($images as $image){ ?>
	<div class="list-item c7 gutter-margin-right-bottom privacy-public curpage_1" id="<?php echo $image['data_id']; ?>" data-type="image" style="background: #E7EFF3;" data-page="1" data-number="<?php if(isset($counter)){ echo $counter; } ?>">
	<div class="list-item-image" style="position: relative;" onmouseover="show_magnify(this);" onmouseout="hide_magnify(this);">
		<a href="<?php echo $image['relative_url']; ?>" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;" >
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['show_filename']; ?>" style="width:100%;position: absolute;z-index: 3;" title="<?php echo $image['show_filename']; ?>"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;text-align: left;margin-bottom: 15%;">
		<!--a href="<?php echo $image['url']; ?>" onclick="show_image_gallery(this);return false;"-->
		<a href="<?php echo $image['url']; ?>" rel="shadowbox[mygallery]" >
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td valign="middle">
						<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/magnify.png" width="24" height="24"/>
				</td>
				<td valign="middle" style="padding-left: 5px;padding-bottom: 10px;font-weight: bold;">
						<?php echo $lang_main['QUICK_VIEW']; ?>
				</td>
			</tr>
		</table>
		</a>
	</div>
	</div>
	<?php if($image['type']  == 'guest'): ?>
		<div class="list-item-desc">
		
			<div><?php echo $language['GUEST']; ?></div>
			<?php if(mb_strlen( $image['comment'] ) > 0): ?>
				<div><?php echo $image['comment']; ?></div>
			<?php else:?>
				<div><?php echo $language['NO_COMMENTS']; ?></div>
			<?php endif; ?>
			<?php if($is_top): ?>
			<?php if($top_sort == 'views'): ?>
				<div><?php echo $lang_top['NUM_VIEWS']; ?>: <?php echo $image['views']; ?></div>
			<?php elseif ($top_sort == 'rating'): ?>
				<div><?php echo $lang_top['RATING']; ?>: <?php echo $image['rating']; ?></div>
			<?php endif; ?>
			<?php else:?>
				<div><?php echo $language['ADDED']; ?> <?php echo $image['added']; ?></div>
			<?php endif; ?>
		</div>
	<?php else:?>

		<?php if($image['album_name']): ?>
			<div class="list-item-desc" style="padding-bottom: 30px;">
		<?php else:?>
			<div class="list-item-desc">
		<?php endif; ?>
		
			<div><a href="<?php echo site_url ('user'); ?>/<?php echo $image['uid']; ?>" target="_blank"><?php echo $image['username']; ?></a></div>
			<?php if($image['album_name']): ?>
				<div><?php echo $language['ALBUM']; ?>: <a href="<?php echo site_url ('albums'); ?>/<?php echo $image['album_id']; ?>" target="_blank"><?php echo splitterWord ( $image['album_name'] ,20); ?></a></div>
			<?php endif; ?>
			<?php if(mb_strlen( $image['comment'] ) > 0): ?>
				<div><?php echo $image['comment']; ?></div>
			<?php else:?>
				<div><?php echo $language['NO_COMMENTS']; ?></div>
			<?php endif; ?>
			<?php if($is_top): ?>
			<?php if($top_sort == 'views'): ?>
				<div><?php echo $lang_top['NUM_VIEWS']; ?>: <?php echo $image['views']; ?></div>
			<?php elseif ($top_sort == 'rating'): ?>
				<div><?php echo $lang_top['RATING']; ?>: <?php echo $image['rating']; ?></div>
			<?php endif; ?>
		<?php else:?>
			<div><?php echo $language['ADDED']; ?> <?php echo $image['added']; ?></div>
		<?php endif; ?>
			
		</div>
	<?php endif; ?>
</div>
<?php $counter++?>
<?php }} ?>
<?php if($pages > 1): ?>
<div data-template="content-listing" class="hidden">
	<div class="pad-content-listing"></div>
	<div class="content-listing-more">
		<button class="btn btn-big grey" data-action="load-more"><?php echo $language['LOAD_MORE']; ?></button>
	</div>
	<div class="content-listing-loading"></div>
	<div class="content-listing-pagination"><a data-action="load-more"><?php echo $language['LOAD_MORE']; ?></a></div>
</div>
<div data-template="content-listing-empty" class="hidden">
</div>
<div data-template="content-listing-loading" class="hidden">
	<div class="content-listing-loading"></div>
</div>
<?php endif; ?>
<?php else:?>
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;"><?php echo $language['NOT_FOUND']; ?></div>
<?php endif; ?>
</div>

<?php endif; ?><?php $mabilis_ttl=1457782946; $mabilis_last_modified=1447766116; //d:\server\www\imghost.vit\templates\imghost\pages\gallery.tpl ?>