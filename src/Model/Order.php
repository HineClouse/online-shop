<?php
namespace Model;

use PDO;

class Order extends Model
{
    public function createOrder($data) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (contact_name, contact_phone, city, street, number_house, stage, apartment, comment, total_sum, user_id) 
                                     VALUES (:contact_name, :contact_phone, :city, :street, :number_house, :stage, :apartment, :comment, :total_sum, :user_id)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function addOrderProduct($orderId, $productId, $amount, $price) {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) 
                                     VALUES (:order_id, :product_id, :amount, :price)");
        return $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
    }

    public function getOrderById($orderId) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderProducts($orderId) {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
