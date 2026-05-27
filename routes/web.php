<?php

// ruta principal - pagina de bienvenida
$router->get('/', 'app\controllers\HomeController@index');

// ruta de ejemplo - estado del sistema
$router->get('/api/status', function () {
    header('Content-Type: application/json');
    echo json_encode([
        'status'  => 'ok',
        'app'     => 'smartparse ocr',
        'version' => '1.0.0',
    ]);
});
