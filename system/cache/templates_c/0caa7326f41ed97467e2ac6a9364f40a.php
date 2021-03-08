<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php if(isset($site_title)){ echo $site_title; } ?></title>
  <meta name="description" content="<?php if(isset($site_description)){ echo $site_description; } ?>" />
  <meta name="keywords" content="<?php if(isset($site_keywords)){ echo $site_keywords; } ?>" />
  <meta name="recreativ-verification" content="uFzNhms50k4UymgxqImSG3PDWRLsPP3vxzIs7DbK" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url ('templates/imghost/css/seedoff_sync.css'); ?>" media="all" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url ('templates/imghost/css/shadowbox.css'); ?>" media="all" />
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery-1.8.3.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery-ui.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.form.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.cycle.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.treeview.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/ajax.js?v=2'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/helpers.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/datepicker-ru.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/formstyler.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.ui.widget.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/tmpl.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/load-image.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/canvas-to-blob.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.iframe-transport.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.fileupload.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.fileupload-fp.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.fileupload-ui.js?v=1'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/jquery.pluginssiteimage.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/scripts.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/rotate.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/carousel.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/ui.js?v=1'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/overlib_.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/shadowbox.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo site_url ('templates/imghost/js/functions.js?v=2'); ?>"></script>
		
		<script type="text/javascript">
			var	ajax_small_url = '<?php echo site_url ('templates/imghost/images/ajax-loaders/small.gif'); ?>';
			var max_number_of_files = <?php if(isset($max_number_of_files)){ echo $max_number_of_files; } ?>;
			var is_iframe = 1;
			var token = '<?php if(isset($token)){ echo $token; } ?>';
			var torrent_id = '<?php if(isset($torrent_id)){ echo $torrent_id; } ?>';
			var from_edit_fast = '<?php if(isset($from_edit_fast)){ echo $from_edit_fast; } ?>';
			<?php if(isset($is_cover)): ?>
				var is_cover = '<?php if(isset($is_cover)){ echo $is_cover; } ?>';
			<?php endif; ?>
			
			<?php if(isset($type_operation)): ?>
				var type_operation = '<?php if(isset($type_operation)){ echo $type_operation; } ?>';
			<?php endif; ?>
	
			Shadowbox.init({
					enableKeys: false
				}	
				);
			$(document).ready(function() {
				
				$("body").click(function(e) {
	    if($(e.target).closest("#overDiv").length==0) {
				nd();
		}
		
		});
			});
			
			var upload_by_one = '<?php if(isset($upload_by_one)){ echo $upload_by_one; } ?>';

		</script>
</head>
<body>
<?php if($width < $iframe_width && $height > 0): ?>
	<section id="upload" style="width;<?php if(isset($width)){ echo $width; } ?>px;height:<?php if(isset($height)){ echo $height; } ?>px;overflow: scroll;">
<?php else:?>
	<section id="upload" style="background: #f2f2f2;<?php if(isset($is_cover)): ?> height: 550px;<?php endif; ?>">
<?php endif; ?>
<div class="block">
<span class="sticker"></span>
<div class="block-title"></div>	
	<span id="comp-wrapper">
<div class="upload-form">
	<?php if($from_edit_fast): ?>
	<div class="upload-fields" style="margin-top: -50px;">
		<?php if(isset($content)){ echo $content; } ?>
	</div>
	<?php else:?>
	<div class="upload-fields">
		<?php if(isset($content)){ echo $content; } ?>
	</div>
	<?php endif; ?>

	<?php if(empty($is_cover)): ?>
		<div class="submit" id="all_submit" style="margin-top:30px;">
			<input class="black-button" type="submit" value="<?php echo $language['UPLOAD']; ?>"/>
		</div>
	<?php else:?>
		
		<!--div class="submit" id="all_submit" style="margin-top:20px;<?php if($type_operation == 'edit'): ?>display: none;<?php endif; ?>">
			<input class="black-button" type="submit" value="<?php echo $language['UPLOAD']; ?>"/>
		</div-->
	<?php endif; ?>			
</div>
</span>
</div>
</section>
<!--input type="hidden" id="from_edit" value="<?php if(isset($from_edit)){ echo $from_edit; } ?>"/-->
<input type="hidden" id="from_edit" value="1"/>
<input type="hidden" id="pictures_list"/>
</body>
</html><?php $mabilis_ttl=1473324732; $mabilis_last_modified=1447050042; //d:\server\www\imghost.vit\templates\imghost\layouts\seedoff_upload.tpl ?>