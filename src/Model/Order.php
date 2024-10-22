<?php

namespace Model;

use PDO;

class Order extends Model
{
    private int $id;
    private string $name;
    private string $family;
    private string $city;
    private string $address;
    private string $phone;
    private float $sum;
    private int $userId;

    public function createOrder($name, $family, $city, $address, $phone, $sum, $userId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (name, family, city, address, phone, sum, user_id) VALUES (:name, :family, :city, :address, :phone, :sum, :user_id)");
        $result = $stmt->execute(['name' => $name, 'family' => $family, 'city' => $city, 'address' => $address, 'phone' => $phone, 'sum' => $sum, 'user_id' => $userId]);
        return $result;
    }

    public function getOrderById($orderId): ?self
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id = :id');
        $stmt->execute(['id' => $orderId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($data)) {
            return null;
        }
        return $this->hydrate($data);
    }

    public function getOrdersByUserId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProductToOrder(int $orderId, int $productId, int $amount, float $price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
    }

    private function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->family = $data['family'];
        $obj->city = $data['city'];
        $obj->address = $data['address'];
        $obj->phone = $data['phone'];
        $obj->sum = $data['sum'];
        $obj->userId = $data['user_id'];
        return $obj;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamily(): string
    {
        return $this->family;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
