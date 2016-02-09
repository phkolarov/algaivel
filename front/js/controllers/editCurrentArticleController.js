galya.controller('editCurrentArticleController',['$scope','siteData','$routeParams', '$http', '$location', function ($scope,siteData,$routeParams,$http, $location) {

    $scope.data = {
        titleBg: '',
        image: '',
        descBg: '',
        titleEn: '',
        descEn: '',
        lang:'bg',
    }

    if($routeParams.articleId){


        siteData.getCurrentArticle($routeParams.articleId).then(function (data) {

            var j = data.data.results;

            $scope.data.titleBg = j.titleBG;
            $scope.data.image = j.articleImage;
            $scope.data.descBg = j.contentBG;
            $scope.data.titleEn = j.title;
            $scope.data.descEn = j.content;
            $scope.data.id = j.id;

            //social.getFacebookSocialButtonData();
            document.getElementById('u-eArticleTitle').value = $scope.data.titleBg;
            document.getElementById('u-eArticleImage').value = $scope.data.image;
            document.getElementsByClassName('panel-body')[0].innerHTML = $scope.data.descBg;

        });

    }
    
    $scope.changedValue = function(item){
    
        if ( item == 'bg' ) {

          var lang    = document.getElementById('u-eArticleLang').value,
              titleEn = document.getElementById('u-eArticleTitle').value,
              image   = document.getElementById('u-eArticleImage').value,
              descEn  = document.getElementsByClassName('note-editable')[0].innerHTML;

          $scope.data.titleEn = titleEn;
          $scope.data.image = image;
          $scope.data.descEn = descEn;
          $scope.data.lang = 'bg';

          document.getElementById('u-eArticleTitle').value = $scope.data.titleBg,
          document.getElementById('u-eArticleImage').value = $scope.data.image,
          document.getElementsByClassName('note-editable')[0].innerHTML = $scope.data.descBg;

        }else{

          var lang = document.getElementById('u-eArticleLang').value,
              titleBg = document.getElementById('u-eArticleTitle').value,
              image = document.getElementById('u-eArticleImage').value,
              descBg = document.getElementsByClassName('note-editable')[0].innerHTML;

          $scope.data.titleBg = titleBg;
          $scope.data.image = image;
          $scope.data.descBg = descBg;
          $scope.data.lang = 'en';

          document.getElementById('u-eArticleTitle').value = $scope.data.titleEn,
          document.getElementById('u-eArticleImage').value = $scope.data.image,
          document.getElementsByClassName('note-editable')[0].innerHTML = $scope.data.descEn;

        }

    }

    $scope.saveChanges = function (){
        
        if( $scope.data.lang == 'bg' ){
            $scope.data.titleBg =  document.getElementById('u-eArticleTitle').value;
            $scope.data.descBg  =  document.getElementsByClassName('note-editable')[0].innerHTML;
            $scope.data.image   = document.getElementById('u-eArticleImage').value;
        }else{
            $scope.data.titleEn =  document.getElementById('u-eArticleTitle').value;
            $scope.data.descEn  =  document.getElementsByClassName('note-editable')[0].innerHTML;
            $scope.data.image   = document.getElementById('u-eArticleImage').value;
        }

        $scope.data.sessionId = userInfo.session;
        $scope.data.fbid = userInfo.id;
        var data = JSON.stringify($scope.data);


        $http({
             url: '../back/Admin/editArticle',
             method:'POST',
             contentType:'application/json',
             dataType:'json',
             data: data
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            //console.log(response);
        });

    }

    $(document).ready(function() {
      $('#summernote').summernote();
    });



}]);