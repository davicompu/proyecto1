var controllers={};
controllers.CreateUser=function($scope,$location,$http){

  $scope.create = function() {
    var username =$scope.username;
    var password =$scope.password;
    var firstname=$scope.firstname;
    var lastname=$scope.lastname;
    var age=$scope.age;
    var parameters={
      username:username,
      password:password,
      firstname:firstname,
      lastname:lastname,
      age:age};

    console.log("Parameters: "+parameters);

    $http.post('requests/user/create.php',parameters).
    success(function(data, status, headers, config) {
      console.log("Response: "+data.status);
      if(data.status=="CREATED"){
        $location.path( "/" );
      }
      else if(data.status=="DUPLICATED"){
        $scope.error_message="El usuario esta repetido";
      }
    }).
    error(function(data, status, headers, config) {
      // log error
    });
  };
};

controllers.Login=function($scope,$http){
  $scope.login = function() {
    var username =$scope.username;
    var password =$scope.password;
  //  console.log(username+" "+password);
    var parameters={username:username,password:password};
  //console.log("Parameters: "+parameters);
    $http.post('requests/user/login.php',parameters).
    success(function(data, status, headers, config) {
    //  console.log("Response: "+data.authenticated);
      var auth=data.authenticated;
      if(auth=="FOUND"){
        $scope.success="Usuario Registrado";
      }
      else if(auth=="NOT_FOUND"){
        $scope.success="Usuario No Registrado";
      }
    }).
    error(function(data, status, headers, config) {
      // log error
    });
  };
};
/*
controllers.User=function($scope,$http){
  $scope.login = function() {
    var username =$scope.username;
    var password =$scope.password;
    console.log(username+" "+password);
    var parameters={username:username,password:password};
    console.log("Parameters: "+parameters);
    $http.post('requests/user/login.php',parameters).
    success(function(data, status, headers, config) {
      console.log("Response: "+data.authenticated);
      if(data.authenticated=="FOUND"){
        $scope.success="Usuario autenticado";
      }
      else{
        $scope.success="Usuario no autenticado";
      }
    }).
    error(function(data, status, headers, config) {
      // log error
    });
  };
};
*/
myApp.controller(controllers);
