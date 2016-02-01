galya.controller('fullSizeImageController', ['$scope','$routeParams','siteData', function ($scope,$routeParams,siteData) {


    if($routeParams.image){
        siteData.getCurrentImage($routeParams.image,[],[]).then(function (data) {

            $scope.fullSizeImageSource  = data.data.results.source;
            console.log(data.data.results.source);

        });
    }


}]);