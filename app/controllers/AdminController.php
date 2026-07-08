<?php

namespace app\controllers;

use app\helpers\Auth;
use app\models\User;

class AdminController
{
    public function users(): void
    {
        Auth::requireAdmin();
        global $blade;
        $userModel = new User();
        $users = $userModel->getAllUsers();
        echo $blade->render('admin.users', [
            'users' => $users,
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function resetPassword(int $id): void
    {
        Auth::requireAdmin();

        $tempPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
        $userModel = new User();
        $userModel->updatePassword($id, $tempPassword);

        $user = $userModel->getById($id);
        $name = $user ? $user->name : 'Usuario';

        header('Location: /admin/users?success=Contraseña de ' . urlencode($name) . ' reseteada a: ' . urlencode($tempPassword));
        exit;
    }
}
