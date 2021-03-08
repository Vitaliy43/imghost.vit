<script type="text/javascript">

window.onpopstate = function(event) {
	if(supportsHistoryAPI == false)
		return false;
	if(from_layout)
		return false;
	paginate_link(document.location.href);

};

</script>
<?php if($role == 'guest'): ?>
<div id="container_profile" class="whitepage">
	<div class="wrap960 imglist">	
		<!--div></div-->
		<?php if(isset($image_list)){ echo $image_list; } ?>
	</div>
</div>
<?php else:?>
<div id="container_profile" class="authorize">
	<div class="wrap960">	
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td valign="top" class="container_profile">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td><div style="min-width:240px;" class="user_profile"><?php if(isset($profile)){ echo $profile; } ?></div></td>
						<td><div class="right_hr" <?php if(DEVELOPMENT == false): ?> style="min-height:500px;"<?php endif; ?>></div></td>
					</tr>
				</table>
				</td>
				<td valign="top" class="imglist">
					<?php if(isset($image_list)){ echo $image_list; } ?>
				</td>
			</tr>	
		</table>
	</div>
</div>
<?php endif; ?>


<?php $mabilis_ttl=1541049069; $mabilis_last_modified=1446127388; //d:\server\www\archive\imghost.vit\templates\imghost\pages\profile.tpl ?>