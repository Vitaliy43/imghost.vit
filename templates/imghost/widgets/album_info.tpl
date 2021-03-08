<div id="container_album_info">
	<div style="text-align: center;font-size: 22px;font-weight: bold; margin-top: 5px;">&lt;&lt;{$info.name}&gt;&gt;</div>
		{if isset($info.user_id)}
		<div>{$language.OWNER}: <a href="{site_url('user')}/{$info.user_id}" target="_blank" style="color:#000;">{$info.username}</a></div>
		{/if}
	{if $info.description}
		<div>{$language.DESCRIPTION}: {$info.description}</div>
	{/if}
	{if isset($info.access)}
	<div>
		{$language.ACCESS_LEVEL}: 
		{if $info.access == 'public'}
			{$language.ALBUM_PUBLIC}
		{elseif $info.access == 'protected'}
			{$language.ALBUM_PROTECTED}
		{else:}
			{$language.ALBUM_PRIVATE}
		{/if}
	</div>
	{/if}
	{if isset($info.added)}
	<div>{$language.ADDED}: {$info.added}</div>
	{/if}
</div>

