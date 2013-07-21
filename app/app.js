'use strict';

var routes = [
    //Admin
    ['/index', path.partials + 'index/index.html', 'IndexCtrl'],
    ['/test', path.partials + 'index/test.html', 'TestCtrl'],

    // Modules
    ['/modules/:id/index', path.partials + 'modules/blank.html', 'ModulesIndexCtrl'],
    ['/modules/:id/create', path.partials + 'modules/blank.html', 'ModulesCreateCtrl'],
    ['/modules/:id/view/:rowId', path.partials + 'modules/blank.html', 'ModulesViewCtrl'],
    ['/modules/:id/edit/:rowId', path.partials + 'modules/blank.html', 'ModulesEditCtrl'],
    ['/modules/:id/delete/:rowId', path.partials + 'modules/blank.html', 'ModulesDeleteCtrl'],
    // Account
    ['/account/login', path.partials + 'account/login.html', 'AccLoginCtrl'],
    ['/account/logout', path.partials + 'account/logout.html', 'AccLogoutCtrl'],
    // Lists
    ['/lists/index', path.partials + 'lists/index.html', 'ListsIndexCtrl'],
    ['/lists/view/:id', path.partials + 'lists/view.html', 'ListsViewCtrl'],
    ['/lists/edit/:id', path.partials + 'lists/edit.html', 'ListsEditCtrl'],
    ['/lists/delete/:id', path.partials + 'lists/delete.html', 'ListsDeleteCtrl'],
    ['/lists/create', path.partials + 'lists/create.html', 'ListsCreateCtrl'],
    ['/lists/:id/newfield', path.partials + 'lists/newfield.html', 'ListsCreateFieldCtrl'],
    ['/lists/:id/editfield/:fieldId', path.partials + 'lists/editfield.html', 'ListsEditFieldCtrl'],
    ['/lists/:id/deletefield/:fieldId', path.partials + 'lists/deletefield.html', 'ListsDeleteFieldCtrl'],
    // Pages
    ['/pages/index', path.partials + 'pages/index.html', 'PagesIndexCtrl'],
    ['/pages/view/:pageId', path.partials + 'pages/view.html', 'PagesViewCtrl'],
    ['/pages/edit/:pageId', path.partials + 'pages/edit.html', 'PagesEditCtrl'],
    ['/pages/delete/:pageId', path.partials + 'pages/delete.html', 'PagesDeleteCtrl'],
    ['/pages/create', path.partials + 'pages/create.html', 'PagesCreateCtrl'],
    // Members
    ['/members/index', path.partials + 'members/index.html', 'MembersIndexCtrl'],
    ['/members/create', path.partials + 'members/create.html', 'MembersCreateCtrl'],
    ['/members/edit/:userId', path.partials + 'members/edit.html', 'MembersEditCtrl'],
    ['/members/view/:userId', path.partials + 'members/view.html', 'MembersViewCtrl'],
    ['/members/delete/:userId', path.partials + 'members/delete.html', 'MembersDeleteCtrl']

];

// Declare app level module which depends on filters, and services
angular.module('myApp', ['ngSanitize', 'myApp.filters', 'myApp.services', 'myApp.directives', 'myApp.controllers']).
        config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider) {
        $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        $httpProvider.defaults.transformRequest = function(data){
          if(data){
              return $.param(data);
          }  
        };
        if (!site.skipClientAuthCheck) {
            routes.forEach(function(route) {
                $routeProvider.when(route[0], {templateUrl: route[1], controller: route[2]});
            });
            $routeProvider.otherwise({redirectTo: '/index'});
        }
    }]);


