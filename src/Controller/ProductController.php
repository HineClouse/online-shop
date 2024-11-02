<?php

namespace Controller;

use Model\Product;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    private function checkAuth()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }
    }

    public function showCart()
    {
        $this->checkAuth();

        $userId = $_SESSION['userId'];
        $products = $this->productModel->getCartProducts($userId);

        // Вычисляем общую сумму товаров в корзине
        $totalSum = 0;
        foreach ($products as $product) {
            $totalSum += $product->getPrice() * $product->getAmount();
        }

        require_once './../View/cart.php';
    }

    public function catalog()
    {
        $this->checkAuth();
        $products = $this->productModel->getAll();
        require_once './../View/catalog.php';
    }

    public function addProduct()
    {
        $this->checkAuth();

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

        $success = $this->productModel->addUserProduct($userId, $productId, $amount);

        if ($success) {
            $_SESSION['success'] = 'Товар успешно добавлен в корзину';
            header("Location:/cart");
        } else {
            $_SESSION['errors'] = ['Ошибка при добавлении товара'];
            header("Location:/catalog");
        }
        exit();
    }

    private function validateProduct()
    {
        $errors = [];

        if (!isset($_POST['product-id']) || !ctype_digit($_POST['product-id'])) {
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

        if (!isset($_POST['amount']) || !ctype_digit($_POST['amount'])) {
            $errors['amount'] = "Количество должно содержать только цифры";
        } else {
            $amount = (int)$_POST['amount'];
            if ($amount < 1) {
                $errors['amount'] = "Количество не может быть меньше 1";
            }
        }

        return $errors;
    }
}
