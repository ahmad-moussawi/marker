<?php

Blade::setEscapedContentTags('[[', ']]');
Blade::setContentTags('[[[', ']]]');

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

$route_get = array(
    '/admin' => 'AdminController@Index',
    '/api/partials/static/{name}' => 'PartialsController@StaticView',
    '/api/partials/module/{viewName}/{entityId}' => 'PartialsController@ModuleView',
);

Route::post('api/uploader/image', 'UploaderController@Image');


// Authentication
Route::controller('auth', 'AuthController');


Route::get('api/modules/{entity}', array('before' => 'auth', 'uses' => 'ModulesController@Index'))
        ->where('entity', '[a-z0-9]+');

Route::get('api/modules/{entity}/{item}', array('before' => 'auth', 'uses' => 'ModulesController@Get'))
        ->where('entity', '[a-z0-9]+')
        ->where('item', '[0-9]+');

Route::post('api/modules/{id}', 'ModulesController@postIndex');

Route::controller('api/modules', 'ModulesController');
Route::controller('api/fields', 'FieldsController');
Route::controller('api/schema', 'SchemaController');


Route::get('api/entities/{id}', 'EntitiesController@getIndex');
Route::post('api/entities/{id}', 'EntitiesController@postIndex');
Route::delete('api/entities/{id}', 'EntitiesController@postDelete');
Route::controller('api/entities', 'EntitiesController');




Route::get('/', function() {
    return View::make('home.index')->with('name', Input::Get('name'));
});

foreach ($route_get as $route => $to) {
    Route::get($route, $to);
}

//Route::get('/', function(){
//    //return Response::download(base_path() . '/phpunit.xml'); 
//});