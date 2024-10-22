<?php
namespace Controller;

use Model\Product;

class ProductController {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function catalog() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }
        $products = $this->productModel->getAll();
        require_once './../View/catalog.php';
    }

    public function addProduct() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }
        $errors = $this->validateProduct();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            $userId = $_SESSION['userId'];
            $productId = $_POST['product-id'];
            $amount = $_POST['amount'];
            $currentAmount = $this->productModel->getUserProductAmount($userId, $productId);
            if ($currentAmount > 0) {
                $newAmount = $currentAmount + $amount;
                $this->productModel->updateUserProduct($userId, $productId, $newAmount);
            } else {
                $this->productModel->addUserProduct($userId, $productId, $amount);
            }
            header("Location:/cart");
            exit();
        }
    }

    private function validateProduct(): array {
        $errors = [];
        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];
            if (empty($productId)) {
                $errors['product-id'] = "productId не должно быть пустым.";
            } elseif (!ctype_digit($productId)) {
                $errors['product-id'] = "productId должно содержать только цифры.";
            } elseif ($productId < 1) {
                $errors['product-id'] = "productId не может быть меньше 1";
            } else {
                $maxId = $this->productModel->getMaxProductId();
                if ($productId > $maxId) {
                    $errors['product-id'] = "productId не должно превышать $maxId.";
                }
            }
        } else {
            $errors['product-id'] = 'Поле productId должно быть заполнено';
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
            if (empty($amount)) {
                $errors['amount'] = "amount не должно быть пустым.";
            } elseif (!ctype_digit($amount)) {
                $errors['amount'] = "amount должно содержать только цифры.";
            } elseif ($amount < 1) {
                $errors['amount'] = "amount не может быть меньше 1";
            }
        }
        return $errors;
    }

    public function showCart() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            echo "User not logged in.";
            header("Location:/login");
            exit();
        }
        $userId = $_SESSION['userId'];
        $products = $this->productModel->getProductsByUserId($userId);
        $totalSum = 0;
        foreach ($products as $product) {
            $totalSum += $product['sumproduct'];
        }
        require_once './../View/cart.php';
    }

    public function deleteProductFromCart() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }
        $userId = $_SESSION['userId'];
        $productId = $_POST['product-id'];
        if ($productId === null) {
            echo "Product ID is missing!";
            exit();
        }
        $isProductInCart = $this->productModel->getByUserIdAndProductId($userId, (int)$productId);
        if ($isProductInCart) {
            $this->productModel->deleteProduct($userId, (int)$productId);
        }
        header('Location: /cart');
        exit();
    }
}
