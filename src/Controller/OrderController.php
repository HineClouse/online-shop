<?php
namespace Controller;

use Model\Order;
use Model\Product;

class OrderController
{
    private Order $orderModel;
    private Product $productModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->productModel = new Product();
    }

    public function getOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }

        $allSum = $this->calculateTotalSum();
        require_once "./../View/order.php";
    }

    public function createOrder(): void
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['userId'];
        $errors = $this->validateOrder();

        if (empty($errors)) {
            $name = $_POST['firstName'];
            $family = $_POST['family'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $sum = $this->calculateTotalSum();

            if ($this->orderModel->createOrder($name, $family, $city, $address, $phone, $sum, $userId)) {
                $orderId = $this->orderModel->getByUserIdToTakeOrderId($userId);

                if ($orderId) {
                    $productsInCart = $this->productModel->getProductsByUserId($userId);
                    foreach ($productsInCart as $product) {
                        $this->orderModel->addProductToOrder(
                            $orderId,
                            $product['product_id'],
                            $product['amount'],
                            $product['price']
                        );
                    }

                    $this->productModel->deleteProduct($userId);
                    header('Location: /cart');
                    exit();
                }
            }
        }

        $allSum = $this->calculateTotalSum();
        require_once "./../View/order.php";
    }

    private function calculateTotalSum(): float
    {
        $userId = $_SESSION['userId'];
        $productsInCart = $this->productModel->getProductsByUserId($userId);

        $allSum = 0;
        foreach ($productsInCart as $product) {
            $allSum += $product['price'] * $product['amount'];
        }

        return $allSum;
    }

    private function validateOrder(): array
    {
        $errors = [];

        if (empty($_POST['firstName']) || strlen($_POST['firstName']) < 2 || strlen($_POST['firstName']) > 20 || !preg_match("/^[a-zA-Zа-яА-Я]+$/u", $_POST['firstName'])) {
            $errors['firstName'] = "Имя должно быть от 2 до 20 символов и содержать только буквы";
        }

        if (empty($_POST['family']) || strlen($_POST['family']) < 3 || strlen($_POST['family']) > 20 || !preg_match("/^[a-zA-Zа-яА-Я]+$/u", $_POST['family'])) {
            $errors['family'] = "Фамилия должна быть от 3 до 20 символов и содержать только буквы";
        }

        if (empty($_POST['city']) || strlen($_POST['city']) < 3 || strlen($_POST['city']) > 20 || !preg_match("/^[a-zA-Zа-яА-Я -]+$/u", $_POST['city'])) {
            $errors['city'] = "Город должен быть от 3 до 20 символов и содержать только буквы";
        }

        if (empty($_POST['address']) || strlen($_POST['address']) < 3 || strlen($_POST['address']) > 60 || !preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $_POST['address'])) {
            $errors['address'] = "Адрес должен быть от 3 до 60 символов и содержать только буквы и цифры";
        }

        if (empty($_POST['phone']) || strlen($_POST['phone']) < 3 || strlen($_POST['phone']) > 15 || !preg_match("/^[0-9]+$/u", $_POST['phone'])) {
            $errors['phone'] = "Номер телефона должен содержать от 3 до 15 цифр";
        }

        return $errors;
    }
}