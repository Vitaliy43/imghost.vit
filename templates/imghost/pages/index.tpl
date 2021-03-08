{if isset($one_uploader)}
<script type="text/javascript">
	{if $one_uploader == 'multi'}
	{literal}
	$(document).ready(function() {
		$('#upload-multiple').show();		
	});
	{/literal}
	{elseif $one_uploader == 'fast'}
	{literal}
	$(document).ready(function() {
		$(this).parents('.upload-splash').hide().siblings('.upload-form').show();
	});
	{/literal}
	{/if}
</script>
{/if}
<section id="upload">
	<div class="wrap960">
		<div class="block">
			<span class="sticker"></span>
			<div class="block-title">{$language.UPLOAD_FAST}</div>
				{$upload_fast}
		</div>
		<div class="block">
			<span class="sticker"></span>
			<div class="block-title">{$language.UPLOAD_MULTIPLE}</div>
			<a id="showMultipleUpload" class="button" href="#"><span>{$language.JUMP_TO_UPLOAD}</span></a>
			<div class="hint">{$language.MULTIBLOCK_OPENS_MSG}</div>
			<div class="warning">
				{$language.MAX_SIZE_PHOTO_MSG}		
			</div>
			<canvas id="myCanvas" style="display: none;">
	
			</canvas>
				{$upload_multiple}		
		</div>
		<div id="buffer_blob"></div>
		<!--input type="hidden" id="buffer_blob"/-->
	</div>
</section>