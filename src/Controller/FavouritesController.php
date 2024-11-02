<?php

namespace Controller;

use Model\Product;
use Model\Favourites;

class FavouritesController {
    private Product $product;
    private Favourites $favourites;

    public function __construct() {
        $this->product = new Product();
        $this->favourites = new Favourites();
    }

    public function getFavourites() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['userId'];
        $favouritesProducts = $this->favourites->getFavouritesByUserId($userId);
        $productsInFavourites = [];

        foreach ($favouritesProducts as $elem) {
            $product = $this->product->getByProductId((int)$elem['product_id']);
            if ($product) {
                $productsInFavourites[] = $product;
            }
        }

        require_once "./../View/favourites.php";
    }

    public function addProductToFavourites() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }

        $userId = $_SESSION['userId'];
        if (!isset($_POST['product-id'])) {
            $_SESSION['errors'] = ["Не указан идентификатор товара."];
            header("Location: /catalog");
            exit();
        }

        $productId = (int)$_POST['product-id'];

        // Проверка, существует ли продукт
        $product = $this->product->getByProductId($productId);
        if (!$product) {
            $_SESSION['errors'] = ["Товар с данным идентификатором не найден."];
            header("Location: /catalog");
            exit();
        }

        if ($this->favourites->addProductToFavourites($userId, $productId)) {
            $_SESSION['success'] = "Товар добавлен в избранное";
        } else {
            $_SESSION['errors'] = ["Не удалось добавить товар в избранное"];
        }

        header("Location: /catalog");
        exit();
    }

    public function deleteProduct() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }

        $userId = $_SESSION['userId'];
        if (!isset($_POST['product-id'])) {
            $_SESSION['errors'] = ["Не указан идентификатор товара."];
            header("Location: /favourites");
            exit();
        }

        $productId = (int)$_POST['product-id'];

        if ($this->favourites->deleteProduct($userId, $productId)) {
            $_SESSION['success'] = "Товар удален из избранного";
        } else {
            $_SESSION['errors'] = ["Не удалось удалить товар из избранного"];
        }

        header("Location: /favourites");
        exit();
    }
}
