
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

<div id="container_gallery">
<div id="header_gallery" style="text-align: center;margin-top: -60px;">
	<h1><?php echo $language['ALBUM']; ?></h1>
</div>
<input type="hidden" id="album_id" value="<?php if(isset($album_id)){ echo $album_id; } ?>"/>
<?php if(isset($album_info)){ echo $album_info; } ?>

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
		<!--a href="<?php echo $image['main_url']; ?>" class="image-container" onclick="show_main_url_album(this);return false;" style="width: 100%;height: 100%;" -->
		<a href="<?php echo $image['related_url']; ?>" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;" >
		<!--a href="<?php echo $image['main_url']; ?>" class="image-container"-->
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['show_filename']; ?>" style="width:100%;position: absolute;z-index: 3;"/>
		</a>
	<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%;;text-align: left;margin-bottom: 15%;">
		<a href="<?php echo $image['url']; ?>" rel="shadowbox[mygallery]">
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

		<div class="list-item-desc">
				
				<?php if($is_owner): ?>
				<div>
				<span><?php echo splitterWord ( $image['show_filename'] , 20); ?></span>
				<span style="margin-left: 5px;">
				<a href="<?php echo site_url ('images/delete'); ?>/<?php echo $image['id']; ?>" onclick="delete_image_from_album_gallery(this,<?php echo $image['id']; ?>,<?php if(isset($album_id)){ echo $album_id; } ?>,'<?php if(isset($type)){ echo $type; } ?>','<?php echo $lang_images['CONFIRM_DELETE']; ?>');return false;" title="<?php echo $lang_main['DELETE_IMAGE']; ?>">
				<img src="/templates/administrator/images/icon_delete.png" width="12" height="12" style="margin-top:3px"/>
				</a>
			</span>
			</div>
			<?php endif; ?>
			<?php if(mb_strlen( $image['comment'] ) > 0): ?>
				<div><?php echo $image['comment']; ?></div>
			<?php else:?>
				<div><?php echo $language['NO_COMMENTS']; ?></div>
			<?php endif; ?>
				<div><?php echo $language['ADDED']; ?> <?php echo $image['added']; ?></div>
		</div>
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
	<div style="min-height: 500px;padding-left: 15px;font-size: 18px;"><?php echo $language['NOT_FOUND_ALBUM']; ?></div>
<?php endif; ?>
</div>
</div><?php $mabilis_ttl=1454149488; $mabilis_last_modified=1441968073; //d:\server\www\imghost.vit\templates\imghost\pages\album.tpl ?>