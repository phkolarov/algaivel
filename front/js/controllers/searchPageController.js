galya.controller('searchPageController',['$scope','$routeParams', function ($scope,$routeParams) {

    $scope.searchContext = $routeParams.searchingContext;

    if (sessionStorage.userLanguage == 'BG') {
        $scope.infoResult = "Резултати от търсенето на:";
        $scope.notFoundText = "Няма намерени резултати."
        $scope.language=  'BG';
    }else if(sessionStorage.userLanguage == 'EN') {
        $scope.infoResult = "Search results for:";
        $scope.notFoundText = "Not found any matches";
        $scope.language=  'EN';

    }


}]);