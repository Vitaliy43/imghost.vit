var multi_upload;

function intval( mixed_var, base ) {
	var tmp;
	if( typeof( mixed_var ) == 'string' ){
		tmp = parseInt(mixed_var);
		if(isNaN(tmp)){
			return 0;
		} else{
			return tmp.toString(base || 10);
		}
	} else if( typeof( mixed_var ) == 'number' ){
		return Math.floor(mixed_var);
	} else{
		return 0;
	}
}

var _formatFileSize = function(bytes) {
	if (typeof bytes !== 'number') {
		return '';
	}
	if (bytes >= 1000000000) {
		return (bytes / 1000000000).toFixed(2) + ' GB';
	}
	if (bytes >= 1000000) {
		return (bytes / 1000000).toFixed(2) + ' MB';
	}
	return (bytes / 1000).toFixed(2) + ' KB';
};

var langDropDown = function() {
	$(this).toggleClass('expanded').find('li:not(.active)').toggle();
}

var jqInitElements = function() {
	$('.dateInput').datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: '-90Y',
		maxDate: '-18Y',
		constrainInput: true
	});
	
	$('input.file').styler();
}

//$AjaxManager.registerEventHandler('onAfterAjaxOutput', jqInitElements);

function ClearForm($form) {
	$form.get(0).reset();
}

function CloseAllPopup() {
	$('.modal-wnd').hide();
	$('#upload-multiple').hide();
	$('.hcArea').hide();
}

function ShowMessage($msg, $el, $type) {
	var $div = $('<div class="msg-popup"></div>');
	var $offset = $($el).offset();
	$offset.top = $offset.top + $($el).outerHeight();
	$div.html($msg).addClass($type).offset($offset).prependTo('body');
	$(document).click(function() {
		$(this).unbind('click');
		$div.remove();
	});
}

function onRegister($data) {
	var $msg = $data.DATA.MSG;
	var $type = $data.DATA.RESULT;
	ShowMessage($msg, '#registerEmail', $type);
}

function onAuth($data) {
	var $msg = $data.DATA.MSG;
	var $type = $data.DATA.RESULT;
	if ($type == 'ok') {
		window.location.reload(true);
	} else {
		ShowMessage($msg, '#msgEdit', $type);
	}
}

function onFileUploaded($data, $component, $form) {
	if ($form !== false) {
		lockComponent($component);
		$form.parents('.item').html($data);
	}
}

function onMultiLinksUploaded($data) {
	if ($data.files.length > 0) {
		var $result = $('<div class="listbox files" />');
		$data.formatFileSize = _formatFileSize;
		var $items = tmpl('template-download', $data);
		$result.html($items);
		$('#upload-result').html($result);
		$('#upload-multi-links').find('.start').addClass('wrToggle').text('Загрузить ещё');
	}
}

function afterPasswordChange($data) {
	var $div = $('<div class="errormsg">' + $data.MSG + '</div>');
	if ($data.RESULT == 'ok')
		$div.addClass('ok');
	$('#wndChangePassword').find('.errormsg').remove();
	$('#wndChangePassword').prepend($div);
}

function insertUploadFields($html, $component) {
	lockComponent($component);
	$('#comp-' + $component).find('.upload-fields').append($html);
	$AjaxManager.unregisterEventHandler('onBeforeAjaxOutput', insertUploadFields);
}

function onAfterAlbumAdd($data, $form) {
	if ($data.RESULT == 'error') {
		ShowMessage($data.MSG, $form.find('input[name=NAME]'), 'error');
	} else {
		ClearForm($form);
		$form.prepend('<div class="errormsg ok">' + $data.MSG + '</div>');
	}
}

function treeview_select($this, $expand_node) {
	var $id = $this.attr('data-id');
	$('#formAddAlbum').find('input[name=PARENT_ID]').val($id);
	$this.parents('.treeview').find('li').removeClass('focused');
	$this.parent('li').addClass('focused');
	
	if ($expand_node === true) {
		var $url = $this.siblings('a.treenode').attr('href');
		if ($this.parent('li').attr('data-expanded') == 1) {
			$this.parent('li').toggleClass('expanded').find('ul').toggle();
		} else {
			$this.parent('li').toggleClass('expanded').attr('data-expanded', 1);
			$.ajax({
				url: $this.attr('href'),
				data: { __AJAX: 'Y' },
				success: function($data) {
					$this.parent('li').append($data);
				}
			});
		}
	} else {
		var $url = $this.attr('href');
	}
		
	$.ajax({
		url: $url,
		data: { __AJAX: 'Y' },
		success: function($data) {
			$('#comp-image-list').html($data);
			$('#imagelist').carouFredSel({
				align: 'center',
				auto: { play: false },
				circular: false,
				infinite: false,
				prev: '#imagelist-prev',
				next: '#imagelist-next',
				width: 215
			});
		}
	});
}

$(function() {
	'use strict';
	
	jqInitElements();
	
	var multi_upload = $('#upload-multi-files').fileupload({
		acceptFileTypes: '/(\.|\/)(gif|jpe?g|png)$/i',
		previewMaxWidth: 130,
		previewMaxHeight: 95,
		previewAsCanvas: false,
		maxFileSize: 20000000,
		maxNumberOfFiles: max_number_of_files,
		dropZone: '#upload-drop-zone'
	}).bind('fileuploadsubmit', function (e, data) {
		$('.listbox').find('.hide-on-submit').hide().siblings('.progressbar').show();
		var $hidden = $('#upload-multi-files').find('input[type=hidden]').serializeArray();
		var $inputs = data.context.find(':input').serializeArray();
		var $form_data = $hidden.concat($inputs);
		data.formData = $form_data;
	});
});

function fast_progress(form_id){
	
	$('#form'+form_id).fileupload({
		acceptFileTypes: '/(\.|\/)(gif|jpe?g|png)$/i',
		previewMaxWidth: 130,
		previewMaxHeight: 95,
		previewAsCanvas: false,
		maxFileSize: 20000000,
		maxNumberOfFiles: 1,
		dropZone: '#form'+form_id
	}).bind('fileuploadsubmit', function (e, data) {		
		var $hidden = $('#form'+form_id).find('input[type=hidden]').serializeArray();
		var $inputs = data.context.find(':input').serializeArray();
		var $form_data = $hidden.concat($inputs);
		data.formData = $form_data;
	});
}

$(document).ready(function() {
	$('#cbLang').on('click', langDropDown);
	
	$('.toggle-page').on('click', function(e) {
		e.preventDefault();
		var $page = $(this).attr('data-page');
		$(this).parents('.auth').find('.page').hide().eq($page).show();
	});
	
	$(document).on('click', '.doToggle', function(e) {
		e.preventDefault();
		var $block = $($(this).attr('data-block'));
		$block.toggle();
	});
	
	$(document).click(function() {
		$('.modal-wnd').hide();
	});
	
	$(document).on('click', '.modal-wnd', function(e) {
		e.stopPropagation();
	});
	
	$(document).on('click', '.close-wnd', function(e) {
		e.preventDefault();
		$(this).parents('.modal-wnd').hide();
	});
	
	$(document).on('click', '.show-modal', function(e) {
		e.preventDefault();
		var $wnd = $($(this).attr('href'));
		$wnd.show();
		e.stopPropagation();
	});
	
	$(document).on('click', '#delete-avatar', function(e) {
		e.preventDefault();
		if (confirm('Текущий аватар будет удалён. Продолжить?')) {
			$AjaxManager.sendComponent($(this).attr('href'));
		}
	});
	
	$(document).on('click', '.switch-upload', function(e) {
		e.preventDefault();
		$(this).parents('.upload-splash').hide().siblings('.upload-form').show();
	});
	
	$(document).on('click', '.source-remote', function(e) {

		e.preventDefault();
		if($(this).closest('.item_cover').length > 0){
			var elem = '.item_cover';
			$(this).parents('.item_cover').find('.source-remote-url').show().siblings('.source-local-fields').show();
			$(this).parents('.item_cover').find('.cell').html('');
			$(this).parents('.item_cover').find('.cimage').html('');
		}
		else{
			$(this).parents('.item').find('.choose-source').hide();
			$(this).parents('.item').find('.source-remote-url').show().siblings('.source-local-fields').show();
		}

	});
	
	$(document).on('change', '.upload-fields-switcher', function() {
		if($(this).closest('.item_cover').length > 0){
			var elem = '.item_cover';
		}
		else{
			var elem = '.item';
		}
			$(this).parents(elem).find('.source-local-fields .filename .cell').html(basename($(this).val())).parent().show().parents(elem).find('.choose-source').hide();
			$(this).parents(elem).find('.source-local-fields').show();
		
		if($(this).closest('avatarForm').length > 0)
			return;
		$(this).parents(elem).find('.source-local-fields .filename .cell').next().html('<span onclick="cancel_change(this);" style="cursor:pointer;margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" /></span>');
		var word = $(this).parents(elem).find('.source-local-fields .filename .cell').html();
		var new_word = splitterWord(word,15);
		$(this).parents(elem).find('.source-local-fields .filename .cell').html(new_word);
		if(elem == '.item_cover'){
			$('.choose-source').show();	
			$('#all_submit').css('margin-top','10px');
			$('.source-remote-url').hide();
			
		}
	});
	
	$(document).on('click', '.add-upload-fields', function(e) {
		e.preventDefault();
//		$AjaxManager.registerEventHandler('onBeforeAjaxOutput', insertUploadFields);
//		$AjaxManager.sendComponent($(this).attr('href'));
		if($('#all_submit').is(':hidden')){
			$('#all_submit').show();
		}
		add_upload_fields($(this).attr('href'));
	});
	
	$(document).on('click', '.autoselect', function() {
		$(this).select();
	});
	
	$(document).on('click', '#showMultipleUpload', function(e) {
		e.preventDefault();
		$('#upload-drop-zone').html('');
		$('#upload-multiple').show();
	});
	
	$(document).keypress(function(e){
		if (e.keyCode == 27)
			CloseAllPopup();
	});
	
	$(document).on('click', '.treeview a.expand, .treeview a.treenode', function(e) {
		e.preventDefault();
		treeview_select($(this), $(this).hasClass('expand'));
	});
	
	$(document).on('click', '.image-list-item', function(e) {
		e.preventDefault();
		var $src = $(this).find('img').attr('src');
		$('#folder-content').find('.image-preview img').attr('src', $src);
	});
	
	$(document).on('click', '.left90, .right90', function(e) {
		e.preventDefault();
		if($('.image_list').length > 0 || $('#container_image').length > 0){
			var img = $('#sb-wrapper #edit_image .fade img');
			var attr = intval(img.attr('data-angle'));
			if ($(this).hasClass('left90')) {
			if (attr == 0)
				var angle = 270;
			else
				var angle = attr - 90;
			} else {
			if (attr == 360)
				var angle = 90;
			else
				var angle = parseInt(attr) + parseInt(90);
			}
			img.attr('data-angle', angle).rotate(angle);
			$(this).siblings('input').val(angle);
			
		}
		else{
			
			var $img = $(this).parents('.tr').find('.preview img');
			var $attr = intval($img.attr('data-angle'));
			if ($(this).hasClass('left90')) {
			if ($attr == 0)
				var $angle = 270;
			else
				var $angle = $attr - 90;
			} else {
			if ($attr == 360)
				var $angle = 90;
			else
				var $angle = parseInt($attr) + parseInt(90);
			}
			$img.attr('data-angle', $angle).rotate($angle);
			$(this).siblings('input').val($angle);
			
		}
		
	});
	
	$(document).on('click', '.hcSwitcher', function(e) {
		e.preventDefault();
		$(this).siblings('.hcArea').show();
	});
	$(document).on('click', '.hcClose', function(e) {
		e.preventDefault();
		$(this).parents('.hcArea').hide();
	});
	
	$(document).on('click', '.jsAction', function(e) {
//		e.preventDefault();
//		$(this).parents('.name').find('.modal-wnd').show();
//		e.stopPropagation();
	});
	
	$(document).on('click', '.close-multiupload', function(e) {
		e.preventDefault();
		CloseAllPopup();
		$('#upload-drop-zone').html('');
	});
	
	$(document).on('click', '#upload-multiple .choose-source a', function(e) {
		e.preventDefault();
		var $block = $(this).attr('href');
		$(this).addClass('active').siblings('a').removeClass('active');
		if ($block == '#upload-multi-links') {
			$('#upload-multi-files').hide();
		} else {
			$('#upload-multi-links').hide();
		}
		$($block).show();
	});
	
	$(document).on('click', '.wrToggle', function(e) {
		e.preventDefault();
		$(this).removeClass('wrToggle').text('Загрузить на сервер');
		var $content = '<div class="caption-text">Введите каждую ссылку с новой строки в поле ниже.</div><textarea class="memo" name="FILE_URL" placeholder="http://somesite.com/some_picture.jpg"></textarea>';
		$('#upload-result').html($content);
		e.stopPropagation();
	});
});