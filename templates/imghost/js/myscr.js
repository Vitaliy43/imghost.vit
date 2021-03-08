var canvas = document.getElementById('myCanvas');
var ctx = canvas.getContext('2d');

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

    showSpiner();
	capture_operation();

    if ($.browser.mozilla) {
        $('#rte').focus();
        $('#rte img').remove();
        setTimeout(function() {
            loadCanvas($('#rte img').attr('src'));
        }, 0);
        return true;
    }

    for (var i = 0; i < e.clipboardData.items.length; i++) {
        if (e.clipboardData.items[i].kind == "file" && e.clipboardData.items[i].type == "image/png") {
            var imageFile = e.clipboardData.items[i].getAsFile();
            var fileReader = new FileReader();
            fileReader.onloadend = function(e) {
                loadCanvas(this.result);
            };
            fileReader.readAsDataURL(imageFile);
            e.preventDefault();
            break;
        }
    }
});

function capture_operation(){
	
//	var content = $('.capture_operations').html();
	$('.capture_operations').show();
	/*
	Shadowbox.open({
        content:    content,
        player:     "html",
        title:      "Операции со скриншотом",
		left: 200,
		overlayOpacity: 0.3,
		handleOversize: 'resize'
    });	
	*/
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
//                var url = 'http://yourscr.com/' + xhr.responseText;
//                var $url = $('#url');
//                $url.attr('data-href', url);
//                $url.text(url);
//				console.info(xhr.responseText);
//				$('.operations').html('<td colspan="2" align="center"><div class="answer" style="margin-top: 15px;white-space: nowrap;"><div><a href="'+xhr.responseText+'" target="_blank" style="color:black;font-size:16px;">Ссылка на снимок</a></div></td>');
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