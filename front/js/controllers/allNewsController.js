galya.controller('allNewsController', ['$scope','siteData', function ($scope,siteData) {






    siteData.getArticles(0,10).then(function (data) {

       var articlesObject = data.data.results;

       var monthNames = ["Ян.", "Фев.", "Март.", "Апр.", "Май.", "Юни.",
            "Юли.", "Авг.", "Сеп.", "Окт.", "Ное.", "Дек."
        ];

        for(var i in articlesObject){

            var date = new Date(articlesObject[i].post_date);

            articlesObject[i].monthName = monthNames[date.getMonth()];
            articlesObject[i].Day = date.getDay();
        }

        $scope.articles = articlesObject;
    });


    $scope.zoom = function (data) {

        var parent = $(data.currentTarget)[0];
        var image = $(parent).children()[0];

        $(image).css({'max-width': '103%'});
        $(image).css({'max-height': '103%'});
        $(image).css({' -webkit-transition': 'max-width 0.3s, max-height 0.3s'});
        $(image).css({'transition': 'max-height 0.3s, max-height 0.3s'});
        $(image).css({'-webkit-transition': 'all 0.3s ease-in-out'});
        var child = $(parent).children()[1];

    };

    $scope.unzoom = function (data) {

        var parent = $(data.currentTarget)[0];
        var image = $(parent).children()[0];

        $(image).css({'max-width': '100%'});
        $(image).css({'max-height': '100%'});
        $(image).css({' -webkit-transition': 'max-width 0.3s, max-height 0.3s'});
        $(image).css({'transition': 'max-height 0.3s, max-height 0.3s'});
        $(image).css({'-webkit-transition': 'all 0.3s ease-in-out'});
        var child = $(parent).children()[1];


    };




}]);