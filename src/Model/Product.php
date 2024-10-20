<?php

namespace Model;

use \PDO;

class Product extends Model
{
    public function getAllProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    public function getMaxProductId()
    {
        $stmt = $this->pdo->query("SELECT MAX(id) FROM products");
        return $stmt->fetch()['max'] ?? null;
    }

    public function addUserProduct($userId, $productId, $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function updateUserProduct($userId, $productId, $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public function getUserProductAmount($userId, $productId)
    {
        $stmt = $this->pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch()['amount'] ?? 0;
    }


    public function getProductsByUserId($userId)
    {
        $stmt = $this->pdo->prepare("SELECT 
                                        products.name AS productname, 
                                        products.image AS image, 
                                        products.description, 
                                        products.price, 
                                        users.name AS userName, 
                                        user_products.amount,
                                        (products.price * user_products.amount) AS sumproduct
                                     FROM user_products
                                     JOIN users ON users.id = user_products.user_id
                                     JOIN products ON products.id = user_products.product_id
                                     WHERE user_products.user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getByProductId(int $productId) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetch();
    }
    public function deleteProduct(int $user, int $product) {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user, 'product' => $product]);
    }
    public function getByUserIdAndProductId(int $userId, int $productId) {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch();
    }

}
