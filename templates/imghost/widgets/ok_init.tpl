<div style="padding-top: 50px;padding-left: 50px;">
{if !$error}
<div style="font-weight: bold;">
		{$language.OK_MESSAGE_AUTHOR}
	</div>
	<div style="font-size: 12px;">
		{$language.WARNING_POPUP}&nbsp;&nbsp;
			{$login}
	</div>
{else:}
	<div>{$error}</div>

{/if}
</div>