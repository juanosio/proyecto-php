<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();
$pdo = new PDO('mysql:host='.$_ENV['DB_HOST'].';port='.$_ENV['DB_PORT'].';dbname='.$_ENV['DB_NAME'].';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASS']);
$stmt = $pdo->query('SELECT token FROM password_resets ORDER BY id DESC LIMIT 1');
echo $stmt->fetchColumn();
