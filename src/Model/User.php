<?php

namespace Model;

use PDO;

class User extends Model
{
    public function addUser($name, $email, $password)
    {
        if ($this->pdo) {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $result = $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
            if ($result) {
                return true;
            } else {
                var_dump($stmt->errorInfo()); // Добавим вывод ошибки
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists($email)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
