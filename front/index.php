<!DOCTYPE html>
<html ng-app="galya">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=320, height=device-height"/>
    <script type="text/javascript" src="js/components/jquery/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/components/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="js/components/bootstrap/css/bootstrap.icon-large.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/css.css">
    <link rel="stylesheet" type="text/css" href="css/css2.css">
    <link rel="stylesheet" type="text/css" href="css/media-queries.css">
    <script type="text/javascript" src="js/components/bootstrap/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-route.js"></script>

    <script type="text/javascript" src="js/globals.js"></script>
    <script src="js/main.js"></script>
    <script src="js/service/data-service.js"></script>

    <!--CUSTOM JS-->
    <script src="js/custom-js/custom-js.js"></script>

    <!--  CONTROLLERS-->
    <script src="js/controllers/mainMenuController.js"></script>
    <script src="js/controllers/imagesController.js"></script>
    <script src="js/controllers/pagingController.js"></script>
    <script src="js/controllers/filtersController.js"></script>
    <script src="js/controllers/galleryController.js"></script>
    <script src="js/controllers/imageController.js"></script>
    <script src="js/controllers/iconsController.js"></script>
    <script src="js/controllers/allNewsMainController.js"></script>
    <script src="js/controllers/allNewsController.js"></script>
    <script src="js/controllers/pagingNewsController.js"></script>
    <script src="js/controllers/currentArticleController.js"></script>
    <script src="js/controllers/fullSizeImageController.js"></script>
    <script src="js/controllers/fineArtController.js"></script>
    <script src="js/controllers/aboutMeController.js"></script>
    <script src="js/controllers/cartController.js"></script>
    <script src="js/controllers/loginController.js"></script>
    <script src="js/controllers/homeController.js"></script>
    <script src="js/controllers/adminController.js"></script>

    <!--DIRECTIVES-->
    <script src="js/directives/main-menu-directive.js"></script>
    <script src="js/directives/images-element-directive.js"></script>
    <script src="js/directives/paging-element-directive.js"></script>
    <script src="js/directives/filters-element-directive.js"></script>
    <script src="js/directives/current-image-element-directive.js"></script>
    <script src="js/directives/arrows-element-directive.js"></script>
    <script src="js/directives/icons-set-directive.js"></script>
    <script src="js/directives/all-news-element-directive.js"></script>
    <script src="js/directives/pagin-news-element-directive.js"></script>
    <script src="js/directives/current-article-element-directive.js"></script>
    <script src="js/directives/about-me-element-directive.js"></script>
    <script src="js/directives/cart-element-directive.js"></script>

    <!--SOCIAL DIRECTIVES-->
    <script src="js/directives/socialDirectives/00-directive.js"></script>
    <script src="js/directives/socialDirectives/02-facebook.js"></script>
    <script src="js/directives/socialDirectives/03-twitter.js"></script>
    <script src="js/directives/socialDirectives/04-google-plus.js"></script>


    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha512.js"></script>

    <!-- FB API -->
    <script type="text/javascript">
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script src="fbapp/fb.js"></script>


    <!-- 3D View -->
    <script src="js/3dView/build/three.min.js"></script>
    <script src="js/3dView/periodictable/js/controls/TrackballControls.js"></script>
    <script src="js/3dView/periodictable/js/libs/tween.min.js"></script>
    <script src="js/3dView/periodictable/js/renderers/CSS3DRenderer.js"></script>


</head>

<body>


<div id="mainWrapper" class="container-fluid wrapper" ng-view>


</div>


<!--<!-- Footer -->
<!--<footer>-->
<!--    <div class="row">-->
<!--        <div class="col-lg-12">-->
<!--            <p>Copyright &copy; Your Website 2014</p>-->
<!--        </div>-->
<!--    </div>-->
<!--    <!-- /.row -->
<!--</footer>-->


<script type="text/javascript">

    $(document).ready(function() {

        function facebookReady(){
            FB.init({
                appId  : '1664655443803322',
                status : true,
                cookie : true,
                xfbml  : true,
                version: 'v2.5'
            });

            $(document).trigger("facebook:ready");
            loginStatus();

        }

        if( window.FB ) {

            facebookReady();
        } else {

            window.fbAsyncInit = facebookReady;
        }

        $(document).unbind("userInfo:ready").on("userInfo:ready", function(){

            var data = {
                id: userInfo.id
            };

            userInfo.admin = false;

            data = JSON.stringify(data);

            $.when(

                $.ajax({
                    url: '../back/Users/isAdmin',
                    method: 'post',
                    data: {data},
                    success: function(result) {
                        if( JSON.parse(result) == 'admin' && userInfo.role != 2 ){
                            userInfo.admin = true;
                            document.getElementById('loginBtn').style.display = 'block';
                        }
                    },
                    error: function(err) {
                        console.log(err)
                    }
                })
            ).then(function() {


                $('.navbar-right').append(
                    '<li class="faceb-user">'+
                    '<div class="faceb-photo"></div>'+
                    '<div class="faceb-name"></div>'+
                    '</li>'
                );
                $('.fb-login-btn').hide();
                $('.faceb-user').show();
                $('.faceb-name').text(userInfo.name);
                $('.faceb-photo').append('<img src="https://graph.facebook.com/'+ userInfo.id + '/picture?" />');
                $('.faceb-user').css('display','block');


            })
        });

    });

</script>

</body>
</html>

  
  

  
  
