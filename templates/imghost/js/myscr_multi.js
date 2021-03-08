var canvas = document.getElementById('myCanvas');
var ctx = canvas.getContext('2d');
var old_upload_content = $('#upload-multi-files').html();

var mouse = {x: 0, y: 0};
var last_mouse = {x: 0, y: 0};

/* Mouse Capturing Work */
canvas.addEventListener('mousemove', function(e) {
    last_mouse.x = mouse.x;
    last_mouse.y = mouse.y;

    mouse.x = e.pageX - this.offsetLeft;
    mouse.y = e.pageY - this.offsetTop;
}, false);

/* Drawing on Paint App */
ctx.lineWidth = 1;
ctx.lineJoin = 'round';
ctx.lineCap = 'round';
ctx.strokeStyle = 'black';

canvas.addEventListener('mousedown', function(e) {
    canvas.addEventListener('mousemove', onPaint, false);
}, false);

canvas.addEventListener('mouseup', function() {
    canvas.removeEventListener('mousemove', onPaint, false);
}, false);

var onPaint = function() {
    ctx.beginPath();
    ctx.moveTo(last_mouse.x, last_mouse.y);
    ctx.lineTo(mouse.x, mouse.y);
    ctx.closePath();
    ctx.stroke();
};

function showSpiner() {
    var $url = $('#url');
    $('#url').html('<span class="spinner"></span>');
    $url.show();
}

function hideSpiner() {
    var $url = $('#url');
    $('span', $url).remove();
    $url.hide();
}

function checkCookie() {
    if (3 > readCookie('save-help')) {
          $('#save-help').fadeIn();
    }
}

function updateCookie() {
    $('#save-help').hide();
    createCookie('save-help', 1 + parseInt(readCookie('save-help') || 0), 365);
}

function loadCanvas(dataURL) {
    var imageObj = new Image();
    imageObj.onload = function() {
        var width = this.width;
        var height = this.height;
        canvas.width  = width;
        canvas.height = height;
        ctx.drawImage(this, 0, 0, width, height);
        hideSpiner();
//        checkCookie();
    };
    imageObj.src = dataURL;
}

document.querySelector('input[type="file"]').addEventListener('change', function(e) {
    loadCanvas(URL.createObjectURL(e.target.files[0]));
}, false);

if ($.browser.mozilla) {
    $(document.body).prepend('<div id="rte" contenteditable="true" style="height:1px;width:1px;color:#FFFFFF;"></div>');
    $('#rte').focus();
}

document.body.addEventListener("paste", function(e) {

//    showSpiner();
	if ($.browser.mozilla) {
		return false;
//		add_row();
	}
	capture_operation();

		
    if ($.browser.mozilla) {
	
//        $('#rte').focus();
//        $('#rte img').remove();
//        setTimeout(function() {
//    	loadCanvas($('.tr:last').find('.preview img').attr('src'));

//        }, 0);
		
    }
	
	if(e.clipboardData){
		for (var i = 0; i < e.clipboardData.items.length; i++) {
        if (e.clipboardData.items[i].kind == "file" && e.clipboardData.items[i].type == "image/png") {
            var imageFile = e.clipboardData.items[i].getAsFile();
            var fileReader = new FileReader();
            fileReader.onloadend = function(e) {
                loadCanvas(this.result);
				$('#buffer_blob').html(this.result);
				paste_in_fast();

            };
            fileReader.readAsDataURL(imageFile);
            e.preventDefault();
            break;
        }
    }
	}
	
});

function paste_in_fast(){
	
	var counter = 0;
	if($('.upload-form').is(':visible')){
		$(".upload-fields form").each(function(){
			if($(this).find('.choose-source').is(':visible')){
				if(counter == 0){
					var file_from_multi = $('#upload-multi-files').find('input[type=file]');
					$(this).find('input[type=file]').replaceWith(file_from_multi);
					$(this).find('input[type=file]').attr('class','upload-fields-switcher');
					$(this).find('input[type=file]').attr('size',1);
					$(this).find('input[type=file]').attr('name','UPLOADED_FILE');
					$(this).find('input[type=file]').attr('id','UPLOADED_FILE');
					$(this).find('.source-local-fields').show();
					$(this).find('.choose-source').hide();

					$(this).find('.source-local-fields .filename .cell').next().html('<span onclick="cancel_change(this);" style="cursor:pointer;margin-left:10px;"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" /></span>');
					var now = new Date();
					var tmp = now.getFullYear()+'-'+now.getMonth()+'-'+now.getDay()+'_'+now.getHours()+'-'+now.getMinutes()+'-'+now.getSeconds();
					var filename = 'Screenshot: ' + tmp;
					$(this).find('.source-local-fields .filename .cell').html(filename);
					$(this).find('.is_paste').val(1);
					var buffer_blob = $('#buffer_blob').html();
					$(this).find('.blob').val(buffer_blob);
					var buffer_blob = $('#buffer_blob').val();

				}
					counter++;		

			}
		
		}); 
	}
}

function truncate_multiupload(){
	$('#upload-drop-zone').html('');

}

function capture_operation(){
	
	$('.capture_operations').show();
	
}

function clean_screen(){
	hideSpiner();
	$('#rte img').remove();
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    canvas.width  = 1;
    canvas.height = 1;
	Shadowbox.close();
    return false;
}

function add_row(){
	
	$.ajax({
		type: "POST",
   	 	url: 'capture/row',
		dataType: 'json',
    	cache: false,
		error: function(){
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			
			$('#upload-drop-zone').append(data.content);	

			var screen = $('#rte img').attr('src');
			
			$('.tr:last').find('.preview').html('<img contenteditable="true" width="130" height="82" src="'+screen+'">');
			$('#rte img').remove();
			
//			$('.tr:last').find('.preview img').attr('src',screen);

		}
    });	
}

function save_screen(){
	
//	updateCookie();
    showSpiner();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $('.save').html();
	
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload/capture', true);
    xhr.onload = function(e) {
        if (4 === xhr.readyState) {
            if (200 === xhr.status && xhr.responseText.length > 0) {
				$('.operations').html('<td colspan="2" align="center"><div class="answer" style="white-space: nowrap;"><div>'+xhr.responseText+'</div></td>');
				$('.operations').next().find('td').show();

            }
			else{
				$('.save').html(container);

			}
        }
		else{
			$('.save').html(container);

		}
    };
    xhr.send(canvas.toDataURL());
	$('.save').html('<img src="'+ajax_url+'">');


    return false;
}

$('#save').click(function(e) {
    updateCookie();
    showSpiner();

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'uploader/accept.php', true);
    xhr.onload = function(e) {
        if (4 === xhr.readyState) {
            if (200 === xhr.status && xhr.responseText.length > 0) {
                var url = 'http://yourscr.com/' + xhr.responseText;
                var $url = $('#url');
                $url.attr('data-href', url);
                $url.text(url);
            }
        }
    };
    xhr.send(canvas.toDataURL());
    return false;
});

$('#clear').click(function(e) {
    hideSpiner();
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    canvas.width  = 1;
    canvas.height = 1;
    return false;
});

$('#url').click(function(e) {
    var win=window.open($(this).attr('data-href'), '_blank');
    win.focus();
    return false;
});

function set_fileupload(){
	
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
}