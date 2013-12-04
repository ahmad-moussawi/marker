/**
 * Auth 
 * 
 * @author Ahmad Moussawi
 * @date 17th October 2013
 * 
 */
var module = angular.module('ngAuth', []);

module.config(['$httpProvider', function($httpProvider) {
        var interceptor = ['$q', function($q) {
                return function(promise) {

                    return promise.then(
                            function(response) {
                                //console.log(response, response.headers());
                                return response;
                            },
                            function(response) {
                                console.log(response);
                                if(response.status == 404){
                                    alert('Not found');
                                }else if(response.status == 401){
                                   window.location.href= path.base;
                                }
                                // Reject the reponse so that angular isn't waiting for a response.
                                return $q.reject(response);
                            }
                    );
                };
            }];

        $httpProvider.responseInterceptors.push(interceptor);
    }]);