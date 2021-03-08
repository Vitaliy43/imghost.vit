<script type="text/javascript">
		$(document).ready(function() {
			var height_image_container = $('.image_list').height();
			var height_image_table = $('.image_list table').height();
			if(height_image_table > 540)
				$('.image_list').css({'overflow-y' : 'scroll'});
			
		});					
	
</script>
<style type="text/css">
a.sorter {
	text-decoration: none;
	color:#000;
	white-space: nowrap;
}

a.sorter:hover {
	text-decoration: underline;
}

</style>
<?php if(isset($transit_parameters)){ echo $transit_parameters; } ?>
<?php if($is_guest): ?>
	<h1 align="center" style=";text-align: center; margin-top: -5px; margin-left: 25%; margin-bottom: 15px;"><?php echo $language['UPLOADED_IMAGES']; ?></h1>
	<div class="container_image_list" style="width: 900px;">
<?php else:?>
	<div class="container_image_list" style="width: 900px;">
	<div style="text-align: center;font-size: 20px;font-weight: bold;" class="header_image_list"><?php echo $language['UPLOADED_IMAGES']; ?></div>
	<?php if($transit_parameters): ?>
			<div style="text-align: center; margin-bottom: 10px;" id="block_search"><a href="/profile" onclick="reset_search_images(this);return false;">Сброс результатов поиска</a></div>
	<?php else:?>
		<div style="text-align: center; margin-bottom: 10px;" id="block_search"><a href="/profile" onclick="show_search_images(this);return false;"><?php echo $language['SEARCH_BY_IMAGES']; ?></a></div>
	<?php endif; ?>
<?php endif; ?>

<div id="container_modal" style="display: none;"></div>
<div class="image_list" >
<?php if(count($files) > 0): ?>
<table cellpadding="2" cellspacing="2" width="100%" height="100%" class="images_table">
<?php if(!$is_guest): ?>
<tr height="30">

	<td class="odd" width="100" align="center"><?php echo $language['PREVIEW']; ?></td>
	<td class="even" width="100"><a href="<?php if(isset($order_link)){ echo $order_link; } ?>?order=show_filename" class="sorter" title="<?php echo $language['ORDER_BY_FILENAME']; ?>" onclick="hash_change(this.href);return false;"><?php echo $language['FILENAME']; ?></a></td>
	<td class="odd" width="100" align="center"><?php echo $language['LINKS']; ?></td>
	<td class="even" width="100" align="center"><?php echo $language['TAG']; ?></td>
	<td class="odd" width="100" align="center"><?php echo $language['ALBUM']; ?></td>
	<td class="even" width="100"><?php echo $language['DESCRIPTION']; ?></td>
	<td class="odd" width="100"><a href="<?php if(isset($order_link)){ echo $order_link; } ?>?order=added" class="sorter" title="<?php echo $language['ORDER_BY_ADDED']; ?>" onclick="hash_change(this.href);return false;"><?php echo $language['DATA_UPLOADED']; ?></a></td>
	<td class="even" width="100"><a href="<?php if(isset($order_link)){ echo $order_link; } ?>?order=size" class="sorter" title="<?php echo $language['ORDER_BY_FILESIZE']; ?>" onclick="hash_change(this.href);return false;"><?php echo $language['FILESIZE']; ?></a></td>
	<td class="odd" width="50"><?php echo $language['FILETYPE']; ?></td>
	<td class="even" width="50"><?php echo $lang_upload['ACCESS']; ?></td>
	<td class="odd" width="100" align="center"><?php echo $lang_main['ACTIONS']; ?></td>
</tr>
<?php else:?>	

	<td class="odd" width="100" align="center"><?php echo $language['PREVIEW']; ?></td>
	<td class="even" width="100"><a href="<?php if(isset($order_link)){ echo $order_link; } ?>?order=show_filename" class="sorter" title="<?php echo $language['ORDER_BY_FILENAME']; ?>" onclick="hash_change(this.href);return false;"><?php echo $language['FILENAME']; ?></a></td>
	<td class="odd" width="100" align="center"><?php echo $language['LINKS']; ?></td>
	<td class="even" width="100" align="center"><?php echo $language['TAG']; ?></td>
	<td class="odd" width="100"><?php echo $language['DESCRIPTION']; ?></td>
	<td class="even" width="100"><a href="<?php if(isset($order_link)){ echo $order_link; } ?>?order=added" class="sorter" title="<?php echo $language['ORDER_BY_ADDED']; ?>" onclick="hash_change(this.href);return false;"><?php echo $language['DATA_UPLOADED']; ?></a></td>
	<td class="odd" width="100"><a href="<?php if(isset($order_link)){ echo $order_link; } ?>?order=size" class="sorter" title="<?php echo $language['ORDER_BY_FILESIZE']; ?>" onclick="hash_change(this.href);return false;"><?php echo $language['FILESIZE']; ?></a></td>
	<td class="even" width="50"><?php echo $language['FILETYPE']; ?></td>
	<td class="odd" width="50"><?php echo $lang_upload['ACCESS']; ?></td>
	<td class="even" width="100" align="center"><?php echo $lang_main['ACTIONS']; ?></td>

<?php endif; ?>
<?php $counter = 0?>
<?php if(is_true_array($files)){ foreach ($files as $file){ ?>

	
	<tr id="row_<?php echo $file['id']; ?>" class="image_row">
		<?php if(!$is_guest): ?>
		<td class="odd" width="100" align="center" valign="middle">
			<a href="<?php echo $file['url']; ?>" class="file_preview" rel="shadowbox[mygallery]"><?php echo $file['preview']; ?></a>
		</td>
		<td class="even file_name">
			<a href="<?php echo $file['main_url']; ?>" class="image-container-profile" onclick="open_main_url(this);return false;" data-position="<?php if(isset($counter)){ echo $counter; } ?>"><?php echo splitterWord ( $file['show_filename'] ,30); ?></a>
			<!--a href="<?php echo $file['main_url']; ?>" class="image-container-profile" target="_blank"><?php echo splitterWord ( $file['show_filename'] ,30); ?></a-->
		</td>
		<td class="odd" width="100" align="center">
		
			<div class="more-options">
				<a class="jsAction" href="#" onclick="show_links_profile(this);return false;" style="text-transform: lowercase;text-decoration: none;color: #000; border-bottom: 1px dashed #000;" title="<?php echo $lang_upload['SHOW_LINKS']; ?>"><?php echo $language['LINKS']; ?></a>
			</div>
			<div class="modal-wnd inplace" style="display: none;">	
				<?php echo block_links ($file,$lang_upload, $user['tiny_static'] ); ?>		
			
		</div>
		</td>
		
		<td class="even tag_name" align="center">
			<?php if($file['tag_name']): ?>
				<a href="<?php echo site_url ('gallery/tags'); ?>/<?php echo $file['tag_id']; ?>" target="_blank"><?php echo splitterWord ( $file['tag_name'] ,25); ?></a>
			<?php endif; ?>
		</td>
		<td class="odd album_name" align="center">
			<?php if($file['album_name']  &&  $file['type']  == 'user'): ?>
				<a href="<?php echo site_url ('albums'); ?>/<?php echo $file['album_id']; ?>" target="_blank"><?php echo splitterWord ( $file['album_name'] ,25); ?></a>
			<?php elseif ( $file['album_name']  &&  $file['type']  == 'guest'  ): ?>
				<a href="<?php echo site_url ('torrents'); ?>/<?php echo $file['album_id']; ?>" target="_blank"><?php echo splitterWord ( $file['album_name'] ,25); ?></a>
			<?php endif; ?>
		</td>
		<td class="even file_comment" width="100">
			<?php echo $file['comment']; ?>
		</td>
		<td class="odd" width="100">
			<?php echo extract_date ( $file['added'] ); ?>
		</td>
		<td class="even file_size" width="100" style="padding: 3px;">

			<table>
				<tr>
					<td nowrap=""><?php echo formatFileSize ( $file['size'] ); ?></td>
				</tr>
				<tr>
					<td style="padding-top:3px;" nowrap=""><?php echo $file['width']; ?> x <?php echo $file['height']; ?></td>
				</tr>
			</table>
		</td>
		<td class="odd file_ext" width="50">
			<?php echo $file['ext']; ?>
		</td>
		<td class="even	file_access" width="50" align="center">
			<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/access_<?php echo $file['access']; ?>.png" width="15" height="15" title="<?php echo $file['access_text']; ?>"/>
		</td>
		
		
		<td class="odd" align="center" width="50">
			<table>
				<tr>
					<td>
					<?php if(isset( $file['type'] ) &&  $file['type']  == 'guest'): ?>
						<a href="<?php echo site_url ('images_guest/edit'); ?>/<?php echo $file['id']; ?>" title="<?php echo $lang_main['EDIT']; ?>" onclick="edit_image(this,<?php echo $file['id']; ?>);return false;" id="edit_<?php echo $file['id']; ?>">
<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/icon_edit.png" width="15" height="15"/></a>
					<?php else:?>
						<a href="<?php echo site_url ('images/edit'); ?>/<?php echo $file['id']; ?>" title="<?php echo $lang_main['EDIT']; ?>" onclick="edit_image(this,<?php echo $file['id']; ?>);return false;" id="edit_<?php echo $file['id']; ?>">
<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/icon_edit.png" width="15" height="15"/></a>
					<?php endif; ?>
					</td>
					<td>
					<?php if(isset( $file['type'] ) &&  $file['type']  == 'guest'): ?>
						<a href="<?php echo site_url ('images_guest/delete'); ?>/<?php echo $file['id']; ?>" title="<?php echo $lang_main['DELETE']; ?>" onclick="delete_image(this,<?php echo $file['id']; ?>,'<?php if(isset($message_confirm_delete)){ echo $message_confirm_delete; } ?>');return false;" id="delete_<?php echo $file['id']; ?>" style="margin-left: 5px;">
<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/icon_delete.png" width="15" height="15"/></a>
					<?php else:?>
						<a href="<?php echo site_url ('images/delete'); ?>/<?php echo $file['id']; ?>" title="<?php echo $lang_main['DELETE']; ?>" onclick="delete_image(this,<?php echo $file['id']; ?>,'<?php if(isset($message_confirm_delete)){ echo $message_confirm_delete; } ?>');return false;" id="delete_<?php echo $file['id']; ?>" style="margin-left: 5px;">
<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/icon_delete.png" width="15" height="15"/></a>
					<?php endif; ?>
					</td>
				</tr>
			</table>
			
				
				<input type="hidden" class="preview_width" value="<?php echo $file['preview_width']; ?>"/>
				<input type="hidden" class="preview_height" value="<?php echo $file['preview_height']; ?>"/>
		</td>
		
		<?php else:?>
		
			<td class="odd" width="100" align="center" valign="middle">
				<a href="<?php echo $file['url']; ?>" class="file_preview" rel="shadowbox[mygallery]"><?php echo $file['preview']; ?></a>
			</td>
		
		<td class="even file_name">
			<!--a href="<?php echo $file['main_url']; ?>" class="image-container-profile" onclick="open_main_url(this);return false;"><?php echo splitterWord ( $file['show_filename'] ,30); ?></a-->
			<a href="<?php echo $file['main_url']; ?>" class="image-container-profile" target="_blank"><?php echo splitterWord ( $file['show_filename'] ,30); ?></a>
		</td>
		<td class="odd	file_access" width="100" align="center">
		
			<div class="more-options">
				<a class="jsAction" href="#" onclick="show_links_profile(this);return false;" style="text-transform: lowercase;text-decoration: none;" title="<?php echo $lang_upload['SHOW_LINKS']; ?>"><?php echo $language['LINKS']; ?></a>
			</div>
			<div class="modal-wnd inplace" style="display: none;">	
			<?php echo block_links ($file,$lang_upload); ?>	
			
		</div>
		</td>
		
		<td class="even tag_name" align="center">
			<?php if($file['tag_name']): ?>
				<a href="<?php echo site_url ('gallery/tags'); ?>/<?php echo $file['tag_id']; ?>" target="_blank"><?php echo splitterWord ( $file['tag_name'] ,25); ?></a>
			<?php endif; ?>
		</td>
		
		<td class="odd file_comment" width="100">
			<?php echo $file['comment']; ?>
		</td>
		<td class="even" width="100">
			<?php echo extract_date ( $file['added'] ); ?>
		</td>
		<td class="even file_size" width="100" style="padding: 3px;">

			<table>
				<tr>
					<td><?php echo formatFileSize ( $file['size'] ); ?></td>
				</tr>
				<tr>
					<td style="padding-top:3px;"><?php echo $file['width']; ?> x <?php echo $file['height']; ?></td>
				</tr>
			</table>
		</td>
		<td class="even file_ext" width="50">
			<?php echo $file['ext']; ?>
		</td>
		<td class="odd	file_access" width="50" align="center">
			<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/access_<?php echo $file['access']; ?>.png" width="15" height="15" title="<?php echo $file['access_text']; ?>"/>
		</td>
		
		<td class="even" align="center" width="50">
				<table>
					<tr>
						<td>
							<a href="<?php echo site_url ('images_guest/edit'); ?>/<?php echo  $file['id']  ?>" title="<?php $lang_main['EDIT']; ?>" onclick="edit_image(this,'<?php echo $file['id']; ?>');return false;" id="edit_<?php echo $file['id']; ?>">
<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/icon_edit.png" width="15" height="15"/></a>
						</td>
						<td>
							<a href="<?php echo site_url ('images_guest/delete'); ?>/<?php echo  $file['id']  ?>" title="<?php $lang_main['DELETE']; ?>" onclick="delete_image(this,'<?php echo $file['id']; ?>','<?php if(isset($message_confirm_delete)){ echo $message_confirm_delete; } ?>');return false;" id="delete_<?php echo $file['id']; ?>" style="margin-left: 5px;">
<img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/icon_delete.png" width="15" height="15"/>
				</a>
						</td>
					</tr>
				</table>
				
				
				<input type="hidden" class="preview_width" value="<?php echo $file['preview_width']; ?>"/>
				<input type="hidden" class="preview_height" value="<?php echo $file['preview_height']; ?>"/>

		</td>
		
		<?php endif; ?>
		
	</tr>
<?php $counter ++?>
<?php }} ?>
</table>
<?php else:?>

	<div style="text-align: center;font-size: 16px;font-weight: bold;"><?php echo $language['NO_PICTURES']; ?></div>
<?php endif; ?>
</div>
</div>
<div class="pagination" style="color: black !important;">
	<?php if(isset($paginator)){ echo $paginator; } ?>
</div><?php $mabilis_ttl=1541049069; $mabilis_last_modified=1455178521; //d:\server\www\archive\imghost.vit\templates\imghost\widgets\image_list.tpl ?>