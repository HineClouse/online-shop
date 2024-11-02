<?php

namespace Model;

use PDO;

class Favourites extends Model
{
    private int $userId;
    private int $productId;

    public function addProductToFavourites(int $userId, int $productId): bool {
        // Проверка на существование продукта перед добавлением
        $stmt = self::getPDO()->prepare("SELECT COUNT(*) FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        if ($stmt->fetchColumn() == 0) {
            return false; // Продукт не существует
        }

        $stmt = self::getPDO()->prepare("INSERT INTO user_products_favourites (user_id, product_id) VALUES (:userId, :productId)");
        return $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function getFavouritesByUserId(int $userId): array {
        $stmt = self::getPDO()->prepare("SELECT * FROM user_products_favourites WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProduct(int $userId, int $productId): bool {
        $stmt = self::getPDO()->prepare("DELETE FROM user_products_favourites WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }
}
