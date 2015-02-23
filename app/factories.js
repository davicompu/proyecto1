var factories={};
factories.Login=function ($http){
  return {
       getFoos: function() {
            //return the promise directly.
            return $http.get('../requests')
                      .then(function(result) {
                           //resolve the promise as the data
                           return result.data;
                       });
       }
  }
};

myapp.factory(factories);
