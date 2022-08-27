<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->group([
    'namespace' => 'Auth',
    'prefix' => '/api/auth',
], function (Router $router) {
    $router->post('/register', 'RegisterController@register');
    $router->get('/verify', 'AuthController@verifyCode');
    $router->post('/login', 'AuthController@login');
    $router->post('/logout', ['middleware' => 'auth', 'uses' => 'AuthController@logout']);
    $router->get('/rest-password', 'ResetPasswordController@resetPassword');
    $router->get('/rest-password-verification', 'ResetPasswordController@verifyResetPassword');
    $router->post('/change-password', 'ResetPasswordController@changePassword');
});
