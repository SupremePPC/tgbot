<!DOCTYPE html>
<html>
<head>
    <title>Casino Promotions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);
  
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }
        body{
            background-color: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
        }
        header {
        background-color: #000;
        color: #fff;
        padding: 1rem;
        text-align: center;
        }
        .navbar-laravel
        {
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        .navbar-brand , .nav-link, .my-form, .login-form
        {
            font-family: Raleway, sans-serif;
        }
        .my-form
        {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .my-form .row
        {
            margin-left: 0;
            margin-right: 0;
        }
        .login-form
        {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .login-form .row
        {
            margin-left: 0;
            margin-right: 0;
        }
        /* Footer Styles */
        footer {
        background-color: #000;
        color: #fff;
        text-align: center;
        padding: 1rem;
        }
    </style>



<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '581635344005390',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v16.0'
    });

    FB.AppEvents.logPageView(); 

  };
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    
<script>
  
  FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
  });
  
  
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


    

   function statusChangeCallback(response) {
            //status: 'connected',
            //authResponse: {
            //    accessToken: '...',
            //    expiresIn:'...',
            //    signedRequest:'...',
            //    userID:'...'
            //}
  
        if (Object.entries(response).length === 0) {
            alert("No response");
        } else {
            alert("Data found");
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
</script>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Laravel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
   
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @endguest
            </ul>
  
        </div>
    </div>
</nav>
  
@yield('content')
     
</body>
</html>