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
    $router->post('Entregado',  ['uses' => 'VehiculoController@Entregado']);
    $router->post('getListasPiezas',  ['uses' => 'VehiculoController@getListasPiezas']);
    
});

$router->group(['prefix' => 'Talleres'], function () use ($router) {
    $router->get('',  ['uses' => 'Talleres@showCatTalleres']);   
    $router->post('add',  ['uses' => 'Talleres@addTallere']);
    $router->post('updteTalleres',  ['uses' => 'Talleres@updteTalleres']);
});

$router->group(['prefix' => 'evidencias'], function () use ($router) {
    $router->post('',  ['uses' => 'EvidenciaController@showBitEvidencias']);   
});

$router->group(['prefix' => 'estatus'], function () use ($router) {
   $router->get('inspecciones/{id}',  ['uses' => 'BitLogEstatusControllers@showInspecciones']);
});

$router->group(['prefix' => 'catalogosFormularios'], function () use ($router) {
   $router->get('',  ['uses' => 'VehiculoController@catalogosFormularios']);
});


$router->group(['prefix' => 'prueba'], function () use ($router) {
   $router->get('',  ['uses' => 'VehiculoController@PruebaFechas']);
});

$router->group(['prefix' => 'DashBoard'], function () use ($router) {
   $router->post('',  ['uses' => 'DashBoardController@getInfoGeneralReport']);
});

