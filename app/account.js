'use strict';

var app = angular.module('myApp', ['myApp.services']);
app.controller('AccLoginCtrl', ['$scope', '$http', 'AuthService', function($scope, $http, auth) {
        $scope.working = false;
        $scope.loginText = 'Login';

        $scope.errors = [];
        $scope.trial = 0;
        $scope.signin = function() {
            $scope.working = true;
            $scope.loginText = 'Logging in ...';
            $http.post(path.ajax + 'account/auth', $scope.model).success(function(r) {
                if (r.status) {
                    auth.isLogged = true;
                    auth.member = r.data;
                    window.location.href = path.admin;
                } else {
                    $scope.errors = ['Login failed (' + (++$scope.trial) + ')'];
                    $scope.model.password = '';
                    $scope.working = false;
                    $scope.loginText = 'Retry !'; 
                }
            }).error(function() {
                $scope.errors = ['Cannot connect to the server'];
                $scope.working = false;
                $scope.loginText = 'Login';
            });
        };
    }]);

