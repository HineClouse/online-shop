<?php
namespace Model;

use PDO;
use PDOException;

class User extends Model {
    private int $id;
    private string $name;
    private string $password;
    private string $email;

    // Метод добавления пользователя в БД
    public static function addUser(string $name, string $email, string $password): bool {
        try {
            $stmt = self::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        } catch (PDOException $e) {
            throw new \RuntimeException('Ошибка при добавлении пользователя: ' . $e->getMessage());
        }
    }

    // Метод для получения пользователя по email
    public static function getUserByEmail(string $email): ?self {
        try {
            $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC); // добавлен режим возврата ассоциативного массива

            if (!$data) {
                return null;
            }

            $user = new self();
            self::hydrate($data, $user); // исправлен вызов метода
            return $user;
        } catch (PDOException $e) {
            throw new \RuntimeException('Ошибка при получении пользователя: ' . $e->getMessage());
        }
    }

    // Геттеры
    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getId(): int {
        return $this->id;
    }

    // Проверка существования email
    public static function emailExists(string $email): bool {
        try {
            $stmt = self::getPDO()->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new \RuntimeException('Ошибка при проверке существования email: ' . $e->getMessage());
        }
    }

    // Сеттеры с возвратом текущего объекта для "цепочек вызовов"
    public function setId(int $id): User {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): User {
        $this->name = $name;
        return $this;
    }

    public function setPassword(string $password): User {
        $this->password = $password;
        return $this;
    }

    public function setEmail(string $email): User {
        $this->email = $email;
        return $this;
    }
}