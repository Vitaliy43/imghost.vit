<table width="80%" cellpadding="4" cellspacing="4" border="1">
	<tr>
		<th align="left">{$language.BLOCK}</th>
		<th align="left">{$language.POSITION}</th>
		<th align="left">{$language.DESCRIPTION}</th>
		<th align="left">{$language.NUMBER}</th>
		<th align="left">{$language.ACTIVE}</th>
		<th align="left">{$language.ACTIONS}</th>
	</tr>
	{foreach $blocks as $block}
	<tr data-id="{$block.id}" class="block">
		<td>{$block.name}</td>
		<td style="padding-top: 5px;">{$block.select_position}</td>
		<td>{$block.description}</td>
		<td>{$block.sortid}</td>
		<td>
			<input type="checkbox" {if $block.active} checked="checked"{/if} onclick="set_active(this);return false;"/>
		</td>
		<td class="span2">
											<table>
												<tr>
													<td>
														<a href="{$BASE_URL}admin/components/init_window/advertisement/edit" title="{$language.EDIT_ADVERT_CONTENT}" onclick="edit_advert_content(this,{$block.id});return false;">
														<img src="/templates/administrator/images/icon_edit.png" width="15" height="15"/></a>
													</td>
													<td>
												<a href="{$BASE_URL}admin/components/init_window/advertisement/delete" onclick="delete_advert(this,,'{$language.CONFIRM_DELETE}');return false;" style="margin-left: 5px;">
													<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
												</a>
													</td>
												</tr>
											</table>
										</td>
	</tr>
	{/foreach}
</table>