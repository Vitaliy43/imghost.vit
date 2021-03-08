<script type="text/javascript">
{literal}

window.onpopstate = function(event) {
	if(supportsHistoryAPI == false)
		return false;
	if(from_layout)
		return false;
	paginate_link_sync(document.location.href);
	}
{/literal}
</script>
<div id="container_sync" class="whitepage">
<div id="header_albums" style="text-align: center;margin-top: -60px;">
	<h1>{$language.SYNCHRONIZATION}</h1>
</div>
<table style="margin-top: 50px;" width="90%" cellpadding="5" cellspacing="5">
	<tr>
		<td width="120"></td>
		<td align="center" style="font-size: 16px; font-weight: bold;" width="700">{$language.SYNC_MSG}</td>
		<td width="100"></td>
	</tr>
	<tr>
		<td width="120" valign="top">
			<table width="100%" style="margin-top: 5px;">
				{if $nets}
					{foreach $nets as $curr_net}
						{if $curr_net.active == 1}
						<tr>
						<td height="100">
						{if $authorized[$curr_net.prefix] }
							<a href="{site_url('sync')}/{$curr_net.prefix}" onclick="hash_change(this.href);return false;">
						{else:}
							<a href="{site_url('sync')}/{$curr_net.prefix}">
						{/if}
						{if $select_net == $curr_net.prefix}
							<div class="{$curr_net.prefix}_icon_hover" title="{$curr_net.name}"></div>
						{else:}
							<div class="{$curr_net.prefix}_icon" title="{$curr_net.name}"></div>
						{/if}
						</a>
					</td>
				</tr>
				
					{/if}
					{/foreach}
				{/if}
				<!--
				<tr>
					<td height="100">
							<a href="{site_url('sync/vk')}" onclick="hash_change(this.href);return false;">
						{if $select_net == 'vk'}
							<div class="vk_icon_hover" title="Vkontakte"></div>
						{else:}
							<div class="vk_icon" title="Vkontakte"></div>
						{/if}
						</a>
					</td>
				</tr>
				<tr>
					<td height="100">
						{if $fb_authorized}
							<a href="{site_url('sync/fb')}" onclick="hash_change(this);return false;">
						{else:}
							<a href="{site_url('sync/fb')}">
						{/if}
						{if $select_net == 'fb'}
							<div class="facebook_icon_hover" title="Facebook"></div>
						{else:}
							<div class="facebook_icon" title="Facebook"></div>
						{/if}
						</a>
					</td>
				</tr>
				
				<tr>
					<td height="100">
						{if $ok_authorized}
							<a href="{site_url('sync/ok')}" onclick="hash_change(this);return false;">
						{else:}
							<a href="{site_url('sync/ok')}">
						{/if}
						{if $select_net == 'ok'}
							<div class="odnoklassniki_icon_hover" title="Odnoklassniki"></div>
						{else:}
							<div class="odnoklassniki_icon" title="Odnoklassniki"></div>
						{/if}
						</a>
					</td>
				</tr>
				
				<tr>
					<td height="100">
						{if $pic_authorized}
							<a href="{site_url('sync/pic')}" onclick="hash_change(this);return false;">
						{else:}
							<a href="{site_url('sync/pic')}">
						{/if}
						{if $select_net == 'pic'}
							<div class="picasa_icon_hover" title="Picasa"></div>
						{else:}
							<div class="picasa_icon" title="Picasa"></div>
						{/if}
						</a>
					</td>
				</tr>
				-->
			</table>
			
		</td>
		<td align="center" colspan="2" width="850">
			<table>
				<td width="375">
					<div class="panel">
						<div id="container_left_panel" class="list_files">
							{$net_panel}
						</div>
					</div>
				</td>
				<td width="40" valign="middle">
					<table width="100%">
						<tr>
							<td align="center">
								{if $dual_sync}
									{if $is_reverse}
										<a href="{site_url('sync')}/{$select_net}" onclick="hash_change(this);return false;">
										<div class="sync_net_icon" title="{$language.SYNC_FROM_LOCAL}"></div>
										</a>
									{else:}
										<a href="{site_url('sync')}/{$select_net}" onclick="hash_change(this);return false;">
										<div class="sync_net_icon_hover" title="{$language.SYNC_FROM_LOCAL}"></div>
										</a>
									{/if}
								{else:}
										<div class="sync_net_icon_hover" title="{$language.SYNC_FROM_LOCAL}"></div>
								{/if}
								
							</td>
						</tr>
						{if $dual_sync}
						<tr>
							<td align="center" style="padding-right: 8px;">
								{if $select_net}
									<a href="{site_url('sync')}/{$select_net}/reverse" onclick="hash_change(this);return false;">
								{else:}
									<a href="{site_url('sync')}/reverse" onclick="hash_change(this);return false;">
								{/if}
								{if $is_reverse}
									<div class="sync_local_icon_hover" title="{$language.SYNC_FROM_NET}"></div>
								{else:}
									<div class="sync_local_icon" title="{$language.SYNC_FROM_NET}"></div>
								{/if}
								</a>
							</td>
						</tr>
						{/if}
					</table>
					
				</td>
				<td width="400">
					<div class="panel" id="right_panel">
						<div id="container_right_panel" class="list_files">
							{$local_panel}
						</div>
					</div>
				</td>
			</table>
		</td>
	</tr>
</table>
</div>
<input type="hidden" id="current_owner_id"/>
<input type="hidden" id="current_net" value="{$select_net}"/>
<input type="hidden" id="current_album_id"/>
<input type="hidden" id="current_local_album_id"/>
<input type="hidden" id="current_id"/>
<input type="hidden" id="result_copy" value="0"/>
<input type="hidden" id="is_work" value="{$is_work}"/>
<input type="hidden" id="update_net" value="0"/>
<input type="hidden" id="is_create_album_net" value="0"/>
{if $is_reverse}
	<input type="hidden" id="is_reverse" value="1"/>
{else:}
	<input type="hidden" id="is_reverse" value="0"/>
{/if}
<div id="container_modal" style="display: none;"></div>
