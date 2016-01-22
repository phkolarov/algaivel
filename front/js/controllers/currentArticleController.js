galya.controller('currentArticleController',['$scope','siteData','$routeParams', function ($scope,siteData,$routeParams) {


    if($routeParams.articleId){


        siteData.getCurrentArticle($routeParams.articleId).then(function (data) {

            $scope.title =  data.data.results.titleBG;
            $scope.articleImage = data.data.results.articleImage;
            $scope.aricleContent = data.data.results.contentBG;
            $scope.postDate = data.data.results.post_date;

            //social.getFacebookSocialButtonData();

            (function(d, s, id) {
                FB = null;
                var js, fjs = d.getElementsByTagName(s)[0];
                //if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=204269043065238";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        });

    }



}]);