'use strict';

var app = angular.module('myApp', ['myApp.services']);
app.controller('AccLoginCtrl', ['$scope', '$http','AuthService', function($scope, $http, auth) {
        $scope.errors = [];
        $scope.trial = 0;
        $scope.signin = function() {
            $http.post(path.ajax + 'account/auth', $scope.model).success(function(r) {
                if (r.status) {
                    console.log(r);
                    auth.isLogged = true;
                    auth.member = r.data;
                    window.location.href = path.admin + '#/index';
                } else {
                    $scope.errors = ['Login failed (' + (++$scope.trial) + ')'];
                    $scope.model.password = '';
                }
            }).error(function() {
                $scope.errors = ['Cannot connect to the server'];
            });
        };
    }]);

