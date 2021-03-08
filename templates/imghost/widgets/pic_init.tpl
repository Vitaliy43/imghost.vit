<script type="text/javascript" src="https://apis.google.com/js/client:plusone.js"></script>
<script type="text/javascript">
	var count_author = 0;
	var message_error = '{$error}';
	{literal}	
	(function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client:plusone.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();		
		function signinCallback(authResult) {
  		if (authResult['access_token']) {
  			makeApiCall();
  		} 
		else if (authResult['error']) {
			count_author++;
			
//			if(count_author > 1)
//				alert(message_error);
  		}
	}
	
	 function makeApiCall() {
        // Step 4: Load the Google+ API
        gapi.client.load('plus', 'v1', function() {
          // Step 5: Assemble the API request
          var request = gapi.client.plus.people.get({
            'userId': 'me'
          });
          // Step 6: Execute the API request
          request.execute(function(resp) {
           	set_google_profile(resp);
          });
        });
		}
		
	{/literal}
</script>

<div style="padding-top: 50px;padding-left: 70px;">
<div>
		{$language.GOOGLE_MESSAGE_AUTHOR}
	</div>
	<div style="font-size: 12px;">
		{$language.WARNING_POPUP}
	</div>
<div style="padding-top: 5px;">
<span id="signinButton">
  <span
    class="g-signin"
    data-callback="signinCallback"
    data-clientid="{$api_id}"
    data-cookiepolicy="single_host_origin"
    data-requestvisibleactions="http://schemas.google.com/AddActivity"
    data-scope="https://www.googleapis.com/auth/plus.login">
  </span>
</span>
</div>
</div>