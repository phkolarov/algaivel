galya.controller('pagingNewsController' ,['$scope','siteData','$location','$routeParams', function ($scope,siteData,$location,$routeParams) {


    var pageButForPrint = 2;
    var currentPage = 1;
    var countOfPages = 5;


    if($routeParams.page){

        currentPage = parseInt($routeParams.page);
    }

    var year = new Date().getFullYear();

    if($routeParams.year){

        year = $routeParams.year;
    }
    $scope.currentPage = currentPage;




    siteData.getPageNewsCount(year).then(function (data) {


        $scope.countOfPages = data.data.results;
        countOfPages = $scope.countOfPages;

        leftButtonSide();
        rightButtonSide();
    });

    function leftButtonSide() {


        if (currentPage > pageButForPrint) {

            $scope.dotsShow = true;
            $scope.leftSideIndex = currentPage - pageButForPrint;
            $scope.leftPageButForPrint = pageButForPrint;

            $scope.leftSideButtons = function (pageButForPrint) {

                return new Array(pageButForPrint);
            }
        } else if (currentPage <= pageButForPrint && currentPage > 0) {

            $scope.leftSideIndex = 1;
            $scope.leftPageButForPrint = pageButForPrint - (pageButForPrint - currentPage) - 1;

            $scope.leftSideButtons = function (pageButForPrint) {

                return new Array(pageButForPrint);
            }
        } else {
            $scope.rightPageButForPrint = 0;
            $scope.rightSideButtons = function (pageButForPrint) {
                return new Array(pageButForPrint);
            }
        }
    }


    function rightButtonSide() {

        if ((currentPage + pageButForPrint) < countOfPages) {

            $scope.rightSideIndex = currentPage + 1;
            $scope.rightPageButForPrint = pageButForPrint;
            $scope.rightSideButtons = function (pageButForPrint) {
                return new Array(pageButForPrint);
            }

        } else if ((currentPage + 1) <= countOfPages) {

            $scope.rightSideIndex = currentPage + 1;
            $scope.rightSideButtonsNumber = currentPage + 1;
            $scope.rightPageButForPrint = countOfPages - currentPage;

            $scope.rightSideButtons = function (rightPageButForPrint) {
                return new Array(rightPageButForPrint);
            }
        } else {
            $scope.rightPageButForPrint = 0;
            $scope.rightSideButtons = function (pageButForPrint) {
                return new Array(pageButForPrint);
            }
        }
    }


    $scope.backNewsPage = function nextNewsPage(){

       if(currentPage > 1){

           $scope.currentPage = currentPage - 1;
           currentPage = $scope.currentPage;

           $location.path('news/page/'+ currentPage + "/" + $scope.years.count);

           //var articleObject = {
           //  page: currentPage,
           //  year: $scope.years.count
           //};

           //$scope.$emit('getArticles',articleObject);
           //
           leftButtonSide();
           rightButtonSide();
       }
    };

    $scope.nextNewsPage = function nextNewsPage(){

      if(currentPage < countOfPages){


          $scope.currentPage = currentPage + 1;
          currentPage = $scope.currentPage;

          $location.path('news/page/'+ currentPage+ "/" + $scope.years.count);


          //var articleObject = {
          //    page: currentPage,
          //    year: $scope.years.count
          //};
          //
          //$scope.$emit('getArticles',articleObject);
          //
          leftButtonSide();
          rightButtonSide();
      }

    };

    $scope.$on('changeYearOfNews', function (event,data) {


        $scope.currentPage = 1;
        $scope.linkYear = $scope.years.count;
        currentPage = 1;

        $location.path('news/page/'+ currentPage + "/" + $scope.years.count);

        //var articleObject = {
        //    page: currentPage,
        //    year: $scope.years.count
        //};
        //
        //leftButtonSide();
        //rightButtonSide();
        //
        //$scope.$emit('getArticles',articleObject);


    });

}]);