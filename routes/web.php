<?php

use app\helpers\Auth;

// Públicas
$router->get('/', 'app\controllers\HomeController@index');

// Auth
$router->get('/login', 'app\controllers\AuthController@showLogin');
$router->post('/login', 'app\controllers\AuthController@login');
$router->get('/register', 'app\controllers\AuthController@showRegister');
$router->post('/register', 'app\controllers\AuthController@register');
$router->post('/logout', 'app\controllers\AuthController@logout');

// Recuperar contraseña
$router->get('/forgot-password', 'app\controllers\AuthController@showForgotPassword');
$router->post('/forgot-password', 'app\controllers\AuthController@forgotPassword');
$router->get('/reset-password/{token}', 'app\controllers\AuthController@showResetPassword');
$router->post('/reset-password', 'app\controllers\AuthController@resetPassword');

// Protegidas (requieren login)
$router->get('/dashboard', function () {
    Auth::requireLogin();
    $c = new \app\controllers\HomeController();
    $c->dashboard();
});
$router->get('/historial', function () {
    Auth::requireLogin();
    $c = new \app\controllers\HomeController();
    $c->historial();
});
$router->get('/historial/{id}', function ($id) {
    Auth::requireLogin();
    $c = new \app\controllers\HomeController();
    $c->historialDetalle($id);
});
$router->get('/canasta', function () {
    Auth::requireLogin();
    $c = new \app\controllers\HomeController();
    $c->canasta();
});
$router->get('/ranking', function () {
    Auth::requireLogin();
    $c = new \app\controllers\HomeController();
    $c->ranking();
});

// Perfil
$router->get('/perfil', 'app\controllers\AuthController@perfil');
$router->post('/perfil', 'app\controllers\AuthController@updatePerfil');
$router->post('/perfil/password', 'app\controllers\AuthController@updatePassword');
$router->post('/perfil/photo', 'app\controllers\AuthController@updatePhoto');

// Solo admin
$router->get('/admin/users', 'app\controllers\AdminController@users');
$router->post('/admin/reset/{id}', 'app\controllers\AdminController@resetPassword');

// API
$router->get('/api/status', function () {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'app' => 'chanchullapp', 'version' => '4.0.0']);
});
