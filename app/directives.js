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

app.directive('upload', ['$http',
    function($http) {
        return {
            restrict: 'A',
            templateUrl: path.partials + 'directives/upload.html',
            scope: {
                property: '=',
                working: '=',
                form: '=',
                doupload: '&',
                upload: '@',
                max: '@',
                thumbnail: '@',
                fieldid: '@',
                required: '&'
            },
            link: function(scope, elm, attr) {

                scope.errors = scope.warnings = [];
                scope.files = scope.uploaded = [];

                function dragEnterLeave(evt) {
                    evt.stopPropagation();
                    evt.preventDefault();
                    scope.$apply(function() {
                        scope.dropText = 'Drop files here...';
                        scope.dropClass = '';
                    });
                }

                function uploadComplete(evt) {
                    /* This event is raised when the server send back a response */
                    scope.$apply(function() {
                        var response = $.parseJSON(evt.target.responseText);
                        scope.errors = response.errors;
                        scope.warning = response.warning;

                        response.upload_data.forEach(function(e) {
                            scope.uploaded.push(e);
                        });
                        // return the uploaded fiels name to the model
                        scope.property = JSON.stringify(scope.uploaded);
                        scope.files = [];
                        scope.working = false;
                    });
                }
                function uploadFailed(evt) {
                    alert("There was an error attempting to upload the file.");
                    scope.$apply(function() {
                        scope.working = false;
                    });
                }
                function uploadCanceled(evt) {
                    scope.$apply(function() {
                        scope.progressVisible = false;
                        scope.working = false;
                    });
                    alert("The upload has been canceled by the user or the browser dropped the connection.")
                }

                function uploadProgress(evt) {
                    scope.$apply(function() {
                        if (evt.lengthComputable) {
                            scope.progress = Math.round(evt.loaded * 100 / evt.total);
                        } else {
                            scope.progress = 'unable to compute'
                        }
                    });
                }

                scope.$watch('property', function(property) {
                    if (property) {

                        /** UPLOAD **/
                        //============== DRAG & DROP =============
                        // source for drag&drop: http://www.webappers.com/2011/09/28/drag-drop-file-upload-with-html5-javascript/
                        var dropbox = elm.find('.dropbox')[0];
                        scope.dropText = 'Drop files here...';
                        if (scope.property) {
                            scope.uploaded = JSON.parse(scope.property)
                        } else {
                            scope.property = [];
                            scope.uploaded = []; // files that successfully uploaded
                        }
                        ;
                        scope.files = []; // files attached in browser but still not uploaded  
                        // init event handlers

                        dropbox.addEventListener("dragenter", dragEnterLeave, false);
                        dropbox.addEventListener("dragleave", dragEnterLeave, false);
                        dropbox.addEventListener("dragover", function(evt) {
                            evt.stopPropagation();
                            evt.preventDefault();
                            var ok = evt.dataTransfer && evt.dataTransfer.types && evt.dataTransfer.types.indexOf('Files') >= 0;
                            scope.$apply(function() {
                                scope.dropText = ok ? 'Drop files here...' : 'Only files are allowed!';
                                scope.dropClass = ok ? 'over' : 'not-available';
                            });
                        }, false);
                        dropbox.addEventListener("drop", function(evt) {
                            //console.log('drop evt:', JSON.parse(JSON.stringify(evt.dataTransfer)))         evt.stopPropagation();
                            evt.preventDefault();
                            scope.$apply(function() {
                                scope.dropText = 'Drop files here...';
                                scope.dropClass = '';
                            });
                            var files = evt.dataTransfer.files;
                            if (files.length > 0) {
                                scope.$apply(function() {
                                    for (var i = 0; i < files.length; i++) {
                                        if ((scope.files.length + scope.uploaded.length) == scope.max) {
                                            break;
                                        }
                                        scope.files.push(files[i]);
                                    }
                                    scope.progressVisible = false;
                                    scope.progress = 0;
                                });
                            }
                        }, false);
                        //============== DRAG & DROP =============

                        scope.removeFile = function(el, removeOnServer) {
                            var removeOnServer = removeOnServer || false;
                            if (removeOnServer) {
                                $http.post(path.ajax + 'uploads/remove', {file: JSON.stringify(el.file)}).success(function(r) {
                                    if (r.status) {
                                        var oldFiles = scope.uploaded;
                                        scope.uploaded = [];
                                        oldFiles.forEach(function(e) {
                                            if (el.file[0].full_path !== e[0].full_path) {
                                                scope.uploaded.push(e);
                                            }
                                        });
                                        scope.property = JSON.stringify(scope.uploaded);
                                    }
                                    ;
                                    scope.warnings = r.warnings;
                                    scope.errors = r.errors;
                                });
                            } else {
                                var oldFiles = scope.files;
                                scope.files = [];
                                oldFiles.forEach(function(e) {
                                    if (el.file.name !== e.name) {
                                        scope.files.push(e);
                                    }
                                });
                            }
                        };
                        scope.setFiles = function(element) {
                            scope.$apply(function(scope) {
                                //console.log('files:', element.files);
                                // Turn the FileList object into an Array
                                scope.files = []
                                for (var i = 0; i < element.files.length; i++) {
                                    scope.files.push(element.files[i]);
                                }
                                scope.progressVisible = false;
                            });
                        };
                        scope.uploadFile = function() {
                            scope.working = true;
                            var fd = new FormData();
                            var c = 0;
                            for (var i in scope.files) {
                                fd.append("file" + (++c), scope.files[i]);
                            }
                            ;
                            //console.log(fd);
                            var xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener("progress", uploadProgress, false);
                            xhr.addEventListener("load", uploadComplete, false);
                            xhr.addEventListener("error", uploadFailed, false);
                            xhr.addEventListener("abort", uploadCanceled, false);
                            xhr.open("POST", scope.upload);
                            scope.progressVisible = true;
                            xhr.send(fd);
                        };
                        /** UPLOAD **/

                    }
                });
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
                                    display.forEach(function(field){
                                       value.push(row[field]);
                                    });

                                    var selected = row['-1'] == scope.ngModel? 'selected="selected"' :'';
                                    elm.append('<option '+ selected +' value="' + row['-1'] + '">' + value.join(' - ') + '</option>')
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
