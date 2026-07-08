<?php

namespace app\helpers;

use app\models\User;

class Auth
{
    public static function login(object $user): void
    {
        $_SESSION['user_id'] = (int) $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['user_name'] = $user->name;
    }

    public static function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function userName(): ?string
    {
        return $_SESSION['user_name'] ?? null;
    }

    public static function userRole(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'admin';
    }

    public static function user(): ?object
    {
        if (!self::check()) return null;
        $model = new User();
        return $model->getById(self::userId()) ?: null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('Location: /');
            exit;
        }
    }
}
