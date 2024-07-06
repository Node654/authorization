<?php

namespace Auth\Database;

class Database
{
    private static \PDO $pdo;

    public static function db()
    {
        $params = require ROOT . '/config/db.php';
        $dsn = "{$params['driver']}:host={$params['host']};dbname={$params['dbname']}";
        self::$pdo = new \PDO($dsn, $params['user'], $params['pass']);
        return self::$pdo;
    }
}