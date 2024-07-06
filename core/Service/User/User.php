<?php

namespace Auth\Service\User;

use Auth\Database\Database;
use PDO;

class User
{
    public static function exists(string $table, string $field, string $value): bool
    {
        $stmt = Database::db()->prepare("SELECT COUNT(*) FROM $table WHERE $field = :value");
        $stmt->execute([':value' => $value]);
        $count = $stmt->fetchColumn();
        return $count === 0;
    }

    public static function insert(string $table, array $data) {
        $keys = implode(', ', array_keys($data));
        $values = ':'.implode(', :', array_keys($data));

        $stmt = Database::db()->prepare("INSERT INTO $table ($keys) VALUES ($values)");
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
    }

    public static function checkEmailExists($email) {
        $stmt = Database::db()->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public static function checkPhoneExists($phone) {
        $stmt = Database::db()->prepare("SELECT COUNT(*) FROM users WHERE phone = :phone");
        $stmt->execute(['phone' => $phone]);
        return $stmt->fetchColumn() > 0;
    }

    public static function validatePasswordByEmail($email, $password) {
        $stmt = Database::db()->prepare("SELECT password FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $hashed_password = $stmt->fetchColumn();
        return password_verify($password, $hashed_password);
    }

    public static function validatePasswordByPhone($phone, $password) {
        $stmt = Database::db()->prepare("SELECT password FROM users WHERE phone = :phone");
        $stmt->execute(['phone' => $phone]);
        $hashed_password = $stmt->fetchColumn();
        return password_verify($password, $hashed_password);
    }

    public static function getUserByEmailOrPhone($emailOrPhone) {
        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            $stmt = Database::db()->prepare("SELECT id, name, phone, email FROM users WHERE email = :emailOrPhone LIMIT 1");
        } else {
            $stmt = Database::db()->prepare("SELECT id, name, phone, email FROM users WHERE phone = :emailOrPhone LIMIT 1");
        }

        $stmt->execute([':emailOrPhone' => $emailOrPhone]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        return $user ?? null;
    }

    public static function select(string $table, array $data = [])
    {
        $sql = "SELECT * FROM {$table}";
        $conditions = [];
        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
        }

        $conditions = implode(' AND ', $conditions);

        if (! empty($conditions)) {
            $sql .= " WHERE {$conditions}";
        }

        $stmt = Database::db()->prepare($sql);

        $stmt->execute($data);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results ?? null;
    }

    public static function update(string $table, array $data = [])
    {
        $conditions = [];
        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
        }
        $conditions = implode(', ', $conditions);
        $sql = "UPDATE {$table} SET $conditions WHERE id = :id";
        $stmt = Database::db()->prepare($sql);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->execute($data);
    }

    public static function checkedUser()
    {
        if (! isset($_SESSION['auth'])) {
            header('Location: /');
            die;
        }
    }
}


