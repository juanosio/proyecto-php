<?php

namespace app\controllers;

use app\helpers\Auth;
use app\models\User;

class AuthController
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            header('Location: /dashboard');
            exit;
        }
        global $blade;
        echo $blade->render('auth.login', ['error' => $_GET['error'] ?? null]);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            header('Location: /login?error=Completa todos los campos');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            header('Location: /login?error=Email o contraseña incorrectos');
            exit;
        }

        Auth::login($user);
        header('Location: /dashboard');
        exit;
    }

    public function showRegister(): void
    {
        if (Auth::check()) {
            header('Location: /dashboard');
            exit;
        }
        global $blade;
        echo $blade->render('auth.register', ['error' => $_GET['error'] ?? null]);
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$name || !$email || !$password || !$confirm) {
            header('Location: /register?error=Completa todos los campos');
            exit;
        }

        if ($password !== $confirm) {
            header('Location: /register?error=Las contraseñas no coinciden');
            exit;
        }

        if (strlen($password) < 6) {
            header('Location: /register?error=La contraseña debe tener al menos 6 caracteres');
            exit;
        }

        $userModel = new User();
        $existing = $userModel->findByEmail($email);
        if ($existing) {
            header('Location: /register?error=Este email ya está registrado');
            exit;
        }

        $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
        ]);

        header('Location: /login?success=Cuenta creada exitosamente');
        exit;
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function perfil(): void
    {
        Auth::requireLogin();
        global $blade;
        $user = Auth::user();
        echo $blade->render('auth.perfil', [
            'user' => $user,
            'success' => $_GET['success'] ?? null,
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function updatePerfil(): void
    {
        Auth::requireLogin();
        $name = trim($_POST['name'] ?? '');

        if (!$name) {
            header('Location: /perfil?error=El nombre no puede estar vacío');
            exit;
        }

        $userModel = new User();
        $userModel->updateName(Auth::userId(), $name);
        $_SESSION['user_name'] = $name;

        header('Location: /perfil?success=Perfil actualizado');
        exit;
    }

    public function updatePassword(): void
    {
        Auth::requireLogin();
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$current || !$new || !$confirm) {
            header('Location: /perfil?error=Completa todos los campos de contraseña');
            exit;
        }

        if ($new !== $confirm) {
            header('Location: /perfil?error=Las nuevas contraseñas no coinciden');
            exit;
        }

        if (strlen($new) < 6) {
            header('Location: /perfil?error=La nueva contraseña debe tener al menos 6 caracteres');
            exit;
        }

        $userModel = new User();
        $user = $userModel->getById(Auth::userId());

        if (!password_verify($current, $user->password)) {
            header('Location: /perfil?error=La contraseña actual es incorrecta');
            exit;
        }

        $userModel->updatePassword(Auth::userId(), $new);
        header('Location: /perfil?success=Contraseña actualizada');
        exit;
    }

    public function updatePhoto(): void
    {
        Auth::requireLogin();

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            header('Location: /perfil?error=No se pudo subir la imagen');
            exit;
        }

        $file = $_FILES['photo'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($file['type'], $allowed)) {
            header('Location: /perfil?error=Formato no válido (usa JPG, PNG, GIF o WebP)');
            exit;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            header('Location: /perfil?error=La imagen no puede superar 5MB');
            exit;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . Auth::userId() . '_' . time() . '.' . $ext;
        $uploadDir = __DIR__ . '/../../public/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            header('Location: /perfil?error=Error al guardar la imagen');
            exit;
        }

        $userModel = new User();
        $userModel->updatePhoto(Auth::userId(), '/uploads/' . $filename);

        header('Location: /perfil?success=Foto de perfil actualizada');
        exit;
    }

    public function showForgotPassword(): void
    {
        if (Auth::check()) {
            header('Location: /dashboard');
            exit;
        }
        global $blade;
        echo $blade->render('auth.forgot-password', [
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
            'reset_link' => $_GET['reset_link'] ?? null,
        ]);
    }

    public function forgotPassword(): void
    {
        $email = trim($_POST['email'] ?? '');

        if (!$email) {
            header('Location: /forgot-password?error=Ingresa tu email');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Por seguridad, siempre mostrar el mismo mensaje
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $pdo = \app\models\Model::getPdo();
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 MINUTE))");
            $stmt->execute([$email, $token]);

            $resetLink = '/reset-password/' . $token;
            header('Location: /forgot-password?success=1&reset_link=' . urlencode($resetLink));
            exit;
        }

        header('Location: /forgot-password?success=1');
        exit;
    }

    public function showResetPassword(string $token): void
    {
        global $blade;
        $pdo = \app\models\Model::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() ORDER BY id DESC LIMIT 1");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if (!$reset) {
            header('Location: /forgot-password?error=El enlace expiró o no es válido');
            exit;
        }

        echo $blade->render('auth.reset-password', [
            'token' => $token,
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function resetPassword(): void
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$token || !$password || !$confirm) {
            header('Location: /reset-password/' . $token . '?error=Completa todos los campos');
            exit;
        }

        if ($password !== $confirm) {
            header('Location: /reset-password/' . $token . '?error=Las contraseñas no coinciden');
            exit;
        }

        if (strlen($password) < 6) {
            header('Location: /reset-password/' . $token . '?error=La contraseña debe tener al menos 6 caracteres');
            exit;
        }

        $pdo = \app\models\Model::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() ORDER BY id DESC LIMIT 1");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if (!$reset) {
            header('Location: /forgot-password?error=El enlace expiró o no es válido');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($reset->email);

        if ($user) {
            $userModel->updatePassword((int) $user->id, $password);
        }

        // Eliminar el token usado
        $del = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        $del->execute([$token]);

        header('Location: /login?success=Contraseña actualizada. Ya puedes iniciar sesión');
        exit;
    }
}
