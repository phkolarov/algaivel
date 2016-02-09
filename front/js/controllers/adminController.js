galya.controller('adminController',['$scope', 'siteData', '$http', 'serviceURL','$routeParams', '$location' ,function ($scope, siteData, $http,serviceURL,$routeParams, $location) {


    /*Post Article*/

   /* $scope.uploadArticle = function(){
        
        var lang = document.getElementById('u-articleLang').value,
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
        }

        data = JSON.stringify(data);

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
    });*/


    /*Edit Article*/
  
    $scope.route = function(path){
        
        $location.path(path);

    }



}]);