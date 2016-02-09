galya.controller('addToCarouselController',['$scope', 'siteData', '$http', 'serviceURL','$routeParams', '$location' ,function ($scope, siteData, $http,serviceURL,$routeParams, $location) {

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

                $scope.imageData = data.data.results;
            });
        }else{

            siteData.getImages(currentPage, $scope.formPageCount.count,categoryArray,filtersArray).then(function (data) {

                $scope.countOfPages = data.data.countOfPages;
                $scope.imageData = data.data.results;

            })
        }


    })

    $scope.addToQueueAC = function (e) {

        if( e.target.className == 'toBeAdded' ){
            e.target.style.border = 'none';
            e.target.className = '';
        }else{
            e.target.style.border = '4px solid green';
            e.target.className = 'toBeAdded';
        }


    }

    $scope.addToCarousel = function() {

        var get = document.getElementsByClassName('toBeAdded'),
            elements = [];

        for( var i = 0; i < get.length; i++){
            var split = get[i].attributes.src.textContent.split('/');
            elements[i] = split[1];
        }

        var data = JSON.stringify({elements: elements, id: userInfo.id, sessionId: userInfo.session});

        $http({
            url: '../back/Admin/addToCarousel',
            method:'POST',
            contentType:'application/json',
            dataType:'json',
            data: data
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            
        });

    };
	
}]);