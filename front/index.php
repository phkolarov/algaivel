<!DOCTYPE html>
<html ng-app="galya">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=320, height=device-height" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="js/components/bootstrap/css/bootstrap.min.css" />
  <script type="text/javascript" src="js/components/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/css.css">
  <link rel="stylesheet" type="text/css" href="css/media-queries.css">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-route.js"></script>
  <script src="js/main.js"></script>
</head>

<body>


<header role="banner" class="navbar navbar-fixed-top " ng-controller="mainController">
    <div class="container-fluid">
      <div class="navbar-header">

          <button data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container" type="button" class="navbar-toggle pull-right">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <ul class="nav navbar-nav navbar-left">
            <li><a ng-click="setRoute('home')" class="logo" href="">GALYA</a></li>
            <li class="wal"><span>планините в България и по света</span></li>
          </ul>

        </div>
        <div class="side-collapse in">
          <nav role="navigation" class="navbar-collapse">
            <ul class="closeSide">
              <li>
                <button>X</button>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a ng-click="setRoute('home')" class="glyphicon glyphicon-home"></a></li>
              <li><a ng-click="setRoute('gallery')" href="">ГАЛЕРИЯ</a></li>
                  <li class="dropdown">
                <a class="dropdown-toggle" >ЗА АВТОРА <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a ng-click="setRoute('aboutGalya')" href="">ЗА ГАЛЯ</a></li>
                  <li><a ng-click="setRoute('media')" href="">В МЕДИИ</a></li>
                  <li><a ng-click="setRoute('clients')" href="">КЛИЕНТИ</a></li>
                  <li><a ng-click="setRoute('contacts')" href="">КОНТАКТИ</a></li>
                </ul>         
            </li>

              <li><a ng-click="setRoute('news')" href="#">НОВИНИ</a></li>
              <li><a ng-click="setRoute('calendar')" href="#">КАЛЕНДАР 2016</a></li>
              <li><a href="#" class="glyphicon glyphicon-envelope"></a></li>
              <li><a href="#" class="language">EN</a></li>
              <li><a href="#" class="mLanguage">English</a></li>
            </ul>
          </nav>
        </div>
    </div>
</header>
    
  
<div class="container-fluid wrapper" ng-view>



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

  
  

  
  
