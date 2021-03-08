
<div id="edit_image" style="padding: 20px;">
<?php if($is_guest): ?>
	<form action="<?php echo site_url ('images_guest/edit'); ?>/<?php if(isset($id)){ echo $id; } ?>" method="post" onsubmit="update_image(this,<?php if(isset($id)){ echo $id; } ?>);return false;">
<?php else:?>
	<form action="<?php echo site_url ('images/edit'); ?>/<?php if(isset($id)){ echo $id; } ?>" method="post" onsubmit="update_image(this,<?php if(isset($id)){ echo $id; } ?>);return false;">
<?php endif; ?>
<input type="hidden" name="is_update" value="1"/>
<table width="100%" height="100%">
	<tr>
		<td rowspan="3" width="<?php if(isset($max_size)){ echo $max_size; } ?>" height="<?php if(isset($max_size)){ echo $max_size; } ?>" valign="middle" align="center">
			<span class="fade">
				<img src="<?php if(isset($src)){ echo $src; } ?>" width="<?php if(isset($width)){ echo $width; } ?>" height="<?php if(isset($height)){ echo $height; } ?>"/>		
			</span>
		</td>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col1');"><?php echo $language['RESIZE_TO']; ?></a>
						<div class="hcAreaModal col_1">
						<input type="hidden" class="proportion" value="<?php if(isset($proportion)){ echo $proportion; } ?>"/>
							<table>
								<tr>
									<td><label><?php echo $language['RESIZE_TO']; ?>:</label></td>
									<td></td>
								</tr>
								<tr>
									<td><label><?php echo $language['WIDTH']; ?></label></td>
									<td>
									<div class="input">
										<input class="edit" type="text" name="RESIZE_TO_WIDTH" value="<?php if(isset($full_width)){ echo $full_width; } ?>" size="5" onchange="constrain_proportions(this,'width');" id="resize_to_width"/>
									</div>
									</td>
								</tr>
								<tr>
									<td>
										<label><?php echo $language['HEIGHT']; ?></label></td>
										<td>
										<div class="input">
											<input class="edit" type="text" name="RESIZE_TO_HEIGHT" value="<?php if(isset($full_height)){ echo $full_height; } ?>" size="5" onchange="constrain_proportions(this,'height');" id="resize_to_height"/>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<label><?php echo $language['CONSTRAIN_PROPORTIONS']; ?></label></td>
										<td>
										<div class="input">
											<input class="edit" type="checkbox" id="constrain" checked=""/>
										</div>
									</td>
								</tr>
							</table>
							<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col1');">OK</a>
						</div>
						<input type="hidden" value="37" class="add_to_modal_width"/>
		</td>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'');"><?php echo $language['TURN']; ?></a>
			<a class="left90" href="#" title="<?php echo $language['LEFT90']; ?>"></a>
				<a class="right90" href="#" title="<?php echo $language['RIGHT90']; ?>"></a>
			<input type="hidden" name="ROTATE" value="0" id="rotate"/>
		</td>
	<td>
		<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');"><?php echo $language['TINY_URL']; ?></a>
			<div class="hcAreaModal col_3 maxwidth3">
				<div class="input">
				<div>
					<table cellpadding="0" cellspacing="0" >
						<tr>
							<td>tinyURL</td>
							<td><input type="checkbox" name="TINYURL" <?php if(isset($checked)): ?> checked="checked" <?php endif; ?> id="tiny_url"/></td>
							<td class="container_tiny_url"><a class="black-button hcCloseModal" href="#" style="margin-left: -6px;" onclick="hide_field(this,'col3');">OK</a></td>	
							<input type="hidden" id="hidden_tiny" value="<?php if(isset($checked)): ?>1<?php else:?>0<?php endif; ?>" />
						</tr>
					</table>
				</div>
				</div>
			</div>	
			<!--a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');"><?php echo $language['TINY_URL']; ?></a>
			<div class="hcAreaModal col_1">
				<table>
					<tr>
						<td><label>tinyURL</label>&nbsp;&nbsp;</td>
						<td><input class="edit" type="checkbox" name="TINYURL" <?php if(isset($checked)): ?> checked="checked" <?php endif; ?>/></td>
					</tr>
				</table>
					
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>
			</div-->

			<input type="hidden" value="90" class="add_to_modal_width"/>
		</td>
	</tr>
	<tr>
		<td>
				<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col1');"><?php echo $language['NAME']; ?></a>
				<div class="hcAreaModal col_1">
					<input class="edit" type="text" name="NAME" value="" size="16" id="name"/>
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col1');">OK</a>
			</div>
				<input type="hidden" value="32" class="add_to_modal_width"/>

		</td>
		<td>
				<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col2');"><?php echo $language['CONVERT']; ?></a>
				<div class="hcAreaModal col_2 max_width2">
				<select class="combobox" name="CONVERT_TO" id="convert_to">
					<option value=""></option>
					<option value="jpg">JPG</option>
					<option value="png">PNG</option>
					<option value="gif">GIF</option>
				</select>
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col2');">OK</a>

			</div>
				<input type="hidden" value="32" class="add_to_modal_width"/>

		</td>
		<td>
			<?php if(!$is_guest): ?>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');"><?php echo $language['ALBUM']; ?></a>
			<div class="hcAreaModal col_3 max_width3">
				<div class="input">
					<?php if(isset($albums)){ echo $albums; } ?>
				</div>
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>
			</div>
				<input type="hidden" value="90" class="add_to_modal_width"/>
			<?php else:?>	
				<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');"><?php echo $language['ACCESS']; ?></a>
			<div class="hcAreaModal col_3 max_width3">
				<div class="input">
					<?php if(isset($access)){ echo $access; } ?>
				</div>
				<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>

			</div>
			<input type="hidden" value="90" class="add_to_modal_width"/>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col1');"><?php echo $language['COMMENTS']; ?></a>
					<div class="hcAreaModal col_1 max_width1">
						<textarea class="memo" name="DESCRIPTION" cols="35" rows="2" id="description"></textarea>
						<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col1');">OK</a>
					</div>
			<input type="hidden" value="145" class="add_to_modal_width"/>

		</td>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col2');"><?php echo $language['WATERMARK']; ?></a>
			<div class="hcAreaModal col_2">
				<div class="input"><input class="edit" type="text" name="WATERMARK" value="" size="16" maxlength="16" id="watermark"/></div>
				<a class="black-button hcCloseModal" href="#">OK</a>
			</div>		
		</td>
		<td>
		
			<?php if(!$is_guest): ?>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');"><?php echo $language['TAGS']; ?></a>
				<div class="hcAreaModal col_3 max_width3">
					<!--input class="edit" type="text" name="PREVIEW_WIDTH" value="" size="5" placeholder="Ш" id="preview_width"/>
					<input class="edit" type="text" name="PREVIEW_HEIGHT" value="" size="5" placeholder="В" id="preview_height"/-->
					<div class="input">
								<?php if(isset($tags)){ echo $tags; } ?>
							</div>
								<div class="input">

							<?php if(!$children_tags): ?>
									<div class="field children_tags" style="display: none;">
							<?php else:?>
								<div class="field children_tags">
							<?php endif; ?>
									<?php if(isset($children_tags)){ echo $children_tags; } ?>
								</div>
							</div>
						<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>
			</div>
			<input type="hidden" value="90" class="add_to_modal_width"/>
			<?php endif; ?>
		</td>

	</tr>

</table>


			<div class="submit" style="text-align: right;margin-top: 5px;">
				<input class="black-button" type="submit" value="<?php echo $language['FINISH']; ?>"/>
			</div>
		<?php if(isset($current_album)): ?>
			<input type="hidden" id="current_album" value="<?php if(isset($current_album)){ echo $current_album; } ?>"/>
		<?php endif; ?>
			<input type="hidden" id="current_access" value="<?php if(isset($current_access)){ echo $current_access; } ?>"/>
<?php echo form_csrf (); ?>
</form>
</div>
<?php $mabilis_ttl=1455270506; $mabilis_last_modified=1424764290; //d:\server\www\imghost.vit\templates\imghost\widgets\image_edit.tpl ?>