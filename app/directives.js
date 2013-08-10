'use strict';
/* Directives */

var app = angular.module('myApp.directives', []);

app.directive('appVersion', ['version', function(version) {
        return function(scope, elm, attrs) {
            elm.text(version);
        };
    }]);

app.directive('ckEditor', function() {
    return {
        require: '?ngModel',
        link: function(scope, elm, attr, ngModel) {

            var ck = CKEDITOR.replace(elm[0],
                    {
                        toolbar_Full:
                                [
                                    {name: 'document', items: []},
                                    {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                                    {name: 'editing', items: ['Find', 'Replace', '-', 'SpellChecker', 'Scayt']},
                                    {name: 'forms', items: []},
                                    {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']},
                                    {name: 'paragraph', items: [
                                            'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
                                    {name: 'links', items: []},
                                    {name: 'insert', items: ['SpecialChar']},
                                    '/',
                                    {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                                    {name: 'colors', items: []},
                                    {name: 'tools', items: ['Maximize']}
                                ]
                                ,
                        height: '290px',
                        width: '99%'
                    }
            );

            if (!ngModel)
                return;

            //loaded didn't seem to work, but instanceReady did
            //I added this because sometimes $render would call setData before the ckeditor was ready
            ck.on('instanceReady', function() {
                ck.setData(ngModel.$viewValue);
            });

            ck.on('pasteState', function() {
                scope.$apply(function() {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function(value) {
                ck.setData(ngModel.$viewValue);
            };
        }
    };
});

app.directive('ace', ['$timeout', function($timeout) {

        var resizeEditor = function(editor, elem) {
            var lineHeight = editor.renderer.lineHeight;
            var rows = editor.getSession().getLength();

            $(elem).height(rows * lineHeight);
            editor.resize();
        };

        return {
            restrict: 'A',
            require: '?ngModel',
            scope: true,
            link: function(scope, elem, attrs, ngModel) {
                var node = elem[0];

                var editor = ace.edit(node);

                editor.setTheme('ace/theme/xcode');
                editor.getSession().setMode("ace/mode/php");

                // set editor options
                //editor.setShowPrintMargin(false);

                // data binding to ngModel
                ngModel.$render = function() {
                    editor.setValue(ngModel.$viewValue);
                    resizeEditor(editor, elem);
                };

                editor.on('change', function() {
                    $timeout(function() {
                        scope.$apply(function() {
                            var value = editor.getValue();
                            ngModel.$setViewValue(value);
                        });
                    });

                    resizeEditor(editor, elem);
                });
            }
        };
    }]);

app.directive('authCheck', ['$rootScope', '$http', '$location', 'AuthService', function($root, $http, $location, auth) {
        return {
            link: function(scope, elem, attrs, ctrl) {
                $root.$on('$routeChangeStart', function(event, currRoute, prevRoute) {
                    // if (!prevRoute.access.isFree && !userSrv.isLogged) {
                    if (!auth.isLogged) {

                        $http.post(path.ajax + 'account/is_authenticated').success(function(r) {
                            if (r) {
                                auth.isLogged = true;
                                auth.member = r;
                            } else {
                                auth.isLogged = false;
                                auth.member = false;
                                $location.path('/account/login');
                            }
                        }).error(function() {
                            if (!auth.isLogged) {
                                $location.path('/account/login');
                            }
                        });
                    }
                });
            }
        };
    }]);

app.directive('authMenu', ['$rootScope', '$http', '$location', 'AuthService', function($root, $http, $location, auth) {
        return {
            templateUrl: path.partials + 'directives/auth/menu.html',
            replace: true,
            link: function(scope, elem, attrs, ctrl) {
                scope.auth = auth;
            }
        };
    }]);

app.directive('fieldIstitle', ['$http', function($http) {
        return {
            scope: {ngModel: '='},
            link: function(scope, elm, attr) {

                scope.$watch('ngModel', function(ngModel) {
                    if (ngModel) {
                        if (ngModel.istitle) {
                            elm.html('Yes')
                        } else {
                            elm.html('<a class="btn btn-mini">No</a>').click(function() {

                                $http.post(path.ajax + 'lists/setTitleField/' + ngModel.id + '/' + ngModel.listid);
                            })
                        }
                    }
                })
            }
        }
    }]);

app.directive('fieldsettingsLists', ['$http', function($http) {
        return {
            link: function(scope, elm, attr) {
                $http.get(path.ajax + 'lists/get').success(function(r) {
                    if (r.length) {
                        r.forEach(function(e) {
                            elm.append('<option value="' + e.id + '">' + e.title + '</option>');
                        })
                    }
                });
            }
        }
    }]);

app.directive('fieldsettingsDisplayfield', ['$http', function($http) {
        return {
            scope: {
                fieldsettingsDisplayfield: '@',
                ngModel: '='
            },
            template: '<option ng-repeat="option in options" value="{{option.id}}">{{option.title}}</option>',
            link: function(scope, elm, attr) {
                scope.$watch('fieldsettingsDisplayfield', function(v) {
                    if (v) {
                        $http.get(path.ajax + 'lists/getFields/' + v).success(function(r) {
                            if (r.length) {
                                scope.options = r;
                            } else {
                                scope.options = [];
                            }
                            scope.options.unshift({id: -1, title: 'id'});

                            elm.change(function() {
                                var val = $(this).val();
                                scope.$apply(function() {
                                    scope.ngModel = val.join(',');
                                });
                            });
                        });
                    }
                });
            }
        }
    }]);

app.directive('fieldInternal', ['$http', function($http) {
        return {
            scope: {
                fieldInternal: '@',
                ngModel: '='
            },
            //template: '<option ng-repeat="option in options" value="{{option.id}}">{{option.title}}</option>',
            link: function(scope, elm, attr) {
                scope.$watch('fieldInternal', function(listid) {
                    if (listid) {
                        var display = attr.fieldDisplay.split(',');
                        $http.get(path.ajax + 'modules/fieldInternalDataLookup/' + listid + '?select=' + attr.fieldDisplay).success(function(r) {
                            if (r.data.rows.length) {
                                r.data.rows.forEach(function(row) {
                                    var value = [];
                                    display.forEach(function(field) {
                                        value.push(row[field]);
                                    });

                                    var selected = row['-1'] == scope.ngModel ? 'selected="selected"' : '';
                                    elm.append('<option ' + selected + ' value="' + row['-1'] + '">' + value.join(' - ') + '</option>')
                                });
                                elm.change(function() {
                                    var val = $(this).val();
                                    scope.$apply(function() {
                                        scope.ngModel = val;
                                    });
                                });
                            }
                        });
                    }
                });
            }
        }
    }]);

app.directive('markerUpload', ['$http', function($http) {
        return {
            restrict: 'E',
            templateUrl: path.partials + 'directives/upload.html',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs, ctrl) {
                // Change this to the location of your server-side upload handler:
                var url = path.ajax + attrs.path;
                var $input = elm.find('input[type=file]');

                if (scope.ngModel === null || scope.ngModel === undefined) {
                    scope.ngModel = [];
                }

                if (!(scope.ngModel instanceof Array)) {
                    try {
                        scope.ngModel = $.parseJSON(scope.ngModel);
                    } catch (ex) {
                        scope.ngModel = [];
                    }
                }


                scope.queue = [];
                $input.fileupload({
                    url: url,
                    dataType: 'json',
                    add: function(e, data) {
                        data.getProgress = function() {
                            var progress = data.progress(),
                                    result = parseInt(progress.loaded / progress.total * 100, 10);
                            return result;
                        };
                        scope.$apply(function() {
                            scope.queue.push(data);
                        });
                        data.submit();
                    },
                    done: function(e, data) {
                        var result = data.response().result;
                        var fullpath = result.upload_data[0][0].full_path;
                        scope.$apply(function() {
                            // add to the model

                            scope.ngModel.push(result.upload_data[0]);

                            // remove from the queue
                            var toRemove = [];
                            angular.forEach(scope.queue, function(f, i) {
                                if (f.response().result) {
                                    var p1 = f.response().result.upload_data[0][0].full_path;
                                    if (p1 === fullpath) {
                                        toRemove.push(i);
                                    }
                                }
                            });

                            angular.forEach(toRemove, function(index) {
                                scope.queue.splice(index, 1);
                            });

                        });
                    }
                }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');


                scope.removeFile = function(file) {
                    $http.post(path.ajax + 'uploads/remove', {file: angular.toJson(file)}).then(function(r) {
                        var toRemove = [];
                        angular.forEach(scope.ngModel, function(f, i) {
                            if (f[0].full_path === file[0].full_path) {
                                toRemove.push(i);
                            }
                        });
                        angular.forEach(toRemove, function(index) {
                            scope.ngModel.splice(index, 1);
                        });
                    });
                };
            }
        };
    }]);