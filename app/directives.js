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

                // minirgb : 255,0,1
                // rgb : rgb(255,0,1)
                // hex : #ff000a

                var mode = attrs.mode || 'hex';
                var defaultval = {
                    minirgb: '0,0,0',
                    hex: '#000000',
                    rgb: 'rgb(0,0,0)'
                };
                var color = scope.ngModel || attrs.default || defaultval[mode]; //default


                if (mode === 'minirgb') {
                    color = 'rgb(' + scope.ngModel + ')';
                }

                elm.spectrum({
                    color: color,
                    showInput: true,
                    clickoutFiresChange: true,
                    showButtons: false,
                    showPalette: true,
                    palette: ['fff', '000'],
                    change: function(color) {
                        scope.$apply(function() {
                            if (mode === 'rgb') {
                                scope.ngModel = color.toRgbString();
                            } else if (mode === 'minirgb') {
                                scope.ngModel = color.toRgbString().replace('rgb(', '').replace(')', '');
                            } else {
                                scope.ngModel = color.toHexString(); // #ff0000
                            }
                        });
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

app.directive('markerImagePreview', ['$rootScope', function($root) {
        return {
            restrict: 'A',
            scope: {
                ngModel: '='
            },
            //template:'<img ng-repeat="img in images" ng-src="{{\'../\' + img[0].full_path}}" />',
            link: function(scope, elm, attrs, ctrl) {
                if (scope.ngModel && scope.ngModel.length > 0) {
                    var maxWidth = attrs.maxWidth || 350;
                    var maxHeight = attrs.maxHeight || 200;
                    var limit = attrs.limit || -1; // limit the images to this number 
                    var showRemaining = attrs.showRemaining || true;

                    try {
                        var model = angular.fromJson(scope.ngModel);
                        scope.images = model;
                    } catch (ex) {
                        elm.html('<i class="text-info"><small>No Image(s)</small></i>');
                        return false;
                    }

                    // remove the instances from DOM
                    $root.$on('$routeChangeStart', function(event, currRoute, prevRoute) {
                        $('.zoomContainer').remove();
                    });

                    for (var i = 0; i < model.length; i++) {
                        if (i == limit)
                            break;

                        var image = model[i];
                        var imgSrc = image[0].full_path,
                                thumbSrc = image[1] !== undefined ? image[1].full_path : imgSrc;
                        var img = $('<img/>').attr({
                            src: '../' + thumbSrc,
                            'data-zoom-image': '../' + imgSrc
                        }).css({
                            maxWidth: maxWidth,
                            maxHeight: maxHeight
                        });
                        elm.append(img);
                        img.elevateZoom({scrollZoom: true});

                    }
                    ;

                    if (showRemaining && limit < model.length && limit > 0) {
                        var remaining = model.length - limit;
                        if (remaining === 1) {
                            elm.append('<p>and one more image.</p>');
                        } else {
                            elm.append('<p>and ' + remaining + ' images.</p>');
                        }
                    } else if (limit == 0) {
                        if (model === undefined || !model || model.length === 0) {
                            elm.append('<i>No images</i>');
                        } else if (model.length == 1) {
                            elm.append('<i>One image</i>');
                        } else if (model.length > 1) {
                            elm.append('<i>' + model.length + ' images</i>');
                        }
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

app.directive('checkbox', [function() {
        return {
            restrict: 'A',
            template: '<div class="checker"><span ng-class="{checked:ngModel}"><input type="checkbox" ng-checked="ngModel" /></span></div>',
            scope: {
                ngModel: '='
            },
            link: function(scope, elm, attrs) {
                elm.click(function() {
                    scope.$apply(function() {
                        scope.ngModel = !scope.ngModel;
                    });
                });
            }
        };
    }]);

/** Backward Compatibility **/
app.directive('ngBindHtmlUnsafe', ['$sce', function($sce) {
        return {
            scope: {
                ngBindHtmlUnsafe: '=',
            },
            template: "<div ng-bind-html='trustedHtml'></div>",
            link: function($scope, iElm, iAttrs, controller) {
                $scope.updateView = function() {
                    $scope.trustedHtml = $sce.trustAsHtml($scope.ngBindHtmlUnsafe);
                }

                $scope.$watch('ngBindHtmlUnsafe', function(newVal, oldVal) {
                    $scope.updateView(newVal);
                });
            }
        };
    }]);

/** Form Validation : markerUnique **/
/* Directives */
app.directive('markerUnique', ['$http', function($http) {
        return {
            require: 'ngModel',
            link: function(scope, elem, attrs, ctrl) {
                var val = elem.val();
                elem.on('focus', function() {
                    val = elem.val();
                });
                elem.on('blur', function(evt) {
                    // skip if their is no value or value is not changed;
                    if (!elem.val().length || elem.val() === val)
                        return;

                    scope.$apply(function() {
                        elem.addClass('spinner');
                        var uniqueAttr = attrs.markerUnique.replace('.', '/');
                        var maxCount = attrs.maxCount || 1;

                        ctrl.$setValidity('unique', true);
                        ctrl.$setValidity('validatingunique', false);
                        $http.get(path.ajax + 'modules/validateCount/' + uniqueAttr + '/' + elem.val() + '/' + (attrs.skip || ''))
                                .success(function(r, status, headers, config) {
                            ctrl.$setValidity('validatingunique', true);
                            ctrl.$setValidity('unique', r.data < maxCount);
                            elem.removeClass('spinner');
                        }).error(function() {
                            ctrl.$setValidity('validatingunique', true);
                            elem.removeClass('spinner');
                        });
                    });
                });
            }
        }
    }]);

/** Form Validation : markerUniqueGroup **/
/* Directives */
app.directive('markerUniqueGroup', ['$http', function($http) {
        return {
            require: 'ngModel',
            link: function(scope, elem, attrs, ctrl) {
                var oldVal = elem.val();
                elem.on('focus', function() {
                    oldVal = elem.val();
                });
                
                elem.on('blur', function(evt) {
                    // skip if their is no value or value is not changed;
                    if (!elem.val().length || elem.val() === oldVal)
                        return;

                    scope.$apply(function() {
                        elem.addClass('spinner');
                        var params = {
                            fields :attrs.fields.split(','),
                            values :attrs.values.split('__markersep__'),
                            skip :attrs.skip || ''
                        };

                        ctrl.$setValidity('uniquegroup', true);
                        ctrl.$setValidity('validatinguniquegroup', false);
                        $http.post(path.ajax + 'modules/validateGroup', params)
                                .success(function(r, status, headers, config) {
                            ctrl.$setValidity('validatinguniquegroup', true);
                            ctrl.$setValidity('uniquegroup', r.data === 0);
                            elem.removeClass('spinner');
                        }).error(function() {
                            ctrl.$setValidity('validatinguniquegroup', true);
                            elem.removeClass('spinner');
                        });
                    });
                });
            }
        }
    }]);

app.directive('markerParseattrs', ['$filter', function($filter) {
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {

                var inFocus = false;
                var oldValue = {};
                elm.focus(function() {
                    inFocus = true;
                    oldValue = ctrl.$viewValue;
                });
                // view -> model
                elm.on('blur', function() {
                    inFocus = false;
                    scope.$apply(function() {
                        var newValue;
                        try {
                            newValue = angular.fromJson(elm.val());
                        } catch (e) {
                            newValue = oldValue;
                        }
                        ctrl.$setViewValue(newValue);
                    });
                });

                // model -> view
                ctrl.$render = function() {
                    if (ctrl.$viewValue) {
                        //console.log(ctrl.$viewValue, typeof ctrl.$viewValue);
                        if(typeof ctrl.$viewValue === 'string'){
                            try{
                                ctrl.$viewValue = angular.fromJson(ctrl.$viewValue);
                            }catch(e){
                                ctrl.$viewValue = {};
                            }
                        }
                        elm.val($filter('json')(ctrl.$viewValue));
                    }
                };

                scope.$watch(attrs.ngModel, function() {
                    if (!inFocus) {
                        ctrl.$render();
                    }
                }, true);

                // load init value from DOM
                //elm.blur();
                //ctrl.$render();
                 //ctrl.$setViewValue(elm.val());
                 //elm.blur();
                
            }
        };
    }]);