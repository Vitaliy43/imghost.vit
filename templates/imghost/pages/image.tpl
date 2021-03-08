
<script type="text/javascript">
var relative_url = '{$relative_url}';
var from_seedoff = '{$from_seedoff}';
var last_url;
var first_enter_navigation = false;
var global_direct;
var is_profile = false;
var is_opener = false;
var carousel;
var from_gallery = false;
//var from_gallery = false;
{if $is_big_image}
	var is_big_image = {$is_big_image};
{else:}
	var is_big_image = 0;
{/if}
var filename = '{$filename}';
var view_zoom = {$view_zoom};
var is_user = {$is_user};
var browse_mode = {$browse_mode};
</script>
<link rel="stylesheet" type="text/css" href="{$THEME}css/rating.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$THEME}css/elevatezoom.css" media="all" />

<script type="text/javascript">

{literal}

	function load_more_profile(direct){
		
			if(window.opener.jQuery('.pagination').length >= 1){
				var url = get_current_page_profile(direct);
				if(typeof(url) != 'undefined'){
					hash_change_parent(url);
					paginate_link_parent(url,direct)
				}
				else
					$('#'+direct+'_link').parent().html('<div style="width:32px;height:32px;"></div>');

			}
			else{
				$('#'+direct+'_link').parent().html('<div style="width:32px;height:32px;"></div>');
				
			}
	}
	
	function is_open(){
		try{
			if(window.opener && document.location.hostname == window.opener.location.hostname){
				if(window.opener.jQuery('#container_profile').length >= 1)
					is_profile = true;
				is_opener = true;
			}
		}
		catch(e){
			
		}
	}
	
	
	function load_more_opener(){
		
			var all_uploaded = window.opener.jQuery('#all_uploaded').val();
			var items = window.opener.jQuery('#container_gallery .list-item').size();
			var new_page = (window.opener.jQuery('#current_page').val())*1 + 1;
			var num_pages = window.opener.jQuery('.curpage_'+new_page).size();
			if(items < all_uploaded){
				if(num_pages == 0){
					if(window.opener.jQuery('#container_album_info').length > 0){
						load_more_album_parent(new_page);
					}
					else{
						load_more_parent(new_page);
					}

				}
			}
			else{
				$('#next_link').parent().html('<div style="width:32px;height:32px;"></div>');
			}
		
	}
	

	$(document).ready(function() {
			var current_slide = $('#container_image #current_slide').val();
			var image_height = $('#container_image .main_table').attr('height');
			image_height = image_height*1 + 100;
			is_open();
			$('#container_image').css({'height':image_height});
			var browser = get_browser();
			$('.zoomContainer').remove();

			if(browser == 'Mozilla'){
				if(is_user == 1)
					$('.right_links').css('margin-top','0px');
			}
			else {
				
				if(browser = 'Google Chrome'){
					if($('.header_table h1 a').length > 0)
					{
					
					}
					else
					{
						if(is_user == 1){
							$('.right_links').css('margin-top','0px');

						}
							
					}
				}
			}
			
			if(is_opener == true){
				$('#prev_link').after('<a href="" class="shadowbox" rel="shadowbox[mygallery]" style="display:none;" id="prev_link_direct">Prev</a>');
				$('#next_link').after('<a href="" class="shadowbox" rel="shadowbox[mygallery]" style="display:none;" id="next_link_direct">Next</a>');

			}	
				Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
				});
				
				if(is_profile == true)
					set_navigation_profile();
				else
					set_navigation();	
			
			$('.pic').qtip({
    			content: {
        			text: function(event, api) {
						var address = $(this).attr('src');
						return '<img src="'+address+'" />';
        			}
    			},
				style: {
        			classes: 'qtip-cluetip'
    			}
			});
			
			if(is_big_image == 1 && view_zoom == 1){
				
				 $('#image img').elevateZoom({
					cursor: "pointer",
					zoomWindowFadeIn: 500,
					zoomWindowFadeOut: 750,
					tint:true,
					tintColour:'#F90',
					tintOpacity:0.5
  				 }); 
				  	 
			}
				if(from_gallery == false){
					carousel = $('#carousel').elastislide({
						imageW 	: 60,
						minItems: 5
					});	
				}
				
			
	   	});
		
		
window.onpopstate = function(event) {
	if(supportsHistoryAPI == false)
		return false;
	if(from_layout)
		return false;
	var current_url = document.location.href;
	if(current_url.indexOf('/big') != -1 )	
		return false;
	$('.zoomContainer').remove();
	$('.pic').qtip('destroy', true); 
	navigation_image(current_url);
	if(from_big == true)
		return false;

};
{/literal}
</script>
{if !$is_ajax}
<div id="container_image">
<input type="hidden" id="real_width" value="{$real_width}"/>
<input type="hidden" id="preview_width" value="{$preview_width}"/>
<input type="hidden" id="real_height" value="{$real_height}"/>
<input type="hidden" id="preview_height" value="{$preview_height}"/>
<input type="hidden" id="image_id" value="{$id}"/>
<input type="hidden" id="image_url" value="{$filename}"/>
<input type="hidden" id="current_slide" value="0"/>
{/if}
	<table cellpadding="0" cellspacing="0" width="850" class="main_table" border="0">
		<tr>
			<td></td>
			<td width="600" align="left" class="header_table">
			<h1 style="font-size: 22px; font-weight: bold; background: inherit; border-radius: 0px 0px 0px 0px; box-shadow: none; color: inherit; display: block; text-shadow: none; padding: 0px; line-height: inherit;">
				{if isset($torrent_id)}
					<a href="{$seedoff_link}" target="_blank" style="text-decoration: none; line-height: 1.2;">{$screen}</a>
				{else:}
					<span style="line-height: 1.2;">{splitterWord($show_filename,40)}</span>
				{/if}
			</h1>
			
			</td>
			<td>
		
			</td>
			<td></td>
		</tr>
		<tr>
			<td valign="top" align="center" style="padding-right: 5px; padding-top: 223px;" class="container_prev">
				<a href="{$prev_link}" onclick="hash_change_image(this.href,'prev');return false;" id="prev_link">
					<img src="{$THEME}images/left_arrow.png"/>
				</a>
				
			</td>

				<td valign="top" style="background: #828587;border-right: 1px solid #000;" width="600">
				<table cellpadding="2" cellspacing="2" width="100%" height="100%" >
					<tr>
						<td width="100%" align="center" valign="middle">
							<div id="image" >
								{if $is_big_image}
									<!--a href="{$filename_big}" style="padding: 0px;" onclick="open_big_image(this);return false;" title="{$language.TITLE_BIG}"-->
									<a href="{$filename_big}" style="padding: 0px;" title="{$language.TITLE_BIG}">
										<!--img src="{$filename}" width="{$width}" height="{$height}" style="margin:0px;border-left:1px solid #828587;border-top:1px solid #828587;" data-type="big" alt="{$show_filename}" title="{$show_filename}"/-->
										<img src="{$filename}" width="{$width}" height="{$height}" style="margin:0px;border-left:1px solid #828587;border-top:1px solid #828587;" data-type="big" alt="{$show_filename}" title="{$show_filename}" data-zoom-image="{$filename}"/>
									</a>
									
								{else:}
									<img src="{$filename}" width="{$width}" height="{$height}" style="margin:0px;border-left:1px solid #828587;border-top:1px solid #828587;" data-type="small"  alt="{$show_filename}" title="{$show_filename}"/>
								{/if}
								

							</div>
						</td>
					</tr>
					<tr>
						<td>
							<table width="100%" class="img_links" cellpadding="0" cellspacing="0" height="100%">
					<tr>
						<td align="center">
							<div class="more-options" style="margin-top: 10px;margin-bottom:10px;">
								<a class="jsAction" href="#" onclick="show_links_profile(this);return false;" style="text-decoration: none;color: #fff;font-size: 16px;border-bottom: 2px dashed #fff;" title="{$lang_upload.SHOW_LINKS}">{$lang_upload.SHOW_LINKS}</a>
							</div>
							<div class="modal-wnd inplace" style="display: none;">		
			<div class="popup-links" style="background: white;">
			<ul style="list-style-type: none; ">
				<li>
					<em>{$lang_upload.SHOW_LINK}</em>
					<input class="edit autoselect" type="text" value="{$filename_main}" size="75" style="text-transform: lowercase;" readonly id="show_link"/>
				</li>
				<li>
					<em>{$lang_upload.DIRECT_LINK}</em>
					<input class="edit autoselect" type="text" value="{$filename}" size="75" style="text-transform: lowercase;" readonly id="direct_link"/>
				</li>
				
				<li>
					<em>{$lang_upload.PREVIEW_LINK_BB}</em>
					<input class="edit autoselect" type="text" value="{$imglink_preview_bb}" size="75" readonly id="preview_link_bb"/>
				</li>
				<li>
					<em>{$lang_upload.PREVIEW_LINK_HTML}</em>
					<input class="edit autoselect" type="text" value="{$imglink_preview_html}" size="75" readonly id="preview_link_bb"/>
				</li>
				<li>
					<em>{$lang_upload.BB_CODE_LINK}</em>
					<input class="edit autoselect" type="text" value="[IMG]{$filename}[/IMG]" size="75" style="text-transform: lowercase;" readonly id="bb_code"/>
				</li>
				
				{if isset($tiny_url) && $tiny_url}
					<li>
						<em>{$lang_upload.TINY_URL}</em>
						<input class="edit autoselect" type="text" value="{$tiny_url}" size="75" readonly id="tiny_url"/>
					</li>
				{/if}
				
			</ul>
			<a class="black-button" href="javascript:void(0);" onclick="nd();">Закрыть</a>
		</div>
		</div>
						</td>
						<td></td>
					</tr>
					{if $browse_mode}
						<tr>
							<td align="center" id="browse_gallery">
								{$browse_gallery}
							</td>
						</tr>
					{/if}
					
					
				</table>
						</td>
					</tr>
				</table>
				
			</td>
			<td width="250" valign="top" >
				<table cellpadding="0" cellspacing="0" height="100%" width="250">
				
					<tr>
						<td valign="top" width="250">
							<table cellpadding="0" cellspacing="0" height="100%" width="250" class="right_links" style="margin-top: -3px;">
									
									<tr>

									<td align="center">
									{if $is_user && $show_account}
									{if isset($is_favourite) && $is_favourite == 1}
										<div id="container_favourite"><a href="{site_url('remove_favourite')}/{$type}/{$id}" onclick="set_favourite(this);return false;">{$language['DELETE_FROM_FAVORITES']}</a></div>
									{else:}
										<div id="container_favourite"><a href="{site_url('favourite')}/{$type}/{$id}" onclick="set_favourite(this);return false;">{$language['FAVORITES']}</a></div>
									{/if}
									{/if}
									</td>
										</tr>
								
									<tr>
									<td align="center">
										<div><a href="{site_url('feedback')}{if isset($id)}?type_feedback=complaint&image_id={$id}{/if}">{$language['COMPLAIN']}</a></div>
									</td>
									</tr>
					
								{if $exif}
								<tr>
									<td align="center">
										<div><a href="javascript:void(0);" onclick="get_exif();">{$language['EXIF_INFO']}</a></div>
									</td>
								</tr>
								{/if}
								{if DEVELOPMENT == true}
								<tr>
									<td align="center">
										<div><a href="">{$language['PHOTO_NEARBY']}</a></div>
									</td>
								</tr>
								{/if}
							</table>
							
						</td>
					</tr>
					
					<tr>
					
						<td valign="{if $is_user && $show_account}bottom{else:}top{/if}" >
							<table cellpadding="0" cellspacing="0" height="100%" width="250" class="file_info">
								<tr>
									<td>
										<div class="container_file_info" {if !$is_user} style="margin-top:0px;"{/if}>
											<div class="header_file_info">
												{$language['FILE_INFO']}
											</div>
											<div class="main_file_info" >
												{if $is_user && $user_id && $show_account}
												
												{if $image_actions}
													<div>Действия:
														<span>
															<a href="/images/edit/{$id}" title="{$lang_main.EDIT}" onclick="edit_image_from_page(this,{$id});return false;" id="edit_{$id}" style="text-decoration: none;"><img src="{$THEME}images/icon_edit.png" width="12" height="12"/></a>
														</span>
														<span style="margin-left: 2px;">
														<a href="/images/delete/{$id}" onclick="delete_image_from_page(this,{$id},'{$lang_imagelist.CONFIRM_DELETE}');return false;" style="text-decoration: none;"><img width="12" height="12" src="/templates/administrator/images/icon_delete.png"/>
														<!--a href="/images/delete/{$id}" onclick="delete_image_from_page(this,{$id},'{$lang_imagelist.CONFIRM_DELETE}')" style="text-decoration: none;"><img width="15" height="15" src="{$THEME}images/icon_delete.png"/-->
														</a>
														
														</span>
														
													</div>
												
												{else:}
													<div>{$language['OWNER']}:<a href="{site_url('user')}/{$user_id}" style="margin-left: 3px;color: inherit;" target="_blank"> {$owner}</a></div>
												{/if}
													
												{else:}
													{if $image_actions && $from_user}
													
														<div>Действия:
														<span>
															<a href="/images/edit/{$id}" title="{$lang_main.EDIT}" onclick="edit_image_from_page(this,{$id});return false;" id="edit_{$id}" style="text-decoration: none;"><img src="{$THEME}images/icon_edit.png" width="12" height="12"/></a>
														</span>
														<span style="margin-left: 2px;">
														<a href="/images/delete/{$id}" onclick="delete_image_from_page(this,{$id},'{$lang_imagelist.CONFIRM_DELETE}');return false;" style="text-decoration: none;"><img width="12" height="12" src="/templates/administrator/images/icon_delete.png"/>
														</a>
														<!--a href="/images/delete/{$id}" onclick="delete_image_from_page(this,{$id},'{$lang_imagelist.CONFIRM_DELETE}')" style="text-decoration: none;"><img width="15" height="15" src="{$THEME}images/icon_delete.png"/></a-->
														</span>
														
														</div>
													
													{elseif $image_actions}
													
														<div>Действия:
														<span>
															<a href="/images_guest/edit/{$id}" title="{$lang_main.EDIT}" onclick="edit_image_from_page(this,{$id});return false;" id="edit_{$id}" style="text-decoration: none;"><img src="{$THEME}images/icon_edit.png" width="12" height="12"/></a>
														</span>
														<span style="margin-left: 2px;">
														<a href="/images_guest/delete/{$id}" onclick="delete_image_from_page(this,{$id},'{$lang_imagelist.CONFIRM_DELETE}');return false;" style="text-decoration: none;"><img width="12" height="12" src="/templates/administrator/images/icon_delete.png"/>
														</a>
														<!--a href="/images_guest/delete/{$id}" onclick="delete_image_from_page(this,{$id},'{$lang_imagelist.CONFIRM_DELETE}')" style="text-decoration: none;"><img width="12" height="12" src="{$THEME}images/icon_delete.png"/></a-->
														</span>
														
														</div>
													
													{else:}
														{if $from_user}
															<div>{$language['OWNER']}: {$lang_auth['USER']}</div>
														{else:}
															<div>{$language['OWNER']}: {$lang_auth['GUEST']}</div>
														{/if}
													
													{/if}
													
												{/if}
												
												<div>{$language['NAME']}: {splitterWord($show_filename,20)}</div>
												
												<div>
														
												{if $tag_name}
													{if isset($cover)}
														<span>{$language['TAG_NAMES']}: <a href="{site_url('gallery')}?is_cover=1" target="_blank" style="color:#fff;">{$language.COVER}</a></span>
														<span style="margin-left: 3px;"><a href="{site_url('gallery/tags')}/{$tag_id}" target="_blank" style="color:#fff;">{splitterWord($tag_name,20)}</a></span>
													{else:}
														<span>{$language['TAG_NAME']}: <a href="{site_url('gallery/tags')}/{$tag_id}" target="_blank" style="color:#fff;">{splitterWord($tag_name,20)}</a></span>
													{/if}
												{else:}
												{if isset($cover)}
													<span>{$language['TAG_NAME']}: <a href="{site_url('gallery')}?is_cover=1" target="_blank" style="color:#fff;">{$language.COVER}</a></span>
												{/if}
												{/if}	
												
												</div>

												{if $album_name}
													{if isset($torrent_id)}
														<div>{$lang_album['ALBUM']}: <a href="{site_url('torrents')}/{$album_id}" target="_blank" style="color:#fff;">{splitterWord($album_name,20)}</a></div>
													{else:}
														<div>{$lang_album['ALBUM']}: <a href="{site_url('albums')}/{$album_id}" target="_blank" style="color:#fff;">{splitterWord($album_name,20)}</a></div>
													{/if}
												{/if}
												{if isset($block_genres)}
													<div>{$language['GENRES']}: {$block_genres}</div>
												{/if}
												<div>{$language['RESOLUTION']}: {$real_width}x{$real_height}</div>
												<div>{$language['EXT']}: {$ext}</div>
												<div>{$language['ADDED']}: {extract_date($data)}</div>
												<div>{$language['FILE_SIZE']}: {formatFileSize($size)}</div>
												{if $show_views}
													<div>{$language['NUM_VIEWS']}: {$views}</div>
												{/if}
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td valign="bottom">
										<div class="container_vote" style="width:100%;">					
												{$rating_bar}
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
				<td valign="top" align="center" style="padding-left: 15px;padding-top: 223px;" class="container_next" width="50">
					<a href="{$next_link}" onclick="hash_change_image(this.href,'next');return false;" id="next_link">
						<img src="{$THEME}images/right_arrow.png"/>
					</a>
				</td>

		</tr>
		{if $is_user && DEVELOPMENT == true && $show_account}
		<tr>
			<td valign="top" align="center" style="padding-right: 5px;">
				
			</td>
			<td width="600" valign="top">
			
			<div id="container_comments">
				{$comments}
			</div>
				
			</td>
			<td width="250" valign="top">
			
			</td>
			<td valign="top" align="center" style="padding-left: 15px;">

			</td>
		</tr>
		{/if}
	</table>

{if !$is_ajax}	
</div>
{/if}
<div id="exif" style="display: none;">
	{$exif}
</div>
<div id="container_items" style="display:none;">

</div>
{if $image_actions}
	<div id="container_modal" style="display: none;"></div>
{/if}
