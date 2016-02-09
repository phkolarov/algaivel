galya.controller('addNewsController',['$scope', 'siteData', '$http', 'serviceURL','$routeParams', '$location' ,function ($scope, siteData, $http,serviceURL,$routeParams, $location) {

  $scope.data = {
    titleBg: '',
    image: '',
    descBg: '',
    titleEn: '',
    descEn: '',
  }

  $scope.changedValue=function(item){
    
    if ( item == 'bg' ) {

      var lang    = document.getElementById('u-articleLang').value,
          titleEn = document.getElementById('u-articleTitle').value,
          image   = document.getElementById('u-articleImage').value,
          descEn  = document.getElementsByClassName('note-editable')[0].innerHTML;

      $scope.data.titleEn = titleEn;
      $scope.data.image = image;
      $scope.data.descEn = descEn;

      document.getElementById('u-articleTitle').value = $scope.data.titleBg,
      document.getElementById('u-articleImage').value = $scope.data.image,
      document.getElementsByClassName('note-editable')[0].innerHTML = $scope.data.descBg;

    }else{

      var lang = document.getElementById('u-articleLang').value,
          titleBg = document.getElementById('u-articleTitle').value,
          image = document.getElementById('u-articleImage').value,
          descBg = document.getElementsByClassName('note-editable')[0].innerHTML;

      $scope.data.titleBg = titleBg;
      $scope.data.image = image;
      $scope.data.descBg = descBg;

      document.getElementById('u-articleTitle').value = $scope.data.titleEn,
      document.getElementById('u-articleImage').value = $scope.data.image,
      document.getElementsByClassName('note-editable')[0].innerHTML = $scope.data.descEn;

    }

  }    

	$scope.uploadArticle = function(){
        
        /*var lang = document.getElementById('u-articleLang').value,
            data,
            title = document.getElementById('u-articleTitle').value,
            image = document.getElementById('u-articleImage').value,
            desc = document.getElementsByClassName('note-editable')[0].innerHTML;

        data = {
            lang: lang,
            title: title,
            image: image,
            desc: desc,
            id: userInfo.id,
            sessionId: userInfo.session
        }*/

        data = JSON.stringify($scope.data);

        $http({
             url: '../back/Admin/postArticle',
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