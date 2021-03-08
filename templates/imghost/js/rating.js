

function set_rating(object){
	var parameterString=object.href;
	var class_name=object.className;
var buffer=class_name.split('-');
var num=str_replace('r','',buffer[0]);
var parameterTokens=parameterString.split("&");

var parameterList=new Array();
for(j=0;j<parameterTokens.length;j++)
{var parameterName=parameterTokens[j].replace(/(.*)=.*/,"$1");
 var parameterValue=parameterTokens[j].replace(/.*=(.*)/,"$1");
 parameterList[parameterName]=parameterValue;
 }
var theratingID=parameterList['id'];
var theVote=parameterList['vote'];
var theunits=parameterList['c'];
var type=parameterList['type'];

sndReq(object.href);
}

function sndReq(url)
{

var container = $('.container_vote').html();
$.ajax({
		type: "POST",
   	 	url: url,
		data: 'is_ajax=1',
		dataType: 'json',
    	cache: false,
		beforeSend:function(){
			$('.container_vote').html('<div class="loading"></div>');			
		},
		error: function(){
			$('.container_vote').html(container);
			alert('Ошибка загрузки!');
		},
    	success: function(data){
			changeText(data.content);
		}
    });	

}

 
 
function change_rating(object){
	parameterString=jQuery('#parameter_poll').val();
	var parameterTokens=parameterString.split("&");
	var parameterList=new Array();
	for(j=0;j<parameterTokens.length;j++){
	var parameterName=parameterTokens[j].replace(/(.*)=.*/,"$1");
	var parameterValue=parameterTokens[j].replace(/.*=(.*)/,"$1");
 	parameterList[parameterName]=parameterValue;
 	}
	var theratingID=parameterList['q'];
	var theVote=parameterList['j'];
	var theuserIP=parameterList['t'];
	var theunits=parameterList['c'];
	sndReq(theVote,theratingID,theuserIP,theunits);

}
 
function changeText(text)
{
  	$('.container_vote').html(text);
  }

