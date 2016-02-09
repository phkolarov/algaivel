galya.controller('allNewsController', ['$scope','siteData','$routeParams', function ($scope,siteData,$routeParams) {


    var yearNow = new Date().getFullYear().toString();
    $scope.year = [
        { name: '2016', value: '2016' },
        { name: '2017', value: '2017' }
    ];
    $scope.years = {count : yearNow};
    $scope.linkYear = yearNow;

    var articlesParam = {
        page : 1,
        year : $scope.years.count
    };

    if($routeParams.page){

        articlesParam.page = parseInt($routeParams.page) - 1;
    }
    if($routeParams.year){

        articlesParam.year = $routeParams.year;
        $scope.years = {count : $routeParams.year};
        $scope.linkYear = $routeParams.year;

    }

    $scope.zoom = function (data) {

        var parent = $(data.currentTarget)[0];
        var image = $(parent).children()[0];

        $(image).css({'max-width': '104%'});
        $(image).css({'max-height': '104%'});
        $(image).css({' -webkit-transition': 'max-width 0.3s, max-height 0.3s'});
        $(image).css({'transition': 'max-height 0.3s, max-height 0.3s'});
        $(image).css({'-webkit-transition': 'all 0.3s ease-in-out'});
        var child = $(parent).children()[1];

    };

    $scope.unzoom = function (data) {

        var parent = $(data.currentTarget)[0];
        var image = $(parent).children()[0];

        $(image).css({'max-width': '102%'});
        $(image).css({'max-height': '102%'});
        $(image).css({' -webkit-transition': 'max-width 0.3s, max-height 0.3s'});
        $(image).css({'transition': 'max-height 0.3s, max-height 0.3s'});
        $(image).css({'-webkit-transition': 'all 0.3s ease-in-out'});
        var child = $(parent).children()[1];

    };


    $scope.$on("getArticles", function (event, artObj) {


        siteData.getArticles(artObj.page,artObj.year).then(function (data) {

            var articlesObject = data.data.results;

            var monthNames = ["Ян.", "Фев.", "Март.", "Апр.", "Май.", "Юни.",
                "Юли.", "Авг.", "Сеп.", "Окт.", "Ное.", "Дек."
            ];

            for(var i in articlesObject){

                var date = new Date(articlesObject[i].post_date);

                articlesObject[i].monthName = monthNames[date.getMonth()];
                articlesObject[i].Day = date.getDate();
            }

            $scope.articles = articlesObject;
        });
    });



    $scope.$emit('getArticles',articlesParam);



}]);