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
            templateUrl: 'templates/news.html',
            controller: 'articleController'
        }).
        when('/calendar', {
            templateUrl: 'templates/calendar.html',
            /*controller: calendarCtrl*/
        })
    }]);

galya.controller('mainController', ['$scope', '$location', function ($scope, $location) {
    $scope.setRoute = function (route) {
        $location.path(route);
    }
}]);