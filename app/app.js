var myApp = angular.module('myApp', ['ngRoute']);
myApp.config(function ($routeProvider) {
    $routeProvider.
            when('/', {
                templateUrl: 'views/user/login.html',
                controller: 'Login'
            }).
            when('/logout', {
                templateUrl: 'views/user/login.html',
                controller: 'Logout'
            }).
            when('/registeruser', {
                templateUrl: 'views/user/create.html',
                controller: 'CreateUser'
            }).
            when('/addfriends', {
                templateUrl: 'views/user/addFriends.html',
                controller: 'addFriends'
            }).
            when('/getglobalscores', {
                templateUrl: 'views/user/getGlobalScores.html',
                controller: 'getGlobalScores'
            }).
                     when('/getfriendscores', {
                templateUrl: 'views/user/getFriendsScores.html',
                controller: 'getFriendsScores'
            }).
            when('/user/:user', {
                templateUrl: 'views/user/user.html',
                controller: 'User'
            });

});
