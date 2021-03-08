{if count($albums) > 0}
{foreach $albums as $album}
	<div class="item" ondblclick="open_folder(this,{$album.id});" style="cursor: pointer;" data-album="{$album.id}" title="{$language.DBLCLICK_FOLDER}">
		<table width="100%" height="100%">
			<tr>
				<td align="center">
					<img src="{$THEME}images/folder.png" />
				</td>
			</tr>
			{if $is_reverse == 1}
			<tr>
				<td align="center">
					<div class="sync_arrow" title="{$language.COPY_ALBUM_TO_NET}" onclick="modal_album_copy_net(this);" style="cursor: e-resize;">
						<img src="{$THEME}images/sync_arrow_reverse.png" width="33" height="17"/>
					</div>
				</td>
			</tr>
			{/if}
			<tr>
				<td align="center">
					<div style="font-weight: bold;" {briefWordTitle($album.name)}>{briefWord($album.name)}</div>
				</td>
			</tr>
		</table>
	</div>
{/foreach}
{/if}
