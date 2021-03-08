<?php if(isset($one_uploader)): ?>
<script type="text/javascript">
	<?php if($one_uploader == 'multi'): ?>
	$(document).ready(function() {
		$('#upload-multiple').show();		
	});
	
	<?php elseif ($one_uploader == 'fast'): ?>
	$(document).ready(function() {
		$(this).parents('.upload-splash').hide().siblings('.upload-form').show();
	});
	
	<?php endif; ?>
</script>
<?php endif; ?>
<section id="upload">
	<div class="wrap960">
		<div class="block">
			<span class="sticker"></span>
			<div class="block-title"><?php echo $language['UPLOAD_FAST']; ?></div>
				<?php if(isset($upload_fast)){ echo $upload_fast; } ?>
		</div>
		<div class="block">
			<span class="sticker"></span>
			<div class="block-title"><?php echo $language['UPLOAD_MULTIPLE']; ?></div>
			<a id="showMultipleUpload" class="button" href="#"><span><?php echo $language['JUMP_TO_UPLOAD']; ?></span></a>
			<div class="hint"><?php echo $language['MULTIBLOCK_OPENS_MSG']; ?></div>
			<div class="warning">
				<?php echo $language['MAX_SIZE_PHOTO_MSG']; ?>		
			</div>
			<canvas id="myCanvas" style="display: none;">
	
			</canvas>
				<?php if(isset($upload_multiple)){ echo $upload_multiple; } ?>		
		</div>
		<div id="buffer_blob"></div>
		<!--input type="hidden" id="buffer_blob"/-->
	</div>
</section><?php $mabilis_ttl=1545381220; $mabilis_last_modified=1443183730; //d:\server\www\archive\imghost.vit\templates\imghost\pages\index.tpl ?>