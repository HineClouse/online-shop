<?php
namespace Model;

use \PDO;

class Product {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
    }

    public function getAllProducts() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaxProductId() {
        $stmt = $this->pdo->query("SELECT MAX(id) FROM products");
        return $stmt->fetch(PDO::FETCH_ASSOC)['max'] ?? 0;
    }

    public function addUserProduct($userId, $productId, $amount) {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function updateUserProduct($userId, $productId, $amount) {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public function getUserProductAmount($userId, $productId) {
        $stmt = $this->pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['amount'] ?? 0;
    }
}
