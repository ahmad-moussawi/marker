var app = angular.module('marker.modules', []);

function correctTypes(row){
    var newRow = {};
    for(var i in row){
        if(!(isNaN(row[i]))){
            newRow[i] = +row[i];
        }else{
            newRow[i] = row[i];
        }
    }
    return newRow;
}

app.controller('ModulesIndexCtrl',
        ['$scope', '$http', '$routeParams', '$route', '$compile', '$filter', 'ngTableParams',
            function($scope, $http, $routeParams, $route, $compile, $filter, ngTableParams) {
                $scope.working = true;

                $route.current.templateUrl = path.ajax + 'modules/renderView/index/' + $routeParams.id;
                $http.get($route.current.templateUrl).success(function(data) {
                    $http.get(path.ajax + 'modules/get/' + $routeParams.id).success(function(r) {

                        $scope.tableParams = new ngTableParams({
                            page: 1,
                            count: 10
//                    sorting: {
//                        id: 'asc'     // initial sorting
//                    }
//                    ,
//                    filter: {
//                        title: 'M'       // initial filter
//                    }
                        },
                        {
                            total: r.data.rows.length,
                            getData: function($defer, params) {
                                // use build-in angular filter
                                var descOrder = false;
                                if(params.orderBy()[0]){
                                    // get the first charachter of first item
                                    // e.g. ['+id'] ==> '+'
                                    descOrder = params.orderBy()[0][0] === '-';
                                }
                                var orderedData = params.sorting() ? //params.orderBy()
                                        $filter('orderBy')(r.data.rows, function(item){
                                            var predicate  = params.orderBy();
                                            if(! predicate.length) return;
                                            var field = predicate[0].slice(1);
                                            // detect if number 
                                            if(isNaN(item[field])){
                                                return item[field];
                                            }else{
                                                return Number(item[field]);
                                            }
                                        }, descOrder) :
                                        r.data.rows;
                                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                            }
                        });

                        $('#view').html($compile(data)($scope));
                        $scope.working = false;
                    });
                });
            }]);
app.controller('ModulesCreateCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', '$location', function($scope, $http, $routeParams, $route, $compile, $location) {
        $scope.working = true;
        $scope.errors = [];
        $scope.attachedfiles = [];
        $route.current.templateUrl = path.ajax + 'modules/renderView/create/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $('#view').html($compile(data)($scope));
            $scope.working = false;
        });

        $scope.save = function() {
            $scope.working = true;
            var item = $.parseJSON(angular.toJson($scope.item));
            $http.post(path.ajax + 'modules/set/' + $routeParams.id, item)
                    .success(function(r) {
                $scope.working = false;
                $scope.saved = true;
                $location.path('modules/' + $routeParams.id + '/index');
            })
            .error(function(data, status, headers, config){
                $scope.errors.unshift(data);
                $scope.working = false;
            });
        };
    }]);
app.controller('ModulesViewCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', function($scope, $http, $routeParams, $route, $compile) {
        $scope.working = true;
        $route.current.templateUrl = path.ajax + 'modules/renderView/view/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $http.get(path.ajax + 'modules/get/' + $routeParams.id + '/' + $routeParams.rowId).success(function(r) {
                $scope.item = r.data.row;
                $('#view').html($compile(data)($scope));
                $scope.working = false;
            });
        });
    }]);
app.controller('ModulesEditCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', function($scope, $http, $routeParams, $route, $compile) {
        $scope.working = true;
                $scope.errors = [];
        $route.current.templateUrl = path.ajax + 'modules/renderView/edit/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $http.get(path.ajax + 'modules/get/' + $routeParams.id + '/' + $routeParams.rowId).success(function(r) {
                $scope.item = correctTypes(r.data.row);
                
                
                $('#view').html($compile(data)($scope));
                $scope.working = false;
            });
        });

        $scope.save = function() {
            $scope.working = true;
            var item = $.parseJSON(angular.toJson($scope.item));
            $http.post(path.ajax + 'modules/set/' + $routeParams.id + '/' + $routeParams.rowId, item).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
            })
            .error(function(data, status, headers, config){
                $scope.errors.unshift(data);
                $scope.working = false;
            });;
        };
    }]);
app.controller('ModulesDeleteCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', '$location', function($scope, $http, $routeParams, $route, $compile, $location) {
        $scope.working = true;
        $scope.errors = [];
        $route.current.templateUrl = path.ajax + 'modules/renderView/delete/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $http.get(path.ajax + 'modules/get/' + $routeParams.id + '/' + $routeParams.rowId).success(function(r) {
                $scope.item = r.data.row;
                $('#view').html($compile(data)($scope));
                $scope.working = false;
            });
        });

        $scope.remove = function() {
            $http.post(path.ajax + 'modules/delete/' + $routeParams.id + '/' + $routeParams.rowId, $scope.item).success(function(r) {
                $location.path('/modules/' + $routeParams.id + '/index');
            })
            .error(function(data, status, headers, config){
                $scope.errors.unshift(data);
                $scope.working = false;
            });;
        };
    }]);