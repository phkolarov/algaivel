galya.controller('galleryController',['$scope','siteData','$route', function ($scope,siteData,$route) {


    $scope.pageCount = [
        { name: '15', value: '15' },
        { name: '30', value: '30' },
        { name: '45', value: '45' },
        { name: '60', value: '60' }
    ];
    $scope.formPageCount = {count : $scope.pageCount[0].value};





    $scope.$on('MyEvent', function (event,data) {

        var currentPage = 0;
        var imagegPerPage = parseInt( $scope.formPageCount.count);
        var categoryArray = $scope.categoryArray;
        var filtersArray = $scope.filtersArray;


        if(categoryArray == undefined || categoryArray.length == 0){

            siteData.getImages(currentPage,imagegPerPage).then(function (data) {

                console.log(currentPage);
                console.log(imagegPerPage);
                console.log(data);

                $scope.presentImage = data.data.results[0];
                $scope.imageData = data.data.results.splice(1,data.data.results.length);

            });
        }else{

            siteData.getImages(currentPage, $scope.formPageCount.count,categoryArray,filtersArray).then(function (data) {

                $scope.countOfPages = data.data.countOfPages;
                $scope.presentImage = data.data.results[0];
                $scope.imageData = data.data.results.splice(1,data.data.results.length);

            })
        }


    })
}]);