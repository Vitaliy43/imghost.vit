 <script type="text/javascript" src="{$THEME}js/tags.js?v={date('h')}"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
	
	$("#object").autocomplete('/search', {
		width: 400,
		max: 10,
		highlight: false,
		multiple: true,
		scroll: true,
		scrollHeight: 300,
		minChars: 2,
		deferRequestBy: 200,
		dataType: 'text'
	});
	
	
$('[name="object"]').result(function(event, data, formatted) {
	var str = ''+data+'';
	var field_object = $('#object').val();

	field_object = $.trim(field_object);
	var last_symbol = field_object.substr(-1,1);
	field_object = field_object.substr(0,field_object.length - 1);
	$('#object').val(field_object);

	var buffer = str.split(',');
	var address = buffer[buffer.length-1];
	if(address.indexOf('-') != -1){
		var temp = address.split('-');
		var object_id = temp[1] * 1;
		if(temp[0] == 'tag' || temp[0] == 'torrent' || temp[0] == 'album' || object_id > 0){
			if(temp[0] == 'tag')
				var url = '/gallery/tags/'+object_id;
			else
				var url = '/'+temp[0]+'s/'+object_id;
			$('#type_object').val(temp[0]);
			$('#object_id').val(object_id);
		}
	}
	else{
		alert('Ошибка поиска!');
	}
	document.location.href = url;
//	document.location.href = '/gallery/tags/'+tag_id;
});	
	
	});
	
	function find(object){
		
		var field_object = $('#object').val();
		var type_object = $('#type_object').val();
		var object_id = $('#object_id').val();
		
		if($('#object').val() == ''){
			alert('Поле поиска пустое!');
			return false;
		}
		else{
			
			
			var text = $('#object').val();
			
			$.ajax({
			type: "POST",
   	 		url: object.action,
			data: 'text='+text+'&type_object='+type_object+'&object_id='+object_id,
			dataType: 'json',
    		cache: false,
			beforeSend:function(){
				$('#object').text('...Секунду');	
			},
			error:function(){
				$('#object').text(text);	
				alert('Ошибка поиска!');
			},
    		success: function(data){
				if(data.answer == 1){
					document.location.href = data.url;
//					console.info('find_url '+data.url);
				}
				else{
					alert('Поиск не дал результатов');
					$('#object').text('');	
					$('#object').focus();

				}
			}
			});	
			
		}
	}
	
{/literal}




</script>

<div class="search">
		<form action="/search" onsubmit="find(this);return false;">
			<table>
				<tr>
					<td valign="top">
						<div class="label">{$lang_main.SEARCH}:</div>
							<div class="input"><input class="edit" type="text" placeholder="{$lang_main.EXAMPLE_SEARCH}" value="" name="object" id="object"/></div>
					</td>
					<input type="hidden" name="type_object" id="type_object" />
					<input type="hidden" name="object_id" id="object_id" />
					<!--td valign="top">
						<select id="type_search" style="margin-left: 10px;">
							<option value="tags">По тегам</option>
							<option value="albums">По альбомам</option>
						</select>
					</td-->
				</tr>
			</table>
			
			
		</form>
</div>