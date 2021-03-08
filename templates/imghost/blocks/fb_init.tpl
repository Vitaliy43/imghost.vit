<script id="facebook-jssdk" src="//connect.facebook.net/en_US/sdk.js"></script>
<script type="text/javascript">
  	{literal}
	
	function show_modal_fb(){
		var container_fb = $('#container_fb').html();
		var modal_title = $('#fb_message').val();
		var modal_error = $('#fb_error').val();
		Shadowbox.open({
        	content: container_fb,
        	player:  "html",
        	title:  modal_title,
			left: 200,
			height: 300,
			overlayOpacity: 0.5,
			handleOversize: 'resize'
    		});	
	}
	
		
	 window.fbAsyncInit = function() {
  	FB.init({
	{/literal}
    appId      : '{$api_id}',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.0
	{literal}
  });
  
    FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
	};

  
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  
   function statusChangeCallback(response) {

    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      fb_api();
    } else if (response.status === 'not_authorized') {
		alert(modal_error);
	
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
//      document.getElementById('status').innerHTML = 'Please log ' +
//        'into Facebook.';
    }
  }
  
  {/literal}
	
 </script>

