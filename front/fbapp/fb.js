function statusChangeCallback(response) {
  console.log(response);
    if (response.status === 'connected') {

      $.ajax({
        url: "fbapp/login-callback.php",
        success: function(e) {

        },
        error: function() {

        }
      })
      	
    } else if (response.status === 'not_authorized') {
      	
    } else {
      	
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
}

function getUserInfo(token, id) {

  FB.api(
    "/me",
    function (response) {

      if (response && !response.error) {
        userInfo.name = response.name;
        userInfo.id = response.id;
        $(document).trigger("userInfo:ready");
      }

    }, {access_token: token}

  );
}

window.fbAsyncInit = function() {
  FB.init({
  	appId      : '1664655443803322',
  	cookie     : true,  // enable cookies to allow the server to access 
  	                    // the session
  	xfbml      : true,  // parse social plugins on this page
  	version    : 'v2.5' // use any version
  });

};

function loginStatus() {

  FB.getLoginStatus(function(response) {
    if (response.status === 'connected') {
      console.log(response);
      getUserInfo(response.authResponse.accessToken, response.authResponse.userID);
    }else{

    }
  })

}

function login() {
  FB.login(function(response) {
    if (response.authResponse) {
      loginStatus();
      window.location.hash = '#home';
    } else {
     
    }
  });
}

