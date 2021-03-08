<script type="text/javascript">
{literal}

window.onpopstate = function(event) {
	if(supportsHistoryAPI == false)
		return false;
	if(from_layout)
		return false;
	paginate_link(document.location.href);

};
{/literal}
</script>
{if $role == 'guest' }
<div id="container_profile" class="whitepage">
	<div class="wrap960 imglist">	
		<!--div></div-->
		{$image_list}
	</div>
</div>
{else:}
<div id="container_profile" class="authorize">
	<div class="wrap960">	
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td valign="top" class="container_profile">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td><div style="min-width:240px;" class="user_profile">{$profile}</div></td>
						<td><div class="right_hr" {if DEVELOPMENT == false} style="min-height:500px;"{/if}></div></td>
					</tr>
				</table>
				</td>
				<td valign="top" class="imglist">
					{$image_list}
				</td>
			</tr>	
		</table>
	</div>
</div>
{/if}


