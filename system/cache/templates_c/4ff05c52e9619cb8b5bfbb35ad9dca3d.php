 <?php if(count($comments) > 0): ?>
 <!--div style="width:60%;">
 <?php if(is_true_array($comments)){ foreach ($comments as $comment){ ?>
 <div id="comment_<?php echo $comment['id']; ?>" class="comment">
    <table width="100%">
		<tr>
			<td width="50%">
				<?php if(isset($avatar)){ echo $avatar; } ?>
			</td>
			<td colspan="2"></td>
		</tr>
        <tr class="comment_info">
            <td><?php echo $comment['author']; ?></td>
            <td><span><?php echo time_change_show_data ( $comment['data'] ); ?></span></td>
			<td>
			<?php if($user_id == $article_owner_user_id &&  $comment['user_id']  != $user_id &&  $comment['answered']  != 1): ?>
			       	<div id="reply_<?php echo $comment['id']; ?>">

				<a href="#reply_comment" onclick="reply_modal(<?php if(isset($user_id)){ echo $user_id; } ?>,'<?php echo site_url ('comment/add_reply'); ?>/<?php echo $comment['id']; ?>',<?php echo $comment['id']; ?>,'<?php echo site_url (''); ?>');return false;" title="Ответить на комментарий" style="color:black;" class="reply_modal">
	<img src="/templates/articler/images/reply.png" width="13" height="13" style="margin-bottom:-2px;"/>
	&nbsp;&nbsp;Ответить на комментарий
	</a>
		</div>
			<?php endif; ?>   
			</td>
        </tr>
		<tr>
		<td width="50%">
		<div class="comment_text">
            <?php echo $comment['comment']; ?>
        </div>
		</td>
        </tr>
		</table> 
   </div>
   <hr/>
  <?php }} ?>
  </div-->
 
 <?php else:?>

 <!--div id="comment_<?php if(isset($id)){ echo $id; } ?>" class="comment">
 		<table width="100%">
		<tr>
			<td width="50%">
				<?php if(isset($avatar)){ echo $avatar; } ?>
			</td>
			<td colspan="2"></td>
		</tr>
        <tr>
            <td><b><?php if(isset($author)){ echo $author; } ?></b></td>
            <td><span><?php if(isset($date)){ echo $date; } ?></span></td>
			<td align="right">
			<?php if($reply_comment): ?>
				<span style="font-size:9px;font-weight:bold;">Ответ на комментарий: <?php if(isset($reply_comment)){ echo $reply_comment; } ?></span>
			<?php endif; ?>
			<span>
			<a href="<?php echo site_url ('comment/delete'); ?>/<?php if(isset($id)){ echo $id; } ?>" title="Удалить комментарий" onclick="delete_comment(this.href,'<?php if(isset($id)){ echo $id; } ?>');return false;" id="delete_<?php if(isset($id)){ echo $id; } ?>">
<img src="/<?php if(isset($THEME)){ echo $THEME; } ?>/images/icon_delete.png" width="12" height="12"/>
</a>
 &nbsp;
<a href="<?php echo site_url ('comment/edit'); ?>/<?php if(isset($id)){ echo $id; } ?>" title="Редактировать комментарий" onclick="modal_edit_comment(this.href,'<?php if(isset($id)){ echo $id; } ?>');return false;" id="edit_<?php if(isset($id)){ echo $id; } ?>">
<img src="/<?php if(isset($THEME)){ echo $THEME; } ?>/images/icon_edit.png" width="12" height="12"/>
</a>
			</span>
			</td>
        </tr>
		<tr>
		<td width="50%">
		<div class="comment_text">
            <?php if(isset($comment)){ echo $comment; } ?>
        </div>
		</td>
		<td colspan="2"></td>
		</tr>
         </table>   
   </div-->
  <?php endif; ?>
<h3 style="margin-bottom:10px;" id="post_comment"><?php echo $language['ADD_COMMENT']; ?></h3>
<form action="<?php echo site_url ('add_comment'); ?>" method="post" class="form" onsubmit="add_comment(this);return false;" id="comment_form">
	<input type="hidden" name="image_id" id="image_id" value="<?php if(isset($image_id)){ echo $image_id; } ?>"/>

    <div class="textbox">
        <textarea name="comment_text" id="comment_text" rows="6" cols="50"></textarea>
    </div>
	
	<div id="container_submit" style="margin-top:10px;">
		<input type="submit" class="submit" value="<?php echo $language['WRITE_COMMENT']; ?>" />
	</div>

    <?php echo form_csrf (); ?>
</form><?php $mabilis_ttl=1455683289; $mabilis_last_modified=1426495552; //d:\server\www\imghost.vit\templates\imghost\widgets\comments.tpl ?>