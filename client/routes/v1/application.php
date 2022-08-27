<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->group([
    'middleware' => ['auth'],
    'namespace' => 'v1',
    'prefix' => '/api/v1/client/application',
], function (Router $router) {
    $router->get('/all', 'ApplicationController@index');
    $router->post('/create', 'ApplicationController@store');
    $router->get('/detail/{app_code}', 'ApplicationController@show');
    $router->put('/update/{app_cod}', 'ApplicationController@update');
    $router->delete('/delete/{app_cod}', 'ApplicationController@destroy');
    //Client Application Version routes
    $router->group([
        'prefix' => '/{app_code}/version',
    ], function () use ($router) {
        $router->get('/all', 'VersionController@index');
        $router->post('/create', 'VersionController@store');
        $router->get('/detail/{version}', 'VersionController@show');
        $router->put('/update/{version}', 'VersionController@update');
        $router->delete('/delete/{version}', 'VersionController@destroy');
    });
});
