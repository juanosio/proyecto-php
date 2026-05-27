<?php

namespace app\models;

class Product extends Model
{
    protected string $table = 'products';

    /**
     * obtener productos por nombre
     */
    public function getByName(string $name): array
    {
        $stmt = self::$pdo->prepare(
            "SELECT * FROM {$this->table} WHERE name LIKE :name"
        );
        $stmt->execute([':name' => "%{$name}%"]);
        return $stmt->fetchAll();
    }
}
