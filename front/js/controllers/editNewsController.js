galya.controller('editNewsController' ,['$scope','siteData','$location','$routeParams', '$http', function ($scope,siteData,$location,$routeParams,$http) {    

  var yearNow = new Date().getFullYear().toString();
    $scope.year = [
        { name: '2016', value: '2016' },
        { name: '2017', value: '2017' }
    ];
    $scope.years = {count : yearNow};
    $scope.linkYear = yearNow;

    var articlesParam = {
        page : 0,
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

    $scope.selectArticle = function(e){
        e.target.style.border = '1px solid #06B600';
        e.target.parentNode.id = "selectedArticle";
    }

    $scope.removeArticle = function(e) {

        var data = {};
        data.sessionId = userInfo.session;
        data.id = userInfo.id;
        data.elId = document.getElementById('selectedArticle').attributes['data-id'].value;
        data = JSON.stringify(data);

        
        $http({
             url: '../back/Admin/removeArticle',
             method:'POST',
             contentType:'application/json',
             dataType:'json',
             data: data
        }).then(function successCallback(response) {
            $scope.$emit('getArticles',articlesParam);
        }, function errorCallback(response) {
            //console.log(response);
        });

        

    }

    $scope.editArticle = function() {
        var id = document.getElementById('selectedArticle').attributes['data-id'].value
        $location.path('adminPanel/editNews/' + id);
    }


}]);
