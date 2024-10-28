<?php
namespace Controller;

use Model\Product;

class ProductController {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    private function checkAuth() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }
    }

    public function catalog() {
        $this->checkAuth();
        $products = $this->productModel->getAll();
        require_once './../View/catalog.php';
    }

    public function addProduct() {
        $this->checkAuth();

        // Проверяем метод запроса
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location:/catalog");
            exit();
        }

        $errors = $this->validateProduct();
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location:/catalog");
            exit();
        }

        $userId = $_SESSION['userId'];
        $productId = (int)$_POST['product-id'];
        $amount = (int)$_POST['amount'];

        $currentAmount = $this->productModel->getUserProductAmount($userId, $productId);
        $success = false;

        if ($currentAmount > 0) {
            $newAmount = $currentAmount + $amount;
            $success = $this->productModel->updateUserProduct($userId, $productId, $newAmount);
        } else {
            $success = $this->productModel->addUserProduct($userId, $productId, $amount);
        }

        if ($success) {
            $_SESSION['success'] = 'Товар успешно добавлен в корзину';
            header("Location:/cart");
        } else {
            $_SESSION['errors'] = ['Ошибка при добавлении товара'];
            header("Location:/catalog");
        }
        exit();
    }

    private function validateProduct() {
        $errors = [];

        // Валидация product-id
        if (!isset($_POST['product-id'])) {
            $errors['product-id'] = 'Поле productId должно быть заполнено';
        } elseif (!ctype_digit($_POST['product-id'])) {
            $errors['product-id'] = "productId должно содержать только цифры";
        } else {
            $productId = (int)$_POST['product-id'];
            if ($productId < 1) {
                $errors['product-id'] = "productId не может быть меньше 1";
            } else {
                $maxId = $this->productModel->getMaxProductId();
                if ($maxId !== null && $productId > $maxId) {
                    $errors['product-id'] = "productId не должно превышать $maxId";
                }
            }
        }

        // Валидация amount
        if (!isset($_POST['amount'])) {
            $errors['amount'] = "Количество должно быть указано";
        } elseif (!ctype_digit($_POST['amount'])) {
            $errors['amount'] = "Количество должно содержать только цифры";
        } else {
            $amount = (int)$_POST['amount'];
            if ($amount < 1) {
                $errors['amount'] = "Количество не может быть меньше 1";
            } elseif ($amount > 100) {
                $errors['amount'] = "Количество не может превышать 100";
            }
        }

        return $errors;
    }

    public function showCart() {
        $this->checkAuth();

        $userId = $_SESSION['userId'];
        $products = $this->productModel->getProductsByUserId($userId);

        $totalSum = 0;
        foreach ($products as $product) {
            $totalSum += $product['sumproduct'];
        }

        require_once './../View/cart.php';
    }

    public function deleteProductFromCart() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit();
        }

        if (!isset($_POST['product-id']) || !ctype_digit($_POST['product-id'])) {
            $_SESSION['error'] = 'Неверный ID продукта';
            header('Location: /cart');
            exit();
        }

        $userId = $_SESSION['userId'];
        $productId = (int)$_POST['product-id'];

        $isProductInCart = $this->productModel->getByUserIdAndProductId($userId, $productId);
        if ($isProductInCart) {
            if ($this->productModel->deleteProduct($userId, $productId)) {
                $_SESSION['success'] = 'Товар успешно удален из корзины';
            } else {
                $_SESSION['error'] = 'Ошибка при удалении товара';
            }
        } else {
            $_SESSION['error'] = 'Товар не найден в корзине';
        }

        header('Location: /cart');
        exit();
    }
}