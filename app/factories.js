var factories={};
factories.Login=function ($http){
  return {
       getFoos: function() {
            //return the promise directly.
            return $http.get('/foos')
                      .then(function(result) {
                           //resolve the promise as the data
                           return result.data;
                       });
       }
  }
};

myapp.factory(factories);
myApp.factory('myService', function($http) {
   return {
        getFoos: function() {
             //return the promise directly.
             return $http.get('/foos')
                       .then(function(result) {
                            //resolve the promise as the data
                            return result.data;
                        });
        }
   }
});
