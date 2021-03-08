
<?php if(!$from_resort): ?>
<div id="sync_info" style="text-align: center;display: none;">
	<?php echo $lang_upload['SYNC_INFO']; ?>
</div>
<div class="panel_iframe" style="width: <?php if(isset($width)){ echo $width; } ?>;height: <?php if(isset($height)){ echo $height; } ?>;">
<?php if(count($files) > 0): ?>
<?php $counter = 0?>
<?php if($display == 'block'): ?>
<table cellpadding="10" cellspacing="10" width="90%">
<?php if(is_true_array($files)){ foreach ($files as $file){ ?>
	<?php if($counter == 0): ?><tr><?php endif; ?>
	<td align="center" valign="top">
	<table cellpadding="0" cellspacing="0" class="container_item">
	<tr>
			<td valign="top" align="center">
			<table>
				<tr>
					<td>
						<div style="text-align: center;margin-bottom:5px;" id="link_<?php echo $file['id']; ?>">
						<?php if($delete_without_confirm): ?>
						<a href="<?php echo site_url ('images_guest/delete'); ?>/<?php echo $file['id']; ?>?token=<?php if(isset($token)){ echo $token; } ?>&torrent_id=<?php echo $file['torrent_id']; ?>" onclick="delete_image_from_seedoff_without_confirm(this,<?php echo $file['id']; ?>);return false;" title="<?php echo $language['DELETE_IMAGE']; ?>">
						<?php else:?>
							<a href="<?php echo site_url ('images_guest/delete'); ?>/<?php echo $file['id']; ?>?token=<?php if(isset($token)){ echo $token; } ?>&torrent_id=<?php echo $file['torrent_id']; ?>" onclick="delete_image_from_seedoff_edit(this,<?php echo $file['id']; ?>,'<?php echo $lang_images['CONFIRM_DELETE']; ?>');return false;" title="<?php echo $language['DELETE_IMAGE']; ?>">
					<?php endif; ?>
						<img src="/templates/administrator/images/icon_delete.png" width="15" height="15" />
					</a>
				</div>
					</td>
					
					
				</tr>
			</table>	
			
			</td>
		</tr>
		<tr>
			<td height="150" valign="top">
				<div class="file_item_edit" data-id="<?php echo $file['id']; ?>">
				<div>
					<a rel="shadowbox[mygallery]" href="<?php echo $file['url']; ?>" title="<?php echo $file['show_filename']; ?>" class="shadowbox" >
			<!--img src="<?php echo $file['thumbnail_80']; ?>" /-->
					<img src="<?php echo $file['thumbnail']; ?>" width="150px;"/>
					</a>
			</div>	
			</div>
			</td>
		
		</tr>
	</table>
	
	</td>
	<?php $counter ++?>
	<?php if($counter > $cols): ?>
	</tr>
	<?php $counter = 0?>
	<?php endif; ?>
<?php }} ?>
</table>
<?php else:?>
<table cellpadding="5" cellspacing="5" width="100%" id="torrent_files" border="1">
<?php $counter = 1?>
<?php if(is_true_array($files)){ foreach ($files as $file){ ?>
<tr id="element_<?php echo $file['id']; ?>" style="cursor: move;" title="<?php echo $lang_image['CLICK_FOR_DRAG']; ?>">
	<td align="center" width="50"><?php if(isset($counter)){ echo $counter; } ?></td>
	<td class="odd" width="100" align="center" valign="middle">
		<!--a href="<?php echo $file['url']; ?>" class="shadowbox" rel="shadowbox[mygallery]"><?php echo $file['preview']; ?></a-->
		<a href="<?php echo $file['url']; ?>" class="shadowbox" rel="shadowbox[mygallery]" title="<?php echo $lang_image['TITLE_BIG']; ?>"><img src="<?php echo $file['thumbnail_80']; ?>"/>
</a>
	</td>
	<td width="50%">
		<a href="<?php echo $file['main_url']; ?>" target="_blank" style="font-size: 15px;"><?php echo $file['show_filename']; ?> - <?php echo $lang_image['SCREEN']; ?> <?php if(isset($counter)){ echo $counter; } ?></a>
	</td>
	<td align="center" width="50">
		<table>
			<tr>
				
				<td align="center">
					<a href="<?php echo site_url ('images_guest/delete'); ?>/<?php echo $file['id']; ?>" title="<?php echo $lang_main['DELETE']; ?>" onclick="delete_image(this,'<?php echo $file['id']; ?>','<?php echo $lang_images['CONFIRM_DELETE']; ?>');return false;" id="delete_<?php echo $file['id']; ?>" style="margin-left: 5px;">
<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
					</a>
				</td>
					</tr>
				</table>
	</td>
</tr>
<?php $counter++?>
<?php }} ?>


</table>
<?php endif; ?>
<?php endif; ?>
</div>
<?php else:?>
<table cellpadding="10" cellspacing="10" width="100%" id="torrent_files" border="1">
<?php $counter = 1?>
<?php if(is_true_array($files)){ foreach ($files as $file){ ?>
<tr id="element_<?php echo $file['id']; ?>" style="cursor: move;" title="<?php echo $lang_image['CLICK_FOR_DRAG']; ?>">
	<td align="center" width="50"><?php if(isset($counter)){ echo $counter; } ?></td>
	<td class="odd" width="100" align="center" valign="middle">
		<!--a href="<?php echo $file['url']; ?>" class="shadowbox" rel="shadowbox[mygallery]"><?php echo $file['preview']; ?></a-->
		<a href="<?php echo $file['url']; ?>" class="shadowbox" rel="shadowbox[mygallery]"><img src="<?php echo $file['thumbnail_80']; ?>"/></a>
	</td>
	<td width="50%">
		<a href="<?php echo $file['main_url']; ?>" target="_blank" style="font-size: 15px;"><?php echo $file['show_filename']; ?> - <?php echo $lang_image['SCREEN']; ?> <?php if(isset($counter)){ echo $counter; } ?></a>
	</td>
	<td align="center" width="50">
		<table>
			<tr>
				<td align="center">
					<a href="<?php echo site_url ('images_guest/delete'); ?>/<?php echo $file['id']; ?>" title="<?php echo $lang_main['DELETE']; ?>" onclick="delete_image(this,'<?php echo $file['id']; ?>','<?php echo $lang_images['CONFIRM_DELETE']; ?>');return false;" id="delete_<?php echo $file['id']; ?>" style="margin-left: 5px;">
<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
					</a>
				</td>
					</tr>
				</table>
	</td>
</tr>
<?php $counter++?>
<?php }} ?>
</table>

<?php endif; ?><?php $mabilis_ttl=1473324731; $mabilis_last_modified=1451036238; //d:\server\www\imghost.vit\templates\imghost\widgets\torrent_files.tpl ?>