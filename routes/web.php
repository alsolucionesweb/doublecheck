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

$router->post('/login', 'Auth\AuthController@login');
$router->get('/login', 'Auth\AuthController@showLoginForm');

$router->get('/indicadores/candidato/{id}', 'CandidatoIndicadorController@indicadoresCandidato');


$router->group(['middleware' => 'session.auth'], function () use ($router) {  
    $router->get('/', 'HomeController@index');
    $router->get('/candidato/{id}', 'HomeController@getCandidato');    
});

$router->group(['prefix' => 'admin','middleware' => 'admin'], function () use ($router) {

    $router->post('/indicadores/candidato', 'CandidatoIndicadorController@post');
    
    $router->group(['prefix' => 'candidatos'], function () use ($router) {
        $router->get('', 'CandidatosController@index');
        $router->post('', 'CandidatosController@post');        
        $router->post('/editar', 'CandidatosController@put');
        $router->post('/eliminar', 'CandidatosController@delete');
    });

    $router->group(['prefix' => 'indicadores'], function () use ($router) {
        $router->get('', 'IndicadoresController@index');
        $router->post('', 'IndicadoresController@post');        
        $router->post('/editar', 'IndicadoresController@put');
        $router->post('/eliminar', 'IndicadoresController@delete');
    });

    $router->group(['prefix' => 'descargable'], function () use ($router) {
        $router->get('', 'DescargableController@index');
        $router->post('', 'DescargableController@post');        
        $router->post('/editar', 'DescargableController@put');
        $router->post('/eliminar', 'DescargableController@delete');
    });

    $router->group(['prefix' => 'tendencias'], function () use ($router) {
        $router->get('', 'TendenciasController@index');
        $router->post('', 'TendenciasController@post');        
        $router->post('/editar', 'TendenciasController@put');
        $router->post('/eliminar', 'TendenciasController@delete');
    });

});

$router->get('/logout', function () {
    
    session_destroy();
    return redirect('/login');
});

$router->get('/check-session', function () {
    dd(session('error'));
});

$router->get('/test-lottery', function () {
    return config('session.lottery');
});

$router->post('/send-otp', 'OtpController@sendOtp');
$router->get('/oauth', 'OtpController@auth');
$router->get('/oauth-callback', 'OtpController@callback');
