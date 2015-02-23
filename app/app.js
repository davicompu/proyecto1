var myApp=angular.module('myApp',['ngRoute']);
myApp.config(function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: 'views/home/login.html',
        //controller: 'Home'
      }).
      when('/registeruser', {
        templateUrl: 'views/user/create.html',
        controller: 'Login'
      });
  });
