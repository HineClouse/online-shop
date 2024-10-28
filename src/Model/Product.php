<?php
namespace Model;

use PDO;

class Product extends Model {
    private int $id;
    private Product $product;

    private User $user;

    private int $amount;

    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
        $this->user = new User();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM products");

        $products = $stmt->fetchAll();
        if(empty($products)){
            return null;
        }
        foreach ($products as &$product) {
            $product = $this->hydrate($product);
        }

        return $products;
    }

    public function getMaxProductId() {
        $stmt = $this->pdo->query("SELECT MAX(id) as max_id FROM products");
        $result = $stmt->fetch();

        if (empty($result)) {
            return null;
        }
        return $this->hydrate($result);
    }

    // Проверка существования продукта и пользователя перед операциями
    private function checkUserAndProduct($userId, $productId) {
        // Проверяем пользователя
        $userStmt = $this->pdo->prepare("SELECT id FROM users WHERE id = :user_id");
        $userStmt->execute(['user_id' => $userId]);
        if (!$userStmt->fetch()) {
            return false;
        }

        // Проверяем продукт
        $productStmt = $this->pdo->prepare("SELECT id FROM products WHERE id = :product_id");
        $productStmt->execute(['product_id' => $productId]);
        if (!$productStmt->fetch()) {
            return false;
        }

        return true;
    }

    public function addUserProduct($userId, $productId, $amount) {
        if (!$this->checkUserAndProduct($userId, $productId)) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'amount' => $amount
        ]);
    }

    public function updateUserProduct($userId, $productId, $amount) {
        if (!$this->checkUserAndProduct($userId, $productId)) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute([
            'amount' => $amount,
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    public function getUserProductAmount($userId, $productId) {
        $stmt = $this->pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        $result = $stmt->fetch();
        return $result ? (int)$result['amount'] : 0;
    }

    public function getProductsByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.name AS productname,
                p.image AS image,
                p.description,
                p.price,
                u.name AS userName,
                up.amount,
                up.product_id AS productid,
                (p.price * up.amount) AS sumproduct
            FROM user_products up
            JOIN users u ON u.id = up.user_id
            JOIN products p ON p.id = up.product_id
            WHERE up.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getByProductId($productId) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $product = $stmt->fetch();
        if ($product) {
            return $this->hydrate($product);
        }
        return null;
    }

    public function getByUserIdAndProductId($userId, $productId) {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        return $stmt->fetch();
    }

    public function deleteProduct($userId, $productId) {
        if (!$this->checkUserAndProduct($userId, $productId)) {
            return false;
        }

        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    private function hydrate($data) {
        $obj = new self();
        $obj->id = (int)$data['id'];
        $obj->name = $data['name'];
        $obj->description = $data['description'];
        $obj->image = $data['image'];
        $obj->price = (float)$data['price'];
        return $obj;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function setImage(string $image): Product
    {
        $this->image = $image;
        return $this;
    }

    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }
}