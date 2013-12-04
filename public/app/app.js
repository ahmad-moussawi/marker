'use strict';

var routes = [
    //Admin
    ['/', path.partials + 'index/index.html', 'IndexCtrl'],
    ['/test', path.partials + 'index/test.html', 'Test2Ctrl'],
    ['/demo', path.partials + 'index/demo.html', 'TableCtrl'],
    // Modules
    ['/m/:id', path.partials + 'modules/blank.html', 'ModulesIndexCtrl'],
    ['/m/:id/new', path.partials + 'modules/blank.html', 'ModulesCreateCtrl'],
    ['/m/:id/view/:rowId', path.partials + 'modules/blank.html', 'ModulesViewCtrl'],
    ['/m/:id/edit/:rowId', path.partials + 'modules/blank.html', 'ModulesEditCtrl'],
    ['/m/:id/delete/:rowId', path.partials + 'modules/blank.html', 'ModulesDeleteCtrl'],
    // Account
    ['/account/login', path.partials + 'account/login.html', 'AccLoginCtrl'],
    ['/account/logout', path.partials + 'account/logout.html', 'AccLogoutCtrl'],
    ['/account/changepwd', path.partials + 'account/changepwd.html', 'AccChangePwdCtrl'],
    // Entities
    ['/entities', path.partials + 'entities/index.html', 'EntitiesIndexCtrl'],
    ['/entities/view/:id', path.partials + 'entities/view.html', 'EntitiesViewCtrl'],
    ['/entities/edit/:id', path.partials + 'entities/edit.html', 'EntitiesEditCtrl'],
    ['/entities/delete/:id', path.partials + 'entities/delete.html', 'EntitiesDeleteCtrl'],
    ['/entities/create', path.partials + 'entities/create.html', 'EntitiesCreateCtrl'],
    ['/entities/existing', path.partials + 'entities/create_existing.html', 'EntitiesCreateFromExistingCtrl'],
    ['/entities/existingfields', path.partials + 'entities/create_existing_fields.html', 'EntitiesCreateFromExistingFieldsCtrl'],
    ['/entities/:id/newfield', path.partials + 'entities/newfield.html', 'EntitiesCreateFieldCtrl'],
    ['/entities/:id/editfield/:fieldId', path.partials + 'entities/editfield.html', 'EntitiesEditFieldCtrl'],
    ['/entities/:id/deletefield/:fieldId', path.partials + 'entities/deletefield.html', 'EntitiesDeleteFieldCtrl'],
    // Pages
    ['/pages', path.partials + 'pages/index.html', 'PagesIndexCtrl'],
    ['/pages/view/:pageId', path.partials + 'pages/view.html', 'PagesViewCtrl'],
    ['/pages/edit/:pageId', path.partials + 'pages/edit.html', 'PagesEditCtrl'],
    ['/pages/delete/:pageId', path.partials + 'pages/delete.html', 'PagesDeleteCtrl'],
    ['/pages/create', path.partials + 'pages/create.html', 'PagesCreateCtrl'],
    // Users
    ['/users', path.partials + 'users/index.html', 'UsersIndexCtrl'],
    ['/users/create', path.partials + 'users/create.html', 'UsersCreateCtrl'],
    ['/users/edit/:userId', path.partials + 'users/edit.html', 'UsersEditCtrl'],
    ['/users/view/:userId', path.partials + 'users/view.html', 'UsersViewCtrl'],
    ['/users/delete/:userId', path.partials + 'users/delete.html', 'UsersDeleteCtrl'],
    //Settings
    ['/settings', path.partials + 'settings/index.html', 'SettingsIndexCtrl']

];

// Declare app level module which depends on filters, and services
angular.module('myApp',
        [
            'ngRoute',
//            'ngAuth',
            'accountApp',
            'ngSanitize',
            'myApp.filters',
            'myApp.services',
            'myApp.directives',
            'myApp.controllers',
            'webStorageModule',
            'LoadingIndicator',
            'ngTable',
            'marker.modules',
            'marker.entities',
            'mkValidation',
            'angularFileUpload'
        ]).
        config(['$routeProvider', '$httpProvider', '$locationProvider',
            function($routeProvider, $httpProvider, $locationProvider) {

                //$locationProvider.html5Mode(true);

//        $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
//        $httpProvider.defaults.transformRequest = function(data) {
//            if (data) {
//                return $.param(data);
//            }
//        };


                var authInterceptor = function($rootScope, $location, $q) {
                    var success = function(response) {
                        return response
                    }
                    var error = function(response) {
                        if (response.status == 401) {
                            delete sessionStorage.authenticated
                            $location.path('/account/login')
                        }
                        return $q.reject(response)
                    }
                    return function(promise) {
                        return promise.then(success, error)
                    }
                }
                $httpProvider.responseInterceptors.push(authInterceptor);

                routes.forEach(function(route) {
                    $routeProvider.when(route[0], {templateUrl: route[1], controller: route[2]});
                });
                $routeProvider.otherwise({redirectTo: '/'});
            }]);


