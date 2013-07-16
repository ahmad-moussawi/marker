'use strict';

/* Controllers */

var app = angular.module('myApp.controllers', []);


///////////////
// Index
///////////////
app.controller('IndexCtrl', ['$scope', function($scope) {
    }]);

app.controller('TestCtrl', ['$scope', '$http', function(scope, $http) {
        //============== DRAG & DROP =============
        // source for drag&drop: http://www.webappers.com/2011/09/28/drag-drop-file-upload-with-html5-javascript/
        var dropbox = document.getElementById("dropbox")
        scope.dropText = 'Drop files here...'

        // init event handlers
        function dragEnterLeave(evt) {
            evt.stopPropagation()
            evt.preventDefault()
            scope.$apply(function() {
                scope.dropText = 'Drop files here...'
                scope.dropClass = ''
            })
        }
        dropbox.addEventListener("dragenter", dragEnterLeave, false)
        dropbox.addEventListener("dragleave", dragEnterLeave, false)
        dropbox.addEventListener("dragover", function(evt) {
            evt.stopPropagation()
            evt.preventDefault()
            var clazz = 'not-available'
            var ok = evt.dataTransfer && evt.dataTransfer.types && evt.dataTransfer.types.indexOf('Files') >= 0
            scope.$apply(function() {
                scope.dropText = ok ? 'Drop files here...' : 'Only files are allowed!'
                scope.dropClass = ok ? 'over' : 'not-available'
            })
        }, false)
        dropbox.addEventListener("drop", function(evt) {
            console.log('drop evt:', JSON.parse(JSON.stringify(evt.dataTransfer)))
            evt.stopPropagation()
            evt.preventDefault()
            scope.$apply(function() {
                scope.dropText = 'Drop files here...'
                scope.dropClass = ''
            })
            var files = evt.dataTransfer.files
            if (files.length > 0) {
                scope.$apply(function() {
                    scope.files = []
                    for (var i = 0; i < files.length; i++) {
                        scope.files.push(files[i])
                    }
                })
            }
        }, false)
        //============== DRAG & DROP =============

        scope.setFiles = function(element) {
            scope.$apply(function(scope) {
                console.log('files:', element.files);
                // Turn the FileList object into an Array
                scope.files = []
                for (var i = 0; i < element.files.length; i++) {
                    scope.files.push(element.files[i])
                }
                scope.progressVisible = false
            });
        };

        scope.uploadFile = function() {
            var fd = new FormData()
            for (var i in scope.files) {
                fd.append("file", scope.files[i])
            }
            var xhr = new XMLHttpRequest()
            xhr.upload.addEventListener("progress", uploadProgress, false)
            xhr.addEventListener("load", uploadComplete, false)
            xhr.addEventListener("error", uploadFailed, false)
            xhr.addEventListener("abort", uploadCanceled, false)
            xhr.open("POST", path.ajax + 'pages/upload')
            scope.progressVisible = true
            xhr.send(fd)
        }

        function uploadProgress(evt) {
            scope.$apply(function() {
                if (evt.lengthComputable) {
                    scope.progress = Math.round(evt.loaded * 100 / evt.total)
                } else {
                    scope.progress = 'unable to compute'
                }
            })
        }

        function uploadComplete(evt) {
            /* This event is raised when the server send back a response */
            alert(evt.target.responseText)
        }

        function uploadFailed(evt) {
            alert("There was an error attempting to upload the file.")
        }

        function uploadCanceled(evt) {
            scope.$apply(function() {
                scope.progressVisible = false
            })
            alert("The upload has been canceled by the user or the browser dropped the connection.")
        }
    }]);



app.controller('ModulesCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.working = true;
        $http.get(path.ajax + 'modules/getModules').success(function(r) {
            $scope.modules = r;
            $scope.working = false;
        });
    }]);
app.controller('ModulesIndexCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', function($scope, $http, $routeParams, $route, $compile) {
        $scope.working = true;
        $route.current.templateUrl = path.ajax + 'modules/renderView/index/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $http.get(path.ajax + 'modules/getItem/' + $routeParams.id).success(function(r) {
                $scope.items = r;
                $('#view').html($compile(data)($scope));
                $scope.working = false;
            });
        });
    }]);
app.controller('ModulesCreateCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', function($scope, $http, $routeParams, $route, $compile) {
        $scope.working = true;
        $scope.attachedfiles = [];
        $route.current.templateUrl = path.ajax + 'modules/renderView/create/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $('#view').html($compile(data)($scope));
            $scope.working = false;
        });

        $scope.save = function() {
            $scope.working = true;
            $http.post(path.ajax + 'modules/setItem/' + $routeParams.id, $scope.item).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
            });
        };
    }]);
app.controller('ModulesViewCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', function($scope, $http, $routeParams, $route, $compile) {
        $scope.working = true;
        $route.current.templateUrl = path.ajax + 'modules/renderView/view/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $http.get(path.ajax + 'modules/getItem/' + $routeParams.id + '/' + $routeParams.rowId).sucess(function(r) {
                $scope.item = r;
                $('#view').html($compile(data)($scope));
                $scope.working = false;
            });
        });
    }]);
app.controller('ModulesEditCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', function($scope, $http, $routeParams, $route, $compile) {
        $scope.working = true;
        $route.current.templateUrl = path.ajax + 'modules/renderView/edit/' + $routeParams.id;
        $http.get($route.current.templateUrl).sucess(function(data) {
            $http.get(path.ajax + 'modules/getItem/' + $routeParams.id + '/' + $routeParams.rowId).success(function(r) {
                $scope.$apply(function() {
                    $scope.item = r;
                    $('#view').html($compile(data)($scope));
                    $scope.working = false;
                });
            });
        });

        $scope.save = function() {
            $scope.working = true;
            $http.post(path.ajax + 'modules/setItem/' + $routeParams.id + '/' + $routeParams.rowId, $scope.item).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
            });
        };
    }]);
app.controller('ModulesDeleteCtrl', ['$scope', '$http', '$routeParams', '$route', '$compile', '$location', function($scope, $http, $routeParams, $route, $compile, $location) {
        $scope.working = true;
        $route.current.templateUrl = path.ajax + 'modules/renderView/delete/' + $routeParams.id;
        $http.get($route.current.templateUrl).success(function(data) {
            $http.get(path.ajax + 'modules/getItem/' + $routeParams.id + '/' + $routeParams.rowId).success(function(r) {
                $scope.$apply(function() {
                    $scope.item = r;
                    $('#view').html($compile(data)($scope));
                    $scope.working = false;
                });
            });
        });

        $scope.delete = function() {
            $http.post(path.ajax + 'modules/deleteItem/' + $routeParams.id + '/' + $routeParams.rowId, $scope.item).success(function(r) {
                $location.path('/modules/' + $routeParams.id + '/index');
            });
        };
    }]);

///////////////
// Account
///////////////

app.controller('AccLoginCtrl', ['$scope', '$location', '$http', 'AuthService', function($scope, $location, $http, auth) {
        $scope.signin = function(hardRedirect) {
            hardRedirect = hardRedirect || false;
            $scope.errors = [];
            $http.post(path.ajax + 'account/auth', $scope.model).success(function(r) {
                if (r) {
                    if (hardRedirect) {
                        window.location.href = path.ajax + '';
                    } else {
                        $location.path('/index');
                    }
                    auth.isLogged = true;
                    auth.member = r;
                } else {
                    auth.isLogged = false;
                    auth.member = false;
                    $scope.errors.push('Login failed');
                }
            }).error(function() {
                $scope.errors.push('Login failed');
            });
        }
    }]);

app.controller('AccLogoutCtrl', ['$scope', '$http', '$location', 'AuthService', function($scope, $http, $location, auth) {
        $scope.done = false;
        $scope.clazz = 'warning';
        $scope.message = 'Logging out now';
        $http.post(path.ajax + 'account/logout').success(function(r) {
            $scope.done = true;
            auth.member = null;
            auth.isLogged = false;
            $scope.clazz = 'success';
            $scope.message = 'Logged out ☺';
        });

    }]);


///////////////
// Lists
///////////////

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
            $scope.list = r;
            $scope.working = false;
        });

        $scope.delete = function() {
            $http.get(path.ajax + 'lists/delete/' + $routeParams.id).success(function(r) {
                $scope.working = false;
                $location.path('/lists/index');
            });

        }

    }]);
app.controller('ListsCreateCtrl', ['$scope', '$http', '$filter', '$routeParams', '$location', function($scope, $http, $filter, $routeParams, $location) {
        $scope.working = false;

        $scope.list = {created: $filter('date')(new Date(), 'yyyy-MM-dd'), title: '', description: ''};
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
app.controller('ListsEditCtrl', ['$scope', '$http', '$filter', '$routeParams', function($scope, $http, $filter, $routeParams) {
        $scope.working = true;

        //get list
        $http.get(path.ajax + 'lists/get/' + $routeParams.id).success(function(r) {
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
            list.fields = null;
            $http.post(path.ajax + 'lists/set/' + $routeParams.id, list).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
            });
        };

    }]);
app.controller('ListsCreateFieldCtrl', ['$scope', '$http', '$routeParams', '$filter', function($scope, $http, $routeParams, $filter) {
        $scope.working = true;
        $scope.attrs = {};
        $scope.field = {created: $filter('date')(new Date(), 'yyyy-MM-dd'), title: '', type: '1.1'};
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

        $scope.addField = function() {
            $scope.field.attrs = JSON.stringify($scope.attrs);
            $http.post(path.ajax + 'lists/addField/' + $routeParams.id, $scope.field).success(function(r) {
                $scope.working = false;
                $scope.saved = true;
            });
        };


    }]);
app.controller('ListsDeleteFieldCtrl', ['$scope', '$http', '$routeParams', '$filter', '$location', function($scope, $http, $routeParams, $filter, $location) {
        $http.get(path.ajax + 'lists/getField/' + $routeParams.fieldId).success(function(r) {
            $scope.field = r;
        });
        $scope.delete = function() {
            $http.post(path.ajax + 'lists/deleteField/' + $routeParams.fieldId).success(function(r) {
                $location.path('/lists/edit/' + $routeParams.id);
            });
        };
    }]);


///////////////
// Members
///////////////
app.controller('MembersIndexCtrl', '$http', ['$scope', function($scope, $http) {
        $scope.working = true;
        $scope.members = [];
        $http.get(path.ajax + 'members/get').success(function(r) {

            $scope.$apply(function() {
                $scope.members = r;
                $scope.working = false;
            });
        });
    }]);
app.controller('MembersCreateCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.working = true;
        $scope.success = false;

        $scope.roles = [];
        $scope.member = {
            roles: []
        };

        //get roles
        $http.get(path.ajax + 'members/getroles').success(function(r) {
            $scope.$apply(function() {
                $scope.roles = r;
                $scope.working = false;
            });
        });

        $scope.save = function() {
            $scope.working = true;
            $http.post(path.ajax + 'members/set', $scope.member).success(function(r) {
                $scope.success = true;
            });
        };

    }]);
app.controller('MembersEditCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        $scope.working = true;
        $scope.success = false;

        //get roles
        $http.get(path.ajax + 'members/getroles').success(function(r) {
            $scope.$apply(function() {
                $scope.roles = r;

                //get member
                $http.get(path.ajax + 'members/get/' + $routeParams.userId).success(function(r) {
                    $scope.$apply(function() {
                        $scope.member = r;
                        $scope.working = false;
                    });
                });
            });
        });



        $scope.save = function() {
            $scope.working = true;
            $http.post(path.ajax + 'members/set/' + $routeParams.userId, $scope.member).success(function(r) {
                $scope.success = true;
            });
        };

    }]);
app.controller('MembersViewCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        $scope.working = true;

        //get roles
        $http.get(path.ajax + 'members/getroles').success(function(r) {
            $scope.$apply(function() {
                $scope.roles = r;

                //get member
                $http.get(path.ajax + 'members/get/' + $routeParams.userId).success(function(r) {
                    $scope.$apply(function() {
                        $scope.member = r;
                        $scope.working = false;
                    });
                });
            });
        });
    }]);



///////////////
// Pages
///////////////
app.controller('PagesIndexCtrl', ['$scope', '$http', function($scope, $http) {
        $http.get(path.ajax + 'pages/get').success(function(r) {
            $scope.pages = r.data.pages;
        });
    }]);
app.controller('PagesCreateCtrl', ['$scope', '$http', '$filter', '$location', function($scope, $http, $filter, $location) {

        $scope.working = false;

        $scope.page = {meta: '', ispublished: true, images: '[]', title: ''};

        $scope.$watch('page.title', function(value) {
            $scope.page.urlpath = $filter('urlify')(value);
        });

        $scope.save = function(isDraft) {

            $scope.working = true;
            $scope.page.ispublished = +$scope.page.ispublished;

            $scope.page.isdraft = isDraft || 0;
            ;

            $http.post(path.ajax + 'pages/set', $scope.page).success(function(r) {
                if (r.status) {
                    $scope.page = r.data.page;
                    $scope.saved = true;
                    $scope.working = false;
                }
            });
        };
    }]);
app.controller('PagesViewCtrl', ['$scope', '$routeParams', '$http', function($scope, $routeParams, $http) {
        $http.get(path.ajax + 'pages/get/' + $routeParams.pageId).success(function(r) {
            $scope.page = r.data.page;
        });
    }]);
app.controller('PagesDeleteCtrl', ['$scope', '$routeParams', '$http', '$location', function($scope, $routeParams, $http, $location) {
        $scope.working = false;
        $scope.page = {};
        $http.get(path.ajax + 'pages/get/' + $routeParams.pageId).success(function(r) {
            $scope.page = r.data.page;
        });

        $scope.delete = function() {
            $http.post(path.ajax + 'pages/delete', {id: $scope.page.id}).success(function(r) {
                $location.path('/pages/index');
            });
        };
    }]);
app.controller('PagesEditCtrl', ['$scope', '$routeParams', '$http', '$filter', '$location', function($scope, $routeParams, $http, $filter, $location) {

        $http.get(path.ajax + 'pages/get/' + $routeParams.pageId).success(function(r) {
            $scope.page = r.data.page;
            if (!$scope.page.images || $scope.page.images.length === 0) {
                $scope.page.images = '[]';
            }
        });

        $scope.save = function() {
            $scope.working = true;
            $scope.page.isdraft = 0;
            $scope.page.ispublished = +$scope.page.ispublished;

            $http.post(path.ajax + 'pages/set/' + $routeParams.pageId, $scope.page).success(function(r) {
                if (r.status) {
                    $scope.saved = true;
                }
                $scope.working = false;
            });
        };
    }]);