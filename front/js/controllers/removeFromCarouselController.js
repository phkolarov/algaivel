galya.controller('removeFromCarouselController',['$scope','siteData','$route', '$http', function ($scope,siteData,$route,$http) {

	$scope.getImage = function() {

        return $http({
            url:'http://localhost:1234/xampp/algaivel/back/Gallery/getCarouselImages',
            method: 'GET',
            headers: {
                "Content-type": "application/json",
                "dataType": "json"
            }
        }).success(function(response) {

            $scope.setImages(response.results);

        }).error(function(err){
        	console.log(err);
        });



	};

    $scope.setImages = function(images) {
        
        var canvas = "";

        images.forEach(function(index, value){

            canvas += '<div><img src="images/'+ index.source +'" onclick="addToQueueRC(event)" /></div>';

        })

        document.getElementsByClassName('removeCarouselContent')[0].innerHTML = canvas;
    }

    addToQueueRC = function (e) {

        /*var element = e.target.attributes.src.textContent;
        var data = JSON.stringify({element: element, id: userInfo.id, sessionId: userInfo.session});

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
        });*/

        
        if( e.target.className == 'toRemove' ){
            e.target.style.border = 'none';
            e.target.className = '';
        }else{
            e.target.style.border = '4px solid green';
            e.target.className = 'toRemove';
        }


    }

    $scope.removeFromCarousel = function() {

        var get = document.getElementsByClassName('toRemove'),
            elements = [];

        for( var i = 0; i < get.length; i++){
            var split = get[i].attributes.src.textContent.split('/');
            elements[i] = split[1];
        }

        var data = JSON.stringify({elements: elements, id: userInfo.id, sessionId: userInfo.session});

        $http({
            url: '../back/Admin/index',
            method:'POST',
            contentType:'application/json',
            dataType:'json',
            data: data
        }).then(function successCallback(response) {
            $scope.getImage();

        }, function errorCallback(response) {
            //console.log(response);
        });

    };

	$scope.getImage();

}]);