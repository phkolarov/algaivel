galya.controller('pagingNewsController' ,['$scope', function ($scope) {


    var pageButForPrint = 2;
    var currentPage = 5;
    var countOfPages = 5;

    $scope.currentPage = currentPage;

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

    leftButtonSide();
    rightButtonSide();
}]);