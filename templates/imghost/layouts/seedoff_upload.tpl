<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>{$site_title}</title>
  <meta name="description" content="{$site_description}" />
  <meta name="keywords" content="{$site_keywords}" />
  <meta name="recreativ-verification" content="uFzNhms50k4UymgxqImSG3PDWRLsPP3vxzIs7DbK" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <link rel="stylesheet" type="text/css" href="{site_url('templates/imghost/css/seedoff_sync.css')}" media="all" />
  <link rel="stylesheet" type="text/css" href="{site_url('templates/imghost/css/shadowbox.css')}" media="all" />
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery-1.8.3.min.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery-ui.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.form.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.cycle.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.treeview.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/ajax.js?v=2')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/helpers.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/datepicker-ru.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/formstyler.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.ui.widget.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/tmpl.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/load-image.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/canvas-to-blob.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.iframe-transport.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.fileupload.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.fileupload-fp.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.fileupload-ui.js?v=1')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/jquery.pluginssiteimage.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/scripts.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/rotate.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/carousel.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/ui.js?v=1')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/overlib_.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/shadowbox.js')}"></script>
  <script type="text/javascript" src="{site_url('templates/imghost/js/functions.js?v=2')}"></script>
		
		<script type="text/javascript">
			var	ajax_small_url = '{site_url('templates/imghost/images/ajax-loaders/small.gif')}';
			var max_number_of_files = {$max_number_of_files};
			var is_iframe = 1;
			var token = '{$token}';
			var torrent_id = '{$torrent_id}';
			var from_edit_fast = '{$from_edit_fast}';
			{if isset($is_cover)}
				var is_cover = '{$is_cover}';
			{/if}
			
			{if isset($type_operation)}
				var type_operation = '{$type_operation}';
			{/if}
	
			{literal}
	
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
			{/literal}
			var upload_by_one = '{$upload_by_one}';

		</script>
</head>
<body>
{if $width < $iframe_width && $height > 0}
	<section id="upload" style="width;{$width}px;height:{$height}px;overflow: scroll;">
{else:}
	<section id="upload" style="background: #f2f2f2;{if isset($is_cover)} height: 550px;{/if}">
{/if}
<div class="block">
<span class="sticker"></span>
<div class="block-title"></div>	
	<span id="comp-wrapper">
<div class="upload-form">
	{if $from_edit_fast}
	<div class="upload-fields" style="margin-top: -50px;">
		{$content}
	</div>
	{else:}
	<div class="upload-fields">
		{$content}
	</div>
	{/if}

	{if empty($is_cover)}
		<div class="submit" id="all_submit" style="margin-top:30px;">
			<input class="black-button" type="submit" value="{$language.UPLOAD}"/>
		</div>
	{else:}
		
		<!--div class="submit" id="all_submit" style="margin-top:20px;{if $type_operation == 'edit'}display: none;{/if}">
			<input class="black-button" type="submit" value="{$language.UPLOAD}"/>
		</div-->
	{/if}			
</div>
</span>
</div>
</section>
<!--input type="hidden" id="from_edit" value="{$from_edit}"/-->
<input type="hidden" id="from_edit" value="1"/>
<input type="hidden" id="pictures_list"/>
</body>
</html>