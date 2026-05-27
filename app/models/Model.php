<?php

namespace app\models;

abstract class Model
{
    protected static ?\PDO $pdo = null;
    protected string $table = '';

    /**
     * inyecta la conexion pdo desde el front controller
     */
    public static function setPdo(\PDO $pdo): void
    {
        self::$pdo = $pdo;
    }

    /**
     * obtiene la conexion pdo actual
     */
    public static function getPdo(): ?\PDO
    {
        return self::$pdo;
    }

    /**
     * obtiene el nombre de la tabla
     * convierte "Product" en "products" por defecto
     */
    protected function getTable(): string
    {
        if ($this->table !== '') {
            return $this->table;
        }

        $class = (new \ReflectionClass($this))->getShortName();
        $snake = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $class));
        return $snake . 's';
    }

    /**
     * obtener todos los registros
     */
    public function getAll(): array
    {
        $stmt = self::$pdo->query("SELECT * FROM {$this->getTable()}");
        return $stmt->fetchAll();
    }

    /**
     * obtener un registro por su id
     */
    public function getById(int $id): object|false
    {
        $stmt = self::$pdo->prepare(
            "SELECT * FROM {$this->getTable()} WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * crear un nuevo registro
     * recibe un array asociativo [columna => valor]
     * devuelve el id del registro creado
     */
    public function create(array $data): string|false
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->getTable()} ({$columns}) VALUES ({$placeholders})";
        $stmt = self::$pdo->prepare($sql);

        $params = [];
        foreach ($data as $key => $value) {
            $params[":{$key}"] = $value;
        }

        $stmt->execute($params);
        return self::$pdo->lastInsertId();
    }

    /**
     * actualizar un registro existente
     * recibe el id y un array asociativo [columna => valor]
     */
    public function update(int $id, array $data): bool
    {
        $sets = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            $sets[] = "{$key} = :{$key}";
            $params[":{$key}"] = $value;
        }

        $sql = "UPDATE {$this->getTable()} SET "
            . implode(', ', $sets)
            . " WHERE id = :id";

        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * eliminar un registro por su id
     */
    public function delete(int $id): bool
    {
        $stmt = self::$pdo->prepare(
            "DELETE FROM {$this->getTable()} WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    /**
     * ejecutar una consulta sql personalizada con prepared statements
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
