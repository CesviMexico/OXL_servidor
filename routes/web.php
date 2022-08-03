<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return response()->json(["Meta-fritterverso"=>"Cesvi México","__v"=>$router->app->version()],200);
});



$router->group(['prefix' => 'vehiculos/add'], function () use ($router) {
    $router->post('', ['uses' => 'VehiculoController@createRegVeh']);  
});

$router->group(['prefix' => 'vehiculos/update'], function () use ($router) {
    $router->post('', ['uses' => 'VehiculoController@updateRegVeh']);  
});

$router->group(['prefix' => 'vehiculos/addPzaCambio'], function () use ($router) {
    $router->post('', ['uses' => 'VehiculoController@addPzaCambio']);  
});

$router->group(['prefix' => 'vehiculos/addPzaRepar'], function () use ($router) {
    $router->post('', ['uses' => 'VehiculoController@addPzaRepar']);  
});






$router->group(['prefix' => 'clientes', 'middleware' => 'jwt'], function () use ($router) {
    $router->get('',  ['uses' => 'ClientesController@showAll']);
    $router->get('/{id}', ['uses' => 'ClientesController@showOne']);
    $router->post('', ['uses' => 'ClientesController@create']);
    $router->delete('/{id}', ['uses' => 'ClientesController@delete']);
    $router->put('/{id}', ['uses' => 'ClientesController@update']);
});
$router->group(['prefix' => 'demo/data'], function () use ($router) {
    $router->get('',  ['uses' => 'PlantillaDataDemoController@showAll']);
    $router->post('', ['uses' => 'PlantillaDataDemoController@create']);
});
