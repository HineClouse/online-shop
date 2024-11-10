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

    public function createOrder(): bool
    {
        $stmt = self::getPDO()->prepare("
            INSERT INTO orders (name, family, city, address, phone, sum, user_id) 
            VALUES (:name, :family, :city, :address, :phone, :sum, :user_id)
        ");

        return $stmt->execute([
            'name' => $this->name,
            'family' => $this->family,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'sum' => $this->sum,
            'user_id' => $this->userId
        ]);
    }

    public function getOrderById(int $orderId): ?self
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $orderId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }

        $order = new self();
        self::hydrate($data, $order);
        return $order;
    }

    public function getOrdersByUserId(int $userId): array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProductToOrder(int $orderId, int $productId, int $amount, float $price): bool
    {
        $stmt = self::getPDO()->prepare("
            INSERT INTO order_products (order_id, product_id, amount, price) 
            VALUES (:order_id, :product_id, :amount, :price)
        ");

        return $stmt->execute([
            'order_id' => $orderId,
            'product_id' => $productId,
            'amount' => $amount,
            'price' => $price
        ]);
    }

    public function getByUserIdToTakeOrderId(int $userId): ?int
    {
        $stmt = self::getPDO()->prepare("
            SELECT id FROM orders 
            WHERE user_id = :user_id 
            ORDER BY id DESC 
            LIMIT 1
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn() ?: null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Order
    {
        $this->name = $name;
        return $this;
    }

    public function getFamily(): string
    {
        return $this->family;
    }

    public function setFamily(string $family): Order
    {
        $this->family = $family;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): Order
    {
        $this->city = $city;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Order
    {
        $this->address = $address;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Order
    {
        $this->phone = $phone;
        return $this;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): Order
    {
        $this->sum = $sum;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): Order
    {
        $this->userId = $userId;
        return $this;
    }


}
