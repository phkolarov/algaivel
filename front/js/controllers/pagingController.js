galya.controller("pagingController", ["$scope", 'siteData','$routeParams', function ($scope, siteData,$routeParams) {


    var countOfArticles = 79;
    var countOfPages = 3;
    var pageButForPrint = 2;
    var currentPage = 1;
    var selected = "blue";
    var imagesPerPage = $scope.formPageCount.count;


    if($routeParams.page != null){
        currentPage = parseInt($routeParams.page);
    }

    siteData.getPageCount(imagesPerPage).then(function (data) {

        countOfPages = data.data.results.pages;
        $scope.countOfPages = countOfPages;

        leftButtonSide();
        rightButtonSide();

    });

    $scope.$on('refreshPageCount', function (event, data) {


        countOfPages = data;
        $scope.countOfPages = data;
        currentPage = 1;
        $scope.currentPage = currentPage;
        leftButtonSide();
        rightButtonSide();
    });

    $scope.currentPage = currentPage;

    $scope.nextPage = function nextPage() {

        if (currentPage < countOfPages) {
            ++currentPage;
            $scope.currentPage = currentPage;
            leftButtonSide();
            rightButtonSide();
        }
        var count = $scope.formPageCount.count;
        var page = currentPage - 1;


        if ($scope.groups.length > 0) {

            siteData.getImages(page, count, $scope.groups, $scope.filters).then(function (data) {
                $scope.presentImage = data.data.results[0];
                $scope.imageData = data.data.results.splice(1, data.data.results.length);

            });

        } else {

            siteData.getImages(page, count).then(function (data) {
                $scope.presentImage = data.data.results[0];
                $scope.imageData = data.data.results.splice(1, data.data.results.length);

            });
        }
    };

    $scope.backPage = function nextPage() {


        if (currentPage > 1) {
            --currentPage;
            $scope.currentPage = currentPage;
            leftButtonSide();
            rightButtonSide();
        }

        var count = $scope.formPageCount.count;
        var page = currentPage - 1;


        if ($scope.groups.length > 0) {

            siteData.getImages(page, count, $scope.groups, $scope.filters).then(function (data) {
                $scope.presentImage = data.data.results[0];
                $scope.imageData = data.data.results.splice(1, data.data.results.length);

            });

        } else {

            siteData.getImages(page, count).then(function (data) {
                $scope.presentImage = data.data.results[0];
                $scope.imageData = data.data.results.splice(1, data.data.results.length);

            });
        }
    };
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


    //RELOAD DATA WITH EVENT ON CHANGE COUNT OF IMAGES PER PAGE

    $scope.$on('MyEvent', function () {

        $scope.currentPage = 1;
        currentPage = 1;
        imagesPerPage = parseInt($scope.formPageCount.count);

        var groups = $scope.groups;

        //CHECK FOR BUGS!!!!!!

        if(groups.length == 0){

            siteData.getPageCount(imagesPerPage).then(function (data) {


                countOfPages = data.data.results.pages;

                leftButtonSide();
                rightButtonSide();

            });
        }else{

            countOfPages =  $scope.countOfPages;
            leftButtonSide();
            rightButtonSide();
        }


    });


}]);