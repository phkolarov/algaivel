galya.controller('cartController', ['$scope', 'siteData', function ($scope, siteData) {


    $scope.total = 0;
    $scope.price = {};
    if (sessionStorage.addtoCartImages) {

        var imagesIdsArray = JSON.parse(sessionStorage.addtoCartImages);
        var imagesNamesArray = JSON.parse(sessionStorage.cartImagesNames);
        var i;


        var imagesWithNames = [];


        for (i = 0; i < imagesIdsArray.length; i++) {


            var tempObj = {};
            tempObj.imageId = imagesIdsArray[i];
            tempObj.imageName = imagesNamesArray[i];

            imagesWithNames.push(tempObj);
        }

        $scope.imagesObject = imagesWithNames;
    }


    $scope.priceOption = [
        {name: "XS - 800 x 531 px @ 72 dpi", price: "10"},
        {name: "S - 1440 x 961 px @ 300 dpi", price: "30"},
        {name: "M - 2126 x 1419 px @ 300 dpi", price: "50"},
        {name: "L - 3200 х 2136 px @ 300 dpi", price: "70"},
        {name: "XL - 4288 x 2862 px @ 300 dpi", price: "100"},
        {name: "XXL - 7360 x 4912 px @ 300 dpi", price: "150"}
    ];

    $scope.formPageCount = {count: $scope.priceOption[0].price};

    $scope.remove = function (imageId) {

        $("." + imageId).remove();
        var imagesIdsArray = JSON.parse(sessionStorage.addtoCartImages);
        var cartImagesNames = JSON.parse(sessionStorage.cartImagesNames);
        //var cartImageSources = JSON.parse(sessionStorage.cartImageSources);
        var currentElementIndex = imagesIdsArray.indexOf(imageId);


        var imageId = imagesIdsArray.splice(currentElementIndex, 1);
        cartImagesNames.splice(currentElementIndex, 1);
        //cartImageSources.splice(currentElementIndex,1);

        sessionStorage.addtoCartImages = JSON.stringify(imagesIdsArray);
        sessionStorage.cartImagesNames = JSON.stringify(cartImagesNames);
        //sessionStorage.cartImageSources = JSON.stringify(cartImageSources);

        $scope.cartCounter -= 1;
        if (imagesIdsArray.length < 1) {

            $scope.cartCounter = undefined;
            sessionStorage.removeItem('addtoCartImages');
            sessionStorage.removeItem('cartImagesNames');
            //sessionStorage.removeItem('cartImageSources');
        }


        var allProductsPrice = $scope.formPageCount;

        delete allProductsPrice[imageId];
        $scope.formPageCount = allProductsPrice;
        $scope.total = 0;

        for(var i in allProductsPrice){
            if(parseFloat(i)){

                $scope.total += parseFloat(allProductsPrice[i]);
            }
        }
    };


    $scope.$on('updatePrice', function (data,event) {

        var allProductsPrice = $scope.formPageCount;
        console.log(allProductsPrice);
        $scope.total = 0;

        for(var i in allProductsPrice){
            if(parseFloat(i)){

                $scope.total += parseFloat(allProductsPrice[i]);
            }
        }
    });

    $scope.calcTotal = function (price) {

       $scope.total+=  parseFloat(price);
    }

}]);