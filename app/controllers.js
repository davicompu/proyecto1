var controllers = {};
controllers.CreateUser = function ($scope, $location, $http) {

    $scope.create = function () {
        var username = $scope.username;
        var password = $scope.password;
        var firstname = $scope.firstname;
        var lastname = $scope.lastname;
        var age = $scope.age;
        var parameters = {
            username: username,
            password: password,
            firstname: firstname,
            lastname: lastname,
            age: age};

        console.log("Parameters: " + parameters);

        $http.post('requests/user/create.php', parameters).
                success(function (data, status, headers, config) {
                    console.log("Response: " + data.status);
                    if (data.status == "CREATED") {
                        $location.path("/");
                    }
                    else if (data.status == "DUPLICATED") {
                        $scope.error_message = "El usuario esta repetido";
                    }
                }).
                error(function (data, status, headers, config) {
                    // log error
                });
    };
};

controllers.Login = function ($scope, $http, $location, $window) {
    var user = $window.sessionStorage.getItem('user');
    if (user) {
        $location.path("/user/" + user);
    }
    else {
        $scope.login = function () {
            var username = $scope.username;
            var password = $scope.password;
            //  console.log(username+" "+password);
            var parameters = {username: username, password: password};
            //console.log("Parameters: "+parameters);
            $http.post('requests/user/login.php', parameters).
                    success(function (data, status, headers, config) {
                        //  console.log("Response: "+data.authenticated);
                        var auth = data.authenticated;
                        if (auth == "FOUND") {
                            //$scope.success="Usuario Registrado";
                            var id = data.user.id;
                            $window.sessionStorage.setItem('user', data.user.id);
                            $location.path("/user/" + id);

                        }
                        else if (auth == "NOT_FOUND") {
                            $scope.success = "Usuario No Registrado";
                        }
                    }).
                    error(function (data, status, headers, config) {
                        // log error
                    });
        };
    }
};

controllers.Logout = function ($scope, $http, $location, $window) {
    $window.sessionStorage.removeItem('user');
    $location.path("/");
};

controllers.User = function ($scope, $http, $location, $window, $routeParams) {


    var id = $routeParams.user;
    var parameters = {id: id};
    $http.post('requests/user/user.php', parameters).
            success(function (data, status, headers, config) {
                //  console.log("Response: "+data.status);
                if (data.status == "FOUND") {
                    //  console.log(data.user);
                    var user = data.user;
                    $scope.firstname = user.firstname;
                    $scope.lastname = user.lastname;
                    $scope.username = user.username;
                    $scope.password = user.password;
                    $scope.age = user.age;
                }
                else {
                    $location.path("/");
                }
            }).
            error(function (data, status, headers, config) {
                // log error
            });


};

controllers.addFriends = function ($scope, $http, $location, $window) {
    var user = $window.sessionStorage.getItem('user');
    if (user) {
        $scope.getUsers = function (userId, page) {
            var parameters = {id: userId, page: page};
            $http.post('requests/user/getUsers.php', parameters).
                    success(function (data, status, headers, config) {
                        console.log("Response: " + data.status);
                        console.log("Users: " + data.count);
                        console.log("Pages: " + data.pages);
                        if (data.status == "FOUND") {
                            $scope.users = data.users;
                            $scope.pages = data.pages;
                        }
                    });
        };

        $scope.getUsers(user, 0);
        $scope.addFriend = function (user_b) {
            console.log("Add Friend " + user_b);
            var parameters = {user_a: user, user_b: user_b};
            $http.post('requests/user/addFriend.php', parameters).
                    success(function (data, status, headers, config) {
                        console.log("Response: " + data.status);
                        $scope.getUsers(user, 0);
                    });
        };

        $scope.getUserFromPage = function (page) {
            console.log('Page');

            $scope.getUsers(user, page);
        };
    }
    else {
        $location.path('/');
    }
};

controllers.getGlobalScores = function ($scope, $http, $location, $window) {
    var user = $window.sessionStorage.getItem('user');
    if (user) {
        $scope.getUsers = function (page) {
            var parameters = {page: page};
            $http.post('requests/user/getGlobalScores.php', parameters).
                    success(function (data, status, headers, config) {
                        console.log("Response: " + data.status);
                        console.log("Users: " + data.count);
                        console.log("Pages: " + data.pages);
                        if (data.status == "FOUND") {
                            $scope.users = data.users;
                            $scope.pages = data.pages;
                        }
                    });
        };
         $scope.getUsers(0);
         $scope.getUserFromPage = function (page) {
            console.log('Page');

            $scope.getUsers(page);
        };
    }
    else {
        $location.path('/');
    }
};  
    
controllers.getFriendsScores = function ($scope, $http, $location, $window) {
    var user = $window.sessionStorage.getItem('user');
    if (user) {
        $scope.getUsers = function (user,page) {
            var parameters = {user:user,page: page};
            $http.post('requests/user/getFriendsScores.php', parameters).
                    success(function (data, status, headers, config) {
                        console.log("Response: " + data.status);
                        console.log("Users: " + data.count);
                        console.log("Pages: " + data.pages);
                        if (data.status == "FOUND") {
                            $scope.users = data.users;
                            $scope.pages = data.pages;
                        }
                    });
        };
         $scope.getUsers(user,0);
         $scope.getUserFromPage = function (page) {
            console.log('Page');

            $scope.getUsers(user,page);
        };
    }
    else {
        $location.path('/');
    }
};

myApp.controller(controllers);
