
<form action="<?php echo site_url ('gallery'); ?>" onsubmit="search_by_tags();return false;" method="POST">
<h3 align="center"><?php echo $language['SELECT_RUBRIC']; ?></h3>
<table width="85%" style="margin-top: 20px;">
	<tr>
		<td>
		<table>
			<tr>
				<td><?php echo $language['TAG']; ?>:&nbsp;</td>
				<td><?php if(isset($tags_box)){ echo $tags_box; } ?></td>
			</tr>
		</table>
		</td>
		<td>
			<table>
				<tr>
					<td><?php echo $language['CHILDREN_TAG']; ?>:&nbsp;</td>
					<td><?php if(isset($children_tags_box)){ echo $children_tags_box; } ?></td>
				</tr>
			</table>
		</td>
		<td align="left">
			<div class="submit">
				<input class="black-button" type="submit" value="<?php echo $language['SEARCH']; ?>"/>
			</div>
		</td>
	</tr>
</table>
<div class="hr" style="margin-bottom: 10px;"></div>
<div id="genres_list" style="display: none;width: 100%;margin-top: -10px;">
	
</div>
<?php if(count($popular_tags) > 0): ?>
	<h3 align="center"><?php echo $language['TOP_RUBRICS']; ?></h3>

<div id="popular_tags" style="width: 100%;">
	<?php $counter = 0?>
	<?php if(is_true_array($popular_tags)){ foreach ($popular_tags as $tag){ ?>
		<div>
		<!--button value="<?php echo $tag['id']; ?>" id="popular_<?php echo $tag['id']; ?>" onclick="set_popular(this);return false;" ><?php echo $tag['value']; ?></button-->
		
		<button value="<?php echo $tag['id']; ?>" id="popular_<?php echo $tag['id']; ?>" onclick="open_popular(this);return false;" <?php if($curr_tag['id']  ==  $tag['id']): ?> style="background: grey; color: #fff;" disabled="" <?php else:?> style="cursor: pointer;"<?php endif; ?>><?php echo $tag['value']; ?></button>
		</div>
		<input type="hidden" id="hiddenpopular_<?php echo $tag['id']; ?>" value="0" class="hiddenpopular"/>
		<input type="hidden" id="textpopular_<?php echo $tag['id']; ?>" value="<?php echo $tag['value']; ?>"/>
		<?php $counter++?>
		
		<?php if($counter == 5): ?>
			<!--div style="clear: both;margin-bottom: 10px;"></div-->
			<?php $counter = 0?>
		<?php endif; ?>
	<?php }} ?>
</div>
<div style="clear: both;margin-bottom: 10px;"></div>

<!--table width="100%">
	<tr>
		<td align="center">
			<div class="submit">
				<input class="black-button" type="submit" value="<?php echo $language['SEARCH']; ?>"/>
			</div>
		</td>
	</tr>
</table-->
<div class="hr" style="margin-top: 15px;"></div>
<?php endif; ?>
<?php echo form_csrf (); ?>
</form>


<?php $mabilis_ttl=1457782946; $mabilis_last_modified=1446037526; //d:\server\www\imghost.vit\templates\imghost\widgets\search_tags.tpl ?>