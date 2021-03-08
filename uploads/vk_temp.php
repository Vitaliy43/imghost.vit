<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<!--script src="//vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script-->

<!--div id="login_button" onclick="VK.Auth.login({scope: 'photos'});">VK</div-->
<div id="login_button" onclick="VK.Auth.login(null, VK.access.PHOTOS);">VK</div>
<!--div id="login_button" onclick="VK.Auth.login(authInfo);">VK</div-->
<!--div id="login_button" onclick="VK.Auth.login(null, VK.access.FRIENDS);" >VK2</div-->

<script language="javascript">

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

VK.init({
  apiId: 4552292
});

function create_album(){
	VK.api("photos.createAlbum", {title: "Checker",privacy: '0'}, function(data) {
    // Действия с полученными данными
//	alert('Success');
	console.info(data.response);

	}); 
}

function get_upload_server(){
	VK.api("photos.getUploadServer", {album_id: '199854556'}, function(data) {
    // Действия с полученными данными
//	alert(data.upload_url);
	console.info(data.response);
	}); 
}

var temp = {"server":616523,"photos_list":"[{\"photo\":\"0e1de0205b:z\",\"sizes\":[[\"s\",\"616523805\",\"1930c\",\"aAYEtNwLrqg\",75,56],[\"m\",\"616523805\",\"1930d\",\"OX6guqJU_NE\",130,97],[\"x\",\"616523805\",\"1930e\",\"PNQws3OSY3k\",604,453],[\"y\",\"616523805\",\"1930f\",\"hRe5OPAoHOg\",807,605],[\"z\",\"616523805\",\"19310\",\"Xq7QP_dMKpQ\",1024,768],[\"o\",\"616523805\",\"19311\",\"QZrHDcimOGw\",130,98],[\"p\",\"616523805\",\"19312\",\"nczDbmnEkaw\",200,150],[\"q\",\"616523805\",\"19313\",\"tKQ5dyfHv5c\",320,240],[\"r\",\"616523805\",\"19314\",\"tQECmNLDci0\",510,383]],\"kid\":\"710ddff22f461ef173c2876a14078bc0\"},{\"photo\":\"ceada8b41d:z\",\"sizes\":[[\"s\",\"616523805\",\"19315\",\"4HAYvkQ3VH0\",75,56],[\"m\",\"616523805\",\"19316\",\"se0cBXoyIoc\",130,97],[\"x\",\"616523805\",\"19317\",\"Lm7hJyyOW6E\",604,453],[\"y\",\"616523805\",\"19318\",\"WXXKgxOBxpw\",807,605],[\"z\",\"616523805\",\"19319\",\"GDQHB4jV1Aw\",1024,768],[\"o\",\"616523805\",\"1931a\",\"v2n1N2q6mJE\",130,98],[\"p\",\"616523805\",\"1931b\",\"O0e4xZYbmXU\",200,150],[\"q\",\"616523805\",\"1931c\",\"7O_0zSysrEM\",320,240],[\"r\",\"616523805\",\"1931d\",\"dskAv0hFSkQ\",510,383]],\"kid\":\"7c366e8912d472aacb36e4efb6dd13b7\"},{\"photo\":\"cd0b10cb29:z\",\"sizes\":[[\"s\",\"616523805\",\"1931e\",\"tVEHFlarkQM\",75,56],[\"m\",\"616523805\",\"1931f\",\"2o_a2-imVoM\",130,97],[\"x\",\"616523805\",\"19320\",\"oEHkKwLgnsY\",604,453],[\"y\",\"616523805\",\"19321\",\"O_Z2q9Ke_Bg\",807,605],[\"z\",\"616523805\",\"19322\",\"-szWtb3rG9g\",1024,768],[\"o\",\"616523805\",\"19323\",\"9QnnSUyE7_o\",130,98],[\"p\",\"616523805\",\"19324\",\"gEgBs6B7bAM\",200,150],[\"q\",\"616523805\",\"19325\",\"A1e-5psKMx0\",320,240],[\"r\",\"616523805\",\"19326\",\"HSBA_7bj3kI\",510,383]],\"kid\":\"750756d80c2f7efcd34d3e1c97422f5f\"}]","aid":202603517,"hash":"2151888c26cbb4aa5daf2d50a36d2ee7"};

function photos_save(){
//	VK.Api.call('photos.save', {server:622527,photos_list:"[{\"photo\":\"f65916fbbb:z\",\"sizes\":[[\"s\",\"622527805\",\"1c9\",\"zHbRmR5oYE4\",75,56],[\"m\",\"622527805\",\"1ca\",\"3vDll6uKSCg\",130,97],[\"x\",\"622527805\",\"1cb\",\"gapyhTf7x8U\",604,453],[\"y\",\"622527805\",\"1cc\",\"j_G4daofIDA\",807,605],[\"z\",\"622527805\",\"1cd\",\"SZKOovn9nJg\",1024,768],[\"o\",\"622527805\",\"1ce\",\"0sBUXLfX56M\",130,98],[\"p\",\"622527805\",\"1cf\",\"ploA_O_lf7k\",200,150],[\"q\",\"622527805\",\"1d0\",\"ZRvlqzqpvXg\",320,240],[\"r\",\"622527805\",\"1d1\",\"Ncl4hQ2gbfw\",510,383]],\"kid\":\"7a3caea3bdb57264a99b659634937509\"}]",aid:199854556,hash:"77431560926934340b7a4a0ceb7c45c7"} , function(r) {
//	VK.Api.call('photos.save', {server:622527,photos_list:"[{\"photo\":\"f65916fbbb:z\",\"sizes\":[[\"s\",\"622527805\",\"1c9\",\"zHbRmR5oYE4\",75,56],[\"m\",\"622527805\",\"1ca\",\"3vDll6uKSCg\",130,97],[\"x\",\"622527805\",\"1cb\",\"gapyhTf7x8U\",604,453],[\"y\",\"622527805\",\"1cc\",\"j_G4daofIDA\",807,605],[\"z\",\"622527805\",\"1cd\",\"SZKOovn9nJg\",1024,768],[\"o\",\"622527805\",\"1ce\",\"0sBUXLfX56M\",130,98],[\"p\",\"622527805\",\"1cf\",\"ploA_O_lf7k\",200,150],[\"q\",\"622527805\",\"1d0\",\"ZRvlqzqpvXg\",320,240],[\"r\",\"622527805\",\"1d1\",\"Ncl4hQ2gbfw\",510,383]],\"kid\":\"7a3caea3bdb57264a99b659634937509\"}]",aid:199854556,hash:"77431560926934340b7a4a0ceb7c45c7"} , function(r) {
//	VK.Api.call('photos.save', {"server":616523,"photos_list":"[{\"photo\":\"0e1de0205b:z\",\"sizes\":[[\"s\",\"616523805\",\"1930c\",\"aAYEtNwLrqg\",75,56],[\"m\",\"616523805\",\"1930d\",\"OX6guqJU_NE\",130,97],[\"x\",\"616523805\",\"1930e\",\"PNQws3OSY3k\",604,453],[\"y\",\"616523805\",\"1930f\",\"hRe5OPAoHOg\",807,605],[\"z\",\"616523805\",\"19310\",\"Xq7QP_dMKpQ\",1024,768],[\"o\",\"616523805\",\"19311\",\"QZrHDcimOGw\",130,98],[\"p\",\"616523805\",\"19312\",\"nczDbmnEkaw\",200,150],[\"q\",\"616523805\",\"19313\",\"tKQ5dyfHv5c\",320,240],[\"r\",\"616523805\",\"19314\",\"tQECmNLDci0\",510,383]],\"kid\":\"710ddff22f461ef173c2876a14078bc0\"},{\"photo\":\"ceada8b41d:z\",\"sizes\":[[\"s\",\"616523805\",\"19315\",\"4HAYvkQ3VH0\",75,56],[\"m\",\"616523805\",\"19316\",\"se0cBXoyIoc\",130,97],[\"x\",\"616523805\",\"19317\",\"Lm7hJyyOW6E\",604,453],[\"y\",\"616523805\",\"19318\",\"WXXKgxOBxpw\",807,605],[\"z\",\"616523805\",\"19319\",\"GDQHB4jV1Aw\",1024,768],[\"o\",\"616523805\",\"1931a\",\"v2n1N2q6mJE\",130,98],[\"p\",\"616523805\",\"1931b\",\"O0e4xZYbmXU\",200,150],[\"q\",\"616523805\",\"1931c\",\"7O_0zSysrEM\",320,240],[\"r\",\"616523805\",\"1931d\",\"dskAv0hFSkQ\",510,383]],\"kid\":\"7c366e8912d472aacb36e4efb6dd13b7\"},{\"photo\":\"cd0b10cb29:z\",\"sizes\":[[\"s\",\"616523805\",\"1931e\",\"tVEHFlarkQM\",75,56],[\"m\",\"616523805\",\"1931f\",\"2o_a2-imVoM\",130,97],[\"x\",\"616523805\",\"19320\",\"oEHkKwLgnsY\",604,453],[\"y\",\"616523805\",\"19321\",\"O_Z2q9Ke_Bg\",807,605],[\"z\",\"616523805\",\"19322\",\"-szWtb3rG9g\",1024,768],[\"o\",\"616523805\",\"19323\",\"9QnnSUyE7_o\",130,98],[\"p\",\"616523805\",\"19324\",\"gEgBs6B7bAM\",200,150],[\"q\",\"616523805\",\"19325\",\"A1e-5psKMx0\",320,240],[\"r\",\"616523805\",\"19326\",\"HSBA_7bj3kI\",510,383]],\"kid\":\"750756d80c2f7efcd34d3e1c97422f5f\"}]","aid":202603517,"hash":"2151888c26cbb4aa5daf2d50a36d2ee7"} , function(r) {
//	alert('124');

//}); 	

VK.Api.call('photos.save',temp , function(r) {
	alert('124');

}); 	
		
//	VK.Api.call('photos.save', temp , function(r) {
//		alert('124');
//  if(r.response) {
//    alert('Привет, ' + r.response[0].first_name);
//  }
//}); 
}

function authInfo(response) {
  if (response.session) {
    alert('user: '+response.session.mid);
//	get_upload_server();
//	create_album();
//	photos_save();
//	create_album();
  } else {
    alert('not auth');
  }
}
VK.Auth.getLoginStatus(authInfo);
//VK.UI.button('login_button');



</script>
<?php



function photos_save($url,$postdata){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$uri); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 	
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);  //$photo - прямая ссылка на изображение

    $result = curl_exec($ch);
	echo 'result <br>';
	echo $result;
	$content = json_decode($result,true);

//	var_dump($result2);
//	var_dump($content);
 
    if (curl_errno($ch) != 0 && empty($result)) {
//		echo 'Error!!1'
        $result = false;
    }
 
    curl_close($ch);
}

function upload_server($uri){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$uri); 
 	$photos = array(1,2,3);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 	foreach($photos as $item){
//		$photo = 'http://vitaliy43.ru/pictures/'.$item.'.jpg';
		$photo = 'pictures/'.$item.'.jpg';
		$field = 'file'.$item;
//		$postdata = array( 'name' => 'evgenijj',
//             'email' => 'evgenijj@mail.ru',
//              'message' => 'Какое-то сообщение от пользователя evgenijj',
//               $field => "@".$photo );
		$postdata[$field] = "@".$photo;
	
	}
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);  //$photo - прямая ссылка на изображение

    $result = curl_exec($ch);
	echo 'result <br>';
	echo $result;
	$content = json_decode($result,true);
	$url = "https://api.vk.com/method/photos.save?v=5.3&album_id=199854556&server=".$content['server'].'&photos_list='.$content['photos_list'].'&hash='.$content['hash'];
	$buffer = file_get_contents($url);
	$result2 = json_decode($buffer,true);
//	var_dump($result2);
//	var_dump($content);
 
    if (curl_errno($ch) != 0 && empty($result)) {
//		echo 'Error!!1'
        $result = false;
    }
 
    curl_close($ch);
}



?>


