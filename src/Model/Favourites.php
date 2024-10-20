<?php
namespace Model;

class Favourites extends Model {
    public function getByUserIdAndProductId(int $userId, int $productId) {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products_favourites WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch();
    }

    public function addProductToFavourites(int $user, int $product, int $amount, int $price) {
        $stmt = $this->pdo->prepare("INSERT INTO user_products_favourites (user_id, product_id, amount, price) VALUES (:userId, :productId, :amount, :price)");
        $stmt->execute(['userId' => $user, 'productId' => $product, 'amount' => $amount, 'price' => $price]);
    }

    public function updateProductAmountInCart(int $user, int $product, int $amount) {
        $stmt = $this->pdo->prepare("UPDATE user_products_favourites SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['userId' => $user, 'productId' => $product, 'amount' => $amount]);
    }

    public function getFavouritesByUserId(int $user) {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products_favourites WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user]);
        return $stmt->fetchAll();
    }

    public function deleteProduct(int $user, int $product) {
        $stmt = $this->pdo->prepare("DELETE FROM user_products_favourites WHERE user_id = :user_id AND product_id = :product");
        $stmt->execute(['user_id' => $user, 'product' => $product]);
    }
}
