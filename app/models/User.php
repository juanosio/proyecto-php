<?php

namespace app\models;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): object|false
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function getAllUsers(): array
    {
        $stmt = self::$pdo->query("SELECT id, name, email, role, photo, created_at FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function updatePassword(int $id, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = self::$pdo->prepare("UPDATE {$this->table} SET password = :password WHERE id = :id");
        return $stmt->execute([':password' => $hash, ':id' => $id]);
    }

    public function updatePhoto(int $id, string $path): bool
    {
        $stmt = self::$pdo->prepare("UPDATE {$this->table} SET photo = :photo WHERE id = :id");
        return $stmt->execute([':photo' => $path, ':id' => $id]);
    }

    public function updateName(int $id, string $name): bool
    {
        $stmt = self::$pdo->prepare("UPDATE {$this->table} SET name = :name WHERE id = :id");
        return $stmt->execute([':name' => $name, ':id' => $id]);
    }
}
