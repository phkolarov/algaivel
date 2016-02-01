galya.controller('mainMenuController', ['$scope','$routeParams',function ($scope,$routeParams) {



    if(sessionStorage.addtoCartImages){

        var imageIdArray = JSON.parse(sessionStorage.addtoCartImages);

        var count = imageIdArray.length;
        $scope.cartCounter = count;

        if($routeParams.image){

            if(imageIdArray.indexOf($routeParams.image) >= 0){
             $scope.isAdded = {color : "red"}
            }
        }

    }

}]);