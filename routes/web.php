<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return response()->json(["Meta-fritterverso"=>"Cesvi México","__v"=>$router->app->version()],200);
});

$router->group(['prefix' => 'vehiculos'], function () use ($router) {
    $router->get('',  ['uses' => 'VehiculoController@showAll']);
    $router->post('',  ['uses' => 'VehiculoController@createRegVeh']);
    $router->put('',  ['uses' => 'VehiculoController@updateRegVeh']);
    $router->post('pzaCambio', ['uses' => 'VehiculoController@addPzaCambio']);
    $router->post('pzaRepar', ['uses' => 'VehiculoController@addPzaRepar']);
    $router->post('files', ['uses' => 'VehiculoController@addFiles']);
});
