'use strict';

var app = angular.module('myApp', []);
app.controller('AccLoginCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.errors = [];
        $scope.trial = 0;
        $scope.signin = function() {
            $http.post(path.ajax + 'account/auth', $scope.model).success(function(r) {
                if (r.status) {
                    window.location= path.admin + '/#/index';
                } else {
                    $scope.errors = ['Login failed (' + (++$scope.trial) + ')'];
                    $scope.model.password = '';
                }
            }).error(function() {
                $scope.errors = ['Cannot connect to the server'];
            });
        };
    }]);

