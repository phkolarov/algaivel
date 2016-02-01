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
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=1421278344834781";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
        });

    }



}]);