<!--div class="show-links"><?php echo $language['UPLOAD_SUCCESS']; ?><a class="show-modal" href="#wndShowLinks"><?php echo $language['SHOW_LINKS']; ?></a></div-->
<div class="container_link" style="margin-bottom: 10px;">
<div class="more-options">
	<a class="jsAction" href="#" onclick="show_links(this);return false;" style="text-transform: lowercase;"><?php echo $language['SHOW_LINKS']; ?></a>
</div>
	<div id="wndShowLinks" class="modal-wnd inplace" style="padding: 10px;">
		<?php echo block_links ($file,$language,$tiny_static); ?>
		<!--div class="popup-links" style="background: white;">
			<ul style="list-style-type: none; ">
				<li>
					<em><?php echo $language['SHOW_LINK']; ?></em>
					<input class="edit autoselect" type="text" value="<?php if(isset($imglink_html)){ echo $imglink_html; } ?>" size="75" style="text-transform: lowercase;" readonly id="show_link" data-position="0"/>
				</li>
				<li>
					<em><?php echo $language['DIRECT_LINK']; ?></em>
					<input class="edit autoselect" type="text" value="<?php if(isset($imglink)){ echo $imglink; } ?>" size="75" style="text-transform: lowercase;" readonly id="direct_link"  data-position="0"/>
				</li>
				
				<li>
					<em><?php echo $language['PREVIEW_LINK_BB']; ?></em>
					
					<input class="edit autoselect" type="text" value="<?php if(isset($imglink_preview_bb)){ echo $imglink_preview_bb; } ?>" size="75" readonly id="preview_link_bb"  data-position="2"/><br>
					
				</li>
				<li>
					<em><?php echo $language['PREVIEW_LINK_HTML']; ?></em>
					<input class="edit autoselect" type="text" value="<?php if(isset($imglink_preview_html)){ echo $imglink_preview_html; } ?>" size="75" style="text-transform: lowercase;" readonly id="preview_link_html"/>
				</li>
				<li>
					<em><?php echo $language['BB_CODE_LINK']; ?></em>
					<input class="edit autoselect" type="text" value="[IMG]<?php if(isset($imglink)){ echo $imglink; } ?>[/IMG]" size="75" style="text-transform: lowercase;" readonly id="bb_code" data-position="2"/></li>
				
				<?php if(isset($tiny_url)): ?>
					<li>
						<em><?php echo $language['TINY_URL']; ?></em>
						<input class="edit autoselect" type="text" value="<?php if(isset($tiny_url)){ echo $tiny_url; } ?>" size="75" readonly id="tiny_url"  data-position="0"/>
					</li>
				<?php endif; ?>
				
			</ul>
			<a class="black-button" href="javascript:void(0);" onclick="nd();">Закрыть</a>
		</div-->
	</div>
</div><?php $mabilis_ttl=1541046309; $mabilis_last_modified=1453806526; //d:\server\www\archive\imghost.vit\templates\imghost\widgets\upload_fast_success.tpl ?>