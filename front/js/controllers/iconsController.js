galya.controller('iconsController', ['$scope', 'siteData', '$routeParams', '$location', function ($scope, siteData, $routeParams, $location) {


    var imageId = $routeParams.image;
    var getImageObject = {imageId : imageId};
    $scope.nextImage = function () {

        getImageObject.param = 'nextImage';
        this.$emit('getImage',getImageObject);

    };


    $scope.previousImage = function () {

        getImageObject.param = 'backImage';
        this.$emit('getImage',getImageObject);

    };

    $scope.favorites = function () {
        console.log('favorites');
    }

}]);