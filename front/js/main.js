var galya = angular.module('galya', ['ngRoute'])

galya.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/home', {
        templateUrl: 'templates/home.html',
        /*controller: homeCtrl*/
      }).
      when('/gallery', {
        templateUrl: 'templates/gallery.html',
        /*controller: galleryCtrl*/
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
        /*controller: newsCtrl*/
      }).
      when('/gallery', {
        templateUrl: 'templates/calendar.html',
        /*controller: calendarCtrl*/
      })
  }]);

galya.controller('mainController', ['$scope', '$location', function($scope, $location){
	$scope.setRoute = function(route){
		$location.path(route);
	}
}]);