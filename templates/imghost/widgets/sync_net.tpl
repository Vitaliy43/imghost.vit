
{if count($albums) > 0}
{foreach $albums as $album}
	<div class="item" ondblclick="open_net_folder(this,'{$album.owner_id}','{$album.id}');" style="cursor: pointer;" data-owner="{$album.owner_id}" data-album="{$album.id}" data-object="folder" title="{$language.DBLCLICK_FOLDER}">
		<table width="100%" height="100%">
			<tr>
				<td align="center">
					<img src="{$THEME}images/folder.png" />
				</td>
			</tr>
			{if $is_reverse == 0}
			<tr>
				<td align="center">
					<div class="sync_arrow" title="{$language.COPY_ALBUM_TO_LOCAL}" onclick="modal_album_copy_local(this);" style="cursor: e-resize;">
						<img src="{$THEME}images/sync_arrow.png" width="33" height="17"/>
					</div>
				</td>
			</tr>
			{/if}
			<tr>
				<td align="center">
					<div style="font-weight: bold;white-space: nowrap;" {briefWordTitle($album.title)} class="net_album_name">{briefWord($album.title)}</div>
				</td>
			</tr>
		</table>
	</div>
{/foreach}
<input type="hidden" id="current_net" value="{$net}"/>
<input type="hidden" id="object_copy" value="folder"/>
<input type="hidden" id="enable_show_album" value="1"/>
{/if}
