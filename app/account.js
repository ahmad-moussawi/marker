'use strict';

var routes = [
];

// Declare app level module which depends on filters, and services
angular.module('myApp', ['myApp.controllers']).
        config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider) {
        $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        $httpProvider.defaults.transformRequest = function(data) {
            if (data) {
                return $.param(data);
            }
        };
//        routes.forEach(function(route) {
//            $routeProvider.when(route[0], {templateUrl: route[1], controller: route[2]});
//        });
//        $routeProvider.otherwise({redirectTo: '/index'});
    }]);

var app = angular.module('myApp.controllers', []);
app.controller('AccLoginCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.errors = [];
        $scope.trial = 0;
        $scope.signin = function() {
            $http.post(path.ajax + 'account/auth', $scope.model).success(function(r) {
                if (r !== 'false') {
                    window.location= path.admin + '/#/index';
                } else {
                    $scope.errors = ['Login failed (' + (++$scope.trial) + ')'];
                    $scope.model.password = '';
                }
            }).error(function() {
                $scope.errors.push('Login failed');
            });
        };
    }]);

