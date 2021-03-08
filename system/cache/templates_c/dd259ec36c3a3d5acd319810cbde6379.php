 <div class="tr template-upload fade in">
        <?php if($file['error']): ?>
			<?php if(isset( $file['name'] )): ?>
            	<div class="td name"><span><?php echo $file['name']; ?></span></div>
			<?php endif; ?>
			<?php if(isset( $file['size'] )): ?>
            	<div class="td size"><span><?php echo formatFileSize ( $file['size'] ); ?></span></div>
			<?php endif; ?>
			<?php if(isset( $file['url'] )): ?>
			    <div class="td error"><?php echo $file['url']; ?>: <?php echo $file['error']; ?></div>
			<?php else:?>
            	<div class="td error"><?php echo $file['error']; ?></div>
			<?php endif; ?>
        <?php else:?>
			<?php if($file['thumbnail_url']): ?>
            <div class="td preview" style="width:100px;"><span class="fade"><a href="<?php echo $file['imglink']; ?>" onclick="show_image(this);return false;"><img src="<?php echo $file['thumbnail_url']; ?>" width="<?php echo $file['thumbnail_width']; ?>" height="<?php echo $file['thumbnail_height']; ?>"></a></span></div>
			<?php endif; ?>
			
            <div class="td name" style="margin-left: -20px;">
				<span class="fade"><a class="jsAction" href="javascript:void(0);" onclick="show_links_multiply(this);"><?php echo $language['SHOW_LINKS']; ?></a></span>
				<div class="modal-wnd inplace">
					<?php echo block_links ($file,$language,$tiny_static); ?>
					<!--div class="popup-links">
						<ul>
							<li>
								<em><?php echo $language['SHOW_LINK']; ?></em>
								<input class="edit autoselect main_url" type="text" value="<?php echo $file['imglink_html']; ?>" size="75" readonly style="text-transform: lowercase;" id="show_link"/>
							</li>
							<li>
								<em><?php echo $language['DIRECT_LINK']; ?></em>
								<input class="edit autoselect imgurl" type="text" value="<?php echo $file['imglink']; ?>" size="75" readonly style="text-transform: lowercase;" id="direct_link"/>
							</li>
							<li>
								<em><?php echo $language['PREVIEW_LINK_BB']; ?></em>
								<input class="edit autoselect imgurl" type="text" value="<?php echo $file['imglink_preview_bb']; ?>" size="75" readonly id="preview_link_bb"/>
							</li>
							<li>
								<em><?php echo $language['PREVIEW_LINK_HTML']; ?></em>
								<input class="edit autoselect imgurl" type="text" value="<?php echo $file['imglink_preview_html']; ?>" size="75" readonly style="text-transform: lowercase;" id="preview_link_html"/>
							</li>
							<li>
								<em><?php echo $language['BB_CODE_LINK']; ?></em>
								<input class="edit autoselect" type="text" value="[IMG]<?php echo $file['imglink']; ?>[/IMG]" size="75" readonly id="bb_code"/>
							</li>
							<?php if(isset( $file['tiny_url'] )): ?>
							<li>
								<em><?php echo $language['TINY_URL']; ?></em>
								<input class="edit autoselect" type="text" value="<?php echo $file['tiny_url']; ?>" size="75" readonly id="tiny_url"/>
							</li>
							<?php endif; ?>
						</ul>
						<a class="black-button close-wnd" href="javascript:void(0);" onclick="nd();"><?php echo $language['SHUT']; ?></a>
					</div-->
				</div>
			</div>
            <div class="td size" style="margin-left: -20px;"><span class="fade" style="width:100px;"><?php echo formatFileSize ( $file['size'] ); ?></span></div>
			<div class="td" style="margin-left: -10px;">
                <span class="fade"><div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:100%;"></div></div></span>
            </div>
			<div class="td">
					<ul class="hidden-controls">
						<li></li>
						<li><a href="/images/delete/<?php echo $file['id']; ?>" onclick="delete_from_multiupload(this,'<?php echo $lang_image['CONFIRM_DELETE']; ?>');return false;" style="color:red;" title="<?php echo $lang_main['DELETE']; ?>"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" /></a></li>
						<li></li>
					</ul>
			</div>
			<div class="td">
				<span class="progress_percent"></span>
			</div>
        <?php endif; ?>
    </div><?php $mabilis_ttl=1453968932; $mabilis_last_modified=1453883023; //d:\server\www\imghost.vit\templates\imghost\widgets\upload_multiple_internet_by_one.tpl ?>