<?php
namespace Model;

use PDO;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private string $image;
    private float $price;
    private int $amount;

    public function getAll(): array
    {
        $stmt = self::getPDO()->query("SELECT * FROM products");
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($productsData as $productData) {
            $product = new self();
            // Используем hydrate из родительского класса
            self::hydrate($productData, $product);
            $products[] = $product;
        }
        return $products;
    }

    public function getByProductId(int $productId): ?self
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productData) {
            $product = new self();
            // Используем hydrate из родительского класса
            self::hydrate($productData, $product);
            return $product;
        }
        return null;
    }

    public function getMaxProductId(): ?int
    {
        $stmt = self::getPDO()->query("SELECT MAX(id) FROM products");
        return $stmt->fetchColumn();
    }

    public function addUserProduct(int $userId, int $productId, int $amount): bool
    {
        $stmt = self::getPDO()->prepare("INSERT INTO cart (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        return $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getCartProducts(int $userId): array
    {
        $stmt = self::getPDO()->prepare("
        SELECT p.*, up.amount
        FROM products p
        JOIN user_products up ON p.id = up.product_id
        WHERE up.user_id = :userId
    ");
        $stmt->execute(['userId' => $userId]);
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($productsData as $productData) {
            $product = new self();
            self::hydrate($productData, $product);
            $products[] = $product;
        }
        return $products;
    }


    // Геттеры
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getImage(): string { return $this->image; }
    public function getPrice(): float { return $this->price; }
    public function getAmount(): int { return $this->amount; }

    // Сеттеры
    public function setId(int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setImage(string $image): void { $this->image = $image; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setAmount(int $amount): void { $this->amount = $amount; }
}
