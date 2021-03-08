<?php for($i = 1; $i <= $fields_count; $i++):?>
<div class="item">
	<form class="ajaxForm uploadForm" action="/upload/fast" method="post" id="form<?php if(isset($i)){ echo $i; } ?>">
		<input type="hidden" name="current_form" value="<?php if(isset($i)){ echo $i; } ?>" id="current_form"/>
		<input type="hidden" class="is_uploaded" value="0"/>
		<input type="hidden" class="is_progress" value="0"/>
		<input type="hidden" class="blob" name="BLOB"/>
		<input type="hidden" class="proportion" value=""/>
		<div class="choose-source">
			<div class="black-button source-local file-wrap">
				<span><?php echo $language['UPLOAD_FROM_COMPUTER']; ?></span>
				<input class="upload-fields-switcher" type="file" size="1" name="UPLOADED_FILE" id="UPLOADED_FILE"/>
				<input type="hidden" name="<?php if(isset($upload_progress)){ echo $upload_progress; } ?>" value="fast"/>
			</div>
			<a class="black-button source-remote" href="#"><?php echo $language['UPLOAD_FROM_INTERNET']; ?></a>
		</div>
		<fieldset class="source-remote-url hidden">
			<div class="field wide">
				<div class="input"><textarea class="memo" name="FILE_URL" cols="37" rows="2" placeholder="<?php echo $language['LINK_TO_FILE']; ?>"></textarea></div>
			</div>
		</fieldset>
		<div class="source-local-fields hidden" style="overflow: hidden;">
			<div class="filename">
				<table>
					<tr>
						<td class="cell" valign="top"></td>
						<td class="cimage" valign="top"></td>
					</tr>
				</table>
			</div>
			<fieldset style="border: 1px solid #000; padding: 5px;margin-bottom: 10px;">
				<legend style="margin-top: 5px;"><?php echo $language['PREVIEW']; ?></legend>
				<label>
					<span style="margin-right: 15px;"><?php echo $language['PREVIEW_LEGEND']; ?></span>
					<select name="TEXT_ON_PREVIEW" id="text_on_preview" onchange="show_text_preview(this);">
						<option value="none"><?php echo $language['NO_TEXT']; ?></option>
						<option value="image_size"><?php echo $language['IMAGE_SIZE']; ?></option>
						<option value="voluntary_text"><?php echo $language['VOLUNTARY_TEXT']; ?></option>
					</select>
				</label>
				
				<label style="display: none;margin-top:5px;">
					<span style="margin-right: 35px;">Текст</span>
					<input type="text" name="VOLUNTARY_TEXT_PREVIEW" id="voluntary_text_preview"/>
				</label>
				
				<label style="margin-top:5px;">
					<span><?php echo $language['PREVIEW_SIZE']; ?></span>
					<input name="PREVIEW_SIZE" id="preview_size" value="<?php if(isset($preview_size)){ echo $preview_size; } ?>" type="text" size="3" onchange="validate_preview_size(this);"/>&nbsp;px
				</label>
			</fieldset>
			
			<input type="hidden" name="ACTION" value="upload_file" />
			<fieldset style="border: 1px solid #000; padding: 5px;margin-bottom: 10px;">
				<legend style="margin-top: 5px;"><?php echo $language['IMAGE']; ?></legend>

			<?php if($iframe == 0): ?>
			<fieldset >
			
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
				<div class="field">
					<label style="text-transform: lowercase;"><?php echo $lang_albums['ACCESS_LEVEL']; ?>:</label>
					<div class="input">
						<select class="combobox" name="ACCESS" style="width: 110px;">
							<option value="public"><?php echo $lang_albums['ALBUM_PUBLIC']; ?></option>
							<option value="private"><?php echo $lang_albums['ALBUM_PRIVATE']; ?></option>
						</select>
					</div>
				
				</div>
				<div class="field">
					<label><?php echo $language['NAME']; ?>:</label>
					<div class="input"><input class="edit" type="text" name="NAME" value="" style="width: 105px;" /></div>
				</div>
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
			</fieldset>
			<div class="more-options"><a class="doToggle" href="#" data-block=".more-options-block"><?php echo $language['ADDITIONAL_OPTIONS']; ?></a></div>
			<fieldset class="more-options-block hidden">
				<div class="field">
					<label><?php echo $language['WATERMARK']; ?>:</label>
					<div class="input"><input class="edit" type="text" name="WATERMARK" value="" size="16" maxlength="16"/></div>
				</div>
				<div class="field wide">
					<label><?php echo $language['COMMENTS']; ?>:</label>
					<div class="input"><textarea class="memo" name="DESCRIPTION" cols="35" rows="2" maxlength="250"></textarea></div>
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
					<label for="jpeg_quality"><?php echo $language['JPEG_QUALITY']; ?>:</label>
					<div class="input">
						<?php if(isset($compression_jpeg_box)){ echo $compression_jpeg_box; } ?> %
					</div>
				</div>
				<!--div class="field">
					<label for="png_quality"><?php echo $language['PNG_QUALITY']; ?>:</label>
					<div class="input">
						<?php if(isset($compression_png_box)){ echo $compression_png_box; } ?>
					</div>
				</div>
				<?php endif; ?>
				<!--div class="field">
					<label><?php echo $language['PREVIEW']; ?>:</label>
					<div class="input">
						<input class="edit" type="text" name="PREVIEW_WIDTH" value="" size="5" placeholder="Ш" />
						<input class="edit" type="text" name="PREVIEW_HEIGHT" value="" size="5" placeholder="В" />
					</div>
				</div-->
				
				<?php if(!$is_guest): ?>
				<div class="field">
					<label><?php echo $language['DOWNLOAD_TO_ALBUM']; ?>:</label>&nbsp;
					<label><?php if(isset($albums)){ echo $albums; } ?></label>
					<!--div class="input">
						<?php if(isset($albums)){ echo $albums; } ?>
					</div-->
				</div>
				<?php endif; ?>
			</fieldset>
			<?php endif; ?>
			</fieldset>
			<div class="submit" style="display: none;">
				<input class="black-button" type="submit" value="<?php echo $language['EDIT']; ?>" style="font-size: 11px;" id="edit_file"/>
			</div>
		</div>
		<?php echo form_csrf (); ?>
	</form>
</div>
<?php endfor;?>
<?php $mabilis_ttl=1545381219; $mabilis_last_modified=1445617122; //d:\server\www\archive\imghost.vit\templates\imghost\widgets\upload_fast_form.tpl ?>