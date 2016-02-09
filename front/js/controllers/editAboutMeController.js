galya.controller('editAboutMeController', ['$scope','siteData',function ($scope,siteData) {


    $scope.aboutMeLanguage = "BG";

    $scope.changeAboutMeLanguage = function(){

        $scope.aboutMeLanguage = $scope.aboutMeLanguage == 'BG' ? $scope.aboutMeLanguage = 'EN' : $scope.aboutMeLanguage = 'BG';

        if($scope.aboutMeLanguage == 'BG'){

            siteData.getAboutMeInformation().then(function (data) {

                $scope.aboutMeContent = data.data.results.aboutMeContentBG;
                CKEDITOR.instances['editor1'].setData( data.data.results.aboutMeContentBG);

                if(!$scope.$$phase) {
                    $scope.$digest();
                }
            });
        }else{

            siteData.getAboutMeInformation().then(function (data) {
                $scope.aboutMeContent = data.data.results.aboutMeContent;
                CKEDITOR.instances['editor1'].setData( data.data.results.aboutMeContent);

            });
        }
    };

    $scope.submitAboutMeInfo = function () {

        var data =  CKEDITOR.instances['editor1'].getData();

        console.log(data);


    };


    if(sessionStorage.language == 'BG'){

        siteData.getAboutMeInformation().then(function (data) {


            $scope.aboutMeContent = data.data.results.aboutMeContentBG;
        });
    }else{

        siteData.getAboutMeInformation().then(function (data) {


            $scope.aboutMeContent = data.data.results.aboutMeContent;

        });
    }



}]);