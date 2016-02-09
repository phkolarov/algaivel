galya.controller('imageController', ['$scope', 'siteData', '$routeParams','$location','$q', function ($scope, siteData, $routeParams,$location,$q) {


    var id = $routeParams.image;
    var that = this;
    $scope.currentImage = {};

    var imageId = $routeParams.image;
    var getImageObject = {imageId : imageId};



    $scope.$on("getImage", function (event,data) {

        var categoryArray = [];
        var filtersArray = [];
        if (sessionStorage.categoryArray) {

            categoryArray = JSON.parse(sessionStorage.categoryArray);
            filtersArray = JSON.parse(sessionStorage.filtersArray);

        }

        if (data.param == 'nextImage'){


            siteData.nextImage(data.imageId, categoryArray, filtersArray).then(function (data) {

                $location.path('gallery/' + data.data.results.id, false);
                $scope.currentImage.description = data.data.results.descriptionBG;
                $scope.currentImage.id = data.data.results.id;
                var tempDate = data.data.results.post_date;
                var date = new Date(tempDate);
                $scope.currentImage.postDate = date.getDay() + "/" + date.getMonth() + "/" + date.getFullYear();
                $scope.currentImage.source = data.data.results.source;
                $scope.currentImage.title = data.data.results.titleBG;

                console.log(data);
                console.log(data.data.results.lastOne);

                if (data.data.results.firstOne == true) {

                        $scope.showBack = false;
                }else{

                        $scope.showBack = true;
                }

                if(data.data.results.lastOne == true){

                        $scope.showNext = false;
                }else{

                        $scope.showNext = true
                }
            }).then(function () {

                (function () {
                console.log(1231);
                    (function(d, s, id) {
                        FB = null;
                        var js, fjs = d.getElementsByTagName(s)[0];
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=1421278344834781";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                })();
                });


        }
        else if(data.param == 'backImage'){



            siteData.previousImage(data.imageId, categoryArray, filtersArray).then(function (data) {

                $location.path('gallery/' + data.data.results.id, false);

                $scope.currentImage.description = data.data.results.descriptionBG;
                $scope.currentImage.id = data.data.results.id;
                var tempDate = data.data.results.post_date;
                var date = new Date(tempDate);
                $scope.currentImage.postDate = date.getDay() + "/" + date.getMonth() + "/" + date.getFullYear();
                $scope.currentImage.source = data.data.results.source;
                $scope.currentImage.title = data.data.results.titleBG;

                if (data.data.results.firstOne == true) {

                    $scope.showBack = false;
                }else{

                    $scope.showBack = true;
                }

                if(data.data.results.lastOne == true){

                    $scope.showNext = false;
                }else{

                    $scope.showNext = true
                }
            }).then(function () {
                //Facebook loader
                (function () {
                    console.log(1231);
                    (function(d, s, id) {
                        FB = null;
                        var js, fjs = d.getElementsByTagName(s)[0];
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=1421278344834781";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                })();
            });


        }else{

            siteData.getCurrentImage(data.imageId,categoryArray,filtersArray).then(function (data) {

                $scope.currentImage.description = data.data.results.descriptionBG;
                $scope.currentImage.id = data.data.results.id;
                var tempDate = data.data.results.post_date;
                var date = new Date(tempDate);
                $scope.currentImage.postDate = date.getDay() + "/" + date.getMonth() + "/" + date.getFullYear();
                $scope.currentImage.source = data.data.results.source;
                $scope.currentImage.title = data.data.results.titleBG;

                if (data.data.results.firstOne == true) {

                    $scope.showBack = false;
                }else{

                    $scope.showBack = true;
                }

                if(data.data.results.lastOne == true){

                    $scope.showNext = false;
                }else{

                    $scope.showNext = true
                }
                var defer = $q.defer();


                return defer.resolve(1);
            }).then(function (data) {


                (function () {
                    (function(d, s, id) {
                        FB = null;
                        var js, fjs = d.getElementsByTagName(s)[0];
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=1421278344834781";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                })();
            });


        }
    });



    $scope.$emit('getImage',getImageObject);

}]);