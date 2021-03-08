{if $type_show == 'list'}
<div id="container_upload_settings" style="padding: 15px;">
	<div id="container_templates" style="overflow-y: scroll;">

		{if count($templates) > 0}
		<table width="100%" border="1" cellpadding="2" cellspacing="2">
		<tr>
			<th>{$language.NAME}</th>
			<th>{$language.OPTIONS}</th>
			<th>{$lang_main.ACTIONS}</th>
		</tr>
		{foreach $templates as $item}
			<tr>
				<td>{$item.show_name}</td>
				<td style="font-size: 9px;">{$item.options}</td>
				<td align="center">
					<a href="{site_url('profile/upload/templates/edit')}/{$item.id}" onclick="add_upload_template(this,'edit');return false;" title="{$language.EDIT_TEMPLATE}" style="text-decoration: none;margin-right:3px;">
						<img src="/templates/administrator/images/icon_edit.png" width="15" height="15" style="margin-top:3px"/>
					</a>
					<a href="{site_url('profile/upload/templates/delete')}/{$item.id}" onclick="delete_upload_template(this,'{$language.CONFIRM_DELETE}');return false;" title="{$language.DELETE_TEMPLATE}" >
						<img src="/templates/administrator/images/icon_delete.png" width="15" height="15" style="margin-top:3px"/>
					</a>
				</td>
			</tr>
		
		{/foreach}
		{/if}
		</table>
	</div>
	<div id="add_template" style="text-align: center;margin-top: 10px;">
	<a href="{site_url('profile/upload/templates/add')}" style="text-decoration: none;" onclick="add_upload_template(this,'add');return false;">
		<img width="16" height="16" src="{$THEME}images/add.png" />
		<span style="margin-left:9px;text-decoration: underline;color:#166D66;">
			{$language.ADD_TEMPLATE}
		</span>
	</a>
		
	</div>
</div>
{else:}

<div id="container_templates" style="overflow-y: scroll;">
		<table width="100%" border="1" cellpadding="2" cellspacing="2">
		<tr>
			<th>{$language.NAME}</th>
			<th>{$language.OPTIONS}</th>
			<th>{$lang_main.ACTIONS}</th>
		</tr>
		{if count($templates) > 0}
		{foreach $templates as $item}
			<tr>
				<td>{$item.show_name}</td>
				<td style="font-size: 9px;">{$item.options}</td>
				<td align="center">
					<a href="{site_url('profile/upload/templates/edit')}/{$item.id}" onclick="add_upload_template(this,'edit');return false;" title="{$language.EDIT_TEMPLATE}" style="text-decoration: none;margin-right:3px;">
						<img src="/templates/administrator/images/icon_edit.png" width="15" height="15" style="margin-top:3px"/>
					</a>
				
					<a href="{site_url('profile/upload/templates/delete')}/{$item.id}" onclick="delete_upload_template(this,'{$language.CONFIRM_DELETE}');return false;" title="{$language.DELETE_TEMPLATE}">
						<img src="/templates/administrator/images/icon_delete.png" width="15" height="15" style="margin-top:3px"/>
					</a>
				</td>
			</tr>
		
		{/foreach}
		{/if}
		</table>
	</div>
	<div id="add_template" style="text-align: center;margin-top: 10px;">
		<a href="{site_url('profile/upload/templates/add')}" style="text-decoration: none;" onclick="add_upload_template(this);return false;">
			<img width="16" height="16" src="{$THEME}images/add.png" />
			<span style="margin-left:9px;text-decoration: underline;color:#166D66;">
				{$language.ADD_TEMPLATE}
			</span>
		</a>
	</div>

{/if}
