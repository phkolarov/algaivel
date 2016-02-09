galya.controller('addSearchController',['$scope','$routeParams','$location', function ($scope,$routeParams,$location) {


    $scope.doSomething = function (data) {

        var lang = $scope.selection.lang;
        var value = $scope.selection.count;

        if (lang == "BG") {

            if (value == 1 && data.length > 0) {

                $location.path("/search/" + data + "/BG/images");
            } else if (value == 2 && data.length > 0) {

                $location.path("/search/" + data + "/BG/articles");
            }
        } else if (lang == "EN") {

            if (value == 1 && data.length > 0) {

                $location.path("/search/" + data + "/EN/images");
            } else if (value == 2 && data.length > 0) {

                $location.path("/search/" + data + "/EN/articles");
            }
        }

    };


    $scope.$on('initialiseSearchSelectionInformation', function (event,selectionOption) {
        sessionStorage.userLanguage = 'BG';

        if(!selectionOption){
            selectionOption = 'images';
        }

        if (sessionStorage.userLanguage == 'BG') {

            $scope.searchPlaceholder = "Търсене";
            $scope.searchOption = [
                {value: 1, option: "Снимки"},
                {value: 2, option: "Новини"}
            ];


            if(selectionOption == 'images'){
                $scope.selection = {count: $scope.searchOption[0].value, lang: "BG"};

            }else if(selectionOption == 'articles'){
                $scope.selection = {count: $scope.searchOption[1].value, lang: "BG"};
            }


            console.log($scope.infoResult);
        } else if (sessionStorage.userLanguage == 'EN') {

            $scope.searchPlaceholder = "Search";
            $scope.searchOption = [
                {value: 1, option: "Images"},
                {value: 2, option: "News"}
            ];

            if(selectionOption == 'images'){
                $scope.selection = {count: $scope.searchOption[0].value, lang: "EN"};

            }else if(selectionOption == 'articles'){
                $scope.selection = {count: $scope.searchOption[1].value, lang: "EN"};
            }
        }
    });



    $scope.$emit('initialiseSearchSelectionInformation',$routeParams.type);

}]);