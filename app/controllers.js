'use strict';

/* Controllers */

var app = angular.module('myApp.controllers', []);


///////////////
// Index
///////////////
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

app.controller('IndexCtrl', ['$scope', '$http', function($scope, $http) {
        // 1 is the dashboard link modules
        $http.get(path.ajax + 'modules/get/1').success(function(r) {
            $scope.links = r.data.rows;
        });
    }]);



app.controller('TableCtrl', function($scope, $filter, ngTableParams) {
    var data = [{name: "Moroni", age: 50},
        {name: "Tiancum", age: 43},
        {name: "Jacob", age: 27},
        {name: "Nephi", age: 29},
        {name: "Enos", age: 34},
        {name: "Tiancum", age: 43},
        {name: "Jacob", age: 27},
        {name: "Nephi", age: 29},
        {name: "Enos", age: 34},
        {name: "Tiancum", age: 43},
        {name: "Jacob", age: 27},
        {name: "Nephi", age: 29},
        {name: "Enos", age: 34},
        {name: "Tiancum", age: 43},
        {name: "Jacob", age: 27},
        {name: "Nephi", age: 29},
        {name: "Enos", age: 34}];

    $scope.tableParams = new ngTableParams({
        page: 1, // show first page
        count: 10, // count per page
        sorting: {
            name: 'asc'     // initial sorting
        }
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
                    $filter('orderBy')(data, params.orderBy()) :
                    data;

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });
});




///////////////
// Account
///////////////

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
// Users
///////////////
app.controller('UsersIndexCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.users = [];
        $http.get(path.ajax + 'users/get').success(function(r) {
            $scope.users = r.data;
        });
    }]);
app.controller('UsersCreateCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.success = false;

        $scope.roles = [];
        $scope.member = {
            roles: []
        };

        //get roles
        $http.get(path.ajax + 'users/getroles').success(function(r) {
            $scope.roles = r.data;
        });

        $scope.save = function() {
            $scope.working = true;
            $http.post(path.ajax + 'users/set', $scope.member).success(function(r) {
                $scope.success = true;
            });
        };

    }]);
app.controller('UsersEditCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        $scope.success = false;
        //get roles
        $http.get(path.ajax + 'users/getroles').success(function(r) {
            $scope.roles = r.data;
            //get member
            $http.get(path.ajax + 'users/get/' + $routeParams.userId).success(function(r) {
                $scope.user = r.data;
            });
        });



        $scope.save = function() {
            $http.post(path.ajax + 'users/set/' + $routeParams.userId, $scope.member).success(function(r) {
                $scope.success = true;
            });
        };

    }]);
app.controller('UsersViewCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        //get roles
        $http.get(path.ajax + 'users/getroles').success(function(r) {
            $scope.roles = r.data;
            $http.get(path.ajax + 'users/get/' + $routeParams.userId).success(function(r) {
                $scope.user = r.data;
            });
        });
    }]);

app.controller('UsersDeleteCtrl', ['$scope', '$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location) {
        //get roles
        $http.get(path.ajax + 'users/getroles').success(function(r) {
            $scope.roles = r.data;
            $http.get(path.ajax + 'users/get/' + $routeParams.userId).success(function(r) {
                $scope.user = r.data;
            });
        });

        $scope.remove = function() {
            $http.post(path.ajax + 'users/delete/' + $routeParams.userId).success(function(r) {
                $location.path('/users/index');
            });
        };
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

        $scope.remove = function() {
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

app.controller('SettingsIndexCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.settings = [
            {title: 'Dashboard', link: 'modules/1/index', description: 'Manage the Items that appear on the dashboard', icon: 'cogs'}
        ];
    }]);