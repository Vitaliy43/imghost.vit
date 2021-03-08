<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <title>{$site_title}</title>
        <meta name="description" content="{$site_description}" />
        <!--meta name="keywords" content="{$site_keywords}" /-->
		<meta name="recreativ-verification" content="uFzNhms50k4UymgxqImSG3PDWRLsPP3vxzIs7DbK" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="{$THEME}css/style.css?v=1" media="all" />
        <link rel="stylesheet" type="text/css" href="{$THEME}css/jquery-ui.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{$THEME}css/shadowbox.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{$THEME}css/chevereto.css" media="all" />
		<link rel="stylesheet" type="text/css" href="{$THEME}css/jquery.treeview.css">
		{if $is_image}
			<link rel="stylesheet" type="text/css" href="{$THEME}css/jquery.qtip.min.css">
			<link rel="stylesheet" type="text/css" href="{$THEME}css/elastislide.css">
		{/if}
		<link rel="stylesheet" type="text/css" href="{$THEME}css/jquery.autocomplete.css">
        <link rel="icon" type="image/vnd.microsoft.icon" href="{echo siteinfo('siteinfo_favicon_url')}" />
        <link rel="SHORTCUT ICON" href="favicon.ico" />
        <script type="text/javascript" src="{$THEME}js/jquery-1.8.3.min.js"></script>
		{if isset($is_albums) || isset($is_sync)}
			<script type="text/javascript" src="{$THEME}js/jquery-ui11.js"></script>			
		{else:}
		      <script type="text/javascript" src="{$THEME}js/jquery-ui.js"></script>
		{/if}
		<script type="text/javascript">
			var image_window = '';
		</script>
        <script type="text/javascript" src="{$THEME}js/jquery.cycle.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.form.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.history.js"></script>
		<script src="{$THEME}js/jquery.treeview.js" type="text/javascript"></script>
        <script type="text/javascript" src="{$THEME}js/ajax.js"></script>
        <script type="text/javascript" src="{$THEME}js/helpers.js"></script>
        <script type="text/javascript" src="{$THEME}js/datepicker-ru.js"></script>
        <script type="text/javascript" src="{$THEME}js/formstyler.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="{$THEME}js/tmpl.js"></script>
        <script type="text/javascript" src="{$THEME}js/load-image.js"></script>
        <script type="text/javascript" src="{$THEME}js/canvas-to-blob.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.iframe-transport.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.fileupload.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.fileupload-fp.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.fileupload-ui.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.pluginssiteimage.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="{$THEME}js/scripts.js"></script>
		<script type="text/javascript" src="{$THEME}js/shadowbox.js"></script>
        <script type="text/javascript" src="{$THEME}js/rotate.js"></script>
        <script type="text/javascript" src="{$THEME}js/jquery.scrollTo.min.js"></script>
        <script type="text/javascript" src="{$THEME}js/carousel.js"></script>
        <!--script type="text/javascript" src="{$THEME}js/jquery.jcarousel.js"></script-->
        <script type="text/javascript" src="{$THEME}js/ui.js"></script>
        <script type="text/javascript" src="{$THEME}js/overlib_.js"></script>
		<script type="text/javascript" src="{$THEME}js/functions.js?v=1"></script>
		<script type="text/javascript" src="{$THEME}js/antiadblock.js"></script>
		<script type="text/javascript" src="{$THEME}js/behavior.js"></script>
		<script type="text/javascript" src="{$THEME}js/rating.js"></script>
		{if $is_image}
			<script type="text/javascript" src="{$THEME}js/jquery.easing.1.3.js"></script>
			<script type="text/javascript" src="{$THEME}js/jquery.elevatezoom.js"></script>
			<script type="text/javascript" src="{$THEME}js/jquery.qtip.min.js"></script>
			<script type="text/javascript" src="{$THEME}js/modernizr.custom.17475.js"></script>
		{/if}
		<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
		<script type="text/javascript">
  			{$vk_init}
			
		</script>

		<script type="text/javascript">
			var	ajax_small_url = '{$THEME}images/ajax-loaders/small.gif';
			var ol_fgcolor = '#fff';
			var direction = 0;
			var ol_width = 450;
			var supportsHistoryAPI=!!(window.history && history.pushState);// =true если поддерживается, иначе =false
			var from_layout = true;	
			var max_number_of_files = {$max_number_of_files};
			var is_iframe = 0;
			document.domain = "{str_replace('http://','',SITE_URL)}";
			{literal}
			
			window.onload = function() {
	            if (window.addEventListener) window.addEventListener("DOMMouseScroll", mouse_wheel, false);
	            window.onmousewheel = document.onmousewheel = mouse_wheel;
	        }
	             
	        var mouse_wheel = function(event) {
	            if (false == !!event) event = window.event;
	            direction = ((event.wheelDelta) ? event.wheelDelta/120 : event.detail/-3) || false;
	        }	
		{/literal}
		
		var upload_by_one = '{$upload_by_one}';
		</script>


		<script type="text/javascript">
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
		</script>
		{if isset($vk_authorized) && $vk_authorized == 0}
			<script type="text/javascript">
			
				VK.Auth.login(null, VK.access.PHOTOS);
				VK.Auth.getLoginStatus(authInfo);
			</script>
		{/if}
		
		{if isset($fb_init)}
			{$fb_init}
		{/if}
		
		<script type="text/javascript" id="container_save_photos"></script>
    </head>
   <body>

   <div  id="overDiv"  style="position:absolute;  visibility:hidden;  z-index:10000;"></div>  
   	<div id="wrapper">
	<header id="header">
		<section class="ctrls" {if isset($is_admin)} style="height:90px;"{/if}>
			<div class="wrap960">
				<div class="lang">
					<div class="label">{$lang_main.LANGUAGE}:</div>
					<ul id="cbLang" class="combobox">
						<li class="active ru"><span>Русский</span></li>
					</ul>
				</div>
				<!-- Блок поиска тегов по названию -->
				{$search}
				<!-------------------------------------------->
				<div class="auth">
					<div class="page_visible">
						{$auth}
					</div>
				</div>
				{if $link_images_list}
					<div class="header_links"><a href="{site_url('profile')}">{$lang_main.MY_UPLOADS}</a></div>	
				{/if}
			</div>		
		</section>

			<div class="wrap960">
					
			<div class="logo-bg"><a id="logo" href="/"></a></div>
			<a id="gallery" href="/gallery"></a>
			<a id="top" href="/gallery/top"></a>
		</div>
		</header>	
			<!--section id="banner-top-wide-development">Сайт в разработке</section-->
			<!--section id="banner-top-wide">
				<a href='http://www.seedoff.net' target='_blank'><img src='http://img.seedoff.net/banners/seedoff_banner_zima_700_90.png' border=0 width="820"></a>
			</section-->
			{if $with_main_banner}
			<section id="banner-top-wide" style="width: 728px;height: 90px;">
				<div id="bn_cbfdabd10b">загрузка...</div>
			</section>
			{/if}
			<!--section id="banner-top-wide">{$advert_header}</section-->
			<section id="content">
			<table width="100%">
				<tr>
					<td>{$advert_sidebar_left}</td>
					<td>{$content}</td>
					<td></td>
				</tr>
				{if isset($is_image)}
				<tr>
					<td></td>
					<td>
						<section id="banner-down-wide" style="width: 728px;height: 90px; margin-top: -25px;">
							<!-- 728*90 Advertur.ru start -->
	<div id="advertur_77185"></div>
	{literal}
	<script type="text/javascript">
    (function(w, d, n) {
        w[n] = w[n] || [];
        w[n].push({
            section_id: 77185,
            place: "advertur_77185",
            width: 728,
            height: 90
        });
    })(window, document, "advertur_sections");
</script>
{/literal}
<script type="text/javascript" src="//ddnk.advertur.ru/v1/s/loader.js" async></script>
<!-- 728*90 Advertur.ru end -->
						</section>
					</td>
					<td></td>
				</tr>
				{/if}
			</table>
			</section>
	</div>
	<footer id="footer">
		{$footer}
	</footer>
	<script type="text/javascript" src="{$THEME}js/peafowl.js"></script>
	<script type="text/javascript" src="{$THEME}js/chevereto.js"></script>
	<script type="text/javascript" src="{$THEME}js/myscr_multi.js"></script>
	{if $is_image}
		<script type="text/javascript" src="{$THEME}js/jquery.elastislide.js"></script>
		<!--script type="text/javascript" src="{$THEME}js/jquery.easing.1.3.js"></script-->
	{/if}
	<script type="text/javascript">
PF.obj.config.base_url = "{site_url('')}";
PF.obj.config.json_api = "{site_url('')}";
PF.obj.config.listing.items_per_page = "12";
</script>
<!--script type="text/javascript" src="{$THEME}js/pf_obj.js"></script-->

<script type="text/javascript">

{literal}		
if(typeof CHV == "undefined") {
	CHV = {obj: {}, fn: {}, str:{}};
}

{/literal}		
	</script>
	<script type="text/javascript" src="//recreativ.ru/rcode.cbfdabd10b.js"></script>
	{if isset($is_image) && isset($_GET['with_advertur'])}
	<script type="text/javascript">
		var aads = document.getElementById('advertur-ads-late');
		document.getElementById('advertur-ads').appendChild(aads);
	</script>
	{/if}
	{literal}
		<script type="text/javascript">
			
			if ( ! ( 'adBlock' in window ) ) {
//				$('#bn_cbfdabd10b').html('<img src=\'http://img.seedoff.net/banners/seedoff_banner_zima_700_90.png\' border=0 width="728">');
				$('#bn_cbfdabd10b').html('<div style="background: #fff; padding-top: 5px; padding-bottom: 10px;"><div style="font-size: 14px;">Привет! Кажется, ты используешь AdBlock - могут быть недоступны некоторые функции. <br>Добавь <a rel="nofollow" href="/antiaddblock" target="_blank">нас в исключения</a>, пожалуйста.</div></div>');
				
//   				$('body').prepend('<div style="text-align: center; width: 100%; background: #efebd1; color: #000;">Привет! Кажется, ты используешь AdBlock - могут быть недоступны некоторые функции. <br>Добавь <a rel="nofollow" href="<tag:FORUM_HOST />/index.php?topic=14922" target="_blank">нас в исключения</a>, пожалуйста.</div>');
//   				$('.topc').css('top','36px');
//   				$('.topc_winter').css('top','36px');

				}
			
		</script>
	{/literal}
   </body>

</html>