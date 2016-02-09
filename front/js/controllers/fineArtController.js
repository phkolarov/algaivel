galya.controller('fineArtController', ['$scope','siteData','$sce','$routeParams', function ($scope,siteData,$sce,$routeParams) {


    $(window).resize(function () {
       if(sessionStorage.fineArtIndex == "1"){
           firstAnimation();
       }else if(sessionStorage.fineArtIndex == "2"){
           secondAnimation();

       }else if(sessionStorage.fineArtIndex == "3"){
           thirdAnimation();
       }


    });
    siteData.getFineArtInfo().then(function (data) {

        $scope.fineArtContent = $sce.trustAsHtml(data.data.results.fineArtContent);


        $scope.presentedImage = data.data.results.fineArtOne;
        $scope.fineArtOne = data.data.results.fineArtOne;
        $scope.fineArtTwo = data.data.results.fineArtTwo;
        $scope.fineArtThree = data.data.results.fineArtThree;
    }).then(function () {


        siteData.getCurrentImage($routeParams.imageId,[],[]).then(function (data) {

            $scope.animatedImage = data.data.results.source;
            firstAnimation ();
        })

    });


    $scope.presentImage = function (data,index) {

        $scope.presentedImage = data;

        if(index == 1){
            sessionStorage.fineArtIndex = 1;
            firstAnimation();
        }else if(index == 2){
            sessionStorage.fineArtIndex = 2;
            secondAnimation();
        }else if(index == 3){
            sessionStorage.fineArtIndex = 3;
            thirdAnimation();
        }

    };


    function firstAnimation (){


        var width = $('#backGroundImage').width();
        var height = $('#backGroundImage').height();

        var animationWidth = width/100 * 33;
        var animationHeight = height/100 * 25;
        var animationTop = height/100 *30;
        var animationLeft = width/100 *21;

        $('#animation').css('width',animationWidth);
        $('#animation').css('height',animationHeight);
        $('#animation').css('top',animationTop);
        $('#animation').css('left',animationLeft);

        $('#animation').css({'transform': ''});
    }

    function  secondAnimation() {
        var width = $('#backGroundImage').width();
        var height = $('#backGroundImage').height();

        var animationWidth = width / 100 * 28;
        var animationHeight = height / 100 * 40;
        var animationTop = height / 100 * 16.6;
        var animationLeft = width / 100 * 35;

        $('#animation').css('width', animationWidth);
        $('#animation').css('height', animationHeight);
        $('#animation').css('top', animationTop);
        $('#animation').css('left', animationLeft);

        //$('#animation').css(' -webkit-transform', 'rotateY(350deg)');
        $('#animation').css({'transform': 'rotateY(-3deg) scaleY(0.794)'});

    }
    function thirdAnimation(){
        var width = $('#backGroundImage').width();
        var height = $('#backGroundImage').height();

        var animationWidth = width / 100 * 34;
        var animationHeight = height / 100 * 36;
        var animationTop = height / 100 * 30;
        var animationLeft = width / 100 * 32;

        $('#animation').css('width', animationWidth);
        $('#animation').css('height', animationHeight);
        $('#animation').css('top', animationTop);
        $('#animation').css('left', animationLeft);

        //$('#animation').css(' -webkit-transform', 'rotateY(350deg)');
        $('#animation').css({'transform': 'rotateY(45deg) scaleY(0.794) rotateX(-2deg)'});

    }

}]);