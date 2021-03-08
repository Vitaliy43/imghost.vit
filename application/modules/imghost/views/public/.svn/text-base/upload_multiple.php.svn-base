<?php
$style = 'style="';
 if(isset($_REQUEST['width']))
	$width = 'width;'.((int)$_REQUEST['width']).'px;';
 else
 	$width = 0;	
 if($width)
 	$style .= $width;
if(!$is_guest)
	$style .= 'height:540px;';
if($style == 'style="')
	$style = '';
else
	$style .='"';

?>

<script type="text/javascript">
	
$(document).ready(function() {
			
	var browser = get_browser();

	if(browser == 'Google Chrome' || browser == 'Opera'){
			
		$('#faq_upload').text('Нажмите кнопку "Выбрать файлы", вставьте из буфера обмена или перетащите картинку в блок загрузки');
	}
			
});
	
</script>


<div id="upload-multiple">
	<?php if(!$iframe):?>
	<a class="close close-multiupload" href="#"><?php echo $language['SHUT'];?>}</a>
	<?php endif;?>
	<div class="choose-source">
		<a class="black-button active" href="#upload-multi-files"><?php echo $language['UPLOAD_FROM_COMPUTER'];?></a>
		<a class="black-button" href="#upload-multi-links"><?php echo $language['UPLOAD_FROM_INTERNET'];?></a>
	</div>
	<div class="workarea">
	<?php
		if(isset($_REQUEST['torrent_id']) && isset($_REQUEST['token']))
			$action = site_url('upload/multiple').'?torrent_id='.$_REQUEST['torrent_id'].'&token='.$_REQUEST['token'];
		else
			$action = site_url('upload/multiple');
	
	?>
		<form id="upload-multi-files" action="<?php echo $action;?>" method="POST" enctype="multipart/form-data"  >
			<input type="hidden" name="ACTION" value="upload-files" />
			<input type="hidden" name="__AJAX" value="Y" />
			<div class="toolbar fileupload-buttonbar">
				<span class="toolbutton fileinput-button">
					<span><?php echo $language['SELECT_FILES'];?></span>
					<input type="file" name="files[]" multiple />
				</span>
				<button type="submit" class="toolbutton start" onclick="check_enable_upload();"><?php echo $language['UPLOAD_TO_SERVER'];?></button>
				<button type="reset" class="btn-abs cancel delete" title="<?php echo $language['RESET'];?>" onclick="truncate_block_upload();"></button>
			</div>
					<div style="text-decoration: underline;margin-bottom: 5px;text-align: center;"><?php echo $language['MAX_NUMBER_OF_FILES'].' '.$fields_count;?></div>
					<div style="text-align: center;font-size: 11px;margin-bottom: 10px;" id="faq_upload"><?php echo $language['FAQ_UPLOAD'];?></div>
				<div id="sync_info" style="text-align: center;display: none;">
				<?php echo $language['SYNC_INFO'];?>
				</div>
				<div id="summary_links_multiple" style="display: none;">
					<div class="more-options link_summary">
						<a class="jsAction" href="#" onclick="show_summary_links(this);return false;" style="margin-top: 10px;color:#000;"><?php echo $language['SUMMARY_LINKS'];?></a>
					</div>
					<div class="modal-wnd inplace">
					<div class="popup-links">
						<ul style="list-style-type: none;">
						<li>
					<em><?php echo $language['SHOW_LINK'];?></em>
					<textarea class="edit autoselect" readonly="" id="show_link" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				<li>
					<em><?php echo $language['DIRECT_LINK'];?></em>
					<textarea class="edit autoselect" readonly="" id="direct_link" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				
				<li>
					<em><?php echo $language['PREVIEW_LINK_BB'];?></em>
					<textarea class="edit autoselect" readonly="" id="preview_link_bb" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				<li>
					<em><?php echo $language['PREVIEW_LINK_HTML'];?></em>
					<textarea class="edit autoselect" readonly="" id="preview_link_html" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				<li>
					<em><?php echo $language['BB_CODE_LINK'];?></em>
					<textarea class="edit autoselect" readonly="" id="bb_code" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>

				</li>
			
					<li style="display: none;">
						<em><?php echo $language['TINY_URL'];?></em>
						<textarea class="edit autoselect" readonly="" id="tiny_url" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>

					</li>
						</ul>
						<a class="black-button close-wnd" href="javascript:void(0);" onclick="nd();">Закрыть</a>
					</div>
					</div>
				</div>

			<div id="upload-drop-zone" class="listbox files" style="margin-top: 10px;"></div>
		</form>
		
		<form id="upload-multi-links" class="ajaxForm" action="<?php echo $action;?>" method="POST">
			<input type="hidden" name="ACTION" value="upload-links" />
			<input type="hidden" name="__AJAX" value="Y" />
			<input type="hidden" id="enable_memo" value="0"/>
			<div class="toolbar fileupload-buttonbar">
				<button type="submit" class="toolbutton start"><?php echo $language['UPLOAD_TO_SERVER'];?></button>
				<button type="reset" class="btn-abs cancel delete" title="<?php echo $language['RESET'];?>" onclick="truncate_block_upload();"></button>
			</div>
			<div id="upload-result">
				<div class="caption-text"><?php echo $language['UPLOAD_RESULT_CAPTION_TEXT'];?></div>
				<textarea class="memo" name="FILE_URL" placeholder="http://somesite.com/some_picture.jpg" onkeypress="set_enable_memo();" onpaste="set_enable_memo();"></textarea>
			</div>
			<div id="edit_fields" style="display: none;">
				<input type="hidden" name="RESIZE_TO_WIDTH" value="0" class="RESIZE_TO_WIDTH"/>
				<input type="hidden" name="RESIZE_TO_HEIGHT" value="0" class="RESIZE_TO_HEIGHT"/>
				<input type="hidden" name="PREVIEW_WIDTH" value="0" class="PREVIEW_WIDTH"/>
				<input type="hidden" name="PREVIEW_HEIGHT" value="0" class="PREVIEW_HEIGHT"/>
				<?php if(ImageHelper::$enable_compression):?>
					<input type="hidden" name="JPEG_QUALITY" class="JPEG_QUALITY" value="0"/>
				<?php endif;?>
				<input type="hidden" name="TINYURL" class="TINYURL" value="100"/>
				<input type="hidden" name="ROTATE" value="0" class="ROTATE"/>
				<select class="combobox CONVERT_TO" name="CONVERT_TO">
					<option value=""></option>
					<option value="jpg">JPG</option>
					<option value="png">PNG</option>
					<option value="gif">GIF</option>
				</select>
				<input class="edit WATERMARK" type="text" name="WATERMARK" value="" size="16" maxlength="16"/>
				<select class="combobox ACCESS" name="ACCESS" id="ACCESS" style="width:100px;">
					<option value="public"><?php echo $lang_albums['ALBUM_PUBLIC'];?></option>
					<option value="private"><?php echo $lang_albums['ALBUM_PRIVATE'];?></option>
				</select>
				<?php echo $albums_internet;?>
				<?php echo $tags_internet;?>
			</div>
		</form>
	</div>

	<?php if(!$is_guest || $have_token) :?>
	<div style="height: 20px;">
		<table width="100%">
			<tr>
				<td align="right" id="left_block">
				<table>
					<tr>
						<td><input type="checkbox" id="batch" onchange="batch_editing(this);return false;"/></td>
						<td valign="top">
							<span style="margin-left:5px;font-size: 14px;"><?php echo $language['BATCH_EDITING'];?></span>
							<span id="ajax_template_info" style="display: none;"><?php echo $language['APPLY_TEMPLATE_MESSAGE'];?></span>
						</td>
					</tr>
				</table>
				</td>
				<td align="left" id="right_block">
						<span style="margin-left: 10px;">
						<?php 
							if($have_templates)
								echo $language['TEMPLATE'];
						?>		
						</span>
					<span id="container_list_templates"><?php echo $templates_box;?></span>
					<span id="container_delete_template" style="display: none;margin-right: 5px;">
						<a href="" onclick="delete_upload_template(this,'<?php echo $language['CONFIRM_DELETE'];?>');return false;" title="<?php echo $language['DELETE_TEMPLATE'];?>" style="text-decoration: none;">
						<img src="/templates/administrator/images/icon_delete.png" width="15" height="15" style="margin-top:3px"/>
						<span style="margin-left:5px;text-decoration: underline;color: red;font-size:14px;"><?php 
							echo $language['REMOVE'];
						?></span>
					</a>
					</span>
					<span><a href="/profile/upload/templates/add<?php if (isset($_REQUEST['token']) && isset($_REQUEST['torrent_id'])) echo "?token=".$_REQUEST['token'].'&torrent_id='.$_REQUEST['torrent_id'];?>" " style="text-decoration: none;" onclick="add_upload_template(this);return false;" id="add_template">
						<img width="16" height="16" src="<?php echo $THEME.'/images/add.png';?>" />
						<span style="margin-left:9px;text-decoration: underline;color:#166D66;font-size:14px;"><?php 
						if($have_templates)
							echo $language['ADD'];
						else
							echo $language['ADD_TEMPLATE'];
						?></span>
					</a></span>
				</td>
			</tr>
		</table>
	</div>
	<div id="template_options" style="display: none;"><div style="font-size: 12px;color:black;"></div></div>
	<?php endif;?>
</div>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	
	<div class="tr template-upload fade" style="position:relative;">
		{% if (file.error) { %}
            <div class="td error"><span class="fade">{%=file.error%}</span></div>
        {% } else if (o.files.valid && !i) { %}
			{% if (!o.options.autoUpload) { %}
			<input type="hidden" class="file_num" name="file_number" value="">
			<input type="hidden" name="RESIZE_TO_WIDTH[]" value="0" class="RESIZE_TO_WIDTH"/>
			<input type="hidden" name="RESIZE_TO_HEIGHT[]" value="0" class="RESIZE_TO_HEIGHT"/>
			<input id="tiny_url" type="hidden" name="TINYURL[]" class="TINYURL"/>
			<button class="start hidden"></button>
			<button class="cancel hidden"></button>
			<div class="td preview"><span class="fade"></span></div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li>
						<a class="hcSwitcher" href="#"><?php echo $language['RESIZE_TO'];?></a>
						<div class="hcArea">
							<input class="edit" type="text" name="RESIZE_TO[]" value="" size="5" />
							<select class="combobox" name="RESIZE_WHAT[]">
								<option value="none"></option>
								<option value="height"><?php echo $language['HEIGHT'];?></option>
								<option value="width"><?php echo $language['WIDTH'];?></option>
							</select>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#"><?php echo $language['NAME'];?></a>
						<div class="hcArea">
							<input class="edit" type="text" name="NAME[]" value="" size="16" />
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#"><?php echo $language['COMMENTS'];?></a>
						<div class="hcArea">
							<textarea class="memo" name="DESCRIPTION[]" cols="35" rows="2"></textarea>
							<div class="center"><a class="black-button hcClose" href="#">OK</a></div>
						</div>
					</li>
				</ul>
			</div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li>
						<span><?php echo $language['TURN'];?></span>
						<a class="left90" href="#" title="<?php echo $language['LEFT90'];?>"></a>
						<a class="right90" href="#" title="<?php echo $language['RIGHT90'];?>"></a>
						<input type="hidden" name="ROTATE[]" value="0" class="ROTATE"/>
					</li>
					<li>
						<a class="hcSwitcher" href="#"><?php echo $language['CONVERT'];?></a>
						<div class="hcArea">
							<select class="combobox CONVERT_TO" name="CONVERT_TO[]">
								<option value=""></option>
								<option value="jpg">JPG</option>
								<option value="png">PNG</option>
								<option value="gif">GIF</option>
							</select>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<!--li><a class="hcSwitcher" href="#"><?php echo $language['WATERMARK'];?></a>
						<div class="hcArea">
							<div class="input"><input class="edit WATERMARK" type="text" name="WATERMARK[]" value="" size="16" maxlength="16"/></div>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li-->
					<li><a class="hcSwitcher" href="#"><?php echo $language['PREVIEW'];?></a>
						<div class="hcArea">
							<input class="edit PREVIEW_WIDTH" type="text" placeholder="Ш" size="5" value="" name="PREVIEW_WIDTH[]">
							<input class="edit PREVIEW_HEIGHT" type="text" placeholder="В" size="5" value="" name="PREVIEW_HEIGHT[]">
							<a class="black-button hcClose" href="#">OK</a>
						</div>
						
					</li>
				</ul>
				<?php if(ImageHelper::$enable_compression):?>
					<input type="hidden" name="JPEG_QUALITY[]" class="JPEG_QUALITY" value=""/>
				<?php endif;?>
			</div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li><a class="hcSwitcher" href="#"><?php echo $language['ACCESS'];?></a>
					<div class="hcArea">
						<div class="input">
							<select class="combobox ACCESS" name="ACCESS[]" id="ACCESS" style="width:100px;">
								<option value="public"><?php echo $lang_albums['ALBUM_PUBLIC'];?></option>
								<option value="private"><?php echo $lang_albums['ALBUM_PRIVATE'];?></option>
							</select>
						</div>
						<a class="black-button hcClose" href="#">OK</a>
					</div>
					</li>
					<?php if(!$is_guest):?>
					<li>
						<a class="hcSwitcher" href="#"><?php echo $language['ALBUM'];?></a>
						<div class="hcArea">
							<div class="input"><?php echo $albums;?></div>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<?php endif;?>
					<li>
						<a class="hcSwitcher" href="#"><?php echo $language['TAGS'];?></a>
						<div class="hcArea">
							<div class="input"><?php echo $tags;?></div>
							<div class="field children_tags" style="display: none;">
								<div class="input"></div>
							</div>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="td">
				<ul class="hidden-controls">
				<li></li>
				<li><a href="javascript:void(0);" onclick="delete_preupload(this);return false;" style="color:red;"><?php echo $lang_main['DELETE'];?></a></li>
				<li></li>
				</ul>
			</div>
			<div class="td progressbar" style="display: none;">
                <span class="fade"><div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div></span>
            </div>
            {% } %}
        {% } %}
    </div>
{% } %}
</script>
<script src="<?php echo $THEME;?>/js/rotate.js"></script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<div class="tr template-upload fade" id="checker">
		{% if (file.error) { %}
            <div class="td error"><span class="fade">{%=file.error%}</span></div>
        {% } else if (o.files.valid && !i) { %}
			{% if (!o.options.autoUpload) { %}
			<button class="start hidden"></button>
			<button class="cancel hidden"></button>
			<div class="td preview"><span class="fade"></span></div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li>
						<a class="hcSwitcher" href="#">Изменить размер</a>
						<div class="hcArea">
							<input class="edit" type="text" name="RESIZE_TO[]" value="" size="5" />
							<select class="combobox" name="RESIZE_WHAT[]">
								<option value="none"></option>
								<option value="height">высота</option>
								<option value="width">ширина</option>
							</select>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#">Название</a>
						<div class="hcArea">
							<input class="edit" type="text" name="NAME[]" value="" size="16" />
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#">Комментарий</a>
						<div class="hcArea">
							<textarea class="memo" name="DESCRIPTION[]" cols="35" rows="2" ></textarea>
							<div class="center"><a class="black-button hcClose" href="#">OK</a></div>
						</div>
					</li>
				</ul>
			</div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li>
						<span>Поворот</span>
						<a class="left90" href="#" title="На 90° против часовой"></a>
						<a class="right90" href="#" title="На 90° по часовой"></a>
						<input type="hidden" name="ROTATE[]" value="0" class="ROTATE"/>
					</li>
					<li>
						<a class="hcSwitcher" href="#">Конвертировать</a>
						<div class="hcArea">
							<select class="combobox" name="CONVERT_TO[]" class="CONVERT_TO">
								<option value=""></option>
								<option value="jpg">JPG</option>
								<option value="png">PNG</option>
								<option value="gif">GIF</option>
							</select>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li><a class="hcSwitcher" href="#">Водяной знак</a></li>
				</ul>
			</div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li><a class="hcSwitcher" href="#">Доступ</a></li>
					<li>
						<a class="hcSwitcher" href="#">Альбом</a>
						<div class="hcArea">
							
							
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#">Превью</a>
						<div class="hcArea">
							<input class="edit" type="text" name="PREVIEW_WIDTH[]" value="" size="5" placeholder="Ш" />
							<input class="edit" type="text" name="PREVIEW_HEIGHT[]" value="" size="5" placeholder="В" />
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="td progressbar" style="display: none;">
                <span class="fade"><div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div></span>
            </div>
            {% } %}
        {% } %}
    </div>
{% } %}
</script>
<!-- The template to display uploaded files -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="tr template-upload fade">
        {% if (file.error) { %}
            <div class="td name"><span>{%=file.name%}</span></div>
            <div class="td size"><span>{%=o.formatFileSize(file.size)%}</span></div>
            <div class="td error">{%=file.error%}</div>
        {% } else { %}
			{% if (file.thumbnail_url) { %}
            <div class="td preview"><span class="fade"><a href="{%=file.imglink%}" onclick="show_image(this);return false;"><img src="{%=file.thumbnail_url%}" width="{%=file.thumbnail_width%}" height="{%=file.thumbnail_height%}"></a></span></div>
			{% } %}
			
            <div class="td name" style="margin-left:-30px;">
				<span class="fade"><a class="jsAction" href="javascript:void(0);" onclick="show_links_multiply(this);" ><?php echo $language['SHOW_LINKS'];?></a></span>
				<div class="modal-wnd inplace">
					
					<div class="popup-links">
					{% if (file.tiny_static) { %}
					 <div style="margin-bottom:15px; font-size: 14px;"><span  class="tiny_links" onclick="set_links(this,'tiny');return false;">Короткие ссылки</span><span class="standard_links links-tabs" onclick="set_links(this,'standard');return false;" style="margin-left:20px;">Стандартные ссылки</span></div>
					  {% } else { %}
					
					 <div style="margin-bottom:15px; font-size: 14px;"><span class="standard_links" onclick="set_links(this,'standard');return false;">Стандартные ссылки</span><span style="margin-left:20px;" class="tiny_links links-tabs" onclick="set_links(this,'tiny');return false;">Короткие ссылки</span></div>
					{% } %}
					
						<ul>
							{% if (file.tiny_static) { %}
							<li>
								<em><?php echo $language['SHOW_LINK'];?></em>
								<input class="edit autoselect mainurl" type="text" value="{%=file.short_imglink_html%}" size="75" readonly style="text-transform: lowercase;" id="show_link" data-position="0" data-value="{%=file.imglink_html%}"/>
							</li>
							  {% } else { %}
							
							<li>
								<em><?php echo $language['SHOW_LINK'];?></em>
								<input class="edit autoselect mainurl" type="text" value="{%=file.imglink_html%}" size="75" readonly style="text-transform: lowercase;" id="show_link" data-position="0" data-value="{%=file.short_imglink_html%}"/>
							</li>
							
							{% } %}
							
							{% if (file.tiny_static) { %}
							<li>
								<em><?php echo $language['DIRECT_LINK'];?></em>
								<input class="edit autoselect imgurl" type="text" value="{%=file.short_imglink%}" size="75" readonly style="text-transform: lowercase;" id="direct_link" data-position="1" data-value="{%=file.imglink%}"/>
							</li>
							  {% } else { %}
							
							<li>
								<em><?php echo $language['DIRECT_LINK'];?></em>
								<input class="edit autoselect imgurl" type="text" value="{%=file.imglink%}" size="75" readonly style="text-transform: lowercase;" id="direct_link" data-position="1" data-value="{%=file.short_imglink%}"/>
							</li>
							
							{% } %}
							
							{% if (file.tiny_static) { %}
							<li>
								<em><?php echo $language['PREVIEW_LINK_BB'];?></em>
								<input class="edit autoselect imgurl" type="text" value="{%=file.short_imglink_preview_bb%}" size="75" readonly style="text-transform: lowercase;" id="preview_link_bb" data-position="2" data-value="{%=file.imglink_preview_bb%}"/>
							</li>
							  {% } else { %}
							
							<li>
								<em><?php echo $language['PREVIEW_LINK_BB'];?></em>
								<input class="edit autoselect imgurl" type="text" value="{%=file.imglink_preview_bb%}" size="75" readonly style="text-transform: lowercase;" id="preview_link_bb" data-position="2" data-value="{%=file.short_imglink_preview_bb%}"/>
							</li>
							
							{% } %}
							

							{% if (file.tiny_static) { %}
							<li>
								<em><?php echo $language['PREVIEW_LINK_HTML'];?></em>
								<input class="edit autoselect imgurl" type="text" value="{%=file.short_imglink_preview_html%}" size="75" readonly style="text-transform: lowercase;" id="preview_link_html" data-position="2" data-value="{%=file.imglink_preview_html%}"/>
							</li>
							  {% } else { %}
							
							<li>
								<em><?php echo $language['PREVIEW_LINK_HTML'];?></em>
								<input class="edit autoselect imgurl" type="text" value="{%=file.imglink_preview_html%}" size="75" readonly style="text-transform: lowercase;" id="preview_link_html" data-position="2" data-value="{%=file.short_imglink_preview_html%}"/>
							</li>
							
							{% } %}
							
							{% if (file.tiny_static) { %}
							<li>
								<em><?php echo $language['BB_CODE_LINK'];?></em>
								<input class="edit autoselect imgurl" type="text" value="[IMG]{%=file.short_imglink%}[/IMG]" size="75" readonly style="text-transform: lowercase;" id="bb_code" data-position="2" data-value="[IMG]{%=file.imglink%}[/IMG]"/>
							</li>
							  {% } else { %}
							
							<li>
								<em><?php echo $language['BB_CODE_LINK'];?></em>
								<input class="edit autoselect imgurl" type="text" value="[IMG]{%=file.imglink%}[/IMG]" size="75" readonly style="text-transform: lowercase;" id="bb_code" data-position="2" data-value="[IMG]{%=file.short_imglink%}[/IMG]"/>
							</li>
							
							{% } %}
							

							{% if (file.tiny_url) { %}
            					<li>
								<em><?php echo $language['TINY_URL'];?></em>
								<input class="edit autoselect" type="text" value="{%=file.tiny_url%}" size="75" readonly id="tiny_url" data-position="2"/>
								</li>
							{% } %}
							
						</ul>
						<a class="black-button close-wnd" href="javascript:void(0);" onclick="nd();">Закрыть</a>
					</div>
				</div>

			</div>
            <div class="td size" style="margin-left:-30px;"><span class="fade">{%=o.formatFileSize(file.size)%}</span></div>
			<div class="td" style="margin-left:-40px;">
                <span class="fade"><div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:100%;"></div></div></span>
            </div>
			<div class="td">
					<ul class="hidden-controls">
						<li></li>
						<li><a href="/images/delete/{%=file.id%}" onclick="delete_from_multiupload(this,'<?php echo $lang_image['CONFIRM_DELETE']?>');return false;" style="color:red;" title="<?php echo $lang_main['DELETE']?>"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" /></a></li>
						<li></li>
					</ul>
			</div>
        {% } %}
    </div>
{% } %}
</script>
<div id="container_modal" style="display:none;"></div>

