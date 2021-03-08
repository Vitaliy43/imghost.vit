<?php $counter = 0?>
<?php if(is_true_array($images)){ foreach ($images as $image){ ?>
	<div class="list-item c7 gutter-margin-right-bottom privacy-public curpage_<?php if(isset($cur_page)){ echo $cur_page; } ?>" id="<?php echo $image['data_id']; ?>" data-type="image" data-page="<?php if(isset($cur_page)){ echo $cur_page; } ?>" data-number="<?php if(isset($counter)){ echo $counter; } ?>">
	<div class="list-item-image" style="position: relative;" onmouseover="show_magnify(this);" onmouseout="hide_magnify(this);">
		<!--a href="<?php echo $image['main_url']; ?>" class="image-container" onclick="show_main_url(this);return false;" style="width: 100%;height: 100%;"-->
		<a href="<?php echo $image['relative_url']; ?>" class="image-container" onclick="open_main_url(this);return false;" style="width: 100%;height: 100%;">
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['show_filename']; ?>" style="width:100%;position: absolute;z-index: 3;" title="<?php echo $image['show_filename']; ?>"/>
		</a>
		<div class="list-item-privacy" style="display: none;z-index: 4;position: absolute;margin-left: 5%; margin-top: 45%;width: 85%; height: 20%; text-align: left;margin-bottom: 15%;">
		<a href="<?php echo $image['url']; ?>" rel="shadowbox[mygallery]" class="shadowbox">
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
			<div class="list-item-desc" style="padding-bottom: 30px;">
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
<?php endif; ?><?php $mabilis_ttl=1545381236; $mabilis_last_modified=1447767557; //d:\server\www\archive\imghost.vit\templates\imghost\widgets\gallery_load_more.tpl ?>