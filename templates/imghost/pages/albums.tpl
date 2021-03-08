{literal}
<script type="text/javascript">
var ol_width = 100;


$(document).ready(function() {

	$("#albums_tree").treeview({
		persist: "location",
		collapsed: true
	});
	$(".hitarea").bind("click", function(e){
        var buffer = $(this).next().attr('id');
		var arr = buffer.split('_');
		show_branch(this,arr[1]);
    });
		
});

</script>

{/literal}
<input type="hidden" id="current_drag"/>
<input type="hidden" id="current_paginate_url" value="/albums/files"/>

<div id="container_albums" class="whitepage">
<div id="header_albums" style="text-align: center;margin-top: -60px;">
	<h1>{$lang_auth.ALBUMS}</h1>
</div>
<form action="{site_url('albums/add')}" method="POST" onsubmit="add_album(this);return false;">
<table cellpadding="3" cellspacing="3" width="100%" class="main_table">
	<tr>
		<td width="400" valign="top">
		
		<table cellpadding="0" cellspacing="0">
		<tr>
		<td>
			<div>
					<input type="text" size="20" maxlength="50" placeholder="{$language.NAME}" name="name" id="album_name"/>
			</div>
			</td>
			<td style="padding-left: 5px;" valign="bottom">
				<div>{$language.ACCESS}:</div>
			</td>
			</tr>
			<tr>
				<td>
				<div style="margin-top: 5px;">
					<textarea rows="3" cols="20" name="description" placeholder="{$language.DESCRIPTION}" name="description" id="description"></textarea>
				</div>
				<div style="margin-top: 5px;">
					<div class="submit">
						<input class="black-button" type="submit" value="{$language.CREATE_ALBUM}" style="font-size: 11px;text-transform: lowercase;"/>
					</div>
				</div>
			</td>
			<td valign="top" style="padding-top: 5px;padding-left: 5px;" nowrap="">
			<table>
			<tr>
				<td nowrap="">
					<div>
					<input type="radio" name="access" checked="" value="public" class="access" onclick="show_password(this);"/>
				</div>
				</td>
				<td>
					<label>{$language.PUBLIC}</label>

				</td>
			</tr>
			<tr>
				<td nowrap="">
				<div>
					<input type="radio" name="access" value="private" class="access" onclick="show_password(this);"/>
				</div>
				</td>
				<td>
					<label>{$language.PRIVATE}</label>
				</td>
			</tr>
			<tr>
				<td nowrap="">
				<div>
					<input type="radio" name="access" value="protected" class="access" onclick="show_password(this);"/>
				</div>
					<td>
						<label>{$language.PROTECTED}</label>
					</td>
				</td>
			</tr>
			<tr style="display: none;" id="container_password">
					<td colspan="2">
						<input size="12" maxlength="20" name="password" id="password" type="text"/>
					</td>

			</tr>
				
				</table>
			</td>
			</tr>
			</table>
		</td>
		<td width="300" >
			<div style="font-size: 18px;font-weight:bold;">{$language.STATISTIC}</div>
			<div style="margin-top: 5px;">
				{$language.FOLDERS}: <span id="num_folders">{$num_folders}</span>
			</div>
			<div>
				{$language.FILES}: <span id="num_files">{$num_files}</span>
			</div>
			<div style="margin-top: 25px;">
				<div class="submit">
					<input class="black-button" type="submit" value="{$language.UPLOAD_PHOTO}" style="font-size: 11px;text-transform: lowercase;" onclick="show_uploader();return false;"/>
				</div>
			</div>
		</td>
		<td width="300" valign="top" style="padding-top: 5px;">
		{if DEVELOPMENT == true}
			<div style="font-size: 18px;font-weight:bold;">{$lang_sync.SYNCHRONIZE_NET}</div>
			<div style="margin-top: 5px;">
				Vkontakte: <span id="num_vk">{$num_albums_vk}</span>
			</div>
			<div>
				Facebook: <span id="num_fb">{$num_albums_fb}</span>
			</div>
			<div>
				{$lang_sync.OK}: <span id="num_ok">{$num_albums_ok}</span>
			</div>
			<div>
				Picasa: <span id="num_pic">{$num_albums_pic}</span>
			</div>
			<div style="margin-top: 25px;">
				<div class="submit">
					<input class="black-button" type="submit" value="{$lang_sync.SYNCHRONIZATION}" style="font-size: 11px;text-transform: lowercase;" onclick="show_sync();return false;"/>
				</div>
			</div>
			{/if}
		</td>
	</tr>
</table>
	</form>
<table border="1" width="97%" cellpadding="3" cellspacing="3" class="main_table">
	<tr>
		<td width="350" height="450" valign="top">
		<div style="font-weight: bold;padding-left: 5px; padding-top: 5px;">{$language.FOLDERS_LIST}</div>
		<div id="container_file_tree" style="padding-left: 10px; padding-top: 5px;height: 440px;overflow-y: scroll;">
			{$tree}
		</div>
		
		</td>
		<td width="350" height="450" valign="top" id="list_files">{$list_files}</td>
		<td width="300" height="450" valign="top" align="center" class="comments">Комментариев нет</td>
	</tr>
</table>
</div>
<div id="container_modal"></div>
<div id="container_uploader" style="display: none;">
<div id="upload" style="padding: 50px;">
	{$fast_form}
</div>
</div>
