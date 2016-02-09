var galya = angular.module('galya', ['ngRoute']);

galya.constant('serviceURL', 'http://localhost:1234/xampp/algaivel/back/');

galya.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
        when('/home', {
            templateUrl: 'templates/home.html',
            /*controller: homeCtrl*/
        }).
        when('/gallery', {
            templateUrl: 'templates/gallery.html',
            controller: 'galleryController'
        }).
        when('/gallery/page/:page', {
            templateUrl: 'templates/gallery.html',
            controller: 'galleryController'
        }).
        when('/gallery/:image', {
            templateUrl: 'templates/currentImage.html',
            controller: 'galleryController'
        }).
        when('/gallery/fullSizeImage/:image', {
            templateUrl: 'templates/fullSizeImage.html',
            controller: 'fullSizeImageController'
        }).
        when('/gallery/fineArt/:imageId', {
            templateUrl: 'templates/fineArt.html',
            controller: 'fineArtController'
        }).
        when('/aboutGalya', {
            templateUrl: 'templates/aboutGalya.html',
            /*controller: aboutGalyaCtrl*/
        }).
        when('/media', {
            templateUrl: 'templates/media.html',
            /*controller: mediaCtrl*/
        }).
        when('/clients', {
            templateUrl: 'templates/clients.html',
            /*controller: clientsCtrl*/
        }).
        when('/contacts', {
            templateUrl: 'templates/contacts.html',
            /*controller: contactsCtrl*/
        }).
        when('/news', {
            templateUrl: 'templates/news.html',
            controller: 'allNewsMainController'
        }).
        when('/news/:articleId', {
            templateUrl: 'templates/currentArticle.html',
            controller: 'currentArticleController'
        }).
        when('/news/page/:page/:year', {
            templateUrl: 'templates/news.html',
            controller: 'allNewsMainController'
        }).
        when('/cart', {
            templateUrl: 'templates/cart.html'
        }).
        when('/aboutMe', {
            templateUrl: 'templates/aboutGalya.html'
        }).
        when('/search/:searchingContext/:lang/:type', {
            templateUrl: 'templates/search.html',
            controller: "searchController"
        }).
        when('/login', {
            templateUrl: 'templates/login.html',
            controller: 'loginController'
        }).
        when('/css3_periodictable', {
            templateUrl: 'templates/css3_periodictable.html',
            /*controller: 'loginController'*/
        }).
        when('/adminPanel', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'adminController'
        }).
        when('/adminPanel/AddToCarousel', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'adminController'
        }).
        when('/addImage', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'addImageController'
        }).
        when('/editImage', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'editImageController'
        }).
        when('/deleteImage', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'deleteImageController'
        }).
        when('/editAboutMe', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'editAboutMeController'
        }).
        when('/addToCarousel', {
            templateUrl: 'templates/adminPanel.html',
            controller: 'addToCarouselController'
        }).
        when('/adminPanel/removeFromCarousel', {
            templateUrl: 'templates/partials/remove-from-carousel.html',
            controller: 'removeFromCarouselController'
        }).
        when('/adminPanel/editAboutMe', {
            templateUrl: 'templates/editAboutMe.html',
            controller: 'editAboutMeController'
        }).
        when('/adminPanel/editNews/:page/:year', {
            templateUrl: 'templates/partials/edit-news-page.html',
            controller: 'editNewsController'
        }).
        when('/adminPanel/editNews/:articleId', {
            templateUrl: 'templates/partials/editCurrentArticle.html',
            controller: 'editCurrentArticleController'
        }).
        when('/adminPanel/editImage/', {
            templateUrl: 'templates/partials/edit-image.html',
            controller: 'editImageController'
        }).
        when('/adminPanel/uploadImage/', {
            templateUrl: 'templates/partials/upload-image.html',
            controller: 'uploadImageController'
        }).
        when('/adminPanel/editImage/:imageId', {
            templateUrl: 'templates/partials/edit-current-image.html',
            controller: 'editCurrentImageController'
        }).when('/adminPanel/addNews', {
            templateUrl: 'templates/partials/add-news.html',
            controller: 'addNewsController'
        }).when('/adminPanel/addToCarousel', {
            templateUrl: 'templates/partials/add-to-carousel.html',
            controller: 'addToCarouselController'
        }).when('/adminPanel/editNews', {
            templateUrl: 'templates/partials/edit-news-page.html',
            controller: 'editNewsController'
        });

    }]);

galya.controller('mainController', ['$scope', '$location', function ($scope, $location) {
    console.log(121);
    $scope.setRoute = function (route) {
        $location.path(route);
    }
}]);