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

    public function addProductToFavourites() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['userId'];
        $productId = $_POST['productId'];
        $amount = $_POST['amount'] ?? 1;

        if ($productId === null) {
            echo "Product ID is missing!";
            exit();
        }
        if ($amount === null) {
            echo "Amount is missing!";
            exit();
        }

        $price = $this->product->getByProductId((int)$productId);
        $isProductInFavourites = $this->favourites->getByUserIdAndProductId($userId, (int)$productId);

        if ($isProductInFavourites === false) {
            $this->favourites->addProductToFavourites($userId, (int)$productId, (int)$amount, $price['price']);
            header('Location: /favourites');
            exit();
        } else {
            $newAmount = $amount + $isProductInFavourites['amount'];
            $this->favourites->plusProductAmountInCart($userId, (int)$productId, $newAmount);
            header('Location: /favourites');
            exit();
        }
    }

    public function lookFavourites() {
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
                $product['amount'] = $elem['amount'];
                $productsInFavourites[] = $product;
            }
        }

        require_once "./../View/favourites.php";
    }

    public function deleteProductFromFavourites() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['userId'];
        $productId = $_POST['product-id'];
        $isProductInFavourites = $this->favourites->getByUserIdAndProductId($userId, (int)$productId);

        if ($isProductInFavourites) {
            $this->favourites->deleteProduct($userId, (int)$productId);
            header('Location: /favourites');
            exit();
        }
    }
}