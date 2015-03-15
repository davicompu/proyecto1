var myApp = angular.module('myApp', ['ngRoute']);
myApp.config(function ($routeProvider) {
    $routeProvider.
            when('/', {
                templateUrl: 'views/user/login.html',
                controller: 'Login'
            }).
            when('/logout', {
               //  templateUrl: 'views/user/login.html',
                controller: 'Logout'
            }).
            when('/registeruser', {
                templateUrl: 'views/user/create.html',
                controller: 'CreateUser'
            }).
            when('/user/:user', {
                templateUrl: 'views/user/user.html',
                controller: 'User'
            });

});
