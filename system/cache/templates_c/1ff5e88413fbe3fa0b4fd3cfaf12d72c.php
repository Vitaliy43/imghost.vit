<div style="background:#fff;padding: 10px;font-size: 14px;">
<table style="border: 1px #000 double;" width="100%">
<?php if(is_true_array($exif)){ foreach ($exif as $elem){ ?>	
	<tr>
		<td><?php echo $elem['name']; ?></td>
		<td><?php echo $elem['value']; ?></td>
	</tr>
<?php }} ?>	
</table>
</div>
<?php $mabilis_ttl=1453880702; $mabilis_last_modified=1403528506; //d:\server\www\imghost.vit\templates\imghost\widgets\exif.tpl ?>