<?php

namespace Model;

use PDO;
use PDOException;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private string $image;
    private float $price;
    private int $amount;


    public static function getAll(): array
    {
        $stmt = self::getPDO()->query("SELECT * FROM products ORDER BY id");
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($productsData as $productData) {
            $product = new self();
            self::hydrate($productData, $product);
            $products[] = $product;
        }
        return $products;
    }

    // Получение продукта по ID
    public static function getByProductId(int $productId): ?self
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productData) {
            $product = new self();
            self::hydrate($productData, $product);
            return $product;
        }
        return null;
    }

    // Добавление нового продукта в БД
    public static function addProduct(ProductRequest $request): bool
    {

            $stmt = self::getPDO()->prepare("
                INSERT INTO products (name, description, image, price, amount)
                VALUES (:name, :description, :image, :price, :amount)
            ");

            return $stmt->execute([
                'name' => $request->getName(),
                'description' => $request->getDescription(),
                'image' => $request->getImage(),
                'price' => $request->getPrice(),
                'amount' => $request->getAmount()
            ]);

    }

    // Обновление информации о продукте в БД
    public static function updateProduct(int $id, ProductRequest $request): bool
    {

            $stmt = self::getPDO()->prepare("
                UPDATE products 
                SET name = :name, description = :description, image = :image, price = :price, amount = :amount
                WHERE id = :id
            ");

            return $stmt->execute([
                'id' => $id,
                'name' => $request->getName(),
                'description' => $request->getDescription(),
                'image' => $request->getImage(),
                'price' => $request->getPrice(),
                'amount' => $request->getAmount()
            ]);

    }

    // Удаление продукта из БД
    public static function deleteProduct(int $productId): bool
    {

            $stmt = self::getPDO()->prepare("DELETE FROM products WHERE id = :id");
            return $stmt->execute(['id' => $productId]);
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
