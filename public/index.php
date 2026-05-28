<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// 1. cargar variables de entorno desde .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// 2. conectar a mysql con pdo
$pdo = null;
$dbError = null;

try {
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $_ENV['DB_HOST'] ?? '127.0.0.1',
            $_ENV['DB_PORT'] ?? '3306',
            $_ENV['DB_NAME'] ?? 'chanchullapp'
        ),
        $_ENV['DB_USER'] ?? 'root',
        $_ENV['DB_PASS'] ?? '',
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

    \app\models\Model::setPdo($pdo);

} catch (PDOException $e) {
    $dbError = $e->getMessage();
}

// 3. inicializar motor de plantillas blade
$bladeContainer = new \Jenssegers\Blade\Container;
\Jenssegers\Blade\Container::setInstance($bladeContainer);
$blade = new \Jenssegers\Blade\Blade(
    __DIR__ . '/../views',
    __DIR__ . '/../cache',
    $bladeContainer
);

// pasar errores a las vistas
$blade->share('dbError', $dbError);

// 4. inicializar enrutador
$router = new \Bramus\Router\Router();

// 5. cargar rutas
require_once __DIR__ . '/../routes/web.php';

// 6. ejecutar
$router->run();
