var controllers={};
controllers.Home=function($scope){};

controllers.Login=function($scope,$http){
  $scope.login = function() {
        var username =$scope.username;
        var password =$scope.username;
        console.log(username+" "+password);
    };
};
myApp.controller(controllers);
