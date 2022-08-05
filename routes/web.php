<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return response()->json(["Meta-fritterverso"=>"Cesvi México","__v"=>$router->app->version()],200);
});

$router->group(['prefix' => 'vehiculos'], function () use ($router) {
    $router->get('',  ['uses' => 'VehiculoController@showStatus']);
    $router->get('/{id}',  ['uses' => 'VehiculoController@showOne']);
    $router->post('',  ['uses' => 'VehiculoController@createRegVeh']);
    $router->put('',  ['uses' => 'VehiculoController@updateRegVeh']);
    $router->post('pzaCambio', ['uses' => 'VehiculoController@addPzaCambio']);
    $router->post('pzaRepar', ['uses' => 'VehiculoController@addPzaRepar']);
    $router->post('files', ['uses' => 'VehiculoController@addFiles']);
    $router->post('deletefiles', ['uses' => 'VehiculoController@deletefiles']);
    $router->post('WSVInPlusCat', ['uses' => 'VehiculoController@WSVInPlusCat']);
    $router->post('deletPza', ['uses' => 'VehiculoController@deletPza']);
    $router->post('AsignacionTaller',  ['uses' => 'VehiculoController@AsignacionTaller']);
    $router->post('IngresoVehTaller',  ['uses' => 'VehiculoController@IngresoVehTaller']);
    $router->post('InspeccionCalidad',  ['uses' => 'VehiculoController@InspeccionCalidad']);
});

$router->group(['prefix' => 'Talleres'], function () use ($router) {
    $router->get('',  ['uses' => 'Talleres@showCatTalleres']);   
});
