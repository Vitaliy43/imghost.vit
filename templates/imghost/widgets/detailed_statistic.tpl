<div style="background:#fff;padding: 10px;font-size: 14px;">
<table style="border: 1px #000 double;" width="100%" cellpadding="4" cellspacing="4">
	<tr>
		<td>{$lang_profile.STAT_ALBUMS}</td>
		<td>{$num_albums}</td>
	</tr>
	<tr>
		<td>{$lang_profile.STAT_IMAGES}</td>
		<td>{$num_images}</td>
	</tr>
	{if DEVELOPMENT == true}
	<tr>
		<td>{$lang_profile.STAT_COMMENTS}</td>
		<td>0</td>
	</tr>
	{/if}
	<tr>
		<td>{$lang_image.NUM_VIEWS_STATISTIC}</td>
		<td>{$num_views}</td>
	</tr>
		<tr>
		<td>{$lang_poll.IMAGE_RATING}</td>
		<td>{sprintf("%01.1f",$avg_rating)}</td>
	</tr>
</table>
</div>
