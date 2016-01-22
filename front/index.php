<!DOCTYPE html>
<html ng-app="galya">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=320, height=device-height" />
  <script type="text/javascript" src="js/components/jquery/jquery-1.9.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="js/components/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/css.css">
    <link rel="stylesheet" type="text/css" href="css/css2.css">
  <link rel="stylesheet" type="text/css" href="css/media-queries.css">
  <script type="text/javascript" src="js/components/bootstrap/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-route.js"></script>



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


</head>

<body>



    
  
<div id="mainWrapper" class="container-fluid wrapper" ng-view>



</div>


<!-- Footer -->
<footer>
    <div class="row">
        <div class="col-lg-12">
            <p>Copyright &copy; Your Website 2014</p>
        </div>
    </div>
    <!-- /.row -->
</footer>
    

<script type="text/javascript">
$(document).ready(function() {   

    var sideslider = $('[data-toggle=collapse-side]'),
      sel = sideslider.attr('data-target'),
      sel2 = sideslider.attr('data-target-2');

    sideslider.click(function(event){
        $(sel).toggleClass('in');
    });

});

$('.closeSide button').click(function(){
  $('.side-collapse').addClass('in');
});
</script>

</body>
</html>

  
  

  
  
