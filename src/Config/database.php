<?php
namespace App\Config;

use PDO;

class Database {
    public static function conn(): PDO {
     
        $host = '127.0.0.1';
        $port = 3308;        
        $db   = 'users';       
        $user = 'root';
        $pass = '';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
}
