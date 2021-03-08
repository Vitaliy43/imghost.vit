<div class="container_options">
	{if isset($options.RESIZE_TO_WIDTH)}
		<div class="item">{$options.RESIZE_TO_WIDTH}</div>
	{/if}
	
	{if isset($options.RESIZE_TO_HEIGHT)}
		<div class="item">{$options.RESIZE_TO_HEIGHT}</div>
	{/if}
	{if isset($options.PREVIEW_WIDTH)}
		<div class="item">{$options.PREVIEW_WIDTH}</div>
	{/if}
	
	{if isset($options.PREVIEW_HEIGHT)}
		<div class="item">{$options.PREVIEW_HEIGHT}</div>
	{/if}
	
	{if isset($options.JPEG_QUALITY)}
		<div class="item">{$options.JPEG_QUALITY}</div>
	{/if}
	
	{if isset($options.ROTATE)}
		<div class="item">{$options.ROTATE}°</div>
	{/if}
	
	{if isset($options.ACCESS)}
		<div class="item">{$options.ACCESS}</div>
	{/if}
	
	{if isset($options.WATERMARK)}
		<div class="item">{$options.WATERMARK}</div>
	{/if}
	
	{if isset($options.TAGS)}
		<div class="item">{$options.TAGS}</div>
	{/if}
	
	{if isset($options.CONVERT_TO)}
		<div class="item">{$options.CONVERT_TO}</div>
	{/if}
	
	{if isset($options.TINYURL)}
		<div class="item">tinyURL</div>
	{/if}
	
	{if isset($options.ALBUMS)}
		<div class="item">{$options.ALBUMS}</div>
	{/if}
	
</div>
