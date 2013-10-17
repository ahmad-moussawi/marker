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
                        width: '99%',
                        allowedContent: true
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
                            if (r.status) {
                                auth.isLogged = true;
                                auth.member = r.data;
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
            restrict: 'EA',
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
        };
    }]);

app.directive('colorPicker', [function() {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs) {
                elm.spectrum({
                    color: scope.ngModel || attrs.default || '000',
                    showInput: true,
                    showPalette: true,
                    palette: ['fff', '000'],
                    change: function(color) {
                        scope.$apply(function() {
                            scope.ngModel = color.toHexString(); // #ff0000
                        })
                    }
                });
            }
        };
    }]);

app.directive('markerUpload', ['$http', function($http) {
        return {
            restrict: 'E',
            templateUrl: path.partials + 'directives/upload.html',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs, ctrl) {
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

                var removeFrom = function(array, condition) {
                    // remove from the queue
                    var toRemove = [];
                    angular.forEach(array, function(f, i) {
                        if (condition(f)) {
                            toRemove.push(i);
                        }
                    });

                    angular.forEach(toRemove, function(index) {
                        array.splice(index, 1);
                    });
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

                        console.debug(data)
                        if (data) {
                            scope.$apply(function() {
                                scope.queue.push(data);
                            });
                            data.submit();
                        }
                    },
                    done: function(e, data) {
                        var result = data.response().result;
                        if (result.upload_data[0]) {
                            var fullpath = result.upload_data[0][0].full_path;
                            scope.$apply(function() {
                                // add to the model

                                if (!(scope.ngModel instanceof Array)) {
                                    scope.ngModel = [];
                                }

                                scope.ngModel.push(result.upload_data[0]);

                                removeFrom(scope.queue, function(item) {
                                    return !!item.response().result && item.response().result.upload_data[0][0].full_path == fullpath;
                                });

                            });
                        } else {
                            scope.$apply(function() {
                                scope.errors = result.errors;
                                removeFrom(scope.queue, function(item) {
                                    //console.log(item);
                                    //return !!item.response().result && item.response().result.upload_data[0][0].full_path == fullpath;
                                });
                            });
                            // some error occured
                            // TODO >> display the errors
                        }
                    }
                }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');


                scope.removeFile = function(file) {
                    $http.post(path.ajax + 'uploads/remove', {file: angular.toJson(file)}).then(function(r) {
                        removeFrom(scope.ngModel, function(item) {
                            return item[0].full_path === file[0].full_path;
                        });
                    });
                };
            }
        };
    }]);

app.directive('markerVideoPreview', [function() {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs, ctrl) {
                if (scope.ngModel && scope.ngModel.length > 0) {
                    try {
                        var model = angular.fromJson(scope.ngModel);
                        elm.attr('width', '300');
                        if (model && model[0] && model[0][0]) {
                            if (Modernizr.video) {
                                elm.html('<video controls src="../' + model[0][0].full_path + '" width="200"></video>');
                            } else {
                                elm.html('<i class="text-warning"><small>preview not supported</small></i>');
                            }
                            elm.after('<p><a target="_blank" href="../' + model[0][0].full_path + '">' + model[0][0].full_path.split('/').reverse()[0] + '</a></p>');
                        } else {
                            elm.html('<i class="text-info"><small>No video selected</small></i>');
                        }
                    } catch (ex) {
                        elm.html('<i class="text-info"><small>No video selected</small></i>');
                    }
                } else {
                    elm.html('<i class="text-info"><small>No video selected</small></i>');
                }
            }
        };
    }]);

app.directive('markerAudioPreview', [function() {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs, ctrl) {
                if (scope.ngModel && scope.ngModel.length > 0) {
                    try {
                        var model = angular.fromJson(scope.ngModel);
                        if (model && model[0] && model[0][0]) {
                            if (Modernizr.audio) {
                                elm.html('<audio controls src="../' + model[0][0].full_path + '"></audio>');
                            } else {
                                elm.html('<i class="text-warning"><small>preview not supported</small></i>');
                            }
                            elm.after('<p><a target="_blank" href="../' + model[0][0].full_path + '">' + model[0][0].full_path.split('/').reverse()[0] + '</a></p>');
                        } else {
                            elm.html('<i class="text-info"><small>No audio selected</small></i>');
                        }
                    } catch (ex) {
                        elm.html('<i class="text-info"><small>No audio selected</small></i>');
                    }
                } else {
                    elm.html('<i class="text-info"><small>No audio selected</small></i>');
                }
            }
        };
    }]);

app.directive('markerImagePreview', [function() {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            //template:'<img ng-repeat="img in images" ng-src="{{\'../\' + img[0].full_path}}" />',
            link: function(scope, elm, attrs, ctrl) {
                if (scope.ngModel && scope.ngModel.length > 0) {
                    try {
                        var maxWidth = attrs.maxWidth || 350;
                        var maxHeight = attrs.maxHeight || 200;
                        var limit = attrs.limit || -1; // limit the images to this number 
                        var showRemaining = attrs.showRemaining || true;
                        

                        var model = angular.fromJson(scope.ngModel);
                        scope.images = model;
                        
                        for(var i=0; i<model.length; i++){
                            if(i == limit) break;

                            var image = model[i];
                            var imgSrc = image[0].full_path,
                                thumbSrc = image[1] !== undefined ? image[1].full_path:imgSrc;
                            var img = $('<img/>').attr({
                                src: '../' + thumbSrc,
                                'data-zoom-image':'../' + imgSrc
                            }).css({
                                maxWidth: maxWidth,
                                maxHeight: maxHeight
                            });
                            elm.append(img);
                            img.elevateZoom({scrollZoom : true});
                            
                        };
                        
                        if(showRemaining && limit < model.length && limit > 0){
                            var remaining = model.length - limit;
                            if(remaining === 1){
                                elm.append('<p>and one more image.</p>');
                            }else{
                                elm.append('<p>and ' + remaining + ' images.</p>');
                            }
                        }else if(limit == 0){
                            if(model === undefined || !model || model.length === 0){
                                alm.append('<i>No images</i>');
                            }else if(model.length == 1){
                                elm.append('One image');
                            }else if(model.length > 1){
                                elm.append(model.length + ' images');
                            }
                        }

                    } catch (ex) {
                        elm.html('<i class="text-info"><small>No Image(s)</small></i>');
                    }
                } else {
                    elm.html('<i class="text-info"><small>No Image(s)</small></i>');
                }
            }
        };
    }]);

app.directive('markerAudioPreview', [function() {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs, ctrl) {
                if (scope.ngModel && scope.ngModel.length > 0) {
                    try {
                        var model = angular.fromJson(scope.ngModel);
                        if (model && model[0] && model[0][0]) {
                            if (Modernizr.audio) {
                                elm.html('<audio controls src="../' + model[0][0].full_path + '"></audio>');
                            } else {
                                elm.html('<i class="text-warning"><small>preview not supported</small></i>');
                            }
                            elm.after('<p><a target="_blank" href="../' + model[0][0].full_path + '">' + model[0][0].full_path.split('/').reverse()[0] + '</a></p>');
                        } else {
                            elm.html('<i class="text-info"><small>No audio selected</small></i>');
                        }
                    } catch (ex) {
                        elm.html('<i class="text-info"><small>No audio selected</small></i>');
                    }
                } else {
                    elm.html('<i class="text-info"><small>No audio selected</small></i>');
                }
            }
        };
    }]);

app.directive('markerBarcode', [function() {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs, ctrl) {
                if (scope.ngModel) {
                    elm.barcode(scope.ngModel, attrs.type);
                }
            }
        };
    }]);