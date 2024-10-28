<?php
namespace Model;

use PDO;

class User extends Model {
    private int $id;
    private string $name;
    private string $password;
    private string $email;

    public function addUser(string $name, string $email, string $password): bool {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getUserByEmail(string $email): ?self {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM users WHERE email = :email"
            );
            $stmt->execute(['email' => $email]);
            $data = $stmt->fetch();

            if (!$data) {
                return null;
            }

            $user = new self();
            $this->hydrate($data, $user);
            return $user;
        } catch (PDOException $e) {
            throw new \RuntimeException('Failed to get user: ' . $e->getMessage());
        }
    }

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

    public function emailExists(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return (bool)$stmt->fetchColumn();
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
}
