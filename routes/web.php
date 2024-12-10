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


// Units Table CRUD
$router->get('/units/read', 'UnitsController@index');
$router->get('/units/read/{id}', 'UnitsController@show');
$router->post('/units/create', 'UnitsController@store');
$router->put('/units/update/{id}', 'UnitsController@update');
$router->delete('/units/delete/{id}', 'UnitsController@destroy');

// Rooms table CRUD
$router->get('/rooms/read', 'RoomsController@index');
$router->get('/rooms/read/{id}', 'RoomsController@show');
$router->post('/rooms/create', 'RoomsController@store');
$router->put('/rooms/update/{id}', 'RoomsController@update');
$router->delete('/rooms/delete/{id}', 'RoomsController@destroy');

// Users table CRUD
$router->get('/users/read', 'UsersController@index');
$router->get('/users/read/{id}', 'UsersController@show');
$router->post('/users/create', 'UsersController@store');
$router->put('/users/update/{id}', 'UsersController@update');
$router->delete('/users/delete/{id}', 'UsersController@destroy');

// Bookings table CRUD
$router->get('/bookings/read', 'BookingsController@index');
$router->get('/bookings/read/{id}', 'BookingsController@show');
$router->post('/bookings/create', 'BookingsController@store');
$router->put('/bookings/update/{id}', 'BookingsController@update');
$router->delete('/bookings/delete/{id}', 'BookingsController@destroy');