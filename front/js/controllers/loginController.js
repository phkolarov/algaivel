galya.controller('loginController', ['$scope', '$http', function ($scope, $http) {

    $scope.login = function() {

      document.getElementsByClassName('logPassErr')[0].style.display = 'none';
      document.getElementsByClassName('logEmailErr')[0].style.display = 'none';

      var username = document.getElementById('loginEmail').value,
          password = CryptoJS.SHA512(document.getElementById('loginPass').value).toString(CryptoJS.enc.Base64),
          id = userInfo.id || '1',
          data = {
              username: username,
              password: password,
              id: id
          };

   
      $http({
          url: '../back/Users/index',
          method: 'post',
          contentType: 'form-data',
          dataType:'form-data',
          data: {data}

      }).then(function successCallback(response) {
         console.log(response);
          if( response.data[0] == 'Ok' ){

            var cookie = response.data[1]+'_'+response.data[2]+'_'+response.data[3];
            $scope.setCookie('user', cookie, 30);

            document.getElementById('loginBtn').style.display = 'none';

            parent.location.hash = "#home";

          }else{
            document.getElementsByClassName('logErr')[0].style.display = 'block';
          }

      }, function errorCallback(response) {
          //console.log(response);
      });

    }

    $scope.setCookie = function (cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60));
      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
    }

}]);