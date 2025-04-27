<?php
namespace App;

use PDO;
use PDOException;

abstract class Model
{
    protected $db;
    protected $table;
    protected array $fillable = [];

    public function __construct()
    {
        $host = Config::getValue('db_host');
        $user = Config::getValue('db_user');
        $pass = Config::getValue('db_pass');
        $db = Config::getValue('db_name');

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public function create(array $data): int
    {
        $data = $this->filterFillable($data);

        $columns = array_keys($data);
        $columnList = implode(', ', $columns);
        $placeholders = implode(', ', array_map(fn($col) => ":$col", $columns));

        $sql = "INSERT INTO {$this->table} ($columnList) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);

        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }
        $setClause = implode(', ', $setParts);

        $sql = "UPDATE {$this->table} SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_filter(
            $data,
            fn($key) => in_array($key, $this->fillable, true),
            ARRAY_FILTER_USE_KEY
        );
    }
}
