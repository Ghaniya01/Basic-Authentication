<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

final class Database extends PDO
{
    public PDO $db;

    public function __construct()
    {
        // Required env vars (fail fast; no defaults)
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? throw new RuntimeException('Missing DB_HOST');
        $port = (int)($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? throw new RuntimeException('Missing DB_PORT'));
        $name = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? throw new RuntimeException('Missing DB_NAME');
        $user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? throw new RuntimeException('Missing DB_USER');
        $pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? throw new RuntimeException('Missing DB_PASS');
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        $dsn  = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
        $opts = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}",
        ];

        try {
            parent::__construct($dsn, $user, $pass, $opts);
            $this->db = $this;
        } catch (PDOException) {
            throw new PDOException('Database connection failed.');
        }
    }

    /** Prepare + execute and return the statement. */
    public function run(string $sql, array $params = [], array $options = []): PDOStatement
    {
        $stmt = parent::prepare($sql, $options);
        $stmt->execute($params);
        return $stmt;
    }


    /** Execute an INSERT and return last insert id */
    public function insert(string $sql, array $params = []): string
    {
        $this->run($sql, $params);
        return $this->lastInsertId();
    }

   
}
