galya.controller('mainMenuController', ['$scope','$routeParams',function ($scope,$routeParams) {



    if(sessionStorage.addtoCartImages){

        var imageIdArray = JSON.parse(sessionStorage.addtoCartImages);

        var count = imageIdArray.length;
        $scope.cartCounter = count;

        if($routeParams.image){

            if(imageIdArray.indexOf($routeParams.image) >= 0){
             $scope.isAdded = {color : "red"}
            }
        }

    }



        $scope.menu = function() {

            var sideslider = $('[data-toggle=collapse-side]'),
                sel = sideslider.attr('data-target'),
                sel2 = sideslider.attr('data-target-2');

            sideslider.click(function(event){
                $(sel).toggleClass('in');
            });

            $('.closeSide button').click(function(){
                $('.side-collapse').addClass('in');
            });

        }

        $scope.menu();

        $scope.getCookie = function(cname){

            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
            }
            return "";
        }

        $scope.checkCookie = function() {
            var data = $scope.getCookie("user");
            data = data.split('_');

            var role = data[0],
                session = data[1],
                nickname = data[2]

            if ( data != "" ) {

                userInfo.role = role;
                userInfo.session = session;
                userInfo.nickname = nickname;

            }
            if( userInfo.admin == true && userInfo.role != 2 ){
                document.getElementById('loginBtn').style.display = 'block';
            }


        }

        $scope.checkCookie();

        $scope.setFb = function() {
            if ( userInfo.name != undefined ) {
                var x = '<img style="float:left;width:30px;height:30px;margin-top:10px;" src="https://graph.facebook.com/'+ userInfo.id + '/picture?" />'+
                    "<span style='display:inline-block;font-weight:600;color:rgb(119,119,119);float:right;background-color:#fff;width:130px;height:30px;line-height:30px;padding-left:10px;overflow:hidden;margin-right:10px;margin-top:10px'>" + userInfo.name + "</span>"


                document.getElementById('faceb-user').innerHTML = x;
                document.getElementsByClassName('fb-login-btn')[0].style.display = 'none';
            };
        }

        $scope.setFb();


}]);