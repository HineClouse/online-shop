<?php

namespace Model;

use PDO;

class Favourites extends Model
{
    private int $userId;
    private int $productId;

    public function addProductToFavourites(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products_favourites (user_id, product_id) VALUES (:userId, :productId)");
        $result = $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        return $result;
    }

    public function getFavouritesByUserId(int $userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products_favourites WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserIdAndProductId(int $userId, int $productId): ?self
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products_favourites WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($data)) {
            return null;
        }
        return $this->hydrate($data);
    }

    public function deleteProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products_favourites WHERE user_id = :user_id AND product_id = :product");
        $stmt->execute(['user_id' => $userId, 'product' => $productId]);
    }

    private function hydrate(array $data): self
    {
        $obj = new self();
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        return $obj;
    }

    // Getters
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }
}
