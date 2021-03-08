
function myAlert(text){
	
	jAlert(text,'IMGHOST.PRO"');
}

function array_keys( input, search_value, strict ) {    // Return all the keys of an array
	    //
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	 
	    var tmp_arr = new Array(), strict = !!strict, include = true, cnt = 0;
	 
	    for ( key in input ){
	        include = true;
	        if ( search_value != undefined ) {
	            if( strict && input[key] !== search_value ){
	                include = false;
	            } else if( input[key] != search_value ){
	                include = false;
	            }
	        }
	 
	        if( include ) {
	            tmp_arr[cnt] = key;
	            cnt++;
	        }
	    }
	 
	    return tmp_arr;
}
	
	
function arsort(inputArr, sort_flags) {
// discuss at: http://phpjs.org/functions/arsort/
// original by: Brett Zamir (http://brett-zamir.me)
// improved by: Brett Zamir (http://brett-zamir.me)
// improved by: Theriault
// note: SORT_STRING (as well as natsort and natcasesort) might also be
// note: integrated into all of these functions by adapting the code at
// note: http://sourcefrog.net/projects/natsort/natcompare.js
// note: The examples are correct, this is a new way
// note: Credits to: http://javascript.internet.com/math-related/bubble-sort.html
// note: This function deviates from PHP in returning a copy of the array instead
// note: of acting by reference and returning true; this was necessary because
// note: IE does not allow deleting and re-adding of properties without caching
// note: of property position; you can set the ini of "phpjs.strictForIn" to true to
// note: get the PHP behavior, but use this only if you are in an environment
// note: such as Firefox extensions where for-in iteration order is fixed and true
// note: property deletion is supported. Note that we intend to implement the PHP
// note: behavior by default if IE ever does allow it; only gives shallow copy since
// note: is by reference in PHP anyways
// note: Since JS objects' keys are always strings, and (the
// note: default) SORT_REGULAR flag distinguishes by key type,
// note: if the content is a numeric string, we treat the
// note: "original type" as numeric.
// depends on: i18n_loc_get_default
// example 1: data = {d: 'lemon', a: 'orange', b: 'banana', c: 'apple'};
// example 1: data = arsort(data);
// returns 1: data == {a: 'orange', d: 'lemon', b: 'banana', c: 'apple'}
// example 2: ini_set('phpjs.strictForIn', true);
// example 2: data = {d: 'lemon', a: 'orange', b: 'banana', c: 'apple'};
// example 2: arsort(data);
// example 2: $result = data;
// returns 2: {a: 'orange', d: 'lemon', b: 'banana', c: 'apple'}
var valArr = [],
valArrLen = 0,
k, i, ret, sorter, that = this,
strictForIn = false,
populateArr = {};
switch (sort_flags) {
case 'SORT_STRING':
// compare items as strings
sorter = function (a, b) {
return that.strnatcmp(b, a);
};
break;
case 'SORT_LOCALE_STRING':
// compare items as strings, based on the current locale (set with i18n_loc_set_default() as of PHP6)
var loc = this.i18n_loc_get_default();
sorter = this.php_js.i18nLocales[loc].sorting;
break;
case 'SORT_NUMERIC':
// compare items numerically
sorter = function (a, b) {
return (a - b);
};
break;
case 'SORT_REGULAR':
// compare items normally (don't change types)
default:
sorter = function (b, a) {
var aFloat = parseFloat(a),
bFloat = parseFloat(b),
aNumeric = aFloat + '' === a,
bNumeric = bFloat + '' === b;
if (aNumeric && bNumeric) {
return aFloat > bFloat ? 1 : aFloat < bFloat ? -1 : 0;
} else if (aNumeric && !bNumeric) {
return 1;
} else if (!aNumeric && bNumeric) {
return -1;
}
return a > b ? 1 : a < b ? -1 : 0;
};
break;
}
// BEGIN REDUNDANT
this.php_js = this.php_js || {};
this.php_js.ini = this.php_js.ini || {};
// END REDUNDANT
strictForIn = this.php_js.ini['phpjs.strictForIn'] && this.php_js.ini['phpjs.strictForIn'].local_value && this.php_js
.ini['phpjs.strictForIn'].local_value !== 'off';
populateArr = strictForIn ? inputArr : populateArr;
// Get key and value arrays
for (k in inputArr) {
if (inputArr.hasOwnProperty(k)) {
valArr.push([k, inputArr[k]]);
if (strictForIn) {
delete inputArr[k];
}
}
}
valArr.sort(function (a, b) {
return sorter(a[1], b[1]);
});
// Repopulate the old array
for (i = 0, valArrLen = valArr.length; i < valArrLen; i++) {
populateArr[valArr[i][0]] = valArr[i][1];
}
return strictForIn || populateArr;

}

function rsort(inputArr, sort_flags) {

  var valArr = [],
    k = '',
    i = 0,
    sorter = false,
    that = this,
    strictForIn = false,
    populateArr = [];

  switch (sort_flags) {
  case 'SORT_STRING':
    // compare items as strings
    sorter = function (a, b) {
      return that.strnatcmp(b, a);
    };
    break;
  case 'SORT_LOCALE_STRING':
    // compare items as strings, original by the current locale (set with i18n_loc_set_default() as of PHP6)
    var loc = this.i18n_loc_get_default();
    sorter = this.php_js.i18nLocales[loc].sorting;
    break;
  case 'SORT_NUMERIC':
    // compare items numerically
    sorter = function (a, b) {
      return (b - a);
    };
    break;
  case 'SORT_REGULAR':
    // compare items normally (don't change types)
  default:
    sorter = function (b, a) {
      var aFloat = parseFloat(a),
        bFloat = parseFloat(b),
        aNumeric = aFloat + '' === a,
        bNumeric = bFloat + '' === b;
      if (aNumeric && bNumeric) {
        return aFloat > bFloat ? 1 : aFloat < bFloat ? -1 : 0;
      } else if (aNumeric && !bNumeric) {
        return 1;
      } else if (!aNumeric && bNumeric) {
        return -1;
      }
      return a > b ? 1 : a < b ? -1 : 0;
    };
    break;
  }

  // BEGIN REDUNDANT
  try {
    this.php_js = this.php_js || {};
  } catch (e) {
    this.php_js = {};
  }

  this.php_js.ini = this.php_js.ini || {};
  // END REDUNDANT
  strictForIn = this.php_js.ini['phpjs.strictForIn'] && this.php_js.ini['phpjs.strictForIn'].local_value && this.php_js
    .ini['phpjs.strictForIn'].local_value !== 'off';
  populateArr = strictForIn ? inputArr : populateArr;

  for (k in inputArr) {
    // Get key and value arrays
    if (inputArr.hasOwnProperty(k)) {
      valArr.push(inputArr[k]);
      if (strictForIn) {
        delete inputArr[k];
      }
    }
  }

  valArr.sort(sorter);

  for (i = 0; i < valArr.length; i++) {
    // Repopulate the old array
    populateArr[i] = valArr[i];
  }
  return strictForIn || populateArr;
}

function array_unique( array ) {    // Removes duplicate values from an array
	    //
	    // +   original by: Carlos R. L. Rodrigues
	 
	    var p, i, j;
	    for(i = array.length; i;){
	        for(p = --i; p > 0;){
	            if(array[i] === array[--p]){
	                for(j = p; --p && array[i] === array[p];);
	                i -= array.splice(p + 1, j - p).length;
	            }
	        }
	    }
	 
	 return true;
}

function print_r( array, return_val ) { // Prints human-readable information about a variable
	    //
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // + namespaced by: Michael White (http://crestidg.com)
	 
	    var output = "", pad_char = " ", pad_val = 4;
	 
	    var formatArray = function (obj, cur_depth, pad_val, pad_char) {
	        if(cur_depth > 0)
	            cur_depth++;
	 
	        var base_pad = repeat_char(pad_val*cur_depth, pad_char);
	        var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
	        var str = "";
	 
	        if(obj instanceof Array) {
	            str += "Array\n" + base_pad + "(\n";
	            for(var key in obj) {
	                if(obj[key] instanceof Array) {
	                    str += thick_pad + "["+key+"] => "+formatArray(obj[key], cur_depth+1, pad_val, pad_char);
	                } else {
	                    str += thick_pad + "["+key+"] => " + obj[key] + "\n";
	                }
	            }
	            str += base_pad + ")\n";
	        } else {
	            str = obj.toString(); // They didn't pass in an array.... why? -- Do the best we can to output this object.
	        };
	 
	        return str;
	    };
	 
	    var repeat_char = function (len, char) {
	        var str = "";
	        for(var i=0; i < len; i++) { str += char; };
	        return str;
	    };
	 
	    output = formatArray(array, 0, pad_val, pad_char);
	 
	    if(return_val !== true) {
	        document.write("<pre>" + output + "</pre>");
	        return true;
	    } else {
	        return output;
	    }
	}

function implode( glue, pieces ) {  // Join array elements with a string
	    //
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   improved by: _argos
	 
	    return ( ( pieces instanceof Array ) ? pieces.join ( glue ) : pieces );
}

function get_browser(){
	var useragent=navigator.userAgent;
	var navigatorname;
	if (useragent.indexOf('MSIE')!= -1)
	{
    navigatorname="MSIE";
	}
	else if (useragent.indexOf('Gecko')!= -1)
	{
    	if (useragent.indexOf('Chrome')!= -1)
    		navigatorname="Google Chrome";
    	else navigatorname="Mozilla";
	}
	else if (useragent.indexOf('Mozilla')!= -1)
	{
    	navigatorname="old Netscape or Mozilla";
	}
	else if (useragent.indexOf('Opera')!= -1)
	{
    	navigatorname="Opera";
	}
	return navigatorname;
}

function substr( f_string, f_start, f_length ) {    // Return part of a string
	    //
	    // +     original by: Martijn Wieringa
	 
	    if(f_start < 0) {
	        f_start += f_string.length;
	    }
	 
	    if(f_length == undefined) {
	        f_length = f_string.length;
	    } else if(f_length < 0){
	        f_length += f_string.length;
	    } else {
	        f_length += f_start;
	    }
	 
	    if(f_length < f_start) {
	        f_length = f_start;
	    }
	 
	    return f_string.substring(f_start, f_length);
}

function add_upload_fields(url){
	
	var content = $('.five-more').html();

	$.ajax({
	type: "POST",
    url: url,
	dataType: 'json',
    cache: false,
	beforeSend:function(){
		$('.five-more').html('<div class="ajax_loader"><img src="'+ajax_small_url+'"></div>');	
	},
	error: function(){
		$('.five-more').html(content);
		myAlert('Ошибка загрузки!');
	},
    success: function(data){
		$('.five-more').html(content);
		$('.item :last').after(data.content);
		var counter = 1;
		$(".upload-fields form").each(function(){
			var form_id = 'form'+counter;
		$(this).attr({'id':form_id});
		$('#'+form_id+' #current_form').val(counter);
		counter++;		
		
	}); 
		}
    });
}

function str_replace(search, replace, subject) {
	if(typeof(subject) == 'undefined')
		return '';
	else
		return subject.split(search).join(replace);
}

function ajaxFileUpload(main_url)
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		


		$.ajaxFileUpload
		(
			{	
				url:'/uploads/ajaxfileupload.php',
				secureuri:false,
				fileElementId:'UPLOADED_FILE',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				cache: false,
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
					
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							console.log(data.content);
								
						}
						
					}
					
				},
				error: function (data, status, e)
				{
					
					//myAlert(e);
				}
			}
		)
		
		return false;
			
	}
	
	function dump(obj) {
    var out = "";
    if(obj && typeof(obj) == "object"){
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
    } else {
        out = obj;
    }
    return out;
}

	var beginned_modal = 0;
	var width_col1 = 0;
	var width_col2 = 0;
	var width_col3 = 0;
	var new_width_col1 = 0;
	var new_width_col2 = 0;
	var new_width_col3 = 0;
	var modal_left = 0;
	var width_modal = 640;


	function update_image(object,id){
		
		if($('#container_image').length > 0){
			var from_image_page = 1;
		}
		else{
			var from_image_page = 0;

		}
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var empty_fields = true;
		var resize_to_width = $('#sb-wrapper #resize_to_width').val();
		var resize_to_height = $('#sb-wrapper #resize_to_height').val();
		var rotate = $('#sb-wrapper #rotate').val();
		var hidden_tiny = $('#sb-wrapper #hidden_tiny').val();
		if($('#sb-wrapper #tiny_url').attr('checked') == 'checked'){
			var tiny_url = 1;
			
		}
		else{
			var tiny_url = 0;
		}
		var tiny_url = $('#sb-wrapper #tiny_url').val();
		var name = $('#sb-wrapper #name').val();
		var convert_to = $('#sb-wrapper #convert_to').val();
		var description = $('#sb-wrapper #description').val();
		var watermark = $('#sb-wrapper #watermark').val();
		var tags = $('#sb-wrapper #TAGS').val();
		var access = $('#sb-wrapper #ACCESS').val();
		var current_access = $('#sb-wrapper #current_access').val();
		if($('#sb-wrapper #TAGS_CHILDREN').length > 0)
			var tags_children = $('#sb-wrapper #TAGS_CHILDREN').val();
		else
			var tags_children = 0;
			
		if($('#sb-wrapper #ALBUMS').length > 0){
			var albums = $('#sb-wrapper #ALBUMS option:selected').val();
		}
		else{
			var albums = '';
		}
		
		if(access == current_access)
			access = '';
		
		var container = $('#sb-wrapper .submit').html();
		
		if(resize_to_width > 0 || resize_to_height > 0){
			empty_fields = false;

		}

		if(rotate != 0)
			empty_fields = false;
		if(name != '')
			empty_fields = false;
		if(convert_to != '')
			empty_fields = false;
		if(description != '')
			empty_fields = false;
		if(watermark != '')
			empty_fields = false;
		if(tags != 0)
			empty_fields = false;
		if(access != '')
			empty_fields = false;
		if(albums != ''){
			if($('#sb-wrapper #current_album').length > 0){
				empty_fields = false;
			}
			else{
				if(albums != 0)
					empty_fields = false;
			}
			
		}
		if(hidden_tiny != tiny_url)
			empty_fields = false;
		
		if($(object))
		
		if(empty_fields == true)
			return false;
		name = encodeURIComponent(name);
		description = encodeURIComponent(description);
		watermark = encodeURIComponent(watermark);
		access = encodeURIComponent(access);
		var height_modal = $('#sb-wrapper-inner').height()+'px';
		var width_modal = $('#sb-wrapper-inner').width()+'px';
		if(typeof(tags) != 'undefined' && tags != 0){
			if(tags == 'undefined'){
				tags = '';
			}
			else{
				tags = '&TAGS='+tags;
				if(tags_children != 0)
					tags += '&TAGS_CHILDREN='+tags_children;
			}
			
		}
		else{
			tags = '';
		}
		
		$.ajax({
		type: "POST",
   	 	url: object.action,
		dataType: 'json',
		data: 'is_ajax=1&is_update=1&RESIZE_TO_WIDTH='+resize_to_width+'&RESIZE_TO_HEIGHT='+resize_to_height+'&ROTATE='+rotate+'&NAME='+name+'&CONVERT_TO='+convert_to+'&DESCRIPTION='+description+'&WATERMARK='+watermark+tags+'&ALBUMS='+albums+'&ACCESS='+access+'&TINYURL='+tiny_url,
    	cache: false,
		beforeSend:function(){
			$('#sb-player .submit').html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('#sb-player .submit').html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				if(from_image_page == 1){
					document.location.reload();
				}
				else{
					$('#row_'+id+' .file_preview').html(data.preview);
					var current_href = $('#row_'+id+' .file_preview').attr('href');
					var src_preview = $('#row_'+id+' .file_preview img').attr('src');
					var buffer = src_preview.split('?rotate=');
					var big_preview = current_href + '?rotate='+buffer[1];
					$('#row_'+id+' .file_preview').attr({href:big_preview});
					$('#row_'+id+' .file_name a').html(data.show_filename);
					$('#row_'+id+' .file_size').html(data.size);
					$('#row_'+id+' .file_ext').html(data.ext);
					$('#row_'+id+' .file_access').html(data.access_text);
					$('#row_'+id+' .file_comment').html(data.comment);
					$('#row_'+id+' .tag_name').html(data.tag_name);
					$('#row_'+id+' .album_name').html(data.album_name);
					Shadowbox.close();
				}
				
			}
			else{
					$('#sb-player .submit').html(container);
					alert('Неизвестная ошибка!');
			}
		}
    	});
	}
	
	function edit_image_from_page(object,id){
		
		var real_width = $('#real_width').val();
		var real_height = $('#real_height').val();
		
		var preview_width = $('#preview_width').val();
		var preview_height = $('#preview_height').val();

		var real_src = $('#image img').attr('src');
		var preview_src = str_replace('big','preview',real_src);
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).parent();
		var container_link = $(object).parent().html();

		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1&width='+preview_width+'&height='+preview_height+'&src='+preview_src,
    	cache: false,
		beforeSend:function(){
			$(object).replaceWith('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(container).html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(container).html(container_link);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			beginned_modal = 0;
			if(data.answer == 1){
				Shadowbox.open({
        		content:    data.content,
        		player:     "html",
        		title:      "Редактирование изображения",
				left: 200,
				height: height_modal,
				overlayOpacity: 0.7,
				handleOversize: 'resize'
    			});	
			}
			else{
				alert(data.content);

			}
		
			
		}
    	});
		
	}

	function edit_image(object,id){
		
		var preview_width = $('#row_'+id+' .preview_width').val();
		var preview_height = $('#row_'+id+' .preview_height').val();
		var preview_src = $('#row_'+id+' a').attr('href');
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).parent();
		var container_link = $(object).parent().html();

		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1&width='+preview_width+'&height='+preview_height+'&src='+preview_src,
    	cache: false,
		beforeSend:function(){
			$(object).replaceWith('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(container).html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(container).html(container_link);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			beginned_modal = 0;
			if(data.answer == 1){
				Shadowbox.open({
        		content:    data.content,
        		player:     "html",
        		title:      "Редактирование изображения",
				left: 200,
				height: height_modal,
				overlayOpacity: 0.7,
				handleOversize: 'resize'
    			});	
			}
			else{
				alert(data.content);

			}
		
			
		}
    	});
		
	}
	
	function antifocus(object){
		$(object).focus();
	}
	
	function edit_profile(object){
		
		var container = $(object).parent();
		var container_link = $(object).parent().html();
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
    	cache: false,
		beforeSend:function(){
			$(object).replaceWith('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(object).html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(container).html(container_link);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			var width_modal = $('#container_modal').width();
			beginned_modal = 0;
			
			Shadowbox.open({
        	content:    data.content,
        	player:     "html",
        	title:      "Редактирование профиля",
			left: 200,
			width: width_modal,
			height: height_modal,
			overlayOpacity: 0.7,
			handleOversize: 'resize'
    		});	
			
		}
    	});
	}
	
	function show_field(object,type_col){
		var hidden = $(object).next();
		var add_to_modal_width = hidden.next().val();
		var old_width = $('#sb-player #edit_image').width();
		var wrapper_width = $('#sb-wrapper').width();
		if(modal_left == 0){
			modal_left = $('#sb-wrapper').css('left');
			modal_left = str_replace('px','',modal_left);
		}

		if(width_col1 == 0)
			width_col1 = $('#sb-player .col_1').parent().width();
		if(width_col2 == 0)
			width_col2 = $('#sb-player .col_2').parent().width();
		if(width_col3 == 0)
			width_col3 = $('#sb-player .col_3').parent().width();

		var cols1 = $('#sb-player .col_1:visible').size();
		var cols2 = $('#sb-player .col_2:visible').size();
		var cols3 = $('#sb-player .col_3:visible').size();
		$(object).hide();
		hidden.show();
		var new_width = $('#sb-player #edit_image').width();

		var add = 0;
		if(type_col == 'col1'){
			if(new_width_col2 > width_col2)
				add += new_width_col2 - width_col2;
			if(new_width_col3 > width_col3)
				add += new_width_col3 - width_col3;
				add +=20;
		}
		else if(type_col == 'col2'){
			if(new_width_col1 > width_col1)
				add += new_width_col1 - width_col1;
			if(new_width_col3 > width_col3)
				add += new_width_col3 - width_col3;
			add +=20;

		}
		else if(type_col == 'col3'){
			if(new_width_col2 > width_col2)
				add += new_width_col2 - width_col2;
			if(new_width_col1 > width_col1)
				add += new_width_col1 - width_col1;
			add +=20;

		}

		var new_wrapper_width = 640 + add_to_modal_width*1 + add;
		var buffer_add = add + add_to_modal_width*1;
			
		if(new_wrapper_width > wrapper_width)
			$('#sb-wrapper').width(new_wrapper_width);
		new_width_col1 = $('#sb-player .col_1').parent().width();
		new_width_col2 = $('#sb-player .col_2').parent().width();
		new_width_col3 = $('#sb-player .col_3').parent().width();
		
		if(buffer_add > 0){
			var new_modal_left = modal_left - Math.round(buffer_add/2);
			$('#sb-wrapper').css({'left':new_modal_left});
		}

	}
	
	function hide_field(object,type_col){
		var old_width = $('#sb-player #edit_image').width();
		
		var new_width = $('#sb-player #edit_image').width();
		if($(object).parent().hasClass('container_tiny_url')){
			var hidden = $(object).closest('.hcAreaModal');
		}
		else{
			var hidden = $(object).parent();
		}
		var hidden_link = hidden.prev();

		var buffer_width_col = new_width_col1;
		hidden.hide();
		hidden_link.show();
		var wrapper_width = $('#sb-wrapper').width();
		var add_to_modal_width = $(object).parent().next().val();

		new_width_col1 = $('#sb-player .col_1').parent().width();
		new_width_col2 = $('#sb-player .col_2').parent().width();
		new_width_col3 = $('#sb-player .col_3').parent().width();

		max_width1 = 0;
		max_width2 = 0;
		max_width3 = 0;

		$("#sb-player .col_1:visible").each(function(){
        if($(this).next().val() > max_width1)
			max_width1 = $(this).next().val();
			
		});
		
		$("#sb-player .col_2:visible").each(function(){
        if($(this).next().val() > max_width2)
			max_width2 = $(this).next().val();
			
		});
		
		$("#sb-player .col_3:visible").each(function(){
        if($(this).next().val() > max_width3)
			max_width3 = $(this).next().val();
			
		});
		
		max_width1 *=1;
		max_width2 *=1;
		max_width3 *=1;
		var add = (max_width1 + max_width2 + max_width3)+20;
		var new_wrapper_width = width_modal + add;

		$('#sb-wrapper').width(new_wrapper_width);
		var buffer_add = add + add_to_modal_width*1;
			
		if(new_wrapper_width < wrapper_width)
			$('#sb-wrapper').width(new_wrapper_width);
	
		
		if(buffer_add > 0){
			var new_modal_left = modal_left + Math.round(buffer_add/2);
			$('#sb-wrapper').css({'left':new_modal_left});
		}

	}
	
	function show_image(object){
		
		Shadowbox.open({
        	content: object.href,
        	player:     "img",
			continuous: true,
			
    	});	
			 
	}
	
	function show_image_main(object){
		
		var big_image = $(object).find('img').attr('src');
		Shadowbox.open({
        	content: big_image,
        	player:     "img",
			continuous: true,
			
    	});	
			 
	}
	
	function show_image_gallery(object){
		
		Shadowbox.open({
        	content: object.href,
        	player:     "img",
			continuous: true,
			
    	});	
		
		var height_container = $('#sb-wrapper').height();
	}
	
	function get_exif(){
		
		 var height_modal = $('#exif').height() + 50;
		 
		 Shadowbox.open({
        	content:  $('#exif').html()  ,
        	player:     "html",
        	title:      "Информация EXIF",
			left: 200,
			height: height_modal,
			overlayOpacity: 0.7,
			handleOversize: 'resize'
    	});		 
	}
	
	function get_statistic(object){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).parent().html();
		
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<img src="'+ajax_url+'">');	
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			
			$(object).html(container);
			Shadowbox.open({
        	content:  data.content  ,
        	player:  "html",
        	title:  data.title,
			left: 200,
			height: 200,
			overlayOpacity: 0.7,
			handleOversize: 'resize'
    		});		 
		}
    	});
	}
	
	
	function delete_image_from_albums(object,id,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).html();

		if(confirm(message)){
			
			$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<img src="'+ajax_url+'">');	
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			var num_images = $('#list_files .row').size();
			var current_page = $('.pagination b').text() * 1;
			if(data.answer == 1){
				if(num_images == 1){
					document.location.reload();

				}
				else{
					if(current_page < 2)
						paginate_link_list_files('/albums/files/1');
					else
						paginate_link_list_files('/albums/files/'+current_page);

				}

				}
			
			else{
				$(object).html(container);
				alert('Неизвестная ошибка!');
			}
			
		}
    	});
		
		}

	}
	
	function delete_image_from_edit_cover(object,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).closest('.cimage').html();
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
			$(parent).html(container);	
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(parent).html(container);	

			if(data.answer == 1){
				$(parent).closest('.uploadForm').find('.hidden').hide();
				$(parent).closest('.uploadForm').find('.choose-source').show();
				$(parent).closest('.uploadForm').find('.container_link').remove();
				$(parent).closest('.uploadForm').find('.ajax_loader').remove();
				$(parent).closest('.uploadForm').find('.filename a').remove();
				$(parent).closest('.uploadForm').attr('action','/upload/fast?token='+token+'&torrent_id='+torrent_id+'&cover=1');
				$(parent).closest('.uploadForm').find('.submit').val('Загрузить');
			}
			else{
				alert('Ошибка загрузки!');
			}
			
		}
    	});
		}

	}

	function delete_image_from_fast(object,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).closest('.cimage').html();
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
			$(parent).html(container);	
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(parent).html(container);	

			if(data.answer == 1){
				$(parent).closest('.uploadForm').find('.hidden').hide();
				$(parent).closest('.uploadForm').find('.choose-source').show();
				$(parent).closest('.uploadForm').find('.container_link').remove();
				$(parent).closest('.uploadForm').find('#edit_file').hide();
				$(parent).closest('.uploadForm').find('.ajax_loader').remove();
				$(parent).closest('.uploadForm').find('.filename a').remove();
				var action = $(parent).closest('.uploadForm').attr('action');
				if(action.indexOf('upload') == -1){
					$(parent).closest('.uploadForm').attr('action','/upload/fast');				}
			}
			else{
				alert('Ошибка загрузки!');
			}
			
		}
    	});
		}

	}
	
	function set_torrents_cover(){
		
		if(typeof(token) == 'undefined' || token == '')
			return false;
		if(typeof(torrent_id) == 'undefined' || torrent_id == '')
			return false;
		if(typeof(from_edit_fast) != 'undefined' && from_edit_fast == '1'){
			var parameters = '?is_cover=1';
		}
		else{
			var parameters = '';

		}
		$.ajax({	
		type: "POST",
   	 	url: '/seedoff_check/pictures_list/'+torrent_id+parameters,
    	cache: false,
		beforeSend:function(){
			$('#sync_info').show();	
		},
		error:function(){
			$('#sync_info').html('Синхронизация с Seedoff.net завершилась неудачей');	
		},
    	success: function(data){
			$('#sync_info').hide();	
			$('#pictures_list').val(data);
            seedoff_sync_from_edit();
		}
	});	
	}
	
	function remove_cover(){
		
		if(typeof(token) == 'undefined' || token == '')
			return false;
		if(typeof(torrent_id) == 'undefined' || torrent_id == '')
			return false;

		$.ajax({	
		type: "POST",
   	 	url: '/seedoff/remove_cover/'+torrent_id+'?token='+token+'&torrent_id='+torrent_id,
    	cache: false,
		beforeSend:function(){
			$('#sync_info').show();	
		},
		error:function(){
			$('#sync_info').html('Синхронизация с Seedoff.net завершилась неудачей');	
		},
    	success: function(data){
			$('#sync_info').hide();	

		}
	});	
	}
	
	function set_torrents_list(){
	
		if(typeof(token) == 'undefined' || token == '')
			return false;
		if(typeof(torrent_id) == 'undefined' || torrent_id == '')
			return false;

		$.ajax({	
		type: "POST",
   	 	url: '/seedoff_check/pictures_list/'+torrent_id,
    	cache: false,
		beforeSend:function(){
			$('#sync_info').show();	
		},
		error:function(){
			$('#sync_info').html('Синхронизация с Seedoff.net завершилась неудачей');	
		},
    	success: function(data){
			$('#sync_info').hide();	
			$('#pictures_list').val(data);
            seedoff_sync_from_edit();
		}
	});	
		
	}
	
	function seedoff_sync_from_edit(){
			
	if(typeof(token) == 'undefined' || token == '')
		return false;
	var url = '/seedoff/upload';
	var counter = 1;
	var links = '';
	var list = new Array();
	if(typeof(torrent_id) == 'undefined')
		return false;
	if($('#pictures_list').length > 0){
	  
		var buffer = $('#pictures_list').val();
		var urls = buffer.split(';');
		for(i=0;i<urls.length;i++){
			var buffer_url = urls[i];
			buffer_url = encodeURIComponent(buffer_url);
			links += '&link_'+counter+'='+buffer_url;
			counter++;		
		}
		if(counter != 1)
		counter--;
		
	
	var all_uploaded = urls.length;
	}
	else{
		$(".panel .file_item a.shadowbox").each(function(){
		var buffer_url = $(this).attr('href');
		buffer_url = encodeURIComponent(buffer_url);
		links += '&link_'+counter+'='+buffer_url;
		counter++;		
		
	}); 
	if(counter != 1)
		counter--;
		
	var all_uploaded = $('.panel_iframe .file_item a').size();
	}
	
	if(typeof(from_edit_fast) != 'undefined' && from_edit_fast == 1){
		var cover_url = $('#current_url').val();
		links += '&cover='+cover_url;
	}
		
	$.ajax({
		type: "POST",
   	 	url: url,
		data: 'token='+token+'&torrent_id='+torrent_id+'&number='+all_uploaded+links,
        dataType: 'json',
    	cache: false,
		beforeSend:function(){
			$('#sync_info').show();	
		},
		error:function(){
			$('#sync_info').html('Синхронизация с Seedoff.net завершилась неудачей');	
		},
    	success: function(data){
			 $('#sync_info').hide();	
//             set_filename(torrent_id,token,data.filename);
		}
	});	
		
	}
	
	
	function delete_image_from_gallery(object,id,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).html();
		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				document.location.href = '/gallery';
			}
			else{
				$(object).html(container);
				alert('Ошибка загрузки!');

			}

		}
    	});
		}
	}
	
	function delete_image_from_album_gallery(object,id,album_id,type,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).html();
		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				if(type == 'album')
					document.location.href = '/albums/'+album_id;
				else
					document.location.href = '/torrents/'+album_id;

			}
			else{
				$(object).html(container);
				alert('Ошибка загрузки!');

			}

		}
    	});
		}
	}
	
	function delete_image_from_seedoff_without_confirm(object,id){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container_link = $('#link_'+id).html();
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#link_'+id).html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('#link_'+id).html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				$('#link_'+id).closest('.container_item').find('.file_item_edit').remove();
				$('#link_'+id).remove();
//				set_torrents_list();
			}
			else{
				$('#link_'+id).html(container_link);
				alert(data.content);
			}

		}
    	});
		
	}
	
	function delete_image_from_seedoff_edit(object,id,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container_link = $('#link_'+id).html();
		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#link_'+id).html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('#link_'+id).html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				$('#link_'+id).closest('.container_item').find('.file_item_edit').remove();
				$('#link_'+id).remove();
//				set_torrents_list();
			}
			else{
				$('#link_'+id).html(container_link);
				alert(data.content);
			}

		}
    	});
		}
	}
	
	function delete_cover_from_seedoff_edit(object,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container_link = $('.uploadForm .cimage').html();
		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('.uploadForm .cimage').html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('.uploadForm .cimage').html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				$('.uploadForm .cell a').remove();
				$('.uploadForm .cimage a').remove();
				$('.uploadForm .ajax_loader').remove();
				$('.uploadForm').attr('action','/upload/fast?token='+token+'&torrent_id='+torrent_id+'&cover=1');
				$('.uploadForm .tags').val(0);
				$('.uploadForm .choose-source').show();
				$('.uploadForm .container_link').hide();
				$('.uploadForm #ACCESS').val('public');
//				if($('#all_submit').length > 0 && $('#all_submit').is(':visible')){
//					$('.uploadForm #form_action').remove();
//					$('#all_submit').show();
//				}
//				else{
					$('.uploadForm #form_action').val('Загрузить');
					type_operation = 'upload';
//				}
				
			
//				remove_cover();
			}
			else{
				alert(data.content);
				$('.uploadForm .cimage').html(container_link);

			}

		}
    	});
		}
	}

	function delete_image_from_page(object,id,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).parent();
		var container_link = $(object).parent().html();

		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).replaceWith('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			alert('Ошибка загрузки!');
			$(object).html(container_link);

		},
    	success: function(data){
			if(data.answer == 1){
				document.location.href = '/profile';
			}
			else{
				$(object).html(container_link);
				alert(data.content);
			}
			
		}
    	});
		}
	}
	
	function delete_image(object,id,message){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = $(object).parent();
		var container_row = $(object).parent().parent();
		var container_link = $(object).parent().html();
		if(confirm(message)){
			
		$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).replaceWith('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$(object).html(container_link);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(object).html(container_link);
			if(data.answer == 1){
				$('#row_'+id).remove();
				var height_image_table = $('.image_list table').height();
				var curr_overflow = $('.image_list').css('overflow-y');
				if(height_image_table > 520){
					$('.image_list').css({'overflow-y' : 'scroll'});
				}
				else{
					if(curr_overflow == 'scroll')
						$('.image_list').css({'overflow-y' : 'hidden'});

				}
				var sizes = $('.image_list table tr').size();
				if(sizes == 1){
					var curr_page = $('#container_profile .pagination strong').text();
					var page = (curr_page*1) - 1;
					if(page == -1){
						$('.images_table').remove();
						$('.image_list').append('<div style="text-align: center;font-size: 16px;font-weight: bold;">Изображений нет</div>');
						return false;
					}
					if(curr_page != 1){
						paginate_link('/profile/'+page);
					}

				}
			}
			else{
				alert(data.content);
			}
			
		}
    	});
		}

	}
	
	function paginate_link_sync(url){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big_sync.gif';
		var container = $('#content #container_left_panel').html();
		
		$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#content #container_left_panel').html('<div class="ajax_loader" style="padding-left:150px;padding-top:150px;"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('#content #container_left_panel').html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				$('#content').html(data.content);
				document.title = data.title;
				Shadowbox.setup("a.file_preview", {
        			gallery:   "mygallery"
					});

			}
			else{
				document.location.reload();
			}	
		}
    	});
	}
	
	function paginate_link_parent(url,direct){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var container = $('#content .wrap960').html();
		var container_image = $('#container_image').html();
		// Грузим новую страницу в профиле
		
		window.opener.jQuery.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		async: false,
		beforeSend:function(){
			window.opener.jQuery('#content .imglist').html('<div class="ajax_loader" style="padding-left:350px;padding-top:250px;"><img src="'+ajax_url+'"></div>');

		},
		error: function(){
			window.opener.jQuery('#content .imglist').html(container);
			window.opener.alert('Ошибка загрузки!');
		},
    	success: function(data){
//			$('#container_image').html(container_image);
			if(window.opener.jQuery('#current_paginate_url').length > 0)
				window.opener.jQuery('#current_paginate_url').val(url);
			if(data.answer == 1){
				window.opener.jQuery('#content .imglist').html(data.content);
				window.opener.document.title = data.title;
				window.opener.Shadowbox.setup("a.file_preview", {
        			gallery:   "mygallery"
					});
				set_navigation_parent(direct);

			}
			else{
				window.opener.jQuery('#content .wrap960').html(container);
				window.opener.alert('Неизвестная ошибка!');
			}	
		}
    	});
	}
	
	function paginate_link(url){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var container = $('#content .wrap960').html();
		var parameters = '';

		
		if($('#block_parameters').length > 0){
			
			parameters += '&IS_SEARCH=1';
			var from_width = $('#block_parameters #from_width').val();
			var to_width = $('#block_parameters #to_width').val();
			var from_height = $('#block_parameters #from_height').val();
			var to_height = $('#block_parameters #to_height').val();
			var tiny_url = $('#block_parameters #tinyurl').val();
			var tags = $('#block_parameters #tags').val();
			var tags_children = $('#block_parameters #tags_children').val();
			var access = $('#block_parameters #access').val();
			var filename = $('#block_parameters #filename').val();
			var comment = $('#sb-wrapper #comment').val();
			if(typeof(from_width) != 'undefined')
				parameters += '&FROM_WIDTH='+from_width;
			if(typeof(to_width) != 'undefined')
				parameters += '&TO_WIDTH='+to_width;
			if(typeof(from_height) != 'undefined')
				parameters += '&FROM_HEIGHT='+from_height;
			if(typeof(to_height) != 'undefined')
				parameters += '&TO_HEIGHT='+to_height;
			if(typeof(tiny_url) != 'undefined')
				parameters += '&TINYURL='+tiny_url;
			if(typeof(tags) != 'undefined')
				parameters += '&TAGS='+tags;
			if(typeof(tags_children) != 'undefined')
				parameters += '&TAGS_CHILDREN='+tags_children;
			if(typeof(access) != 'undefined')
				parameters += '&ACCESS='+access;
			if(typeof(filename) != 'undefined'){
				filename = encodeURIComponent(filename);
				parameters += '&FILENAME='+filename;
			}
			if(typeof(filename) != 'undefined'){
				comment = encodeURIComponent(comment);
				parameters += '&COMMENT='+comment;
			}
		}

		
		$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1'+parameters,
    	cache: false,
		beforeSend:function(){
			$('#content .imglist').html('<div class="ajax_loader" style="padding-left:350px;padding-top:250px;"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('#content .imglist').html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if($('#current_paginate_url').length > 0)
				$('#current_paginate_url').val(url);
			if(data.answer == 1){
				$('#content .imglist').html(data.content);
				document.title = data.title;
				Shadowbox.setup("a.file_preview", {
        			gallery:   "mygallery"
					});

			}
			else{
				$('#content .wrap960').html(container);
				alert('Неизвестная ошибка!');
			}	
		}
    	});
		
	}
	
	function paginate_link_list_files(url){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var container = $('#content #list_files').html();
		
		$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#content #list_files').html('<div class="ajax_loader"><img src="'+ajax_url+'"></div>');	
		},
		error: function(){
			$('#content #list_files').html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$('#current_paginate_url').val(url);
			if(data.answer == 1){
				$('#content #list_files').html(data.content);
				Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
				});	
				set_draggable();
				
			}
			else{
				$('#content #list_files').html(container);
				alert('Неизвестная ошибка!');
			}	
		}
    	});
		
	}
	
	function show_avatar(object){
		
		$('#container_filename .show_filename').html($(object).val());
		$('#container_filename .input_filename').show();
	}
	
	function load_more_hash(){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var all_uploaded = $('#all_uploaded').val();
		var items = $('#container_gallery .list-item').size();
		var new_page = ($('#current_page').val())*1 + 1;
		var buffer = document.location.hash;
		var buffer2 = buffer.split('_');
		if(buffer2[1] < 2)
			return false;
		
		if(items < all_uploaded){
			
			for(var i = new_page; i < buffer2[1]; ++i){
				load_more(i);
			}
	
		}
	
		
	}
	
	function hash_change_parent(url){
		if(supportsHistoryAPI == false)
			window.opener.location.href = url;
		if(window.opener.location.href == url)
			return false;
		from_layout = false;
		window.opener.history.pushState(null,window.opener.title,window.opener.location.href);
		window.opener.History.replaceState(null,null,url);
	}
	
	function hash_change(url){
		if(supportsHistoryAPI == false)
			document.location.href = url;
		if(document.location.href == url)
			return false;
		from_layout = false;
		last_url = document.location.href;		
		history.pushState(null,document.title,document.location.href);
		History.replaceState(null,null,url);
	}
	
	function hash_change_image(url,direct){
		if(supportsHistoryAPI == false)
			document.location.href = url;
		if(document.location.href == url)
			return false;
		from_layout = false;
		last_url = document.location.pathname;
		history.pushState(null,document.title,document.location.href);
		History.replaceState(null,null,url);
		global_direct = direct;
	}
	
	function clone(obj){
    if(obj == null || typeof(obj) != 'object')
        return obj;
    var temp = new obj.constructor();
    for(var key in obj)
        temp[key] = clone(obj[key]);
    return temp;
}
	
	function add_image_shadowbox_gallery(){
		var id = global_direct+'_link_direct';
		var href = $('#'+id).attr('href');
		var elem = document.getElementById(id);
		
	}
	
	function navigation_image(url){
			from_big = false;
			var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
			var container = $('#container_image').html();
			var left_offset = Math.round($('#container_image').width()*0.46);
			var top_offset = Math.round($('#container_image').height()*0.46);
			$.ajax({
			type: "POST",
   	 		url: url,
			dataType: 'json',
			data: 'is_ajax=1',
    		cache: false,
			beforeSend:function(){
				$('#container_image').html('<div style="padding-left:'+left_offset+'px;padding-top:'+top_offset+'px;"><img src="'+ajax_url+'"></div>');	
			},
			error: function(){
				$('#container_image').html(content);
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				
				$('#image').css('opacity', 1);

				if(data.answer == 1){
					$('#container_image').html(data.content);
					document.title = data.title;
					if($('#container_image').length > 0){
					var prev_link = $('#container_image').find('#prev_link').attr('href');
					var next_link = $('#container_image').find('#next_link').attr('href');
					if(Shadowbox.isOpen())
						add_image_shadowbox_gallery();
					
					if(is_profile == true){
						
						if($('#prev_link').length > 0 && prev_link == ''){
							$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png');
						}
						
						if($('#next_link').length > 0 && next_link == ''){
							$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png');
						}

						if(typeof(next_link) == 'undefined'){
							$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png');
							
						}
						if(prev_link == 'undefined'){
							$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png');

						}
						if(global_direct == 'next' && next_link == prev_link)
							$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png');

						if(global_direct == 'prev' && next_link == prev_link)
							$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png');
						
					}
					
						
				}
				}
				else{
					
					alert('Неизвестная ошибка!');
				}
			
			}
    		});	
			
	}
	
	function load_more_album_parent(new_page){
		
		if(!window.opener)
			return false;
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var album_id = window.opener.jQuery('#album_id').val();
			var time = new Date();
			var current_url = window.opener.document.location.href;
			var buffer_url = current_url.split('/');
			if(current_url.indexOf('tags') != - 1){
				if(buffer_url[buffer_url.length - 3] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 2]+'/';
				}
				else if(buffer_url[buffer_url.length - 2] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 1]+'/';

				}
				else{
					var add_url = '';

				}
			}
			else{
				var add_url = '';
			}
	if(album_id == 0)
		return false;
			
	var count_popular = 0;
	var tag_id = window.opener.jQuery('#TAGS option:selected').val();
	var popular_tags = '';
	
			
			$.ajax({
			type: "POST",
   	 		url: '/albums/'+album_id+'/'+new_page,
			dataType: 'json',
			data: 'is_ajax=1&is_load_more=1',
    		cache: false,
			beforeSend:function(){
				window.opener.jQuery('#container_gallery .list-item:last').after('<div class="list-item c7 gutter-margin-right-bottom privacy-public" data-id="" data-type="image"><div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div></div>');	
			},
			error: function(){
				window.opener.jQuery('#container_gallery .ajax_loader').parent().remove();
				window.opener.alert('Ошибка загрузки!');
			},
    		success: function(data){
				window.opener.jQuery('#container_gallery .ajax_loader').parent().remove();
				var num_pages = window.opener.jQuery('.curpage_'+new_page).size();
				if(data.answer == 1){
					if(num_pages == 0){
						window.opener.jQuery('#container_gallery .list-item:last').after(data.content);
						window.opener.jQuery('#current_page').val(new_page);
						if(supportsHistoryAPI == false){
							window.opener.document.location.hash = 'p_'+new_page;
						}
						else{
							window.opener.history.pushState(null,document.title,document.location.href);
							window.opener.history.replaceState(null,null,'/albums/'+album_id+'/'+new_page);
						}

					}
					window.opener.document.title = data.title;
					window.opener.Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});
					
				}
				else{
					
					window.opener.alert('Неизвестная ошибка!');
				}
			
			}
    		});	
	}
	
	function load_more_album(new_page){
			
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var album_id = $('#album_id').val();
			var time = new Date();
			var current_url = document.location.href;
			var buffer_url = current_url.split('/');
			if(current_url.indexOf('tags') != - 1){
				if(buffer_url[buffer_url.length - 3] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 2]+'/';
				}
				else if(buffer_url[buffer_url.length - 2] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 1]+'/';

				}
				else{
					var add_url = '';

				}
			}
			else{
				var add_url = '';
			}
	if(album_id == 0)
		return false;
			
	var count_popular = 0;
	var tag_id = $('#TAGS option:selected').val();
	var popular_tags = '';
	
			
			$.ajax({
			type: "POST",
   	 		url: '/albums/'+album_id+'/'+new_page,
			dataType: 'json',
			data: 'is_ajax=1&is_load_more=1',
    		cache: false,
			beforeSend:function(){
				$('#container_gallery .list-item:last').after('<div class="list-item c7 gutter-margin-right-bottom privacy-public" data-id="" data-type="image"><div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div></div>');	
			},
			error: function(){
				$('#container_gallery .ajax_loader').parent().remove();
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				$('#container_gallery .ajax_loader').parent().remove();
				var num_pages = $('.curpage_'+new_page).size();
				if(data.answer == 1){
					if(num_pages == 0){
						$('#container_gallery .list-item:last').after(data.content);
						$('#current_page').val(new_page);
						if(supportsHistoryAPI == false){
							document.location.hash = 'p_'+new_page;
						}
						else{
							history.pushState(null,document.title,document.location.href);
							History.replaceState(null,null,'/albums/'+album_id+'/'+new_page);
						}
						if(image_window.location)
							image_window.location.reload();

					}
					document.title = data.title;
					Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});
					
				}
				else{
					
					alert('Неизвестная ошибка!');
				}
			
			}
    		});	
	}
	
	function get_current_page_profile(direct){
		if(direct == 'next')
			var url = window.opener.jQuery('.pagination b').next().attr('href');
		else
			var url = window.opener.jQuery('.pagination b').prev().attr('href');
		return url;
	}
	
	function set_navigation_parent(direct){
		try{
			if(window.opener && document.location.hostname == window.opener.location.hostname){
				var items = new Array();
				var items_for_browse = new Array();
				var counter = 0;
				var str = '';
					var image_selector = '.image-container-profile';

					var num = window.opener.jQuery(image_selector).size();
					if(num == 0)
						return false;
					var buffer_items = new Array();
					var image_url = $('#image_url').val();
				
					window.opener.jQuery(image_selector).each(function(){
					var curr_url = window.opener.jQuery(this).attr('href');
					items_for_browse[counter]['main'] = curr_url;
					items_for_browse[counter]['img'] = window.opener.jQuery(this).find('img').attr('src');
					str += curr_url;

					items[counter] = curr_url;
					img_items[counter] = curr_img_url;
					counter++;
        
					});
					if(global_direct == 'next')
						relative_url = items[0];

					if(global_direct == 'prev'){
						return false;
					}
				set_browser_list_images(items_for_browse,image_url);
				if(items.length > 1){
					for(i = 0; i < items.length; i++){
						if(items[i] == relative_url){
							if(i == 0){
								var prev_url = '';
								var next_url = items[(i*1)+1];
							}
							else if(i == items[items.length-1]){
								var next_url = '';
								var prev_url =  items[(i*1)-1];
							}
							else{
								var prev_url =  items[(i*1)-1];
								var next_url = items[(i*1)+1];
							}
						}
					}
				}
				console.info('prev_url '+prev_url+' next_url '+next_url);

				if(direct == 'next' && prev_url == ''){
					prev_url = last_url;
					next_url = items[0];

				}
				else if(direct == 'prev' && next_url == ''){
					next_url = last_url;
					prev_url = items[items.length - 1];
				}

				
				if(typeof(prev_url) != 'undefined' && prev_url != ''){
					$('#prev_link').attr('href',prev_url);
				}
				else{
						load_more_profile('prev');	

				}
				
				if(typeof(next_url) != 'undefined' && next_url != ''){
					$('#next_link').attr('href',next_url);
				}
				else{
					load_more_profile('next');
					
				}
				

			}
		}
		catch(e){
		}
			if(from_seedoff == 1){
				var current_prev_link = $('#prev_link').attr('href');
				var current_next_link = $('#next_link').attr('href');

				if($('#prev_link').length > 0 && current_prev_link == ''){
					$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png" />');

				}

				if($('#next_link').length > 0 && current_next_link == ''){
					$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png" />');

				}
			}
		remove_image_link();
	}
	
	function set_shadowbox_link(type){
		global_direct = type;
		var id = type+'_link';
		var href = $('#'+id).attr('href');
		hash_change(href,type);
			
	}
	
	function clsg(){
		
		$("#sb-nav-previous").bind("click", function(e){
      		set_shadowbox_link('prev');
    	});
		if(Shadowbox.hasNext()){
			$("#sb-nav-next").bind("click", function(e){
      			set_shadowbox_link('next');
    		});
			
		}	
		
	}
	
	function create_links_shadowbox_gallery(){
		setTimeout('clsg()',500);
	}
	
	function set_navigation(){
		try{
			if(window.opener && document.location.hostname == window.opener.location.hostname){
				var items = new Array();
				var items_direct = new Array();
				var items_for_browse = new Array();
				var counter = 0;
				var str = '';
				var num = window.opener.jQuery('.image-container').size();
				var image_url = $('#image_url').val();
				from_gallery = true;

				if(num == 0){
					remove_image_link();
					return false;
				}

				window.opener.jQuery('.image-container').each(function(){
					var curr_url = window.opener.jQuery(this).attr('href');
					var curr_url_direct = window.opener.jQuery(this).find('img').attr('src');
					var img_url = window.opener.jQuery(this).find('img').attr('src');
					items_for_browse[counter] = {'main' : curr_url, 'img' : img_url};
					str += curr_url;
					items[counter] = curr_url;
					items_direct[counter] = curr_url_direct;
					counter++;
        
				});
				if(browse_mode == 1)
					set_browser_list_images(items_for_browse,image_url);
				
				if(items.length > 1){
					for(i = 0; i < items.length; i++){
						if(items[i] == relative_url){
							if(i == 0){
								var prev_url = '';
								var prev_url_direct = '';
								var next_url = items[(i*1)+1];
								var next_url_direct = items_direct[(i*1)+1];
							}
							else if(i == items[items.length-1]){
								var prev_url =  items[(i*1)-1];
								var prev_url_direct =  items_direct[(i*1)-1];
								var next_url = '';
								var next_url_direct = '';
							}
							else{
								var prev_url =  items[(i*1)-1];
								var prev_url_direct =  items_direct[(i*1)-1];
								var next_url = items[(i*1)+1];
								var next_url_direct = items_direct[(i*1)+1];
							}
						}
					}
				}
				
				if(prev_url){
					$('#prev_link').attr('href',prev_url);
					$('#prev_link_direct').attr('href',prev_url_direct);
				}
				else{
					$('#prev_link').parent().html('<div style="width:32px;height:32px;"></div>');

				}
				
				if(next_url){
					$('#next_link').attr('href',next_url);
					$('#next_link_direct').attr('href',next_url_direct);
				}
				else{
					load_more_opener();

				}

			
		}
		}
		catch(e){
		
			if(from_seedoff == 1){
				var current_prev_link = $('#prev_link').attr('href');
				var current_next_link = $('#next_link').attr('href');

				if($('#prev_link').length > 0 && current_prev_link == ''){
					$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png" />');

				}

				if($('#next_link').length > 0 && current_next_link == ''){
					$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png" />');

				}
			}
		}
		remove_image_link();
			
			
	}
	
	function set_navigation_profile(){
		try{
			if(window.opener && document.location.hostname == window.opener.location.hostname){
				var items = new Array();
				var counter = 0;
				var str = '';
					var image_selector = '.image-container-profile';

					var num = window.opener.jQuery(image_selector).size();
					if(num == 0)
						return false;
					var buffer_items = new Array();
				
					window.opener.jQuery(image_selector).each(function(){
					var curr_url = window.opener.jQuery(this).attr('href');
					str += curr_url;

					items[counter] = curr_url;
					counter++;
        
					});

					
				// Перебираем урлы на странице родителя 
				if(items.length > 1){
					for(i = 0; i < items.length; i++){
						if(items[i] == relative_url){
							if(i == 0){
								var buffer_page_prev = get_current_page_profile('prev');
								if(typeof(buffer_page_prev) != 'undefined')
									var prev_url = last_url;
								else
									var prev_url = '';
								if(last_url == items[1])
									prev_url = '';
								var next_url = items[(i*1)+1];
							}
							else if(i == items[items.length-1]){
								var buffer_page_next = get_current_page_profile('next');
								if(typeof(buffer_page_next) != 'undefined')
									var next_url = last_url;
								else
									var next_url = '';
								var prev_url =  items[(i*1)-1];
							}
							else{
								var prev_url =  items[(i*1)-1];
								var next_url = items[(i*1)+1];
							}
						}
					}
				}

				if(typeof(prev_url) != 'undefined' && prev_url != ''){
					$('#prev_link').attr('href',prev_url);
				}
				else{

				}
				
				if(typeof(next_url) != 'undefined' && next_url != ''){
					$('#next_link').attr('href',next_url);
				}
				else{

//					load_more_profile('next');

				}
				

			}
		}
		catch(e){
		}
			if(from_seedoff == 1){
				var current_prev_link = $('#prev_link').attr('href');
				var current_next_link = $('#next_link').attr('href');

				if($('#prev_link').length > 0 && current_prev_link == ''){
					$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png" />');

				}

				if($('#next_link').length > 0 && current_next_link == ''){
					$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png" />');

				}
			}
		remove_image_link();
			
	}
	
	
	function get_navigation_url(url){
		
			$.ajax({
			type: "POST",
   	 		url: url,
			dataType: 'json',
			data: 'is_ajax=1&is_top=1',
    		cache: false,
			beforeSend:function(){
				$('#content-listing-tabs').html('<div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div>');	
			},
			error: function(){
				$('#content-listing-tabs').html(container);
				alert('Ошибка загрузки!');
			},
    		success: function(data){
					$('#content-listing-tabs').html(data.content);
											
					Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});		
			
			}
    		});	
	}

	function splitterWord(word,maxlength){
	if(typeof(word) == 'undefined')
		return '';
	var step = maxlength;	
	var buffer = word.split(' ');

	if(buffer.length > 1){
		var word_end = buffer[buffer.length - 1].length;
		if(word_end < maxlength)
			return word;
	}
	else{
		word_end = word.length;
		if(word_end < maxlength)
			return word;
	}
	var new_word = '';
	for(var i = 0; i < word_end; ++i){
		new_word += word.substr(i,1);
		if(i == maxlength){
			new_word += '<br>';
			maxlength += step;
		}
	}
	return new_word;
}
	
	function remove_image_link(){
		var buffer = document.location.href;
		var buffer_url = buffer.split('/image');;
		var current_url = '/image'+buffer_url[1];
		var next_link = $('#next_link').attr('href');
		var prev_link = $('#prev_link').attr('href');
		
		if($('#next_link').length > 0 && (current_url == next_link || next_link.length < 1)){
			$('#next_link').parent().html('<img src="/templates/imghost/images/right_arrow_deactive.png" />');
		}
		
		if($('#prev_link').length > 0 && (current_url == prev_link || prev_link.length < 1)){
			$('#prev_link').parent().html('<img src="/templates/imghost/images/left_arrow_deactive.png" />');
		}
	}
	
	function load_more_parent(new_page){
		
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var parameters = '';
			var time = new Date();
			if(!window.opener)
				return false;
			var current_url = window.opener.document.location.href;
			console.info('current_url '+current_url);
			var buffer_url = current_url.split('/');
			if(current_url.indexOf('tags') != - 1){
				if(buffer_url[buffer_url.length - 3] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 2]+'/';
				}
				else if(buffer_url[buffer_url.length - 2] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 1]+'/';

				}
				else{
					var add_url = '';

				}
			}
			else if(current_url.indexOf('genres') != - 1){

				var buffer = buffer_url[buffer_url.length - 1];

				var add_url = 'genres/';
				if(buffer.indexOf('?') != -1){
					var temp = buffer.split('?');
					parameters = '?'+temp[1];
				}
				
			}
			else{
				var add_url = '';
			}
	var count_popular = 0;
	var tag_id = window.opener.jQuery('#TAGS option:selected').val();
	var popular_tags = '';
	
	window.opener.jQuery(".hiddenpopular").each(function(){
		var id = window.opener.jQuery(this).attr('id');
		var buffer = id.split('_');
		var tag_id = buffer[1];
        if($(this).val() == 1){
			popular_tags += tag_id+', ';	
			count_popular++;
		}
		else{

		}
		
	}); 
	
	if(tag_id == 0 && popular_tags == ''){

	}
	else if(tag_id == 0 && popular_tags != ''){
		var buffer = popular_tags.split(',');
		tag_id = buffer[0];
	}
		
	if(popular_tags != '')	
		popular_tags = '&popular_tags='+popular_tags;
			
			window.opener.jQuery.ajax({
			type: "POST",
   	 		url: '/gallery/' + add_url + new_page + parameters,
			dataType: 'json',
			data: 'is_ajax=1&is_load_more=1'+popular_tags,
			async: false,
    		cache: false,
			beforeSend:function(){
				window.opener.jQuery('#container_gallery .list-item:last').after('<div class="list-item c7 gutter-margin-right-bottom privacy-public" data-id="" data-type="image"><div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div></div>');	
			},
			error: function(){
				window.opener.jQuery('#container_gallery .ajax_loader').parent().remove();
				window.opener.alert('Ошибка загрузки!');
			},
    		success: function(data){
				window.opener.jQuery('#container_gallery .ajax_loader').parent().remove();
				var num_pages = window.opener.jQuery('.curpage_'+new_page).size();
				if(data.answer == 1){
					if(num_pages == 0){
						window.opener.jQuery('#container_gallery .list-item:last').after(data.content);
						window.opener.jQuery('#current_page').val(new_page);
						if(supportsHistoryAPI == false){
							window.opener.document.location.hash = 'p_'+new_page;
						}
						else{
							window.opener.history.pushState(null,document.title,document.location.href);
							window.opener.history.replaceState(null,null,'/gallery/' + add_url + new_page + parameters);
						}

					}
					window.opener.document.title = data.title;
					
					window.opener.Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});
					set_navigation();
					
				}
				else{
					
					window.opener.alert('Неизвестная ошибка!');
				}
			
			}
    		});	
	}
	
	function load_top(url){
		var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
		var container = $('#content-listing-tabs').html();
		
		$.ajax({
			type: "POST",
   	 		url: url,
			dataType: 'json',
			data: 'is_ajax=1&is_top=1',
    		cache: false,
			beforeSend:function(){
				$('#content-listing-tabs').html('<div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div>');	
			},
			error: function(){
				$('#content-listing-tabs').html(container);
				alert('Ошибка загрузки!');
			},
    		success: function(data){
					$('#content-listing-tabs').html(data.content);
											
					Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});		
			
			}
    		});	

	}
	
	function load_more(new_page){
		
			var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
			var time = new Date();
			var current_url = document.location.href;
			var buffer_url = current_url.split('/');
			var parameters = '';
			if(current_url.indexOf('tags') != - 1){
				if(buffer_url[buffer_url.length - 3] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 2]+'/';
				}
				else if(buffer_url[buffer_url.length - 2] == 'tags'){
					var add_url = 'tags/'+buffer_url[buffer_url.length - 1]+'/';

				}
				else{
					var add_url = '';

				}
			}
			else if(current_url.indexOf('genres') != - 1){

				var buffer = buffer_url[buffer_url.length - 1];

				var add_url = 'genres/';
				if(buffer.indexOf('?') != -1){
					var temp = buffer.split('?');
					parameters = '?'+temp[1];
				}
				
			}
			else if(current_url.indexOf('is_cover') != - 1){

				var buffer = buffer_url[buffer_url.length - 1];
				var add_url = '';

				if(buffer.indexOf('?') != -1){
					var temp = buffer.split('?');
					parameters = '?'+temp[1];
				}
				
			}
			else if(current_url.indexOf('top') != - 1){
				
				
				if(buffer_url[buffer_url.length - 3] == 'top'){
					var add_url = 'top/'+buffer_url[buffer_url.length - 2]+'/';
				}
				else if(buffer_url[buffer_url.length - 2] == 'top'){
					var add_url = 'top/'+buffer_url[buffer_url.length - 1]+'/';
				}
				else if(buffer_url[buffer_url.length - 1] == 'top'){
					var add_url = 'top/views/';

				}
				else{
					var add_url = '';

				}
			}
			else{
				var add_url = '';
			}
			
			
	var count_popular = 0;
	var tag_id = $('#TAGS option:selected').val();
	var popular_tags = '';
	
	$(".hiddenpopular").each(function(){
		var id = $(this).attr('id');
		var buffer = id.split('_');
		var tag_id = buffer[1];
        if($(this).val() == 1){
			popular_tags += tag_id+', ';	
			count_popular++;
		}
		else{

		}
		
	}); 
	
	if(tag_id == 0 && popular_tags == ''){

	}
	else if(tag_id == 0 && popular_tags != ''){
		var buffer = popular_tags.split(',');
		tag_id = buffer[0];
	}
		
	if(popular_tags != '')	
		popular_tags = '&popular_tags='+popular_tags;
			
			$.ajax({
			type: "POST",
   	 		url: '/gallery/'+add_url+new_page+parameters,
			dataType: 'json',
			data: 'is_ajax=1&is_load_more=1'+popular_tags,
    		cache: false,
			beforeSend:function(){
				$('#container_gallery .list-item:last').after('<div class="list-item c7 gutter-margin-right-bottom privacy-public" data-id="" data-type="image"><div class="ajax_loader" style="height:300px; width:200px;padding: 150px;"><img src="'+ajax_url+'"></div></div>');	
			},
			error: function(){
				$('#container_gallery .ajax_loader').parent().remove();
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				$('#container_gallery .ajax_loader').parent().remove();
				var num_pages = $('.curpage_'+new_page).size();
				if(data.answer == 1){
					if(num_pages == 0){
						$('#container_gallery .list-item:last').after(data.content);
						$('#current_page').val(new_page);
						if(supportsHistoryAPI == false){
							document.location.hash = 'p_'+new_page;
						}
						else{
							history.pushState(null,document.title,document.location.href);
							History.replaceState(null,null,'/gallery/'+add_url+new_page+parameters);
						}
						if(image_window.location)
							image_window.location.reload();

					}
					document.title = data.title;
					
					Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});
					
				}
				else{
					
//					alert('Неизвестная ошибка!');
				}
			
			}
    		});	
			
	}
	
	function show_main_url_album(object){
		
		var prev_elem = $(object).parent().parent().prev();
		var curr_elem = $(object).parent().parent();
		var prev_id = prev_elem.attr('id');
		var next_elem = $(object).parent().parent().next();
		var next_id = next_elem.attr('id');
		if(prev_elem.hasClass('list-item'))
			var prev_page = prev_elem.attr('data-page');	
		else
			var prev_page = '';
			
		if(next_elem.hasClass('list-item'))
			var next_page = next_elem.attr('data-page');	
		else
			var next_page = '';
		var album_id = $('#album_id').val();
		if(!album_id)
			document.location.href = $(object).attr('href');
	
		var index_elem = $(object).parent().parent().attr('data-number');
		var current_page = $(object).parent().parent().attr('data-page');	
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = curr_elem.html();
		
		$.ajax({
			type: "POST",
   	 		url: '/albums_history/'+album_id+'/'+current_page,
			dataType: 'json',
			data: 'is_ajax=1&is_gallery_history_album=1&prev_page='+prev_page+'&next_page='+next_page+'&current_index='+index_elem,
    		cache: false,
			beforeSend:function(){
			},
			error: function(){
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				if(data.answer == 1){
					document.location.href = $(object).attr('href');
				}
				else{
					
					alert('Неизвестная ошибка!');
				}
			
			}
		   });	
	}
	
	function go_to_page(object){
		return false;
		var url = $(object).attr('data-href');
		image_window = window.open(url);
		image_window.focus();
	}
	
	function open_main_url(object){
		image_window = window.open(object.href);
		image_window.focus();

	}
	
	function show_main_url(object){
		var prev_elem = $(object).parent().parent().prev();
		var curr_elem = $(object).parent().parent();
		var prev_id = prev_elem.attr('id');
		var next_elem = $(object).parent().parent().next();
		var next_id = next_elem.attr('id');
		if(prev_elem.hasClass('list-item'))
			var prev_page = prev_elem.attr('data-page');	
		else
			var prev_page = '';
			
		if(next_elem.hasClass('list-item'))
			var next_page = next_elem.attr('data-page');	
		else
			var next_page = '';
		var current_url = document.location.href;
		var buffer_url = current_url.split('/');
		if(buffer_url[4] == 'tags' && buffer_url.length > 5){
			var tags = 'tags/'+buffer_url[5]+'/';
		}
		else{
			var tags = '';
		}
		var index_elem = $(object).parent().parent().attr('data-number');
		var current_page = $(object).parent().parent().attr('data-page');	
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
		var container = curr_elem.html();
		
		$.ajax({
			type: "POST",
   	 		url: '/gallery_history/'+tags+current_page,
			dataType: 'json',
			data: 'is_ajax=1&is_gallery_history=1&prev_page='+prev_page+'&next_page='+next_page+'&current_index='+index_elem,
    		cache: false,
			beforeSend:function(){
			},
			error: function(){
				alert('Ошибка загрузки!');
			},
    		success: function(data){
				if(data.answer == 1){
					document.location.href = $(object).attr('href');
				}
				else{
					
					alert('Неизвестная ошибка!');
				}
			
			}
		   });	

	}
	

function get_categories_multiple(object){

	var num = $(object).find('option:selected').val();
	if(num != 0)
		$(object).parent().next().show();
	else
		$(object).parent().next().hide();
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';

		
		$.ajax({
			type: "POST",
   	 		url: '/categories/'+num,
			dataType: 'json',
			data: 'is_ajax=1&is_multiple=1',
    		cache: false,
			beforeSend:function(){
				$(object).parent().next().find('.input').html('<div><img src="'+ajax_url+'"></div>');
			},
			error: function(){
				alert('Ошибка загрузки!');
				$(object).parent().next().hide();

			},
    		success: function(data){
				if(data.answer == 1)
					$(object).parent().next().find('.input').html(data.content);
				else
					$(object).parent().next().hide();


			}
		 });	
}

function get_categories_profile(object){
	
	var num = $(object).find('option:selected').val();

	if($(object).closest('.upload_template').length > 0 || $(object).closest('.search_images').length > 0){
		if(num != 0)
			$(object).parent().next().show();
		else
			$(object).parent().next().hide();
	}
	else{
		if(num != 0)
		$(object).parent().next().find('.children_tags').show();
			else
		$(object).parent().next().find('.children_tags').hide();
	}
	
		var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';

		$.ajax({
			type: "POST",
   	 		url: '/categories/'+num,
			dataType: 'json',
			data: 'is_ajax=1',
    		cache: false,
			beforeSend:function(){
				$(object).parent().next().find('.children_tags').html('<div><img src="'+ajax_url+'"></div>');
			},
			error: function(){
				alert('Ошибка загрузки!');
				$(object).parent().next().hide();

			},
    		success: function(data){
				if($(object).closest('.upload_template').length > 0){
					if(data.answer == 1){
						$(object).parent().next().html(data.content);
						resize_modal();
					}
					else{
						$(object).parent().next().hide();
					}
				}
				else if($(object).closest('.search_images').length > 0){
					if(data.answer == 1){
						$(object).parent().next().html(data.content);
						resize_images_modal();

					}
					else{
						$(object).parent().next().hide();
					}
				}
				else{
					if(data.answer == 1)
						$(object).parent().next().find('.children_tags').html(data.content);
					else
						$(object).parent().next().find('.children_tags').hide();
					
				}
				

			}
		 });	
}

function get_categories_gallery(object,tag_id){
	var num = $(object).find('option:selected').val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $('#TAGS_CHILDREN').parent();
	var old_content = $('#TAGS_CHILDREN').parent().html();
	var selectbox = container.html();
	if(typeof(tag_id) != 'undefined')
		tag_id = '&tag_id='+tag_id;
	else
		tag_id = '';
	
	$.ajax({
		type: "POST",
   	 	url: '/categories/'+num,
		dataType: 'json',
		data: 'is_ajax=1&'+tag_id,
    	cache: false,
		beforeSend:function(){
			container.html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			alert('Ошибка загрузки!');
			container.html(old_content);

		},
    	success: function(data){
			if(data.answer == 1){
				container.html(data.content);
				$("#TAGS_CHILDREN").minimalect();
			}
			else{
				container.html(old_content);
			}
			
		}
	});	

}
	
function get_categories(object){
	if($('#container_gallery').length > 0){
		get_categories_gallery(object);
		return false;
	}
	if($(object).parent().parent().hasClass('hcArea')){
		get_categories_multiple(object);
		return false;
	}
	else if($(object).parent().parent().hasClass('hcAreaModal') || $(object).closest('.upload_template').length > 0 || $(object).closest('.search_images').length > 0){
		get_categories_profile(object);
		return false;
	}
	var num = $(object).find('option:selected').val();
	if(num != 0)
		$(object).parent().parent().next().show();
	else
		$(object).parent().parent().next().hide();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	
		$.ajax({
			type: "POST",
   	 		url: '/categories/'+num,
			dataType: 'json',
			data: 'is_ajax=1',
    		cache: false,
			beforeSend:function(){
				$(object).parent().parent().next().find('.input').html('<div><img src="'+ajax_url+'"></div>');
			},
			error: function(){
				alert('Ошибка загрузки!');
				$(object).parent().parent().next().hide();

			},
    		success: function(data){
				if(data.answer == 1)
					$(object).parent().parent().next().find('.input').html(data.content);
				else
					$(object).parent().parent().next().hide();

			}
		   });	

}

function open_popular(object){
	var tag_id = $(object).val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	document.location.href = '/gallery/tags/'+tag_id;

	/*
//	document.location.href = '/gallery/tags/'+tag_id;
	$.ajax({
		type: "POST",
   	 	url: '/gallery/tags/'+tag_id,
		dataType: 'json',
		data: 'is_ajax=1&is_search=1',
    	cache: false,
		beforeSend:function(){
			$('#content-listing-tabs').html('<div style="width:100%;padding:50%;"><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			alert('Ошибка загрузки!');
			$('#content-listing-tabs').html(container);

		},
    	success: function(data){
			$('#content-listing-tabs').html(data.content);
			if(supportsHistoryAPI == false){
				
			}	
			else{
				history.pushState(null,document.title,document.location.href);
				History.replaceState(null,null,url);
			}
			
			document.title = data.title;
			
			Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});
		
		}
	 });	
	*/
}

function search_by_tags(){
	var tag_id = $('#TAGS option:selected').val();
	var children_tag_id = $('#TAGS_CHILDREN option:selected').val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var container = $('#content-listing-tabs').html();
	var popular_tags = '';
	var popular_tag_names = '';
	if(children_tag_id != 0 && $('#TAGS_CHILDREN').html() != '')
		tag_id = children_tag_id;
	var count_popular = 0;
		
	$(".hiddenpopular").each(function(){
		var id = $(this).attr('id');
		var buffer = id.split('_');
		var tag_id = buffer[1];
        if($(this).val() == 1){
			popular_tags += tag_id+', ';	
			popular_tag_names += $('#textpopular_'+tag_id).val()+',';	
			count_popular++;
		}
		else{

		}
		
	}); 

	
	if(popular_tag_names != '')
		popular_tag_names = substr(popular_tag_names,0,-1);
	
	if(tag_id == 0 && popular_tags == ''){
		
	}
	else if(tag_id == 0 && popular_tags != ''){
		var buffer = popular_tags.split(',');
		tag_id = buffer[0];
	}
		
	if(popular_tags != '')	
		popular_tags = '&popular_tags='+popular_tags;
	if(tag_id == 0)
		var url = '/gallery';
	else
		var url = '/gallery/tags/'+tag_id;
		
	$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1&is_search=1'+popular_tags,
    	cache: false,
		beforeSend:function(){
			$('#content-listing-tabs').html('<div style="width:100%;padding:50%;"><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			alert('Ошибка загрузки!');
			$('#content-listing-tabs').html(container);

		},
    	success: function(data){
			$('#content-listing-tabs').html(data.content);
			if(supportsHistoryAPI == false){
				
			}	
			else{
				history.pushState(null,document.title,document.location.href);
				History.replaceState(null,null,url);
			}
			
			document.title = data.title;
			
			Shadowbox.setup("a.shadowbox", {
        			gallery:   "mygallery"
					});

			if($('#TAGS_CHILDREN').length > 1 && $('#TAGS_CHILDREN option:selected').val() != 0){
				if(popular_tag_names != '')
					popular_tag_names = $('#TAGS_CHILDREN option:selected').html() + ', ' + popular_tag_names;	
			}
			else if($('#TAGS option:selected').val() != 0){
					if(popular_tag_names != '')
					popular_tag_names = $('#TAGS option:selected').html() + ', ' + popular_tag_names;	
			}
			
			if(count_popular > 1)
				var show_header = data.header_short_tags;
			else
				var show_header = data.header_short_tag;
			
			
			if($('#images_with_tag').length > 0){
				if(popular_tag_names != '')
					$('#images_with_tag span').text(show_header+': '+popular_tag_names);
				else
					$('#images_with_tag span').text(data.header);
			}
			else{
				if(popular_tag_names != '')
					$('#search_panel').before('<div id="images_with_tag"><span>'+show_header+': '+popular_tag_names+'</span></div>');
				else
					$('#search_panel').before('<div id="images_with_tag"><span>'+data.header+'</span></div>');

			}

		}
	 });	
}

function is_empty_dropdown(){
	if($('#TAGS option:selected').val() == 0)
		return true;
	else
		return false;
}


function set_popular(object){
	
	var background = $(object).css('background');
	var tag_id = $(object).val();
	var tag_name = $('#textpopular_'+tag_id).val();
	
	if($('#hiddenpopular_'+tag_id).val() == 1){
		$(object).css({'background':'inherit','color':'inherit'});
		$(object).text(tag_name);
		$('#hiddenpopular_'+tag_id).val(0);
		if(is_empty_dropdown() == true){
			History.replaceState(null,null,'/gallery');
		}
		
	}
	else{
		$(object).css({'background':'#000','color':'#fff'});
		var content = tag_name + ' <font class="close_tag">X</font>';
		$(object).html(content);
		var tag_id = $(object).val();
		$('#hiddenpopular_'+tag_id).val(1);
	}

}

function delete_album(id,object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var old_tree = $('#container_file_tree').html();
	
	if(confirm('Вы уверены в том, что хотите удалить данный альбом? Он будет удален вместе с фотографиями, входящими в него.')){
		
	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#container_file_tree').html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$('#container_file_tree').html(old_tree);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			if(data.answer == 1){
				if(data.content != ''){
					$('#container_file_tree').html(data.content);
					$("#albums_tree").treeview({
					persist: "location",
					collapsed: true
					});
							
				}
				$('#num_folders').text(data.num_folders);
				Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
				});
			}
			else{
				$('#container_file_tree').html(old_tree);
				alert(data.content);
			}
			
		}
	});	
	
	}
}

function add_album(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var old_tree = $('#container_file_tree').html();
	var name = $('#album_name').val();
	var description = $('#description').val();
	var access = $(':radio[name="access"]').filter(':checked').val();
	if(name == ''){
		alert('Поле "Название" обязательно к заполнению!');
		return false;
	}
	if(access == 'protected'){
		var password = $('#password').val();
		if(password == ''){
			alert('Поле "Пароль" пустое!');
			return false;
		}
		password = encodeURIComponent(password);
		password = '&password='+password;
	}
	else{
		var password = '';
	}
	
	name = encodeURIComponent(name);
	description = encodeURIComponent(description);
	
	$.ajax({
		type: "POST",
   	 	url: object.action,
		dataType: 'json',
		data: 'is_ajax=1&name='+name+'&description='+description+'&access='+access+password,
    	cache: false,
		beforeSend:function(){
			$('#container_file_tree').html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$('#container_file_tree').html(old_tree);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			if(data.answer == 1){
				if(data.content != ''){
					$('#container_file_tree').html(data.content);
					$("#albums_tree").treeview({
					persist: "location",
					collapsed: true
					});
					$(".hitarea").bind("click", function(e){
        				var buffer = $(this).next().attr('id');
						var arr = buffer.split('_');
						show_branch(this,arr[1]);
    				});
					$('#albums_tree li').droppable({
        				drop: function() {
						var buffer_name = $(this).find('.folder').attr('id');
						var buffer = buffer_name.split('_');
						var album_id = buffer[1];
						var file_id = $('#current_drag').val();
						add_to_album(file_id,album_id);
        			}
    				});
				}
				$('#num_folders').text(data.num_folders);

			}
			else{
				$('#container_file_tree').html(old_tree);
			}
			
		}
	});	
}


function show_branch(object,id,type){
	

	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var container = $(object).next().parent().find('.children').html();
	if(id == 0)
		return false;
	if(container.length > 1)
		return false;
	if(type == 'torrent')
		var url = '/torrents/show/'+id;
	else
		var url = '/albums/show/'+id;


	$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).next().parent().find('.children').html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).next().parent().find('.children').html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).next().parent().find('.children').html(data.content);
			Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
			});
		}
	});	
	
}

function show_password(object){
	var access = $(object).val();
		if(access == 'protected'){
			$(object).parent().parent().parent().parent().find('#container_password').show();
			$(object).parent().parent().parent().parent().find('#password').focus();
		}
		else{
			$(object).parent().parent().parent().parent().find('#container_password').hide();

	}
}

function show_edit_album(id,object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();

	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).html(container);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			
			Shadowbox.open({
        	content:    data.content,
        	player:     "html",
        	title:      "Редактирование папки",
			left: 200,
			height: height_modal,
			overlayOpacity: 0.3,
			handleOversize: 'resize'
    		});	
			
			$("#sb-wrapper .access").click(function () {
				var access = $(this).val();
				if(access == 'protected'){
					$('#sb-wrapper #container_password').show();
					$('#sb-wrapper #password').focus();
				}
				else{
					$('#sb-wrapper #container_password').hide();

				}
    		});
			
			}
		});	
		
}

function exclude_file(id,object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();
	var buffer_folder = $(object).parent().parent().parent().parent().find('.folder').attr('id');
	var folder = buffer_folder.split('_');
	var album_id = folder[1];
	var container_children = $(object).parent().parent().parent();
	var current_paginate_url = $('#current_paginate_url').val();
	
	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1&file_id='+id+'&album_id='+album_id,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			var buffer_num_files = container_children.find('li').size();
			var num_files = buffer_num_files - 1;
			if(data.answer == 1){
				$(object).parent().parent().remove();
				if(num_files < 1 && typeof(data.content) != 'undefined'){
					container_children.append('<li>'+data.content+'</li>');
				}
				paginate_link_list_files(current_paginate_url);
		
			}
			else{
				$(object).html(container);
				alert('Неизвестная ошибка!');
			}
			
		}
	});	
	
}



function delete_file(id,object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();
	var buffer_folder = $(object).parent().parent().parent().parent().find('.folder').attr('id');
	var folder = buffer_folder.split('_');
	var album_id = folder[1];
	var container_children = $(object).parent().parent().parent();

	
	if(confirm('Вы уверены в том, что хотите удалить данный файл?')){
	
	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1&file_id='+id+'&album_id='+album_id,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			var buffer_num_files = container_children.find('li').size();
			var num_files = buffer_num_files - 1;
			if(data.answer == 1){
				$(object).parent().parent().remove();
				if(num_files < 1){
					container_children.append('<li>'+data.content+'</li>');
				}
						
			}
			else{
				$(object).html(container);
				alert('Неизвестная ошибка!');
			}
			
		}
	});	
	
	}
	
}

function edit_album(id,object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var container = $('#sb-wrapper #container_edit_albums').html();
	var name = $('#sb-wrapper #album_name').val();
	var description = $('#sb-wrapper #description').val();
	var access = $('#sb-wrapper :radio[name="access"]').filter(':checked').val();
	if(name == ''){
		alert('Поле "Название" обязательно к заполнению!');
		return false;
	}
	if(access == 'protected'){
		var password = $('#sb-wrapper #password').val();
		if(password == ''){
			alert('Поле "Пароль" пустое!');
			return false;
		}
		password = encodeURIComponent(password);
		password = '&password='+password;
	}
	else{
		var password = '';
	}
	
	name = encodeURIComponent(name);
	description = encodeURIComponent(description);
	var modal_height = $('#sb-wrapper-inner').height() - 5;

	$.ajax({
		type: "POST",
   	 	url: object.action,
		dataType: 'json',
		data: 'is_ajax=1&is_update=1&name='+name+'&description='+description+'&access='+access+password,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div style="width:100%;height:'+modal_height+'px;"><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).html(container);
			if(data.answer == 1){
				if(data.content != ''){
					Shadowbox.close();
					$('#container_file_tree').html(data.content);
					$("#albums_tree").treeview({
					persist: "location",
					collapsed: true
					});
							
				}
				Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
				});
			}
			else{
				$(object).html(container);
				alert('Ошибка загрузки!');
			}
			}
	});	
	
}


function add_to_album(file_id,album_id,type){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var old_tree = $('#container_file_tree').html();
	var current_paginate_url = $('#current_paginate_url').val();
	if(typeof($('#current_type').val()) != 'undefined')
		var table_type = '&table_type='+$('#current_type').val();
	else
		var table_type = '';
	
	$.ajax({
		type: "POST",
   	 	url: '/albums/file/add',
		dataType: 'json',
		data: 'is_ajax=1&file_id='+file_id+'&album_id='+album_id+'&type='+type+table_type,
    	cache: false,
		beforeSend:function(){
			$('#container_file_tree').html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$('#container_file_tree').html(old_tree);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			if(data.answer == 1){
				if(data.content != ''){
					$('#container_file_tree').html(data.content);
					$("#albums_tree").treeview({
					persist: "location",
					collapsed: true
					});
					$(".hitarea").bind("click", function(e){
        				var buffer = $(this).next().attr('id');
						var arr = buffer.split('_');
						show_branch(this,arr[1],type);
    				});
				}
				$('#albums_tree #folder_'+album_id).parent().removeClass('expandable');
					$('#albums_tree #folder_'+album_id).prev().removeClass('expandable-hitarea');
					$('#albums_tree #folder_'+album_id).prev().addClass('collapsable-hitarea');
					$('#albums_tree #folder_'+album_id).parent().addClass('collapsable');
					$('#albums_tree #folder_'+album_id).parent().find('.children').show();
					var object = $('#albums_tree #folder_'+album_id);
					show_branch(object,album_id,type);
				$('#num_folders').text(data.num_folders);
					paginate_link_list_files(current_paginate_url);
					
			}
			else{
				$('#container_file_tree').html(old_tree);
			}			
		}
	});	
		
}

function modal_album_copy_local(object){
	
	var album_id = $(object).closest('.item').attr('data-album');
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	var container = $(object).html();
	var owner_id = $(object).closest('.item').attr('data-owner');
	var current_net = $('#current_net').val();

	
	$.ajax({
	type: "POST",
   	url: '/albums_settings/net/'+current_net+'/'+album_id,
	dataType: 'json',
	data: 'is_ajax=1&is_sync=1',
    cache: false,
	beforeSend:function(){
		$(object).html('<div><img src="'+ajax_url+'"></div>');
	},
	error: function(){
		$(object).html(container);
		alert('Ошибка копирования!');
	},
    success: function(data){
		$(object).html(container);

		$('#container_modal').html(data.content);
		var height_modal = $('#container_modal').height();
		
	Shadowbox.open({
     content:  data.content,
     player:  "html",
     title:   "Создание папки",
	 left: 200,
	 height: height_modal,
	 overlayOpacity: 0.3,
	 handleOversize: 'resize'
    });	

	}
	});	
	
}

function modal_album_copy_net(object){
	
	var album_id = $(object).closest('.item').attr('data-album');
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	var container = $(object).html();
	var current_net = $('#current_net').val();

	$.ajax({
	type: "POST",
   	url: '/albums_settings/net/'+current_net+'/'+album_id+'/reverse',
	dataType: 'json',
	data: 'is_ajax=1&is_sync=1',
    cache: false,
	beforeSend:function(){
		$(object).html('<div><img src="'+ajax_url+'"></div>');
	},
	error: function(){
		$(object).html(container);
		alert('Ошибка копирования!');
	},
    success: function(data){
		$(object).html(container);

		$('#container_modal').html(data.content);
		var height_modal = $('#container_modal').height();
		
	Shadowbox.open({
     content:  data.content,
     player:  "html",
     title:   "Создание папки",
	 left: 200,
	 height: height_modal,
	 overlayOpacity: 0.3,
	 handleOversize: 'resize'
    });	

	}
	});	
	
}


function vk_upload_photos(object,net_album_id,local_album_id){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	
	VK.api("photos.getUploadServer", {album_id: net_album_id}, function(data) {
		var upload_url = data.response.upload_url;
		upload_url = encodeURIComponent(upload_url);
		var url = '/sync/vk/upload?local_album_id='+local_album_id+'&upload_url='+upload_url;
		window.open(url);
		
		/*
		$.ajax({
		type: "POST",
   	 	url: '/sync/vk/upload',
		data: 'is_ajax=1&is_sync=1&upload_url='+upload_url+'&local_album_id='+local_album_id,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(data){
			alert('Ошибка загрузки фотографий!');
		},
    	success: function(data){
			vk_photos_save(data,object,local_album_id);
			
		}
	});
*/	
		
	}); 
}


function create_album_net(local_album_id){
	
	var album_id = $('#sb-wrapper #album_id').val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big_sync.gif';
	var container = $('#container_left_panel').html();
	var owner_id = $('#sb-wrapper #owner_id').val();
	var error_msg = $('#sb-wrapper #error_msg').val();
	var current_net = $('#current_net').val();
	
	var name = $('#sb-wrapper #album_name').val();
	var description_album = $('#sb-wrapper #description').val();
	if(name == ''){
		alert('Поле "Название" обязательно к заполнению!');
		return false;
	}

//	name = encodeURIComponent(name);
	description = encodeURIComponent(description);
	var modal_height = $('#sb-wrapper-inner').height() - 5;
	
	VK.api("photos.createAlbum", {title: name, privacy: '0', description: description_album}, function(data) {
    // Действия с полученными данными
		if(data.response){
			var result = data.response;
			
			$.ajax({
			type: "POST",
   			url: '/sync/'+current_net+'/create_album/'+local_album_id,
			dataType: 'json',
			data: 'is_ajax=1&is_sync=1&id='+result.aid+'&thumb_id='+result.thumb_id+'&owner_id='+result.owner_id+'&title='+name+'&description='+description_album+'&created='+result.created+'&updated='+result.updated+'&privacy_view='+result.privacy+'&privacy_comment='+result.comment_privacy+'&size=0&can_upload=1',
    		cache: false,
			beforeSend:function(){
				$('#container_left_panel').html('<div style="padding-left:40%;padding-top:20%;"><img src="'+ajax_url+'"></div>');

			},
			error: function(){
				$('#container_left_panel').html(container);
				alert('Ошибка копирования!');
			},
    		success: function(data){
				if(data.answer == 1){
					$('#is_create_album_net').val(1);
					vk_upload_photos(container,result.aid,local_album_id);
				}
				else{
					alert('Error!!');
				}
		}
	});	
		}
		else{
			alert(error_msg);
			return false;
		}
	}); 
}

function copy_album_to_net(object){
	
	var album_id = $('#sb-wrapper #album_id').val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big_sync.gif';
	var container = $('#container_left_panel').html();
	var owner_id = $('#sb-wrapper #owner_id').val();
	var current_net = $('#current_net').val();
	
	var name = $('#sb-wrapper #album_name').val();
	var description = $('#sb-wrapper #description').val();
	if(name == ''){
		alert('Поле "Название" обязательно к заполнению!');
		return false;
	}

	name = encodeURIComponent(name);
	description = encodeURIComponent(description);
	var modal_height = $('#sb-wrapper-inner').height() - 5;

	$.ajax({
	type: "POST",
   	url: '/sync/'+current_net+'/photos/'+owner_id+'/'+album_id+'/reverse',
	dataType: 'json',
	data: 'is_ajax=1&is_sync=1&name='+name+'&description='+description,
    cache: false,
	beforeSend:function(){
		$('#container_left_panel').html('<div style="padding-left:40%;padding-top:20%;"><img src="'+ajax_url+'"></div>');

	},
	error: function(){
		$('#container_left_panel').html(container);
		alert('Ошибка копирования!');
	},
    success: function(data){
		if(data.answer == 1){
			Shadowbox.close();
			$('#container_left_panel').html(data.content);
		}
		else{
			$('#container_left_panel').html(container);
			alert('Ошибка копирования!');

		}

	}
	});	
}

function copy_album_to_local(object){
	
	var album_id = $('#sb-wrapper #album_id').val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big_sync.gif';
	var container = $('#container_right_panel').html();
	var owner_id = $('#sb-wrapper #owner_id').val();
	var current_net = $('#current_net').val();
	
	var name = $('#sb-wrapper #album_name').val();
	var description = $('#sb-wrapper #description').val();
	var access = $('#sb-wrapper :radio[name="access"]').filter(':checked').val();
	if(name == ''){
		alert('Поле "Название" обязательно к заполнению!');
		return false;
	}
	if(access == 'protected'){
		var password = $('#sb-wrapper #password').val();
		if(password == ''){
			alert('Поле "Пароль" пустое!');
			return false;
		}
		password = encodeURIComponent(password);
		password = '&password='+password;
	}
	else{
		var password = '';
	}
	
	name = encodeURIComponent(name);
	description = encodeURIComponent(description);
	var modal_height = $('#sb-wrapper-inner').height() - 5;

	
	$.ajax({
	type: "POST",
   	url: '/sync/'+current_net+'/photos/'+owner_id+'/'+album_id,
	dataType: 'json',
	data: 'is_ajax=1&is_sync=1&name='+name+'&description='+description+'&access='+access+password,
    cache: false,
	beforeSend:function(){
		$('#container_right_panel').html('<div style="padding-left:40%;padding-top:20%;"><img src="'+ajax_url+'"></div>');

	},
	error: function(){
		$('#container_right_panel').html(container);
		alert('Ошибка копирования!');
	},
    success: function(data){
		if(data.answer == 1){
			Shadowbox.close();
			$('#container_right_panel').html(data.content);
		}
		else{
			$('#container_right_panel').html(container);
			alert('Ошибка копирования!');

		}

	}
	});	
}


function copy_to_net(object,local_album_id){
	var net = $('#current_net').val();
	var id = $('#current_id').val();
	var container = $(object).html();
	var current_net = $('#current_net').val();
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	if(id == 0 || typeof(id) == 'undefined')
		return false;
	if(net == 0 || typeof(net) == 'undefined')
		return false
		
		
	VK.api("photos.getUploadServer", {album_id: local_album_id}, function(data) {
		if(data.response.upload_url){
			var upload_link = data.response.upload_url;
			upload_link = encodeURIComponent(upload_link);
		}
		else{
			upload_link = '';
		}
	
		var url = '/sync/vk/upload/'+id;
		
		$.ajax({
		type: "POST",
   	 	url: '/sync/'+current_net+'/upload',
		data: 'is_ajax=1&is_sync=1&photos='+id+'&upload_url='+upload_link+'&is_simple=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка копирования!');

		},
    	success: function(data){
		if(typeof(data) != 'undefined')
			vk_photos_save(data,object,local_album_id);
		}
	});	
		
	}); 
	
}


function vk_photos_save(data,object,local_album_id){
	var owner_id = $('#current_owner_id').val();
	console.info(owner_id);
	
	VK.Api.call('photos.save',data, function(r) {
//		alert('Success!');
		$('#update_net').val(1);	
	open_net_folder(object,owner_id,local_album_id);

}); 
}


function copy_to_local(object,local_album_id){
	var net = $('#current_net').val();
	var owner_id = $('#current_owner_id').val();
	var id = $('#current_id').val();
	var album_id = $('#current_album_id').val();
	var container = $(object).html();
	var current_net = $('#current_net').val();
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	if(owner_id == 0 || typeof(owner_id) == 'undefined')
		return false;
	if(album_id == 0 || typeof(album_id) == 'undefined')
		return false;
	if(id == 0 || typeof(id) == 'undefined')
		return false;
	if(net == 0 || typeof(net) == 'undefined')
		return false;

	$.ajax({
		type: "POST",
   	 	url: '/sync/'+current_net+'/photos/'+owner_id+'/'+album_id,
		dataType: 'json',
		data: 'is_ajax=1&is_sync=1&photo_id='+id+'&local_album_id='+local_album_id,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка копирования!');

		},
    	success: function(data){
			$(object).html(container);
			open_folder(object,local_album_id);
			$('#result_copy').val(data.answer);
			$('#object_copy').val('file');
		}
	});	
	
}


function set_draggable_sync(){
	
	var reverse = $('#is_reverse').val();
	if(reverse == 1){
		var left_panel = 'right_panel';
		var right_panel = 'left_panel';
	}
	else{
		var right_panel = 'right_panel';
		var left_panel = 'left_panel';	
	}
	
	$('#container_'+left_panel+' .draggable').draggable({
        containment: "#container_"+right_panel,
		distance: 20,
		helper: 'clone',
		revert: true,
		start: function() {
			if(reverse == 1){
				var album_id = $(this).attr('data-album');
				var id = $(this).attr('data-id');
			}
			else{
				var owner_id = $(this).attr('data-owner');
				var album_id = $(this).attr('data-album');
				var object_copy = $(this).attr('data-object');
				$('#current_owner_id').val(owner_id);

			}
			
			$('#current_id').val(id);
			$('#current_album_id').val(album_id);
			$('#object_copy').val(object_copy);
        },
		stop: function() {	
			$(this).find('.shadowbox').removeAttr('rel');
			$(this).find('.shadowbox').removeClass('shadowbox');

        }
    });
	
	$('#container_'+right_panel+' .item').droppable({
        drop: function() {
			var local_album_id = $(this).attr('data-album');
			if(reverse == 1){
				copy_to_net($(this),local_album_id);
			}
			else{
				copy_to_local($(this),local_album_id);
			}

        }
    });
	
}

function get_vk_upload_server(object,album_id_net){
	VK.api("photos.getUploadServer", {album_id: album_id_net}, function(data) {
		console.info(data.response.upload);
	}); 
}


function set_draggable_sync_files(){
	
	var reverse = $('#is_reverse').val();
	if(reverse == 1){
		var left_panel = 'right_panel';
		var right_panel = 'left_panel';
	}
	else{
		var right_panel = 'right_panel';
		var left_panel = 'left_panel';	
	}
		
	$('#container_'+left_panel+' .draggable').draggable({
        containment: "#container_"+right_panel,
		distance: 20,
		helper: 'clone',
		revert: true,
		start: function() {
			if(reverse == 1){
				var album_id = $(this).attr('data-album');
				var id = $(this).attr('data-id');

			}
			else{
				var owner_id = $(this).attr('data-owner');
				var id = $(this).attr('data-id');
				var album_id = $(this).attr('data-album');
				var object_copy = $(this).attr('data-object');
				$('#current_owner_id').val(owner_id);

			}
			
			$('#current_id').val(id);
			$('#current_album_id').val(album_id);
			$('#object_copy').val(object_copy);
        },
		stop: function() {	
			$(this).find('.shadowbox').removeAttr('rel');
			$(this).find('.shadowbox').removeClass('shadowbox');

        }
    });
	
	if(reverse == 1){
		$('#container_'+right_panel).droppable({
        drop: function() {

			if(reverse == 1){
				var local_album_id = $('#net_album_id').val();
				var owner_id = $('#net_owner_id').val();
				console.info(local_album_id);
				$('#current_owner_id').val(owner_id);
				copy_to_net($(this),local_album_id);
			}	
			else{
				var local_album_id = $('#current_local_album_id').val();

				copy_to_local($(this),local_album_id);

			}

        }
    });
	}
	else{
		$('#container_'+right_panel).droppable({
        drop: function() {
			
			if(reverse == 1){
				var local_album_id = $(this).attr('data-album');
				copy_to_net($(this),local_album_id);
			}	
			else{
				var local_album_id = $('#current_local_album_id').val();

				copy_to_local($(this),local_album_id);

			}

        }
    });
	}
	
}


function set_draggable(){
		
	 $('.draggable').draggable({
        containment: "#container_file_tree",
		distance: 20,
		helper: 'clone',
		revert: true,
		start: function() {
			var id = $(this).attr('data-id');
			var type = $(this).attr('data-type');
			$('#current_drag').val(id);
			if(typeof(type) != 'undefined')
				$('#current_type').val(type);
        },
		stop: function() {	
			$(this).find('.link_file').removeAttr('rel');

        }
    });
	
	$('#albums_tree li').droppable({
        drop: function() {
			var buffer_name = $(this).find('.folder').attr('id');
			var type = $(this).find('.folder').attr('data-type');
			var buffer = buffer_name.split('_');
			var album_id = buffer[1];
			var file_id = $('#current_drag').val();
			add_to_album(file_id,album_id,type);
        }
    });
	
}

function show_magnify(object){
	$(object).find('.list-item-privacy').show();

}

function hide_magnify(object){
	$(object).find('.list-item-privacy').hide();

}

function quick_view(object){
	
	Shadowbox.open({
        content: object.href,
        player:     "img",
		continuous: true
    });	
}

function show_root(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	var container_id = $(object).closest('.list_files').attr('id');
	var container = $(object).parent().html();
	if(container_id == 'container_left_panel')
		var type = 'net';
	else
		var type = 'local';
		
	var url = document.location.href;

	$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1&is_sync=1&type='+type,
    	cache: false,
		beforeSend:function(){
			$(object).parent().html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).parent().html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$('#'+container_id).html(data.content);	
			Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
			});	
			if(type == 'net')
				$('#object_copy').val('folder');
			$('#result_copy').val(0);
			set_draggable_sync();

		}
	});	
}



function open_folder(object,id){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	var container = $(object).html();
	if(id == 0)
		return false;

	$.ajax({
		type: "POST",
   	 	url: '/albums/show/'+id,
		dataType: 'json',
		data: 'is_ajax=1&is_sync=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).closest('.list_files').html(data.content);	
			Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
			});
		$('#result_copy').val(0);
		$('#current_local_album_id').val(id);
		set_draggable_sync_files();
		}
	});	
}

function open_album(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/big.gif';
	var password = $('#cboxWrapper #album_password').val();
	if(password == ''){
		alert('Поле "Пароль" не может быть пустым!');
		return false;
	}
	password = encodeURIComponent(password);
	var container = $(object).html();

	$.ajax({
		type: "POST",
   	 	url: object.action,
		dataType: 'json',
		data: 'is_ajax=1&album_password='+password,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).html(container);
			if(data.answer == 1){
				document.location.reload();

			}
			else{
				alert(data.content);

			}
			
		}
	});	
}

function show_uploader(){
	
	window.open('/multi');
}

function sync_ok(url){
	
	window.open(url);

}

function show_sync(){
	
	document.location.href = '/sync';
}

function delete_preupload(object){
	$(object).parent().parent().parent().parent().remove();
	var files = $('.preview').size();
	var that = $('#upload-multi-files').data('blueimp-fileupload') || $('#upload-multi-files').data('fileupload');
	$('#upload-multi-files .error').parent().remove();
	that.options.maxNumberOfFiles = 0;

	var count_files = max_number_of_files - files;
	if(count_files > 1)
		that._adjustMaxNumberOfFiles(count_files);
	else
		that._adjustMaxNumberOfFiles(1);

		  
}

function resort_list(){
	
	var counter = 1;
	var arr = new Array();
	$("#upload-drop-zone .tr").each(function(){
		$(this).find('.file_num').val(counter);
		counter++;
				
	}); 
	for(i = 1; i < counter; i++){
		arr[i] = $('#upload-drop-zone .file_num[value="'+i+'"]').parent().html();
		arr[i] = '<div class="tr template-upload fade in">'+arr[i]+'</div>';
	}

	var content = '';
	var str = '';
	for(i = counter - 1; i > 0; i--)	{
		content += arr[i];
	}
	var img = $('#upload-drop-zone .file_num[value="1"]').parent().find('.preview span');

	$('#upload-drop-zone').html(content);

}

function block_access(object){
	if($('#sb-wrapper').length > 0){
		
		if($(object).find(' option:selected').val() != 0){
			$('#sb-wrapper #edit_image #ACCESS').parent().parent().hide();
		}
		else{
			$('#sb-wrapper #edit_image #ACCESS').parent().parent().show();
		}
	}
	else{

		if($(object).find(' option:selected').val() != 0){

			$('upload-drop-zone #ACCESS').parent().parent().hide();
		}
		else{
			$('#upload-drop-zone #ACCESS').parent().parent().show();
		}
	}
}

function block_access_fast(object){
	if($('#sb-wrapper #container_templates').length > 0){
		return false;	
	}
	
	var current_access = $(object).parent().parent().prev().find('#ACCESS option:selected').val();
	if($(object).find(' option:selected').val() != 0){
		$(object).parent().parent().prev().hide();
	}
	else
	{
		if($(object).parent().parent().prev().find('#ACCESS').length > 1){
			
		}
		else{
			$(object).parent().parent().prev().find('.input').append();
		}
		$(object).parent().parent().prev().show();
	}
}

function use_seedoff_data_ready(){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $('#use_seedoff a').html();
	var url = $('#use_seedoff a').attr('href');

	$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$('#use_seedoff a').html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$('#use_seedoff a').html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$('#use_seedoff a').html(container);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			
			Shadowbox.open({
        	content:    data.content,
        	player:  "html",
        	title:  "Ввод регистрационных данных с Seedoff.net",
			left: 200,
			height: height_modal,
			overlayOpacity: 0.5,
			handleOversize: 'resize'
    		});	
			
			}
		});	
}

function use_seedoff_data(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();

	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).html(container);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			
			Shadowbox.open({
        	content:    data.content,
        	player:  "html",
        	title:  "Ввод регистрационных данных с Seedoff.net",
			left: 200,
			height: height_modal,
			overlayOpacity: 0.5,
			handleOversize: 'resize'
    		});	
			
			}
		});	
}

function submit_seedoff_data(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();
	var username = $('#sb-wrapper #register_with_seedoff #username').val();
	var password = $('#sb-wrapper #register_with_seedoff #password').val();
	username = encodeURIComponent(username);
	password = encodeURIComponent(password);

	$.ajax({
		type: "POST",
   	 	url: object.action,
		dataType: 'json',
		data: 'is_ajax=1&username='+username+'&password='+password+'&submit=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			
			if(data.answer == 0){
				$(object).html(container);
				alert('Ошибка регистрации');

			}
			else{
				$('#use_seedoff').val(1);
				Shadowbox.close();
				$('#register-form #username').val(data.username);
				$('#register-form #password').val(data.password);
				$('#register-form #confirm_password').val(data.password);
				$('#register-form #email').val(data.email);
				$('#use_seedoff').hide();
			}
				
			}
		});	
}

function sync_net(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();

	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).html(container);
			$('#container_modal').html(data.content);
			var height_modal = $('#container_modal').height();
			
			Shadowbox.open({
        	content:    data.content,
        	player:  "html",
        	title:  "Ввод регистрационных данных с Seedoff.net",
			left: 200,
			height: height_modal,
			overlayOpacity: 0.5,
			handleOversize: 'resize'
    		});	
			
			}
		});	
}

function set_owner_id(owner_id){
	
	$.ajax({
		type: "POST",
   	 	url: '/sync/vk/set_user',
		dataType: 'json',
		data: 'is_ajax=1&owner_id='+owner_id,
    	cache: false,
    	success: function(data){
			console.info(data.answer);
			if(typeof(data.answer) != 'undefined'){
				document.location.reload();
			}
			else{
				if(owner_id > 0 )
					alert('Вероятно у вас заблокировано всплывающее окно!');
			}
				
		}
	});	
}

function fb_init_albums(owner_id,parameters){
	
	parameters = JSON.stringify(parameters);
	parameters = encodeURIComponent(parameters);
	$.ajax({
		type: "POST",
   	 	url: '/sync/fb/set_user',
		dataType: 'json',
		data: 'is_ajax=1&set_albums=1&owner_id='+owner_id+'&parameters='+parameters,
    	cache: false,
    	success: function(data){
			console.info(data.owner_id);
			if(data.answer == 1){
				paginate_link_sync(document.location.href);
			}
			else{
				alert('Авторизация на Facebook не удалась!');

			}
		}
	});	
}

function show_net(object,current_net,owner_id,album_id,container){
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	var is_update = $('#is_update').val();
	var reverse = $('#is_reverse').val();
	var update_net = $('#update_net').val();
	
	$.ajax({
		type: "POST",
   	 	url: '/sync/'+current_net+'/albums/'+owner_id+'/'+album_id,
		dataType: 'json',
		data: 'is_ajax=1&is_sync=1&is_update='+is_update+'&update_net='+update_net,
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$(object).closest('.list_files').html(data.content);	
			$('#object_copy').val('file');
			Shadowbox.setup("a.shadowbox", {
        		gallery:  "mygallery"
			});
				var num_local = $('#container_right_panel .file_item').size();
				console.info(num_local);
				if(num_local > 0){
					set_draggable_sync_files();

				}
				else{

					set_draggable_sync();

				}
			
		}
	});	
}

function open_net_folder(object,owner_id,album_id){
	var current_net = $('#current_net').val();
	var container = $(object).html();
	var is_work = $('#is_work').val();

	if(owner_id == 0)
		return false;
	if(album_id == 0)
		return false;
		
	if(current_net == 'fb' && is_work == 1){
		is_enable_show_album(album_id,owner_id,object,container);
		return false;
	}
	if($('#is_create_album_net').val() == 1){
		document.location.reload();
	}
	
	show_net(object,current_net,owner_id,album_id,container);

	
}

function fb_init_photos(owner_id,album_id,parameters,object,container){
	parameters = JSON.stringify(parameters);
	parameters = encodeURIComponent(parameters);
	$.ajax({
		type: "POST",
   	 	url: '/sync/fb/set_user',
		dataType: 'json',
		data: 'is_ajax=1&set_photos=1&album_id='+album_id+'&owner_id='+owner_id+'&parameters='+parameters,
    	cache: false,
    	success: function(data){
			console.info(data.owner_id);
			if(data.answer == 1){
					show_net(object,'fb',owner_id,album_id,container);

			}
			else{
				alert('Авторизация на Facebook не удалась!');

			}
		}
	});	
}

function fb_api(){
	FB.api('/me', function(response) {
		owner_id = response.id;
	  fb_init(response);
	  fb_api_albums(response.id);
    });
	
	
}

function fb_api_albums(owner_id){
	FB.api('/me/albums', function(response) {
	  fb_init_albums(owner_id,response);
    });
}

function fb_api_photos(owner_id,album_id,object,container){
	FB.api('/'+album_id+'/photos', function(response) {
	  fb_init_photos(owner_id,album_id,response,object,container);
    });
}

function is_enable_show_album(album_id,owner_id,object,container){
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small_sync.gif';
	$.ajax({
		type: "POST",
   	 	url: '/sync/fb/albums/'+owner_id+'/'+album_id,
		dataType: 'json',
		data: 'is_ajax=1&is_sync=1&enable_show_album=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			$('#enable_show_album').val(data.answer);
			if(data.answer == 0){
				fb_api_photos(owner_id,album_id,object,container);
			}
			else{
				show_net(object,'fb',owner_id,album_id,container);
			}
		}
	});	
}

function fb_init(parameters){
	
	var owner_id = parameters.id;
	parameters = JSON.stringify(parameters);
	parameters = encodeURIComponent(parameters);

	$.ajax({
		type: "POST",
   	 	url: '/sync/fb/set_user',
		dataType: 'json',
		data: 'is_ajax=1&set_user=1&owner_id='+owner_id+'&parameters='+parameters,
    	cache: false,
    	success: function(data){
			console.info(data.owner_id);
			if(data.answer == 1){

			}
			else{
				alert('Авторизация на Facebook не удалась!');

			}
		}
	});	
}



function fb_show(owner_id,parameters){
	
	$.ajax({
		type: "POST",
   	 	url: '/sync/fb/albums/'+owner_id+'/'+parameters.id,
		dataType: 'json',
		data: 'is_ajax=1&parameters='+JSON.stringify(parameters),
    	cache: false,
    	success: function(data){
			if(data.answer == 1){

			}
			else{
				alert('Авторизация на Facebook не удалась!');

			}
		}
	});	
}



function authInfo(response) {
  if (response.session) {
		set_owner_id(response.session.mid);
		
  } else {
		set_owner_id(0);
  }
}



function set_google_profile(result){
	
	var container = $('#signinButton').html();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var id = result.id;
	var url = result.url;
	var image = result.image.url;
	var name = result.displayName;
	var first_name = result.name.givenName;
	var last_name = result.name.familyName;
	var gender = result.gender;
	var verified = result.verified;
	name = encodeURIComponent(name);
	image = encodeURIComponent(image);
	url = encodeURIComponent(url);
	
	$.ajax({
	type: "POST",
   	url: '/sync/pic/set_user',
	dataType: 'json',
	data: 'is_ajax=1&set_user=1&id='+id+'&link='+url+'&image='+image+'&name='+name+'&first_name='+first_name+'&last_name='+last_name+'&gender='+gender+'&verified='+verified,
    cache: false,
	beforeSend:function(){
		$('#signinButton').html('<div><img src="'+ajax_url+'"></div>');
	},
	error: function(){
		$('#signinButton').html(container);
		alert('Ошибка загрузки!');
	},
    success: function(data){
		if(data.answer == 1){
			document.location.reload();
		}
		else{
			$('#signinButton').html(container);
			alert('Ошибка загрузки!');		}
	}
	});	
}

function checkProfile(owner_id){
	
	var vk_profile = $('#sb-wrapper #vk_profile').val();
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	
	$.ajax({
	type: "POST",
   	 url: '/sync/vk/set_user',
	dataType: 'json',
	data: 'is_ajax=1&owner_id='+owner_id+'&vk_profile='+vk_profile,
    cache: false,
	beforeSend:function(){
		$('#sb-wrapper #vk_profile').val('Подождите, идет проверка аккаунта..');
	},
	error: function(){
		$('#sb-wrapper #vk_profile').val('');
		alert('Ошибка загрузки!');
	},
    success: function(data){
		if(data.answer == 0){
			$('#sb-wrapper #vk_profile').val('');
			alert('Ошибка! Данный аккаунт не принадлежит текущему пользователю и не может быть использован!');
		}
		else{
			$('#sb-wrapper #vk_profile').val(vk_profile);
		}
	}
	});	
}

function check_vk_account(object){
	if($('#sb-wrapper #old_vk_profile').length > 0){
		var old_vk_profile = $('#sb-wrapper #old_vk_profile').val();
		var vk_profile = $('#sb-wrapper #vk_profile').val();
		if(old_vk_profile != vk_profile){
			var owner_id = VK.Auth.getLoginStatus(authInfo);
			console.info('owner_id '+owner_id);
			if(owner_id == 'not auth' || typeof(owner_id) == 'undefined'){
				VK.Auth.login();
			}
			else{
				checkProfile(owner_id);
			}
		}	
	}
	else{
		var owner_id = VK.Auth.getLoginStatus(authInfo);
			console.info('owner_id '+owner_id);
			if(owner_id == 'not auth' || typeof(owner_id) == 'undefined'){
				VK.Auth.login();
			}
			else{
				checkProfile(owner_id);
			}
	}
}

function set_favourite(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $('#container_favourite').html();

	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
    	cache: false,
		beforeSend:function(){
			$('#container_favourite').html('<img src="'+ajax_url+'">');
		},
		error: function(){
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			if(data.answer == 1){
				$('#container_favourite').html(data.content);
			}
			else{
				$('#container_favourite').html(container);

			}
		}
	});	
}
  
function get_top(type,object){
	
	var container = $(object).closest('.slider').html();
	var table_width = $(object).closest('.table_top').width();
	var	before_content = '<div style="text-align:center;width:'+table_width+'px;">';
	before_content += '<img src="/templates/imghost/images/ajax-loaders/wide.gif" width="100%" height="20" /></div>';

	
	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
    	cache: false,
		beforeSend:function(){
			$(object).closest('.slider').html(before_content);
		},
		error: function(){
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			
			if(data.answer == 1){
				$('.'+type).html(data.content);
			}
			else{
				$('.'+type).html(container);

			}

		}
	});	
}

function cancel_change(object){
	
	$(object).closest('.uploadForm').find('.hidden').hide();
	$(object).closest('.uploadForm').find('.choose-source').show();
	$(object).closest('.uploadForm').find('.ajax_loader').remove();
}

function set_filename(torrent_id,token,filename){
        
    $.ajax({
		type: "POST",
   	 	url: '/seedoff_filename/'+torrent_id,
		data: 'token='+token+'&filename='+filename,
    	cache: false,
		beforeSend:function(){
			$('#sync_info').show();	
		},
		error:function(){
			$('#sync_info').html('Синхронизация с Seedoff.net завершилась неудачей');	
		},
    	success: function(data){
			$('#sync_info').hide();	

		}
	});	
}

function set_upload_template(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	if($('#upload-multiple #right_block').length > 0){
		var container = $('#right_block a').html();
	}
	else{
		var container = $(object).find('.submit').html();

	}
		var empty_fields = true;
		var resize_to_width = $('#sb-wrapper #resize_to_width').val();
		var resize_to_height = $('#sb-wrapper #resize_to_height').val();
		var preview_width = $('#sb-wrapper #preview_width').val();
		var preview_height = $('#sb-wrapper #preview_height').val();
		if(preview_height == 'В' || preview_height == '' || typeof(preview_height) == 'undefined')
			preview_height = 0;
			
		if(preview_width == 'Ш' || preview_width == '' || typeof(preview_width) == 'undefined')
			preview_width = 0;
		
		var rotate = $('#sb-wrapper #rotate').val();
		var free_rotate = $('#sb-wrapper #free_rotate').val();
		if(resize_to_height != 0 && $('#sb-wrapper #resize_to_height').is(':hidden'))
			resize_to_height = 0;
		if(resize_to_width != 0 && $('#sb-wrapper #resize_to_width').is(':hidden'))
			resize_to_width = 0;
		if($('#sb-wrapper #tiny_url').attr('checked') == 'checked'){
			var tiny_url = 1;	
		}
		else{
			var tiny_url = 0;
		}
		var template_name = $('#sb-wrapper #template_name').val();
		var template_comment = $('#sb-wrapper #template_comment').val();
		var convert_to = $('#sb-wrapper #convert_to').val();
		var watermark = $('#sb-wrapper #watermark').val();
		var tags = $('#sb-wrapper #tags').val();
		var access = $('#sb-wrapper #access').val();
		var jpeg_quality = $('#sb-wrapper #jpeg_quality').val();
		var template_id = $('#sb-wrapper #template_id').val();
		
		if($('#sb-wrapper #tags_children').length > 0)
			var tags_children = $('#sb-wrapper #tags_children').val();
		else
			var tags_children = 0;
			
		if($('#sb-wrapper #albums').length > 0){
			var albums = $('#sb-wrapper #albums option:selected').val();
		}
		else{
			var albums = 0;
		}
		
		if(free_rotate != '')
			rotate = free_rotate;
		
		var container = $('#sb-wrapper .submit').html();
		
		if(preview_width == 0){
			
		}
		else{
			empty_fields = false;
		}

		if(preview_height == 0){
			
		}
		else{
			empty_fields = false;
		}
				
		if(resize_to_width > 0 || resize_to_height > 0){
			empty_fields = false;

		}
		if(rotate != 0)
			empty_fields = false;
		if(convert_to != '')
			empty_fields = false;
		if(watermark != '')
			empty_fields = false;
		if(tags != 0)
			empty_fields = false;
		if(access != 0 && typeof(access) != 'undefined')
			empty_fields = false;
		if(albums != 0 && typeof(albums) != 'undefined')	
			empty_fields = false;
		if(tiny_url == 1)
			empty_fields = false;
		if(typeof(jpeg_quality) != 'undefined' && jpeg_quality != 100){
			empty_fields = false;
			jpeg_quality = '&JPEG_QUALITY='+jpeg_quality;
		}
		else{
			jpeg_quality = '';
		}
		
		if(typeof(template_id) != 'undefined'){
			template_id = '&TEMPLATE_ID='+template_id;
		}
		else{
			template_id = '';
		}
			
		if(template_name == ''){
			alert('Поле "Название" обязательно для заполнения!');
			return false;
		}
		
		
		if(empty_fields == true){
			alert('Опции редактирования не изменены!');
			return false;
		}	
			
		template_name = encodeURIComponent(template_name);
		template_comment = encodeURIComponent(template_comment);
		watermark = encodeURIComponent(watermark);
		access = encodeURIComponent(access);
		
		if(typeof(access) == 'undefined' || access == 'undefined')
			access = 0;
			
		if(typeof(albums) == 'undefined' || access == 'undefined')
			albums = 0;

		if(tags != 0){
			tags = '&TAGS='+tags;
			if(tags_children != 0)
				tags += '&TAGS_CHILDREN='+tags_children;
		}
		else{
			tags = '';
		}
		
		if($('#upload-multiple #right_block').length > 0){
			var from_upload = 1;
		}
		else{
			var from_upload = 0;

		}
		
		
	$.ajax({
		type: "POST",
   	 	url: object.action,
		data: 'is_ajax=1&is_update=1&RESIZE_TO_WIDTH='+resize_to_width+'&RESIZE_TO_HEIGHT='+resize_to_height+'&ROTATE='+rotate+'&TEMPLATE_NAME='+template_name+'&CONVERT_TO='+convert_to+'&TEMPLATE_COMMENT='+template_comment+'&WATERMARK='+watermark+tags+'&ALBUMS='+albums+'&ACCESS='+access+'&TINYURL='+tiny_url+'&from_upload='+from_upload+'&PREVIEW_WIDTH='+preview_width+'&PREVIEW_HEIGHT='+preview_height+jpeg_quality+template_id, 
		dataType: 'json',
		cache: false,
		beforeSend:function(){
			if($('#upload-multiple #right_block').length > 0){
				$('#right_block #add_template').html('<div><img src="'+ajax_url+'"></div>');
			}
			else{
				$(object).find('.submit').html('<div><img src="'+ajax_url+'"></div>');

			}
		},
		error: function(){
			if($('#upload-multiple #right_block').length > 0){
				$('#right_block #add_template').html(container);

			}
			else{
				$(object).find('.submit').html(container);

			}

			alert('Ошибка загрузки!');

		},
    	success: function(data){
			if(data.answer == 1){
				if($('#upload-multiple #right_block').length > 0){
					$('#right_block #add_template').html('<img width="16" height="16" src="/templates/imghost/images/add.png"><span style="margin-left:9px;text-decoration: underline;color:#166D66;">Добавить</span>');
					$('#container_list_templates').html(data.content);
							
					Shadowbox.close();
					$('#batch').prop('checked',true);
					$('#list_templates').prop('disabled',false);
				}
				else{
					$(object).find('.submit').html(container);
					$('#sb-title-inner').text('Настройки редактирования изображений');
					$('#sb-wrapper #container_upload_settings').html(data.content);
					$('#num_templates').text(data.num);
					resize_modal();
				}
				
			}
			else{
				$(object).find('.submit').html(container);
				if(typeof(data.message) != 'undefined'){
					alert(data.message);
					$('#sb-wrapper #template_name').val('');
					$('#sb-wrapper #template_name').focus();
				}
			}
			
				
		}
	});	
}

function resize_images_modal(){
	
	var curr_height = $('#sb-wrapper-inner').height();
	var container_height = $('#sb-wrapper #container_search_images').height();
	var differ_height = container_height - curr_height;
	var all_height = (container_height * 1) + 30;
	$('#sb-wrapper-inner').height(all_height);
	var current_top = $('#sb-wrapper').css('top');
	current_top = str_replace('px','',current_top);
	current_top *= 1;
	differ_height = Math.round(differ_height / 2);
	var new_top = current_top - differ_height;
	new_top += 'px';
	$('#sb-wrapper').css({top : new_top});
}

function resize_modal(){
	
	var curr_height = $('#sb-wrapper-inner').height();
	var container_height = $('#sb-wrapper #container_upload_settings').height();
	var differ_height = container_height - curr_height;
	var all_height = (container_height * 1) + 30;
	$('#sb-wrapper-inner').height(all_height);
	var current_top = $('#sb-wrapper').css('top');
	current_top = str_replace('px','',current_top);
	current_top *= 1;
	differ_height = Math.round(differ_height / 2);
	var new_top = current_top - differ_height;
	new_top += 'px';
	$('#sb-wrapper').css({top : new_top});
}

function add_upload_template(object,type){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();
	var url = object.href;

	
		$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
				if(type == 'add')
					var title = 'Добавить шаблон редактирования';
				else
					var title = 'Изменить шаблон редактирования';
			if($(object).closest('#right_block').length > 0){
				$(object).html(container);
				var content = '<div id="container_upload_settings" style="padding:15px;">';
				content += '<div id="container_templates" style="overflow:hidden;">'+data.content+'</div></div>';
				$('#container_modal').html(content);
				var height_modal = $('#container_modal').height() + 5;
				if(height_modal < 100)
					height_modal = 100;
						
				Shadowbox.open({
        		content:   content,
        		player:  "html",
        		title:  title,
				left: 200,
				height: height_modal,
				overlayOpacity: 0.5,
				handleOversize: 'resize'
    			});	
		
			}
			else{
				$(object).html(container);
				$('#sb-title-inner').text(title);
				$('#sb-wrapper #container_templates').html(data.content);
				$('#sb-wrapper #container_templates').css({'overflow' : 'hidden'});
				$('#sb-wrapper #add_template').remove();
				resize_modal();
			}
			
			
			}
		});	
	
}

function delete_upload_template(object,message){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();
	
	url = object.href;
	
	if(typeof(torrent_id) != 'undefined' && typeof(token) != 'undefined')
		url += '?torrent_id='+torrent_id+'&token='+token;
	
	if(confirm(message)){
	$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){

			if($(object).closest('#sb-wrapper').length >= 1){
				$(object).parent().parent().remove();
				$('#num_templates').text(data.num);
				if(data.num > 0){
					resize_modal();
				}
				else{
					Shadowbox.close();
				}
			}
			else{
				$(object).html(container);
				$('.overlay').remove();
				reset_fields();
				$('#container_delete_template').hide();
				var num_templates = $('#list_templates option').size();
				if(num_templates == 2){
					$('#list_templates').remove();
					$('#add_template span').text('Добавить шаблон');
				}
				else{
					$('#list_templates option:selected').remove();
					$('#list_templates :first').prop('selected',true);
				}
				
			}
			
			
		}
	});	
	}
}

function show_templates(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();

	$.ajax({
		type: "POST",
   	 	url: object.href,
		dataType: 'json',
		data: 'is_ajax=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			$(object).html(container);
			$('#container_modal').html(data.content);
			var tr_sizes = $('#container_modal #container_templates tr').size();
			var height_modal = $('#container_modal').height();
			height_modal = height_modal + (25 * (tr_sizes - 1));
			if(height_modal <100)
				height_modal = 100;

			
			Shadowbox.open({
        	content:    data.content,
        	player:  "html",
        	title:  "Настройки редактирования изображений",
			left: 200,
			height: height_modal,
			overlayOpacity: 0.5,
			handleOversize: 'resize'
    		});	
			
			}
		});	
}

function seedoff_sync(){
	
	if(typeof(token) == 'undefined' || token == '')
		return false;
	var url = '/seedoff/upload';
	var counter = 1;
	var links = '';
	var list = new Array();
	if(typeof(torrent_id) == 'undefined')
		return false;

	$("#upload-drop-zone .imgurl").each(function(){
		var buffer_url = $(this).val();
		buffer_url = encodeURIComponent(buffer_url);
		links += '&link_'+counter+'='+buffer_url;
		counter++;		
		
	}); 
	if(counter != 1)
		counter--;
		
	
	var all_uploaded = $('#upload-drop-zone .imgurl').size();
	var last_link = list[counter];
		
	$.ajax({
		type: "POST",
   	 	url: url,
        dataType: 'json',
		data: 'token='+token+'&torrent_id='+torrent_id+'&number='+all_uploaded+links,
    	cache: false,
    	success: function(data){
            if(data.result == 'Success!!' && typeof(data.filename) != 'undefined'){
                set_filename(torrent_id,token,data.filename);
            }
		}
	});	
		
}



function group_links(type){
	if($('#upload-multi-links').is(':visible'))
		var from_internet = true;
	else
		var from_internet = false;
	if(type == 'fast'){
		var popups = $('.upload-form .choose-source:hidden').size();

	}
	else{
		if(from_internet == true)
			var popups = $('#upload-multi-links #upload-drop-zone').find('.popup-links').size();
		else
			var popups = $('#upload-drop-zone').find('.popup-links').size();

	}
	if(popups >= 2){
		var show_links = '';
		var direct_links = '';
		var preview_links_bb = '';
		var preview_links_html = '';
		var bb_codes = '';
		var tiny_urls = '';
		var buffer_show = new Array();
		var buffer_direct = new Array();
		var buffer_preview_bb = new Array();
		var buffer_preview_html = new Array();
		var buffer_bb = new Array();
		var buffer_tiny= new Array();
		if(type == 'fast'){
			var form = '.uploadForm';

		}
		else{
			if(from_internet == true)
				var form = '#upload-multi-links #upload-drop-zone';
			else
				var form = '#upload-drop-zone';

		}
		if(from_internet == true){
			$('.result_internet').find('.popup-links .autoselect').each(function(){
			var id = $(this).attr('id');
			var position = $(this).attr('data-position') * 1;
			
			switch(id){
				case 'show_link':
				show_links += $(this).val()+';';
				break;
				
				case 'direct_link':
				direct_links += $(this).val()+';';
				break;
				
				case 'preview_link_bb':
				preview_links_bb += $(this).val()+';';
				break;
				
				case 'preview_link_html':
				preview_links_html += $(this).val()+';';
				break;
				
				case 'bb_code':
				bb_codes += $(this).val()+';';
				break;
					
				case 'tiny_url':
				tiny_urls += $(this).val()+';';
				break;

			}
	
		}); 
		}
		else{
			$(form).find('.popup-links .autoselect').each(function(){
			var id = $(this).attr('id');
			var position = $(this).attr('data-position') * 1;
			
			switch(id){
				case 'show_link':
				show_links += $(this).val()+';';
				break;
				
				case 'direct_link':
				direct_links += $(this).val()+';';
				break;
				
				case 'preview_link_bb':
				preview_links_bb += $(this).val()+';';
				break;
				
				case 'preview_link_html':
				preview_links_html += $(this).val()+';';
				break;
				
				case 'bb_code':
				bb_codes += $(this).val()+';';
				break;
				
				case 'tiny_url':
				tiny_urls += $(this).val()+';';
				break;

			}
	
		}); 
		}
		
		if(type == 'fast'){
			$('.link_summary').show();

		}
		else{
			if(from_internet == true){
				$('#upload-multi-links #summary_links_multiple').show();
				$('#upload-multi-links #summary_links_multiple .link_summary').show();
			}
			else{
				$('#summary_links_multiple').show();
				$('#summary_links_multiple .link_summary').show();
			}
			
		}
		
		buffer_show = show_links.split(';');
		array_unique(buffer_show);
		if(type == 'fast')
			buffer_show.shift();
		show_links = implode(' ',buffer_show);
		
		buffer_direct = direct_links.split(';');
		array_unique(buffer_direct);
		if(type == 'fast')
			buffer_direct.shift();
		direct_links = implode(' ',buffer_direct);
		
		buffer_preview_bb = preview_links_bb.split(';');
		array_unique(buffer_preview_bb);
		if(type == 'fast')
			buffer_preview_bb.shift();
		preview_links_bb = implode(' ',buffer_preview_bb);
		
		buffer_preview_html = preview_links_html.split(';');
		array_unique(buffer_preview_html);
		if(type == 'fast')
			buffer_preview_html.shift();
		preview_links_html = implode(' ',buffer_preview_html);
		
		buffer_bb = bb_codes.split(';');
		array_unique(buffer_bb);
		if(type == 'fast')
			buffer_bb.shift();
		bb_codes = implode('  ',buffer_bb);
		
		buffer_tiny = tiny_urls.split(';');
		array_unique(buffer_tiny);
		if(type == 'fast')
			buffer_tiny.shift();
		tiny_urls = implode(' ',buffer_tiny);
		
		if(type == 'fast'){
			var container = '#summary_links';

		}
		else{
			if(from_internet == true)
				var container = '#upload-multi-links #summary_links_multiple';
			else
				var container = '#summary_links_multiple';

		}
		$(container+' #show_link').html(show_links);
		$(container+' #direct_link').html(direct_links);
		$(container+' #preview_link_bb').html(preview_links_bb);
		$(container+' #preview_link_html').html(preview_links_html);
		$(container+' #bb_code').html(bb_codes);
		if(tiny_urls.length > 1){
			$(container+' #tiny_url').parent().show();
			$(container+' #tiny_url').html(tiny_urls);
		}
			

		}

}

function get_resolution(type){
	
var height=0; 
var width=0;

if (self.screen) {
width = screen.width
height = screen.height
}
else if (self.java) {
var jkit = java.awt.Toolkit.getDefaultToolkit();
var scrsize = jkit.getScreenSize();
width = scrsize.width;
height = scrsize.height;
}

resolution = new Array();
resolution['width']=width;
resolution['height']=height;

return resolution[type];

}

function set_margin_big_image(image_height){
	
	var browser_height = get_resolution('height');
	var margin_top = (browser_height - image_height) / 3;
	if(image_height < browser_height)
		$('#container_big_image').css('margin-top',margin_top+'px');
}

function show_search_images(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';
	var container = $(object).html();
	var url = object.href;
	
		$.ajax({
		type: "POST",
   	 	url: url,
		dataType: 'json',
		data: 'is_ajax=1&search_pictures=1',
    	cache: false,
		beforeSend:function(){
			$(object).html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			
			$(object).html(container);
			var content = '<div id="container_search_images" style="padding:15px;">';
			content += '<div  style="overflow:hidden;">'+data.content+'</div></div>';
			$('#container_modal').html(content);
			var height_modal = $('#container_modal').height() + 5;
			if(height_modal < 100)
				height_modal = 100;
						
			Shadowbox.open({
        	content:  content,
        	player:  "html",
        	title:  data.title,
			left: 200,
			height: height_modal,
			overlayOpacity: 0.5,
			handleOversize: 'resize'
    		});	
				
			}
		});	
}

function reset_search_images(object){
	
	$('#block_parameters').remove();
	var current_url = document.location.href;
	paginate_link(current_url);

}

function search_images(object){
	
	var	ajax_url = '/templates/imghost/images/ajax-loaders/small.gif';

		var empty_fields = true;
		var from_width = $('#sb-wrapper #from_width').val();
		var to_width = $('#sb-wrapper #to_width').val();
		var from_height = $('#sb-wrapper #from_height').val();
		var to_height = $('#sb-wrapper #to_height').val();

		if($('#sb-wrapper #tiny_url').attr('checked') == 'checked'){
			var tiny_url = 1;	
		}
		else{
			var tiny_url = 0;
		}
		var tags = $('#sb-wrapper #tags').val();
		var access = $('#sb-wrapper #access').val();
		var filename = $('#sb-wrapper #filename').val();
		var comment = $('#sb-wrapper #comment').val();
		
		if($('#sb-wrapper #tags_children').length > 0)
			var tags_children = $('#sb-wrapper #tags_children').val();
		else
			var tags_children = 0;
			
		if($('#sb-wrapper #albums').length > 0){
			var albums = $('#sb-wrapper #albums option:selected').val();
		}
		else{
			var albums = 0;
		}
		
		
		var container = $('#sb-wrapper .submit').html();
		if(from_width != 0 && typeof(from_width) != 'undefined')
			empty_fields = false;
		if(to_width != 0 && typeof(to_width) != 'undefined')
			empty_fields = false;	
		if(from_height != 0 && typeof(from_height) != 'undefined')
			empty_fields = false;
		if(to_height != 0 && typeof(to_height) != 'undefined')
			empty_fields = false;	
		if(tags != 0)
			empty_fields = false;
		if(access != 0 && typeof(access) != 'undefined')
			empty_fields = false;
		if(albums != 0 && typeof(albums) != 'undefined')	
			empty_fields = false;
		if(filename != '' && typeof(filename) != 'undefined')	
			empty_fields = false;
		if(comment != '' && typeof(comment) != 'undefined')	
			empty_fields = false;
		if(tiny_url == 1)
			empty_fields = false;		
		
		if(empty_fields == true){
			alert('Не задано ни одного параметра для поиска!');
			return false;
		}	
			
		filename = encodeURIComponent(filename);
		comment = encodeURIComponent(comment);
		access = encodeURIComponent(access);
		
		if(typeof(access) == 'undefined' || access == 'undefined')
			access = 0;
			
		if(typeof(filename) == 'undefined')
			filename = '';
			
		if(typeof(comment) == 'undefined')
			comment = '';
			
		if(typeof(albums) == 'undefined' || access == 'undefined')
			albums = 0;

		if(tags != 0){
			tags = '&TAGS='+tags;
			if(tags_children != 0)
				tags += '&TAGS_CHILDREN='+tags_children;
		}
		else{
			tags = '';
		}
		
	
	$.ajax({
		type: "POST",
   	 	url: object.action,
		data: 'is_ajax=1&IS_SEARCH=1&FROM_WIDTH='+from_width+'&TO_WIDTH='+to_width+'&FROM_HEIGHT='+from_height+'&FILENAME='+filename+'&TO_HEIGHT='+to_height+'&COMMENT='+comment+'&ALBUMS='+albums+'&ACCESS='+access+'&TINYURL='+tiny_url+tags, 
		dataType: 'json',
		cache: false,
		beforeSend:function(){
			$(object).find('.submit').html('<div><img src="'+ajax_url+'"></div>');
		},
		error: function(){
			$(object).find('.submit').html(container);
			alert('Ошибка загрузки!');

		},
    	success: function(data){
			if(data.answer == 1){
				$('#content .imglist').html(data.content);
				document.title = data.title;
				Shadowbox.close();
				Shadowbox.setup("a.file_preview", {
        			gallery:   "mygallery"
				});

			}
			else{
				$(object).find('.submit').html(container);
				alert('Ошибка загрузки!');
			}
			
				
		}
	});	
	
}

function set_links(object,type){
	
	if($(object).hasClass('links-tabs') == true){
		
		if(type == 'tiny'){

		$(object).closest('.popup-links').find('.standard_links').addClass('links-tabs');
		$(object).closest('.popup-links').find('.tiny_links').removeClass('links-tabs');

		$(object).closest('.popup-links').find('.edit').each(function () {
        	var buffer = $(this).val();
			var tiny_buffer = $(this).attr('data-value');
			$(this).val(tiny_buffer);
			$(this).attr('data-value',buffer);
		
      });

	}
	
	else{
		
		$(object).closest('.popup-links').find('.tiny_links').addClass('links-tabs');
		$(object).closest('.popup-links').find('.standard_links').removeClass('links-tabs');

		$(object).closest('.popup-links').find('.edit').each(function () {
        	var buffer = $(this).val();
			var tiny_buffer = $(this).attr('data-value');
			$(this).val(tiny_buffer);
			$(this).attr('data-value',buffer);
		
      });
	}
	
	}
	else{
		return false;
	}

}

