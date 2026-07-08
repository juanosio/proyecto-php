<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

session_start([
    'cookie_lifetime' => 86400 * 7,
    'gc_maxlifetime'  => 86400 * 7,
]);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helpers/db.php';
require_once __DIR__ . '/../app/helpers/Auth.php';

use Dotenv\Dotenv;
use app\helpers\Auth;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$pdo = null;
$dbError = null;

try {
    $pdo = db();
    \app\models\Model::setPdo($pdo);
} catch (\Throwable $e) {
    $dbError = $e->getMessage();
    http_response_code(500);
    echo "<h1>Error de conexion a la base de datos</h1>";
    echo "<p>Asegurate de que XAMPP/MySQL este corriendo y de haber ejecutado: <code>php scripts/setup-db.php</code></p>";
    echo "<p style='color:#999;font-size:13px'>" . htmlspecialchars($dbError) . "</p>";
    exit;
}

$bladeContainer = new \Jenssegers\Blade\Container;
\Jenssegers\Blade\Container::setInstance($bladeContainer);
$blade = new \Jenssegers\Blade\Blade(
    __DIR__ . '/../views',
    __DIR__ . '/../cache',
    $bladeContainer
);

$blade->share('dbError', $dbError);
$blade->share('currentRoute', parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$blade->share('auth_logged', Auth::check());
$blade->share('auth_user', Auth::user());
$blade->share('auth_admin', Auth::isAdmin());
$blade->share('auth_user_name', Auth::userName());

$router = new \Bramus\Router\Router();

require_once __DIR__ . '/../routes/web.php';

$router->run();
