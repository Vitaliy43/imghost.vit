<div id="container_album_info">
	<div style="text-align: center;font-size: 22px;font-weight: bold; margin-top: 5px;">&lt;&lt;<?php echo $info['name']; ?>&gt;&gt;</div>
		<?php if(isset( $info['user_id'] )): ?>
		<div><?php echo $language['OWNER']; ?>: <a href="<?php echo site_url ('user'); ?>/<?php echo $info['user_id']; ?>" target="_blank" style="color:#000;"><?php echo $info['username']; ?></a></div>
		<?php endif; ?>
	<?php if($info['description']): ?>
		<div><?php echo $language['DESCRIPTION']; ?>: <?php echo $info['description']; ?></div>
	<?php endif; ?>
	<?php if(isset( $info['access'] )): ?>
	<div>
		<?php echo $language['ACCESS_LEVEL']; ?>: 
		<?php if($info['access']  == 'public'): ?>
			<?php echo $language['ALBUM_PUBLIC']; ?>
		<?php elseif ( $info['access']  == 'protected' ): ?>
			<?php echo $language['ALBUM_PROTECTED']; ?>
		<?php else:?>
			<?php echo $language['ALBUM_PRIVATE']; ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if(isset( $info['added'] )): ?>
	<div><?php echo $language['ADDED']; ?>: <?php echo $info['added']; ?></div>
	<?php endif; ?>
</div>

<?php $mabilis_ttl=1454149488; $mabilis_last_modified=1438694741; //d:\server\www\imghost.vit\templates\imghost\widgets\album_info.tpl ?>