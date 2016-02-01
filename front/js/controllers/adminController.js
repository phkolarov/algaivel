galya.controller('adminController',['$scope', '$http', 'serviceURL',function ($scope, $http,serviceURL) {


    console.log(serviceURL)

	$scope.getImage = function() {

        return $http({
            url: serviceURL + 'Gallery/getCarouselImages',
            method: 'GET',
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        }).success(function(response) {
            console.log(response);
            $scope.setImages(response.results);
        });



	};

    $scope.setImages = function(images) {
        
        var canvas = "";

        images.forEach(function(index, value){

            canvas += '<div><img src="images/'+ index.source +'" onclick="func(event)" /></div>';

        })

        console.log(images);
        document.getElementsByClassName('removeCarousel')[0].innerHTML = canvas;
    }

    func = function (e) {

        var element = e.target.attributes.src.textContent;
        var data = JSON.stringify({element: element, id: userInfo.id, sessionId: userInfo.session});

        console.log(data);
        $http({
            url: '../back/Admin/index',
            method:'POST',
            contentType:'application/json',
            dataType:'json',
            data: data
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            //console.log(response);
        });


    }

	$scope.getImage();

    //$scope.addToCarousel = function(){
    //
    //    $http({
    //        url: '../back/Gallery/index',
    //        method:'get',
    //    }).then(function successCallback(response) {
    //        console.log(response);
    //    }, function errorCallback(response) {
    //        //console.log(response);
    //    });
    //
    //}
    //
    //$scope.addToCarousel();

}]);