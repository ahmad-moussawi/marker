var app = angular.module('marker.lists', []);

app.controller('ListsIndexCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.working = true;
        $http.get(path.ajax + 'lists/get').success(function(r) {
            $scope.lists = r;
            $scope.working = false;
        });
    }]);

app.controller('ListsViewCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        $scope.working = true;
        //get member
        $http.get(path.ajax + 'lists/get/' + $routeParams.id).success(function(r) {
            $scope.list = r;
            $scope.working = false;
        });

    }]);

app.controller('ListsDeleteCtrl', ['$scope', '$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location) {
        $scope.working = true;

        //get list
        $http.get(path.ajax + 'lists/get/' + $routeParams.id).success(function(r) {
            if (parseInt(r.protected)) {
                $location.path('lists/view/' + $routeParams.id);
            }

            $scope.list = r;
            $scope.working = false;
        });

        $scope.remove = function() {
            $http.get(path.ajax + 'lists/delete/' + $routeParams.id).success(function(r) {
                $scope.working = false;
                $location.path('/lists/index');
            });
        };
    }]);

app.controller('ListsCreateCtrl', ['$scope', '$http', '$filter', '$routeParams', '$location', function($scope, $http, $filter, $routeParams, $location) {
        $scope.working = false;

        $scope.list = {created: $filter('date')(new Date(), 'yyyy-MM-dd'), title: '', description: '', attrs: {view_create: true, view_edit: true, view_delete: true}};
        $scope.$watch('list.title', function(value) {
            $scope.list.internaltitle = $filter('safetitle')(value);
        });

        $scope.save = function() {
            $scope.working = true;
            $scope.list.ispublished = +$scope.list.ispublished;
            var list = $scope.list;
            list.fields = null;
            $http.post(path.ajax + 'lists/set/', list).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
                $location.path('/lists/index');
            });
        };

    }]);

app.controller('ListsCreateFromExistingCtrl',
        ['$scope', '$http', '$filter', '$routeParams', '$location', 'webStorage',
            function($scope, $http, $filter, $routeParams, $location, webStorage) {
                $scope.list = {created: $filter('date')(new Date(), 'yyyy-MM-dd'), title: '', description: '', attrs: {view_create: true, view_edit: true, view_delete: true}};
                $scope.tables = [];
                $http.get(path.ajax + 'lists/getTables').success(function(r) {
                    $scope.tables = r.data;
                });

                $scope.$watch('list.mapped_table', function(value) {
                    $scope.list.title = value ? $filter('camelCaseToHuman')(value) : '';
                });

                $scope.$watch('list.title', function(value) {
                    $scope.list.internaltitle = $filter('safetitle')(value);
                });

                $scope.next = function() {
                    webStorage.add('list', $scope.list);
                    $location.path('/lists/existingfields');
                };
            }]);

app.controller('ListsCreateFromExistingFieldsCtrl',
        ['$scope', '$http', '$filter', '$routeParams', '$location', 'webStorage',
            function($scope, $http, $filter, $routeParams, $location, webStorage) {
                $scope.list = webStorage.get('list');
                console.log($scope.list);

                if (!$scope.list) {
                    alert('Table not selected');
                    $location.path('lists/existing');
                    return;
                }

                $scope.list.fields = [];
                $http.get(path.ajax + 'lists/getTableFields/' + $scope.list.mapped_table).success(function(r) {
                    if (r.status) {
                        $scope.list.fields = r.data;
                    }
                });

                $scope.save = function() {
                    $http.post(path.ajax + 'lists/createFromExisting',
                            {list: angular.fromJson(angular.toJson($scope.list))}).success(function(r) {
                        if (r.status) {
                            alert('list created');
                            $location.path('lists/index');
                        } else {
                            alert('An error has occured: ' + r.message);
                        }
                    }).error(function(response) {
                        alert(response);
                    });
                };

            }]);

app.controller('ListsEditCtrl', ['$scope', '$http', '$filter', '$routeParams', '$location', function($scope, $http, $filter, $routeParams, $location) {
        $scope.working = true;

        //get list
        $http.get(path.ajax + 'lists/get/' + $routeParams.id).success(function(r) {

            if (parseInt(r.protected)) {
                $location.path('lists/view/' + $routeParams.id);
            }

            r.attrs = angular.fromJson(r.attrs);
            $scope.list = r;

            $scope.$watch('list.title', function(value) {
                $scope.list.internaltitle = $filter('safetitle')(value);
            });
            $scope.working = false;
        });

        $scope.save = function() {
            $scope.working = true;
            $scope.list.ispublished = +$scope.list.ispublished;
            var list = angular.copy($scope.list);
            console.log(list);
            $http.post(path.ajax + 'lists/set/' + $routeParams.id, list).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
            });
        };

        $scope.order = [];
        var fieldsTr;
        $scope.dragStart = function(e, ui) {
            ui.item.data('start', ui.item.index());
        };
        $scope.dragEnd = function(e, ui) {
            var start = ui.item.data('start'),
                    end = ui.item.index();
            console.log(start, end);
            $scope.list.fields.splice(end, 0,
                    $scope.list.fields.splice(start, 1)[0]);

            $scope.$apply();
        };

        fieldsTr = $('.fields-body').sortable({
            start: $scope.dragStart,
            update: $scope.dragEnd,
            placeholder: "ui-state-highlight",
            handle: ".handle",
            helper: 'clone'
        });



    }]);
app.controller('ListsCreateFieldCtrl', ['$scope', '$http', '$routeParams', '$filter', '$location', function($scope, $http, $routeParams, $filter, $location) {
        $scope.working = true;
        $scope.attrs = {};
        $scope.field = {created: $filter('date')(new Date(), 'yyyy-MM-dd'), title: '', type: '1.1'};
        $scope.$watch('field.title', function(value) {
            $scope.field.internaltitle = $filter('safetitle')(value);
        });

        $http.get(path.ajax + 'fields/Types').success(function(typesref) {
            $http.get(path.ajax + 'lists/get/' + $routeParams.id).success(function(r) {
                $scope.list = r;
                $scope.typesref = typesref;
                $scope.working = false;
            });
        });

        $scope.addField = function() {
            $scope.field.attrs = JSON.stringify($scope.attrs);
            $http.post(path.ajax + 'lists/addField/' + $routeParams.id, $scope.field).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
                $location.path('lists/edit/' + $routeParams.id);
            });
        };


    }]);
app.controller('ListsEditFieldCtrl', ['$scope', '$http', '$routeParams', '$filter', '$location', function($scope, $http, $routeParams, $filter, $location) {
        $scope.working = true;
        $scope.attrs = {};
        $scope.field = {title: '', type: '1.1'};
        $scope.$watch('field.title', function(value) {
            $scope.field.internaltitle = $filter('safetitle')(value);
        });

        $http.get(path.ajax + 'fields/Types').success(function(types) {
            $http.get(path.ajax + 'lists/get/' + $routeParams.id).success(function(r) {
                $scope.list = r;
                $scope.types = types;
                $scope.working = false;
            });
        });

        $scope.save = function() {
            $scope.field.attrs = JSON.stringify($scope.attrs);
            $http.post(path.ajax + 'lists/addField/' + $routeParams.id, $scope.field).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
                $location.path('lists/edit/' + $routeParams.id);
            });
        };
    }]);

app.controller('ListsDeleteFieldCtrl', ['$scope', '$http', '$routeParams', '$filter', '$location', function($scope, $http, $routeParams, $filter, $location) {
        $http.get(path.ajax + 'lists/getField/' + $routeParams.fieldId).success(function(r) {
            $scope.field = r;
        });
        $scope.remove = function() {
            $http.post(path.ajax + 'lists/deleteField/' + $routeParams.fieldId).success(function(r) {
                $location.path('/lists/edit/' + $routeParams.id);
            });
        };
    }]);


app.directive('markerTypematcher', ['$http', function($http) {
        return {
            restrict: 'EA',
            template: '<span ng-switch="metadata.primary_key">\
                        <span ng-switch-when="1">Identity</span>\
                        <span ng-switch-default><select ng-model="field.typeref" ng-options="row.reference as row.type group by row.category for row in types"></select></span>\
                    </span>',
            link: function(scope, elm, attrs) {

                function getBestMatchType(dbtype) {
                    switch (dbtype) {
                        case 'varchar':
                            return 1.1;
                        case 'text':
                            return 1.2;
                        case 'int':
                            return 3.1;
                        case 'float':
                            return 3.2;
                        case 'tinyint':
                            return 4.4;
                        case 'date':
                            return 7.1;
                        case 'datetime':
                            return 7.2;
                        case 'year':
                            return 7.4;
                    }
                }

                scope.metadata = angular.fromJson(attrs.metadata);

                scope.types = [];

                $http.get(path.ajax + 'fields/Types', {cache: true}).success(function(types) {
                    scope.types = types;
                    if (!scope.field.typeref) {
                        scope.field.typeref = String(getBestMatchType(scope.metadata.type));
                    }
                });
            }
        };
    }]);

app.directive('markerTypedefault', [function() {
        return {
            restrict: 'EA',
            replace: true,
            link: function(scope, elm, attrs) {
            }
        };
    }]);