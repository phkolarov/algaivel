galya.controller('searchController', ['$scope', '$location', '$routeParams', 'siteData','$window', '$document',function ($scope, $location, $routeParams, siteData,$window,$document) {


    $scope.searchCounter = 0;
    $scope.bindChecker = 0;
    //$scope.$watch('searchedResultObject');
    $document.unbind('scroll');

    angular.element($document).on('scroll', function testFunc(){

        var windowHeight = "innerHeight" in window ? window.innerHeight : document.documentElement.offsetHeight;
                var body = document.body, html = document.documentElement;
                var docHeight = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight,  html.scrollHeight, html.offsetHeight);
                var windowBottom = windowHeight + window.pageYOffset;

                if ((windowBottom + 1) > docHeight) {
                    $scope.searchCounter++;

                    $scope.$emit('downloadSearchData',$routeParams);
                    console.log($scope.searchedResultObject);
                }

    });

    $scope.$on('downloadSearchData', function (event, obj) {

        if(obj.type == 'images'){

            siteData.searchImages(obj.searchingContext, $scope.searchCounter, obj.lang).then(function (data) {


                if($scope.searchedResultObject){
                    $scope.oldSearchedResults = angular.copy($scope.searchedResultObject);

                    var tempArray = $scope.oldSearchedResults.concat(data.data.results);

                    $scope.searchedResultObject = articleDateTransformer(tempArray);

                    if(!$scope.$$phase) {
                        $scope.$digest();
                    }

                }else {
                    $scope.searchedResultObject = articleDateTransformer(data.data.results);
                }

                if($scope.searchedResultObject.length){
                    $scope.notFound = true;
                }else{
                    $scope.notFound = false;
                }

            });

        }else if(obj.type == 'articles'){

            siteData.searchArticles(obj.searchingContext, $scope.searchCounter, obj.lang).then(function (data) {

                if($scope.searchedResultObject){
                    $scope.oldSearchedResults = angular.copy($scope.searchedResultObject);

                    var tempArray = $scope.oldSearchedResults.concat(data.data.results);
                    $scope.searchedResultObject = articleDateTransformer(tempArray);

                    if(!$scope.$$phase) {
                        $scope.$digest();
                    }

                }else {


                    $scope.searchedResultObject = articleDateTransformer(data.data.results);
                }


                if($scope.searchedResultObject.length){
                    $scope.notFound = true;
                }else{
                    $scope.notFound = false;
                }
            });
        }


    });


    $scope.$emit('downloadSearchData',$routeParams);


    function articleDateTransformer(inputObject){

        var articlesObject = inputObject;
        var monthNames = ["Ян.", "Фев.", "Март.", "Апр.", "Май.", "Юни.",
            "Юли.", "Авг.", "Сеп.", "Окт.", "Ное.", "Дек."
        ];

        for(var i in articlesObject){

            var date = new Date(articlesObject[i].post_date);

            articlesObject[i].monthName = monthNames[date.getMonth()];
            articlesObject[i].Day = date.getDate();
        }

        return articlesObject;
    }
}]);