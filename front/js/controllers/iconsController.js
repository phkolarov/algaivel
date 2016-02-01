galya.controller('iconsController', ['$scope', 'siteData', '$routeParams', '$location', function ($scope, siteData, $routeParams, $location) {


    var imageId = $routeParams.image;
    var getImageObject = {imageId: imageId};
    $scope.nextImage = function () {

        getImageObject.param = 'nextImage';
        this.$emit('getImage', getImageObject);

    };


    $scope.previousImage = function () {

        getImageObject.param = 'backImage';
        this.$emit('getImage', getImageObject);

    };

    $scope.favorites = function () {


    };

    $scope.addToCart = function () {

        if (sessionStorage.addtoCartImages) {
            var array = JSON.parse(sessionStorage.addtoCartImages);
            var imagesNamesArray = JSON.parse(sessionStorage.cartImagesNames);

            if (array.indexOf(imageId) < 0) {
                array.push(imageId);
                imagesNamesArray.push($scope.currentImage.title);
                sessionStorage.addtoCartImages = JSON.stringify(array);
                sessionStorage.cartImagesNames = JSON.stringify(imagesNamesArray);

                if ($scope.cartCounter >= 1) {

                    $scope.cartCounter += 1;
                } else {
                    $scope.cartCounter = 1;
                }

                $scope.isAdded = {color: "red"};

            } else {

                var array = JSON.parse(sessionStorage.addtoCartImages);
                var imagesNamesArray = JSON.parse(sessionStorage.cartImagesNames);

                var elementIndex = array.indexOf(imageId);


                array.splice(elementIndex, 1);
                imagesNamesArray.splice(elementIndex, 1);

                sessionStorage.addtoCartImages = JSON.stringify(array);
                sessionStorage.cartImagesNames = JSON.stringify(imagesNamesArray);


                if ($scope.cartCounter > 1) {

                    $scope.cartCounter -= 1;
                } else {
                    $scope.cartCounter = undefined;
                    sessionStorage.removeItem('addtoCartImages');
                    sessionStorage.removeItem('cartImagesNames');
                }
                $scope.isAdded = {color: "#337ab7"};

            }

        } else {

            var imagesIdArray = [];
            var imagesNamesArray = [];
            imagesIdArray.push(imageId);
            imagesNamesArray.push($scope.currentImage.title);
            sessionStorage.addtoCartImages = JSON.stringify(imagesIdArray);
            sessionStorage.cartImagesNames = JSON.stringify(imagesNamesArray);
            $scope.isAdded = {color: "red"}
            $scope.cartCounter = 1;
        }


    }


}]);