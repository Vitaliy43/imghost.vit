var ajax_process = 0;
var current_times = new Array();
var time_waiting = 60;
var position = 1;
var img_timeout;
var from_big = false;
var num_uploaded_urls = 0;

var $AjaxManager = new function() {
	var $Events = new Array('onAfterAjaxOutput', 'onBeforeAjaxOutput');
	var $postedForm = false;
	var t;
	
	var executeEventHandler = function($event, $params, $component, $form) {
		if (isset($Events[$event])) {
			for ($i = 0; $i < $Events[$event].length; $i++) {
				$Events[$event][$i]($params, $component, $form);
			}
		}
	}
	
	this.processOutput = function($data, $status, $xhr) {
		var $rtype = $xhr.getResponseHeader('X-RESPONSE-TYPE');
		if ($rtype == 'json') {
			var $json = eval_json($data);
			if (isset($json.FUNCTION)) {
				window[$json.FUNCTION]($json, $postedForm);
			}
		} else if ($rtype == 'html') {
			var $comp = $xhr.getResponseHeader('X-COMPONENT-ID');
			executeEventHandler('onBeforeAjaxOutput', $data, $comp, $postedForm);
			var $jqComp = $('#comp-' + $comp);
			if ($jqComp.attr('data-lock') != 'Y')
				$('#comp-' + $comp).html($data);
			else
				unlockComponent($comp);
			executeEventHandler('onAfterAjaxOutput', $data, $comp, $postedForm);
		}
		$postedForm = false;
	}
	
	function OutputUploadAvatar($data){
		$('#user_avatar img').attr({src: $data.image});
		if($('.avatar img').length > 0)
			$('.avatar img').attr({src: $data.image});
		else
			$('.personal-top').prepend('<div class="avatar"><img width="50" height="50" src="'+$data.image+'"></div>');
			
		$('#container_filename .input_filename').hide();

	}
	
	function edit_uploaded_image(form_id){
		
		var RESIZE_TO_WIDTH = $('#form'+form_id+'[name="RESIZE_TO_WIDTH"]').val();
		var RESIZE_TO_HEIGHT = $('#form'+form_id+'[name="RESIZE_TO_HEIGHT"]').val();
		var ROTATE = $('#form'+form_id+'[name="RESIZE_TO_HEIGHT"] option:selected').val();
		var ACCESS = $('#form'+form_id+'[name="ACCESS"] option:selected').val();
		var NAME = $('#form'+form_id+'[name="NAME"]').val();
		var WATERMARK = $('#form'+form_id+'[name="WATERMARK"]').val();
		var DESCRIPTION = $('#form'+form_id+'[name="DESCRIPTION"]').val();
		var TAGS = $('#form'+form_id+'[name="TAGS"] option:selected').val();
		var CONVERT_TO = $('#form'+form_id+'[name="CONVERT_TO"] option:selected').val();
		var url = $('#form'+form_id).attr('action');
		name = encodeURIComponent(name);
		watermark = encodeURIComponent(watermark);
		description = encodeURIComponent(description);
		
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'RESIZE_TO_WIDTH='+RESIZE_TO_WIDTH+'&RESIZE_TO_HEIGHT='+RESIZE_TO_HEIGHT+'&ROTATE='+ROTATE+'&ACCESS='+ACCESS+'&NAME='+NAME+'&WATERMARK='+WATERMARK+'&DESCRIPTION='+DESCRIPTION+'&TAGS='+TAGS+'&CONVERT_TO='+CONVERT_TO,
    	cache: false,
		beforeSend:function(){
			before_upload(form_id);
		},
		error: function(){
			alert('Ошибка загрузки!');
		},
    	success: function($data){
			
			$('#form'+$data.form_number+' .filename .cell').html($data.image);
				$('#form'+$data.form_number+' .is_uploaded').val(1);
				$('#form'+$data.form_number+' .is_progress').val(0);
				$('#form'+$data.form_number+' .submit').show();
		}
	});	

	}
	
	function SuccessUpload($data){
		ajax_process = 0;
		if($data.avatar == 1){
			OutputUploadAvatar($data);
			return false;
		}
		if($('#form'+$data.form_number).find('#edit_file').length > 0){
			$('#form'+$data.form_number).find('#edit_file').show();
		}
		
		if($data.form_number == 'upload-multi-links'){
			$('#upload-multi-links #upload-result').html($data.content);
			var from_edit = $('#from_edit').val();
			group_links('multiple');

		}
		else{
			$('#all_submit').html('<input type="submit" value="Загрузить" class="black-button">');

			if($data.error==''){
				if($('#form'+$data.form_number+' .imglink').length > 0){
					$('#form'+$data.form_number+' .imglink').html($data.imglink);
					
				}
				else{
					if($('#form'+$data.form_number+' .inplace').length > 0){
						
					}
					else{
						$('#form'+$data.form_number+' .black-button').before($data.content);

					}
				}
				$('#form'+$data.form_number+' .filename .cell').html($data.image);
				var msg = 'Вы уверены, что хотите удалить данный файл?';
				if($data.role == 'guest'){
					var href = '/images_guest/delete/'+$data.id;
				}
				else{
					var href = '/images/delete/'+$data.id;
				}
				if(typeof(from_edit_fast) != 'undefined' && from_edit_fast == '1' && typeof(torrent_id) != 'undefined'){
					$('#form'+$data.form_number+' .filename .cell').next().html('<a onclick="delete_cover_from_seedoff_edit(this,\''+msg+'\');return false;" href="'+href+'?token='+token+'&torrent_id='+torrent_id+'" style="margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" title="Удалить изображение"/></span>');
				}
				else{
					$('#form'+$data.form_number+' .filename .cell').next().html('<a onclick="delete_image_from_fast(this,\''+msg+'\');return false;" href="'+href+'" style="margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" title="Удалить изображение"/></span>');
				}
				
				$('#form'+$data.form_number+' .resize').show();
				$('#form'+$data.form_number+' input[name="RESIZE_TO_HEIGHT"]').closest('.field').css({'margin-bottom' : '7px'});
				$('#form'+$data.form_number+' input[name="RESIZE_TO_WIDTH"]').val($data.width);
				$('#form'+$data.form_number+' input[name="RESIZE_TO_HEIGHT"]').val($data.height);
				var proportion = $data.height / $data.width;
				proportion = proportion.toFixed(3);
				$('#form'+$data.form_number+' .proportion').val(proportion);
				$('#form'+$data.form_number+' .container_constrain').css({'margin-bottom' : '20px'});
				$('#form'+$data.form_number+' .is_uploaded').val(1);
				$('#form'+$data.form_number+' .is_progress').val(0);
				
				if(typeof(from_edit_fast) != 'undefined' && from_edit_fast == '1'){
					$('#current_url').val($data.imglink);
					$('#form'+$data.form_number+' .choose-source').hide();
					$('.uploadForm #form_action').val('Редактировать');
					type_operation = 'edit';
				}

				if($data.link != ''){
					$('#form'+$data.form_number).append('<input type="hidden" name="FROM_UPLOAD" value="1" class="from_upload"/>');
					$('#form'+$data.form_number).attr({action : $data.link});
				}
				group_links('fast');
			}
			else{
				alert($data.error);
				

				if(typeof(is_cover) != 'undefined'){
					if(typeof(type_operation) != 'undefined' && type_operation == 'edit'){
						$('.ajax_loader').replaceWith('<input type="submit" value="Редактировать" class="black-button" id="form_action">');
						return false;
	
					}
						$('#form'+$data.form_number+' .cell').html('');
						$('#form'+$data.form_number+' .cimage').html('');
				}
				else{
						$('#form'+$data.form_number+' .cell').html('');
						$('#form'+$data.form_number+' .cimage').html('');
					
						$('#form'+$data.form_number+' .hidden').hide();
						$('#form'+$data.form_number+' .choose-source').show();
						$('#form'+$data.form_number).find('.ajax_loader').remove();
						$('#form'+$data.form_number+' .is_progress').val(0);
				}
				
			}
			
		}
		
		if($data.error == ''){

			if($('.header_links').length > 0){
				
			}
			else{
				if($data.role == 'guest')
					$('.ctrls .wrap960 .auth').after('<div class="header_links"><a href="/profile">Мои загрузки</a></div>');
			}
		}	
		var num_all = $('.uploadForm').size();
		var num_uploaded = $('.uploadForm .filename a').size();
		if(num_all == num_uploaded)	{
			$('#all_submit').hide();
		}
		
		if(typeof(type_operation) != 'undefined' && type_operation == 'upload'){
			$('.ajax_loader').replaceWith('<input type="submit" value="Загрузить" class="black-button" id="form_action">');
		}
		else if(typeof(type_operation) != 'undefined' && type_operation == 'edit'){
			$('.ajax_loader').replaceWith('<input type="submit" value="Редактировать" class="black-button" id="form_action">');

		}
		else{
			if(typeof(from_edit_fast) != 'undefined'){
				$('#all_submit').remove();
				$('.ajax_loader').replaceWith('<input type="submit" value="Редактировать" class="black-button" id="form_action">');
				$('#form_action').parent().css('margin-top','30px');
			}
		}
	}
	
	this.OutputUpload = function($data, $status, $xhr) {
		ajax_process = 0;
		if($data.avatar == 1){
			OutputUploadAvatar($data);
			return false;
		}
		
		if($data.form_number == 'upload-multi-links'){
			$('#upload-multi-links #upload-result').html($data.content);
			var from_edit = $('#from_edit').val();

		}
		else{
			$('#all_submit').html('<input type="submit" value="Загрузить" class="black-button">');

			if($data.error==''){
				if($('#form'+$data.form_number+' .imglink').length > 0){
					$('#form'+$data.form_number+' .imglink').html($data.imglink);
					
				}
				else{
					if($('#form'+$data.form_number+' .inplace').length > 0){
						
					}
					else{
						$('#form'+$data.form_number+' .black-button').before($data.content);

					}
				}
				$('#form'+$data.form_number+' .filename .cell').html($data.image);
				var msg = 'Вы уверены, что хотите удалить данный файл?';
				if($data.role == 'guest'){
					var href = '/images_guest/delete/'+$data.id;
				}
				else{
					var href = '/images/delete/'+$data.id;
				}
				
				$('#form'+$data.form_number+' .filename .cell').next().html('<a onclick="delete_image_from_fast(this,\''+msg+'\');return false;" href="'+href+'" style="margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" title="Удалить изображение"/></span>');
				$('#form'+$data.form_number+' .resize').show();
				$('#form'+$data.form_number+' input[name="RESIZE_TO_HEIGHT"]').closest('.field').css({'margin-bottom' : '7px'});
				$('#form'+$data.form_number+' input[name="RESIZE_TO_WIDTH"]').val($data.width);
				$('#form'+$data.form_number+' input[name="RESIZE_TO_HEIGHT"]').val($data.height);
				var proportion = $data.height / $data.width;
				proportion = proportion.toFixed(3);
				$('#form'+$data.form_number+' .proportion').val(proportion);
				$('#form'+$data.form_number+' .container_constrain').css({'margin-bottom' : '20px'});
				$('#form'+$data.form_number+' .is_uploaded').val(1);
				$('#form'+$data.form_number+' .is_progress').val(0);
				$('#form'+$data.form_number+' .submit').show();
				
				if(typeof(from_edit_fast) != 'undefined' && from_edit_fast == '1'){
					$('#current_url').val($data.imglink);
					$('#form'+$data.form_number+' .choose-source').hide();
					$('#form'+$data.form_number+' .black-button').val('Редактировать');
					$('.uploadForm #form_action').val('Редактировать');
					type_operation = 'edit';
				}

				if($data.link != ''){
					$('#form'+$data.form_number).append('<input type="hidden" name="FROM_UPLOAD" value="1" class="from_upload"/>');
					$('#form'+$data.form_number).attr({action : $data.link});
				}
				group_links('fast');
			}
			else{
				alert($data.error);
				$('#form'+$data.form_number+' .hidden').hide();
				$('#form'+$data.form_number+' .choose-source').show();
				$('#form'+$data.form_number).find('.ajax_loader').remove();
				$('#form'+$data.form_number+' .is_progress').val(0);
			}
			
		}
		
		if($data.error == ''){

			if($('.header_links').length > 0){
				
			}
			else{
				if($data.role == 'guest')
					$('.ctrls .wrap960 .auth').after('<div class="header_links"><a href="/profile">Мои загрузки</a></div>');
			}
		}	
		var num_all = $('.uploadForm').size();
		var num_uploaded = $('.uploadForm .filename a').size();
		if(num_all == num_uploaded)	{
			$('#all_submit').hide();
		}

	}
	
	this.sendComponent = function($url, $data) {
		var $adata = { __AJAX: 'Y' };
		jQuery.extend($adata, $data);
		$.ajax({
			url: $url,
			data: { __AJAX: 'Y' },
			success: this.processOutput
		});
	}
	
	
	
	this.sendForm = function($form) {
		$postedForm = $form;
		var form_id = $form.attr('id');

		if(upload_by_one == '1' && form_id == 'upload-multi-links'){
			upload_from_internet();
			return false;
		}
		var form_action = $form.attr('action');
		if($('#form'+form_id).find('.from_upload').length > 0){
			edit_uploaded_image(form_id);
			return false;
		}
				
		$form.ajaxSubmit({
			data: { __AJAX: 'Y' },
			dataType: 'json',
			cache: false,
			before: before_upload(form_id),
			error: function (data, status)
			 	{
					if(status == 'error')
						ajax_submit($form,this);
				}
			,
			success: function (data, status)
			 	{
					SuccessUpload(data);
				}
			
		});
		
					
	}
	
	function ajax_submit($form,object){
		
		$postedForm = $form;
		var form_id = $form.attr('id');
		var form_action = $form.attr('action');
		if($('#form'+form_id).find('.from_upload').length > 0){
			edit_uploaded_image(form_id);
			return false;
		}
		
		
		$form.ajaxSubmit({
			data: { __AJAX: 'Y' },
			dataType: 'json',
			cache: false,
			before: before_upload(form_id),
			error: function (data, status)
			 	{
					if(status == 'error')
						error_uploaded(form_id);
				}
			,
			success: function (data, status)
			 	{	
					SuccessUpload(data);
				}
		});
	}
	
	
	this.registerEventHandler = function($event, $callback) {
		if (!isset($Events[$event]))
			$Events[$event] = new Array();
		if (jQuery.inArray($callback, $Events[$event]) == -1)
			$Events[$event].push($callback);
	}
	
	this.unregisterEventHandler = function($event, $callback) {
		if (isset($Events[$event])) {
			var $index = jQuery.inArray($callback, $Events[$event]);
			if ($index > -1) {
				$Events[$event].splice($index, 1);
			}
		}
	}
}

$(function() {
	$(document).on('submit', '.ajaxForm', function(e) {
		e.preventDefault();
		$AjaxManager.sendForm($(this));
	});
	
	$(document).on('click', '#all_submit input', function(e) {
		e.preventDefault();
		var uploaded = false;
		$('.ajaxForm').each(function(){
			var form_id = $(this).attr('id');
			if($(this).find('.filename .cell a').length > 0){
				
			}
			else{
				if($('#'+form_id+' .source-remote-url').is(':visible') == true){
				if($('#'+form_id+'[name="FILE_URL"]').html() != '' && form_id != 'upload-multi-links'){
				uploaded = true;
				$AjaxManager.sendForm($(this));
				}
			}
			else{
				if($('#'+form_id+' .filename .cell').html() != '' && form_id != 'upload-multi-links'){
				uploaded = true;
				$AjaxManager.sendForm($(this));
				}
			}
			
			}
			

	});
		if(uploaded == false){
			alert('Не загружено ни одного файла!');
			$('.submit').html('<input type="submit" value="Загрузить" class="black-button" />');
			return false;
		}
		$AjaxManager.sendForm($(this));
	});
	
	
	$(document).on('click', '.ajaxLink', function(e) {
		e.preventDefault();
		$AjaxManager.sendComponent($(this).attr('href'));
	});
});

function error_uploaded(form_id){

	$('#all_submit').html('<input type="submit" value="Загрузить" class="black-button">');
	$('#'+form_id+' .hidden').hide();
	$('#'+form_id+' .choose-source').show();
	$('#'+form_id).find('.ajax_loader').remove();
	$('#'+form_id+' .is_progress').val(0);
	alert('Неизвестная ошибка!');
}

function get_progress(form_id){

	$.ajax({
        url: '/uploads/progress.php',
        dataType: 'json',
        success: function(data){
            if(data.percent) {
				if(data.percent == 100)
					return;
				$('#form'+form_id+' .percent').text(data.percent+'%');
            }
        }
    });

}

function clean_form(form_id){
	if(typeof(form_id) == 'object'){
		form_id = form_id.id;

	}
	if($('#'+form_id).find('.source-remote-url').is(':visible')){
		current_time = Math.round(new Date().getTime()/1000.0);
		var differ = current_time - current_times[form_id];
		if(ajax_process == 1 && differ >= time_waiting){
			error_uploaded(form_id);
		}
	}

}

function check_num_upload_pictures(num){
	var current_num = $('#upload-multi-links #upload-drop-zone .tr').size();
	if(current_num >= num)
		$('#upload-multi-links .caption-text').hide();

	
}

function upload_from_internet(){
	var buffer_links = $('#upload-multi-links .memo').val();
	var enable_memo = $('#upload-multi-links #enable_memo').val();
	var links = buffer_links.split("\n");
	var url = $('#upload-multi-links').attr('action');
	var all_links = links.length;
	var current_num_links = 0;
	if(enable_memo == 0)
		return false;

	$('#upload-multi-links #upload-result').append('<div id="upload-drop-zone" class="listbox files result_internet"></div>');
	
	for(var i = 0; i < links.length; i++){
		
		var url = $('#upload-multi-links').attr('action');

		
		var parameters = '';
		parameters += '&RESIZE_TO_WIDTH='+$('#edit_fields').find('.RESIZE_TO_WIDTH').val();
		parameters += '&RESIZE_TO_HEIGHT='+$('#edit_fields').find('.RESIZE_TO_HEIGHT').val();
		if(typeof($('#edit_fields').find('.PREVIEW_WIDTH').val()) != 'undefined')
			parameters += '&PREVIEW_WIDTH='+$('#edit_fields').find('.PREVIEW_WIDTH').val();
		else
			parameters += '&PREVIEW_WIDTH=0';
		if(typeof($('#edit_fields').find('.PREVIEW_HEIGHT').val()) != 'undefined')
			parameters += '&PREVIEW_HEIGHT='+$('#edit_fields').find('.PREVIEW_HEIGHT').val();
		else
			parameters += '&PREVIEW_HEIGHT=0';
		if(typeof($('#edit_fields').find('.TINY_URL').val()) != 'undefined')
			parameters += '&TINY_URL='+$('#edit_fields').find('.TINY_URL').val();
		parameters += '&ROTATE='+$('#edit_fields').find('.ROTATE').val();
		parameters += '&JPEG_QUALITY='+$('#edit_fields').find('.JPEG_QUALITY').val();
		parameters += '&CONVERT_TO='+$('#edit_fields').find('.CONVERT_TO option:selected').val();
		parameters += '&WATERMARK='+$('#edit_fields').find('.WATERMARK').val();
		parameters += '&ACCESS='+$('#edit_fields').find('.ACCESS option:selected').val();
		parameters += '&ALBUMS='+$('#edit_fields').find('.ALBUMS option:selected').val();
		parameters += '&TAGS='+$('#edit_fields').find('.TAGS option:selected').val();
		var position = i + 1;
		if(url.indexOf('torrent_id') != -1)
			url += '&position='+position;
		else
			url += '?position='+position;

		
		$.ajax({
			type: "POST",
   	 		url: url,
			dataType: 'json',
			data: 'upload_by_one=1&FILE_URL='+links[i]+parameters,
    		cache: false,
			beforeSend:function(){
				$('#upload-multi-links .caption-text').show();
				$('#upload-multi-links .caption-text').text('Подождите, идет загрузка...');
			},
			error: function(){
				$('#upload-multi-links .caption-text').hide();
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				
				if($('#upload-multi-links').find('#summary_links_multiple').length >= 1){
					$('#upload-multi-links #upload-drop-zone').append(data.content);
				}
				else{

					$('#upload-multi-links #upload-result').before(data.wrapper);
					$('#upload-multi-links #upload-drop-zone').append(data.content);

				}
				$('#upload-multi-links #upload-result').find('.memo').hide();

				check_num_upload_pictures(links.length);

				current_num_links++;
				if(current_num_links >= all_links)
					group_links('multiple');
			}
    		});	
	}
}

function before_upload(form_id){
	
	ajax_process = 1;
	if(typeof(form_id) == 'object'){
		form_id = form_id.id;

	}
	
	if($('#form'+form_id).find('#edit_file').length > 0){
			$('#form'+$data.form_number).find('#edit_file').hide();
		}
	
	current_times[form_id] = Math.round(new Date().getTime()/1000.0);
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var	ajax_url_big = '/templates/imghost/images/ajax-loaders/big.gif';
	if(form_id == 'upload-multi-links'){
		if($('#upload-multi-links .memo').val() == ''){
			alert('Нет ссылок для загрузки!');
			return false;
		}
		$('#upload-multi-links .caption-text').text('Подождите, идет загрузка...');

	}
	else{
		if($('#'+form_id).parent().hasClass('item_cover')){
			$('.submit').html('<div class="ajax_loader" style="padding:5px;"><img src="'+ajax_url+'"></div>');
		}
		else{
			$('#'+form_id+' .submit').show();

		}
		$('#all_submit').html('<div class="ajax_loader" style="padding:5px;"><img src="'+ajax_url+'"></div>');
		setTimeout('clean_form('+form_id+');',time_waiting * 1000);
	}
	
}
function overDiv_stylize(){
	$('#overDiv .popup-links').css({'font-size':'12px','font-weight':'bold','padding':'15px','border-radius':'8px','box-shadow':'0 0 13px #323232'});
	$('#overDiv .popup-links ul li').css({'margin-bottom':'10px'});
	$('#overDiv .popup-links ul').css({'list-style-type':'none'});
	$('#overDiv .popup-links input').css({'border':'1px solid #000','padding':'3px','font-weight':'bold'});
}

function show_links_multiply(object){
	var content = $(object).parent().next().html();
	overlib(content,STICKY,RIGHT);
	overDiv_stylize();
}

function zoom_item(object){
	$(object).attr('width',180);
	$(object).parent().attr('max-width',184);

}

function default_width_item(object){
	$(object).attr('width',50);
	$(object).parent().attr('max-width',54);

}

function show_summary_links(object){
	
	var content = $(object).parent().next().html();
	overlib(content,STICKY,RIGHT);
	overDiv_stylize();
}

function show_links_profile(object){
	
	var content = $(object).parent().next().html();
	overlib(content,STICKY,RIGHT);
	overDiv_stylize();
}

function show_links(object){

	var form_id = $(object).closest('.ajaxForm').attr('id');
	var content = $('#'+form_id+' .inplace').html();
	overlib(content,STICKY,RIGHT);
	overDiv_stylize();

}

function correct_proportion(object){
	if($(object).val() <= 0.1)
		$(object).val(0.1);
}

function set_align(object){
	var option = $(object).find('option:selected').val();
	if(option == 0){
		$(object).parent().parent().parent().next().show();
		$(object).closest('.upload_template').find('#resize_to_height').parent().parent().parent().show();
		$(object).closest('.upload_template').find('#resize_to_width').parent().parent().parent().show();

	}
	else{
		$(object).parent().parent().parent().next().hide();
		if(option == 'by_width'){
			$(object).closest('.upload_template').find('#resize_to_width').parent().parent().parent().show();
			$(object).closest('.upload_template').find('#resize_to_height').parent().parent().parent().hide();
		}
		else if(option == 'by_height'){
			$(object).closest('.upload_template').find('#resize_to_width').parent().parent().parent().hide();
			$(object).closest('.upload_template').find('#resize_to_height').parent().parent().parent().show();

		}
		
	}
}

function constrain_proportions(object,type){
	
	if($(object).closest('#sb-wrapper').length > 0){
		if($(object).closest('.upload_template').length > 0){
			var form = '.upload_template';

		}
		else if($(object).closest('#edit_image').length > 0){
			var form = '#edit_image';

		}
		
	}
	else{
		var form = '.uploadForm';

	}
	
		var width = $(object).closest(form).find('input[name="RESIZE_TO_WIDTH"]').val();
		var height = $(object).closest(form).find('input[name="RESIZE_TO_HEIGHT"]').val();
		var old_proportion = $(object).closest(form).find('.proportion').val();

		if(form == '.upload_template'){
			var proportion = $(object).closest(form).find('#set_proportion').val();
			if(proportion <= 0)
				proportion = 0.1;
			if(width == 0 && height == 0){
				
			}
			else if(width == 0){
				width = Math.round(height / proportion);
				$(object).closest(form).find('input[name="RESIZE_TO_WIDTH"]').val(width);
			}
			else if(height == 0){
				height = Math.round(width * proportion);
				$(object).closest(form).find('input[name="RESIZE_TO_HEIGHT"]').val(height);

			}
			else{
				var old_proportion = width / height;
				if(old_proportion != proportion){
					height = Math.round(width * proportion);
					$(object).closest(form).find('input[name="RESIZE_TO_HEIGHT"]').val(height);
				}
			}
		}
		else{
			if(width < 1)
				width = 1;
			if(height < 1)
				height = 1;

			var new_proportion = height / width;
			new_proportion = new_proportion.toFixed(3);
			if($(object).closest(form).find('#constrain').prop('checked') == true){
			
			if(new_proportion != old_proportion){
				if(type == 'width')
					height = Math.round(width * old_proportion);
				else
					width = Math.round(height / old_proportion);
				$(object).closest(form).find('input[name="RESIZE_TO_WIDTH"]').val(width);
				$(object).closest(form).find('input[name="RESIZE_TO_HEIGHT"]').val(height);
			}
			}
		}
		
			
}

function set_rotate(object){
	var degree = $(object).val();
	if(degree < 0)
		degree = 360 + degree;
	if(degree > 360)
		degree = degree - 360;
	$(object).val(degree);
}


function free_rotate(object){
	
	var selected = $(object).find('option:selected').val();
	if(selected == 'free'){
		$(object).next().show();
	}
	else{
		$(object).next().hide();
	}
	
}

function free_rotate_template(object){
	
	var selected = $(object).find('option:selected').val();
	if(selected == 'free'){
		$(object).next().show();
	}
	else{
		$(object).next().hide();
	}
	resize_modal();
}

function load_gallery_from_delete(object){
	
	var cur_page = $(object).closest('.list-item').attr('data-page');
	var all_uploaded = $('#all_uploaded').val();
	var items = $('#container_gallery .list-item').size();
	var new_page = ($('#current_page').val())*1 + 1;
	var num_pages = $('.curpage_'+new_page).size();
	if(items < all_uploaded){
		if(num_pages == 0){
			if($('#container_album_info').length > 0)
				load_more_album(new_page);
			else
				load_more(new_page);

		}
	}
	var container = $(object).closest('.list-item').html();
	$.ajax({
			type: "POST",
   	 		url: '/gallery/'+add_url+new_page,
			dataType: 'json',
			data: 'is_ajax=1&is_load_more=1'+popular_tags,
    		cache: false,
			beforeSend:function(){
				$(object).closest('.list-item').html('<div class="list-item c7 gutter-margin-right-bottom privacy-public" data-id="" data-type="image"><div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div></div>');	
			},
			error: function(){
				$(object).closest('.list-item').html(container)
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				$('#container_gallery .ajax_loader').parent().remove();
				if(data.answer == 1){
					
					document.location.href = '/gallery';
				}
				else{
					
				$(object).closest('.list-item').html(container)
				alert('Ошибка загрузки!');				}
			
			}
    		});	
}

function load_gallery(){
	var all_uploaded = $('#all_uploaded').val();
	var items = $('#container_gallery .list-item').size();
	var new_page = ($('#current_page').val())*1 + 1;
	var num_pages = $('.curpage_'+new_page).size();
	if(items < all_uploaded){
		if(num_pages == 0){
			if($('#container_album_info').length > 0)
				load_more_album(new_page);
			else
				load_more(new_page);

		}
	}
}

function batch_editing(object){
	if($(object).prop('checked') == true){
		$(object).closest('#left_block').next().find('#list_templates').prop('disabled',false);
	}
	else{
		$(object).closest('#left_block').next().find('#list_templates').prop('disabled',true);

	}

}

function reset_fields(){

	$('.RESIZE_TO_HEIGHT').val(0);
	$('.PREVIEW_HEIGHT').val(0);
	$('.RESIZE_TO_WIDTH').val(0);
	$('.PREVIEW_WIDTH').val(0);
	$('.TINYURL').val(0);
	$('.ROTATE').val(0);
	$('.CONVERT_TO').val('');
	$('.WATERMARK').val('');
	$('.ALBUMS').val(0);
	$('.TAGS').val(0);
	$('.JPEG_QUALITY ').val(100);
	$('.ACCESS').val('public');
}


function get_template_info(template_id,word,from_upload){
	
	var url = '/upload/apply_template/'+template_id;
	if(typeof(torrent_id) != 'undefined' && typeof(token) != 'undefined')
		url += '?torrent_id='+torrent_id+'&token='+token;
	
	$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#ajax_template_info').show();
		},
		error: function(){
			$('#ajax_template_info').hide();
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$('#ajax_template_info').hide();

			if(from_upload == 0){
				if(typeof(data.RESIZE_TO_WIDTH) != 'undefined'){
					$('.RESIZE_TO_WIDTH').val(data.RESIZE_TO_WIDTH);
				}
				if(typeof(data.RESIZE_TO_HEIGHT) != 'undefined'){
					$('.RESIZE_TO_HEIGHT').val(data.RESIZE_TO_HEIGHT);
				}
				if(typeof(data.PREVIEW_WIDTH) != 'undefined'){
					$('.PREVIEW_WIDTH').val(data.PREVIEW_WIDTH);
				}
				if(typeof(data.PREVIEW_HEIGHT) != 'undefined'){
					$('.PREVIEW_HEIGHT').val(data.PREVIEW_HEIGHT);
				}
				if(typeof(data.TINYURL) != 'undefined'){
					$('.TINYURL').val(data.TINYURL);
				}
				if(typeof(data.JPEG_QUALITY) != 'undefined'){
					$('.JPEG_QUALITY').val(data.JPEG_QUALITY);
				}
				if(typeof(data.ROTATE) != 'undefined'){
					$('.ROTATE').val(data.ROTATE);
				}
				if(typeof(data.CONVERT_TO) != 'undefined'){
					$('.CONVERT_TO').val(data.CONVERT_TO);
				}
				if(typeof(data.WATERMARK) != 'undefined'){
					$('.WATERMARK').val(data.WATERMARK);
				}
				if(typeof(data.ALBUMS) != 'undefined'){
					$('.ALBUMS').val(data.ALBUMS);
				}
				if(typeof(data.TAGS) != 'undefined'){
					$('.TAGS').val(data.TAGS);
				}
				if(typeof(data.ACCESS) != 'undefined'){
					$('.ACCESS').val(data.ACCESS);
				}
				$('#template_options div').html(data.content);
				createOverlay(word,from_upload);
			}
			else{
				$('#template_options div').html(data.content);

			}
			
		}
	});	
}

function select_template(object){
	var option = $(object).find('option:selected').val();
	var word = $(object).find('option:selected').text();
	$('.overlay').remove();

	if(option == 0){
		$('#batch').prop('checked',false);
		$('#left_block').prop('checked',false);
		$(object).prop('disabled',true);
		reset_fields();
		$('#container_delete_template').hide();
		$('#container_delete_template a').attr({href: ''});

	}
	else{
		$('#container_delete_template').show();
		$('#container_delete_template a').attr({href: '/profile/upload/templates/delete/'+option});
		if($('#upload-multi-links').is(':visible')){
			get_template_info(option,word,0);

		}
		else{
			if($('#upload-multi-files .tr').length > 0){
				get_template_info(option,word,0);
			}
			else{	
				get_template_info(option,word,1);

			}
		}
		
	}
}


function createOverlay(text,from_upload){
  var docHeight = $('.tr').height();
  var buffer = '<table width="100%" height="100%">';
  buffer += '<tr><td style="font-size:16px;" align="center">'+text+'</td><td style="font-size:16px;" align="center">'+text+'</td><td style="font-size:16px;" align="center">'+text+'</td></tr>';
  if($('#template_options').length > 0){
  	  buffer += '<tr><td colspan="3" align="center">'+$('#template_options').html()+'</td></tr>';
  }

  buffer += '</table>';
  var content = '<div style="position:absolute;z-index:5100;color:green;oveflow:hidden;width:100%;height:100%;">'+buffer+'</div>';
  if(from_upload){
  	var append_class = '.tr:last';
  }
  else{
  	var append_class = '.tr';

  }
  var num_overlays = $(append_class).find('.overlay').size();
  if(num_overlays == 0){
  	 $("<div class='overlay'>"+content+"</div>")
  	.appendTo(append_class)
  	.height(docHeight)
  	.css({
    'opacity': 0.8,
    'position': 'absolute',
    'top': 0,
    'left': 0,
    'background-color': 'white',
	'margin-left' : '175px',
	'margin-right' : '200px',
	'overflow' : 'hidden',
    'width': '500px',
    'height': '100%',
    'z-index': 5000
  	});
  }
 
}

function add_comment(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).find('#container_submit').html();
	var comment = $(object).find('#comment_text').val();
	var image_id = $(object).find('#image_id').val();
	
	if(comment == ''){
		alert('Комментарий пустой');
		return false;
	}
	comment = encodeURIComponent(comment);
	
	$.ajax({
	type: "POST",
   	url: object.action,
	dataType: 'json',
	data: 'is_ajax=1&comment='+comment+'&image_id='+image_id,
    cache: false,
	beforeSend:function(){
		$(object).find('#container_submit').html('<div><img src="'+ajax_url+'"></div>');	
	},
	error: function(){
		$(object).find('#container_submit').html(container);	
		alert('Ошибка загрузки!');
	},
    success: function(data){
			$(object).find('#container_submit').html(container);	

			if(data.answer == 1){
					
			}
			else{
					
				$(object).find('#container_submit').html(container);	
				alert('Ошибка загрузки!');			}
			
			}
    });	
}

function clean_positions(){
	
	$("#upload-drop-zone .tr").each(function(){
			var first_position = $(this).find('.raw_position:first').attr('data-position');	
			var buffer_size = $(this).find('.position').size();
			if(buffer_size > 0){
				
			}
			else{
				$(this).prepend('<input type="hidden" name="POSITION[]" value="'+position+'" class="position"/>');
			}

	}); 
}

function set_position(){
	
	$("#upload-drop-zone .tr").each(function(){
		var classname = $(this).attr('class');	

		if(classname == 'tr template-upload fade in'){
			$(this).prepend('<input type="hidden" value="'+position+'" class="position" name="POSITION[]"/>');
			position++;
		}
	}); 
}


function blackout(object){
	var opacity = $('#'+object).css('opacity');

	if(opacity < 0.1){
		clearTimeout(img_timeout);
		return false;
	}
	else{
		opacity -= 0.1;
		$('#image').css('opacity', opacity);
		img_timeout = setTimeout("blackout('"+object+"')",100);
	}
		
}

function open_big_image(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var container = $('#wrapper').html();
	var container_image = $('#image').html();
	var screen_width = get_resolution('width');
	var screen_height = get_resolution('height');
	var real_width = $('#real_width').val();
	var real_height = $('#real_height').val();
	if((real_width / screen_width) < 0.75){
		show_image_main(object);
		return false;
	}
	
	if((real_height / screen_height) < 0.75){
		show_image_main(object);
		return false;
	}
	
	$.ajax({
	type: "POST",
   	url: object.href,
	dataType: 'json',
	data: 'is_ajax=1',
    cache: false,
	beforeSend:function(){
		blackout('image');
	},
	error: function(){
		alert('Ошибка загрузки!');
	},
    success: function(data){
		from_big = false;
		$('#image').css('opacity',1);
		$('#wrapper').after('<div id="hidden_wrapper" style="display:none;"></div>');	
		$('#hidden_wrapper').html(container);
		var title = document.title;
		$('#wrapper').html(data.content);
		hash_change(object.href);
		document.title = title;	
		$('#footer').hide();
		set_margin_big_image(data.image_height);
		$.scrollTo('#footer',1000);

		}
    });	
}

function open_main_image(object){
	var content = $('#hidden_wrapper').html();
	$('#wrapper').html(content);
	$('#hidden_wrapper').remove();
	$('#footer').show();
	hash_change(object.href);
	from_big = true;
}

function set_positions(parameters){
	
	var container = $('.panel_iframe').html();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	if(typeof(torrent_id) == 'undefined')
		return false;
		
	if(typeof(token) == 'undefined')
		return false;
	
	$.ajax({
	type: "POST",
   	url: '/seedoff/resort_position/'+torrent_id,
	dataType: 'json',
	data: parameters+'&token='+token,
    cache: false,
	beforeSend:function(){
		$('.panel_iframe').html('<div><img src="'+ajax_url+'"></div>');	
	},
	error: function(){
		$('.panel_iframe').html(container);	
		alert('Ошибка загрузки!');
	},
    success: function(data){
		$('.panel_iframe').html(data.content);
		set_sortable();
//		set_torrents_list();

	}
    });	
}

function save_sortable(array)
{
array_unique(array);
var strok = '';
for(var p in array)
{
var add = '&';
if(p==0) add = '';
if(array[p] != '')
	strok += add+array[p]+'='+p;
}
set_positions(strok);
}

function set_sortable(){
	$("#torrent_files").sortable({
		items: 'tr',
  		opacity: 0.6,
  		update: function(event, ui) {
		save_sortable($('#torrent_files').sortable('toArray'));
  		}
  	});
}

function show_links_modal(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var container = $('#wrapper').html();
	var container_image = $('#image').html();
	
	$.ajax({
	type: "POST",
   	url: object.href,
	dataType: 'json',
	data: 'is_ajax=1',
    cache: false,
	beforeSend:function(){
		blackout('image');
	},
	error: function(){
		alert('Ошибка загрузки!');
	},
    success: function(data){
		from_big = false;
		$('#image').css('opacity',1);
		$('#wrapper').after('<div id="hidden_wrapper" style="display:none;"></div>');	
		$('#hidden_wrapper').html(container);
		$('#wrapper').html(data.content);	
		hash_change(object.href);
		$('#footer').hide();	
		}
    });	
}

function truncate_block_upload(){
	$('#upload-multi-links .memo').val('');
	$('.result_internet').html('');
	$('#upload-multi-links #enable_memo').val(0);
	$('#upload-multi-links .memo').show();
	$('#upload-multi-links #upload-drop-zone').remove();
	$('#upload-multi-links #summary_links_multiple').hide();
	$('#upload-multi-files #summary_links_multiple').hide();
	
}

function set_enable_memo(){
	$('#upload-multi-links #enable_memo').val(1);
}

function check_enable_upload(){
	if($('#upload-drop-zone').find('.tr').length < 2)
		return false;
}

function show_text_preview(object){
	var select = $(object).find('option:selected').val();
	if(select == 'voluntary_text'){
		$(object).parent().next().show();
	}
	else{
		$(object).parent().next().hide();

	}
	
}

function validate_preview_size(object){
	if($(object).val() <= 0){
		$(object).val(240);
		alert('Недопустимый размер превью!');
	}
}

function delete_from_multiupload(object, message){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).closest('.tr').html();
		var parent = $(object).parent();
		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(parent).html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(object).closest('.tr').html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){

			if(data.answer == 1){
				$(parent).closest('.tr').remove();
				var trs = $('.tr').size();
				if(trs < 1){
					if($('#upload-multi-links').is(':visible'))
						truncate_block_upload();
				}
			}
			else{
				$(object).closest('.tr').html(container);
				alert('Ошибка загрузки!');
			}
			
		}
    	});
		}

}

function set_browser_list_images(urls,current_url){
	
	var html = '';
	var direct = 'prev';

	for(i = 0; i < urls.length; i++){
		html += '<li>';
		if(current_url == urls[i]['img']){
			direct = 'next';
			var ind = i + 1;
			var preview = str_replace('big','preview',urls[i]['img']);
			preview = str_replace('web','preview',preview);
			html += '<a href="'+urls[i]['main']+'" ><img height="50" src="'+preview+'" class="current_image pic"/></a>';
			$('#current_slide').val(ind);
			
		}
		else{
			html += '';
			var preview = str_replace('big','preview',urls[i]['img']);
			preview = str_replace('web','preview',preview);
			html += '<a href="'+urls[i]['main']+'" onclick="hash_change_image(this.href,\''+direct+'\');return false;"><img height="50" src="'+preview+'" class="pic"/></a>';
		}
		html += '</li>';

	}
	if($('.browser_pictures').length > 0){
		$('.browser_pictures').html(html);
		carousel = $('#carousel').elastislide({
			imageW 	: 60,
			minItems: 5,
			start : ind
		});	
	}
	else{
		var container = '<div class="es-carousel-wrapper" style="max-width:570px; overflow: hidden;">';
		container += '<div class="es-carousel"><ul id="carousel" class="elastislide-list browser_pictures">';
		container += html;
		container += '</ul></div></div>';
		$('#browse_gallery').html(container);
		carousel = $('#carousel').elastislide({
			imageW 	: 60,
			minItems: 5,
			start : ind
		});	
	}


}
