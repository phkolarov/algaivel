galya.controller('aboutMeController', ['$scope','siteData',function ($scope,siteData) {





    siteData.getAboutMeInformation().then(function (data) {

        $scope.aboutMeImageSource = data.data.results.aboutMeImageSource;
        $scope.aboutMeContent = data.data.results.aboutMeContentBG;

        console.log($scope.aboutMeImageSource)

    });


}]);