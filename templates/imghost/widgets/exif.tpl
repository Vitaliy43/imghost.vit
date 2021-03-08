<div style="background:#fff;padding: 10px;font-size: 14px;">
<table style="border: 1px #000 double;" width="100%">
{foreach $exif as $elem}	
	<tr>
		<td>{$elem.name}</td>
		<td>{$elem.value}</td>
	</tr>
{/foreach}	
</table>
</div>
