<?php

$router->get('/', 'app\controllers\HomeController@index');
$router->get('/dashboard', 'app\controllers\HomeController@dashboard');
$router->get('/historial', 'app\controllers\HomeController@historial');
$router->get('/historial/{id}', 'app\controllers\HomeController@historialDetalle');
$router->get('/canasta', 'app\controllers\HomeController@canasta');
$router->get('/ranking', 'app\controllers\HomeController@ranking');
$router->get('/perfil', 'app\controllers\HomeController@perfil');

$router->get('/api/status', function () {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'app' => 'chanchullapp', 'version' => '3.0.0']);
});
