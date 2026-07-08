<?php
/**
 * Setup de base de datos - ChanchullApp
 * Ejecutar: php scripts/setup-db.php
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helpers/db.php';

use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

// Conectar sin BD para crearla si no existe
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];

$pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo->exec("USE `$dbName`");

// ============================================================
// Aqui vas a crear tus tablas y relaciones
// ============================================================

$pdo->exec("
    CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(150) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `photo` VARCHAR(255) DEFAULT NULL,
        `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS `uploads` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `file_path` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS `password_resets` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(150) NOT NULL,
        `token` VARCHAR(255) NOT NULL,
        `expires_at` DATETIME NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ============================================================
// USUARIOS DE PRUEBA - Tiene que la tabla estar vacia para que se creen
// ============================================================

$count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

if ($count == 0) {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Administrador', 'admin@mail.com', password_hash('admin1234', PASSWORD_DEFAULT), 'admin']);
    $stmt->execute(['Usuario Demo', 'usuario@mail.com', password_hash('user1234', PASSWORD_DEFAULT), 'user']);
}

// Crear carpeta uploads si no existe
@mkdir(__DIR__ . '/../public/uploads', 0755, true);

echo "Listo pa! Base de datos '$dbName' configurada.\n";
