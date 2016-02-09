galya.controller('editCurrentImageController',['$scope','siteData','$routeParams', '$http', '$location', function ($scope,siteData,$routeParams,$http, $location) {

	$scope.data = {}

	var data = {
		id:$routeParams.imageId,
	}

	data = JSON.stringify(data);

	$http({
        url: '../back/Admin/getCurrentImage',
        method:'POST',
        contentType:'application/json',
        dataType:'json',
        data: data
    }).then(function successCallback(response) {
    	$scope.currentImageSetter(response.data[1])
    }, function errorCallback(response) {
        //console.log(response);
    });

    $scope.currentImageSetter = function(item) {

    	for( var i in item  ){
    		$scope.data[i] = item[i];
    	}

    	document.getElementById('title').value   = $scope.data.title;
    	document.getElementById('desc').value    = $scope.data.description;
    	document.getElementById('titleBg').value = $scope.data.titleBG;
    	document.getElementById('descBg').value  = $scope.data.descriptionBG;

    }

    $scope.saveChanges = function() {

    	var data = {};

    	data.title   = document.getElementById('title').value;
    	data.desc    = document.getElementById('desc').value;
    	data.titleBg = document.getElementById('titleBg').value;
    	data.descBg  = document.getElementById('descBg').value;
    	data.imageId = $scope.data.id;
    	data.id      = userInfo.id;
    	data.sessionId = userInfo.session;

    	data = JSON.stringify(data);

    	$http({
	        url: '../back/Admin/editImage',
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