galya.controller('footerController', ['$scope','$location', function ($scope,$location) {

    $scope.shareLink = $location.absUrl();


    (function () {
        (function(d, s, id) {
            FB = null;
            var js, fjs = d.getElementsByTagName(s)[0];
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=1421278344834781";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    })();


    $scope.testFunc = function () {



        console.log(12312111111111);
    }

}]);