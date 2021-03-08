<div class="item_cover">
	<?php if($type == 'edit'): ?>
		<form class="ajaxForm uploadForm" action="<?php echo site_url ('images_guest/edit'); ?>/<?php if(isset($image_id)){ echo $image_id; } ?>?token=<?php if(isset($token)){ echo $token; } ?>&torrent_id=<?php if(isset($torrent_id)){ echo $torrent_id; } ?>&cover=1&image_size=<?php if(isset($image_size)){ echo $image_size; } ?>" method="post" id="form1">
	<?php else:?>
		<form class="ajaxForm uploadForm" action="<?php echo site_url ('upload/fast'); ?>?token=<?php if(isset($token)){ echo $token; } ?>&torrent_id=<?php if(isset($torrent_id)){ echo $torrent_id; } ?>&cover=1&image_size=<?php if(isset($image_size)){ echo $image_size; } ?>" method="post" id="form1">
	<?php endif; ?>
		<input type="hidden" name="current_form" value="1" id="current_form"/>
		<input type="hidden" class="is_uploaded" value="0"/>
		<input type="hidden" class="is_progress" value="0"/>
		<input type="hidden" class="proportion" value=""/>
		<input type="hidden" id="current_url" value="" />
		<input type="hidden" value="1" name="is_update"/>
		<div class="choose-source" style="margin-bottom: 15px; <?php if($type == 'edit'): ?> display:none; <?php endif; ?>" >
			<div class="black-button source-local file-wrap">
				<span><?php echo $language['UPLOAD_FROM_COMPUTER']; ?></span>
				<input class="upload-fields-switcher" type="file" size="1" name="UPLOADED_FILE" id="UPLOADED_FILE"/>
				<input type="hidden" name="<?php if(isset($upload_progress)){ echo $upload_progress; } ?>" value="fast"/>
			</div>
			<a class="black-button source-remote" href="#"><?php echo $language['UPLOAD_FROM_INTERNET']; ?></a>
		</div>
		<div id="sync_info" style="text-align: center;display: none;">
				<?php echo $language['SYNC_INFO']; ?>
		</div>
		<fieldset class="source-remote-url hidden">
			<div class="field wide">
				<div class="input"><textarea class="memo" name="FILE_URL" cols="37" rows="2" placeholder="<?php echo $language['LINK_TO_FILE']; ?>"></textarea></div>
			</div>
		</fieldset>
		<div class="source-local-fields" style="overflow: hidden;">
			<div class="filename">
				<table>
					<tr>
						<td class="cell" valign="top">
							<?php if($type == 'edit'): ?>
								<a onclick="show_image(this);return false;" href="<?php if(isset($imglink)){ echo $imglink; } ?>"><img width="<?php if(isset($preview_width)){ echo $preview_width; } ?>" height="<?php if(isset($preview_height)){ echo $preview_height; } ?>" src="<?php if(isset($imglink_preview)){ echo $imglink_preview; } ?>"></a>
							<?php endif; ?>
						</td>
						<td class="cimage" valign="top">
						<?php if($type == 'edit'): ?>
							<a onclick="delete_cover_from_seedoff_edit(this,'Вы уверены, что хотите удалить данный файл?');return false;" href="<?php if(isset($delete_link)){ echo $delete_link; } ?>" style="margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" title="Удалить изображение"/></a>
						<?php endif; ?>
						</td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="ACTION" value="upload_file" />
			<?php if($iframe == 0): ?>
			<fieldset >
				<div class="resize" style="display: none;">
				<div class="field">
					<label><?php echo $language['RESIZE_TO']; ?>:</label>
				</div>
				
				<div class="field">
					<label><?php echo $language['WIDTH']; ?></label>
					<div class="input">
						<input class="edit" type="text" name="RESIZE_TO_WIDTH" value="0" size="5" onchange="constrain_proportions(this,'width');"/>
					</div>
				</div>
				<div class="field" style="margin-bottom: 20px;">
					<label><?php echo $language['HEIGHT']; ?></label>
					<div class="input">
						<input class="edit" type="text" name="RESIZE_TO_HEIGHT" value="0" size="5" onchange="constrain_proportions(this,'height');"/>
					</div>
				</div>
				
				<div class="field container_constrain">
					<label><?php echo $language['CONSTRAIN_PROPORTIONS']; ?></label>
					<div class="input">
						<input class="edit" type="checkbox" id="constrain" checked=""/>
					</div>
				</div>
				</div>
				<div class="field">
					<label><?php echo $language['TURN']; ?>:</label>
					<div class="input">
						<select class="combobox" name="ROTATE" onchange="free_rotate(this);">
							<option value="0">0</option>
							<option value="90">90°</option>
							<option value="180">180°</option>
							<option value="270">270°</option>
							<option value="free"><?php echo $language['FREE_ROTATE']; ?></option>
						</select>
						<div class="free_rotate" style="display: none;margin-top:5px;">
							<input type="text" name="FREE_ROTATE" onchange="set_rotate(this);" size="3"/>
						</div>
					</div>
				</div>

			</fieldset>
			<fieldset class="more-options-block">
				<div class="field">
					<label><?php echo $language['WATERMARK']; ?>:</label>
					<div class="input"><input class="edit" type="text" name="WATERMARK" value="" size="16" maxlength="16"/></div>
				</div>
				
				<div class="field">
					<label style="text-transform: lowercase;"><?php echo $language['SELECT_TAG']; ?>:</label>
					<div class="input">
						<?php if(isset($tags)){ echo $tags; } ?>
					</div>
				</div>
				<div class="field children_tags" style="display: none;">
					<div class="input">
					</div>
				</div>
				<div class="field">
					<label><?php echo $language['TO_CONVERT']; ?>:</label>
					<div class="input">
						<select class="combobox" name="CONVERT_TO">
							<option value=""></option>
							<option value="jpg">JPG</option>
							<option value="png">PNG</option>
							<option value="gif">GIF</option>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="tinyurl"><?php echo $language['TINYURL']; ?>:</label>
					<div class="input"><input id="tinyurl" type="checkbox" name="TINYURL" value="Y" /></div>
				</div>
				<?php if($enable_compression): ?>
				<div class="field">
					<label for="tinyurl"><?php echo $language['JPEG_QUALITY']; ?>:</label>
					<div class="input">
						<?php if(isset($compression_jpeg_box)){ echo $compression_jpeg_box; } ?> %
					</div>
				</div>
				<?php endif; ?>
				<div class="field">
					<label><?php echo $language['PREVIEW']; ?>:</label>
					<div class="input">
						<input class="edit" type="text" name="PREVIEW_WIDTH" value="" size="5" placeholder="Ш" />
						<input class="edit" type="text" name="PREVIEW_HEIGHT" value="" size="5" placeholder="В" />
					</div>
				</div>
				
				<?php if(!$is_guest): ?>
				<div class="field">
					<label><?php echo $language['DOWNLOAD_TO_ALBUM']; ?>:</label>
					<div class="input">
						<?php if(isset($albums)){ echo $albums; } ?>
					</div>
				</div>
				<?php endif; ?>
			</fieldset>
			<?php endif; ?>
			<?php if($type == 'edit'): ?>
				<div class="submit" style="margin-top: 15px;">
					<input class="black-button" type="submit" value="<?php echo $language['EDIT']; ?>" id="form_action"/>
				</div>
			<?php else:?>
				<div class="submit" style="margin-top: 15px;">
					<input class="black-button" type="submit" value="<?php echo $language['UPLOAD']; ?>" id="form_action"/>
				</div>
			<?php endif; ?>
		</div>
		
		<?php echo form_csrf (); ?>
	</form>
</div>

<?php $mabilis_ttl=1458056964; $mabilis_last_modified=1451036082; //d:\server\www\imghost.vit\templates\imghost\widgets\edit_fast_form_seedoff.tpl ?>