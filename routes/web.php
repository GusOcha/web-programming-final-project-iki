<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Register
$router->post('/api/register', ['uses' => 'LoginController@register']);

// Login
$router->post('/api/login', ['uses' => 'LoginController@login']);

$router->group(['prefix' => 'api', 'middleware'=>'auth'], function() use ($router){
    // Units Table CRUD
    $router->get('/units/read', ['uses' => 'UnitsController@index']);
    $router->get('/units/read/{id}', ['uses' => 'UnitsController@show']);
    $router->post('/units/create', ['uses' => 'UnitsController@store']);
    $router->put('/units/update/{id}', ['uses' => 'UnitsController@update']);
    $router->delete('/units/delete/{id}', ['uses' => 'UnitsController@destroy']);

    // Rooms table CRUD
    $router->get('/rooms/read', ['uses' => 'RoomsController@index']);
    $router->get('/rooms/read/{id}', ['uses' => 'RoomsController@show']);
    $router->post('/rooms/create', ['uses' => 'RoomsController@store']);
    $router->put('/rooms/update/{id}', ['uses' => 'RoomsController@update']);
    $router->delete('/rooms/delete/{id}', ['uses' => 'RoomsController@destroy']);

    // Users table CRUD
    $router->get('/users/read', ['uses' => 'UsersController@index']);
    $router->get('/users/read/{id}', ['uses' => 'UsersController@show']);
    $router->post('/users/create', ['uses' => 'UsersController@store']);
    $router->put('/users/update/{id}', ['uses' => 'UsersController@update']);
    $router->delete('/users/delete/{id}', ['uses' => 'UsersController@destroy']);

    // Bookings table CRUD
    $router->get('/bookings/read', ['uses' => 'BookingsController@index']);
    $router->get('/bookings/read/{id}', ['uses' => 'BookingsController@show']);
    $router->post('/bookings/create', ['uses' => 'BookingsController@store']);
    $router->put('/bookings/update/{id}', ['uses' => 'BookingsController@update']);
    $router->delete('/bookings/delete/{id}', ['uses' => 'BookingsController@destroy']);
});
