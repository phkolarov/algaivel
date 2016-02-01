galya.controller('adminController',['$scope', '$http', function ($scope, $http) {

	$scope.getImage = function() {

		$http({
            url: '../back/Gallery/getCarouselImages'
        }).then(function successCallback(response) {
            $scope.setImages(response.data.results);
        }, function errorCallback(response) {
            //console.log(response);
        });

	}

    $scope.setImages = function(images) {
        
        var canvas = "";

        images.forEach(function(index, value){

            canvas += '<div><img src="'+ index.source +'" onclick="func(event)" /></div>';

        })

        document.getElementsByClassName('removeCarousel')[0].innerHTML = canvas;
    }

    func = function (e){

        var element = e.target.attributes.src.textContent;
        var data = JSON.stringify({element:element, id:userInfo.id, sessionId:userInfo.session});

        $http({
            url: '../back/Admin/index',
            method:'POST',
            contentType:'application/json',
            dataType:'json',
            data: {data}
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            //console.log(response);
        });


    }

	$scope.getImage();

    $scope.addToCarousel = function(){

        $http({
            url: '../back/Gallery/index',
            method:'get',
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            //console.log(response);
        });

    }

    $scope.addToCarousel();

}]);