<?php
namespace Controller;

use Model\Order;
use Model\Product;

class OrderController {
    private $orderModel;
    private $productModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->productModel = new Product();
    }

    public function getOrderForm()
    {
        session_start();
        $userId = $_SESSION['userId'];
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        } else{
            $allSum = $this->allSum();
            require_once "./../View/order.php";
        }
    }

    public function createOrder() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['userId'];
        $errors = $this->validateOrder();
        if (empty($errors)) {
            $name = $_POST['name'];
            $family = $_POST['family'];
            $city = $_POST['city'];
            $address = $_POST['street'] . ' ' . $_POST['number_house'] . ', ' . $_POST['stage'] . ', ' . $_POST['apartment'];
            $phone = $_POST['phone'];
            $sum = $_POST['all_sum'];

            $this->orderModel->createOrderId($name, $family, $city, $address, $phone, $sum, $userId);

            $orderId = $this->orderModel->getByUserIdToTakeOrderId($userId);
            $productsInCart = $this->productModel->getProductsByUserId($userId);
            foreach ($productsInCart as $product) {
                $this->orderModel->sendProductToOrder($orderId['id'], $product['product_id'], $product['amount'], $product['price']);
            }

            $this->productModel->deleteProduct($userId);
            header('Location: /cart');
            exit();
        }

        $allSum = $this->allSum();
        require_once "./../View/order.php";
    }



    private function allSum()
    {
        $userId = $_SESSION['userId'];

        $productsInCart = $this->productModel->getProductsByUserId($userId);

        $allSum=0;
        foreach($productsInCart as $product){
            $sum = $product['price'] * $product['amount'];
            $allSum += $sum;
        }
        return $allSum;
    }

    private function validateOrder(): array
    {
        $errors = [];

        if (isset($_POST['firstName'])) {
            $name = $_POST['firstName'];
            if (empty($name)){
                $errors['firstName'] = "Имя не должно быть пустым";
            } elseif (strlen($name) < 2 || strlen($name) > 20) {
                $errors['firstName'] = "Имя должно содержать не меньше 2 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['firstName'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['firstName'] = "Поле name должно быть заполнено";
        }


        if (isset($_POST['family'])) {
            $family = $_POST['family'];
            if (empty($family)){
                $errors['family'] = "Поле Фамилия не должно быть пустым";
            } elseif (strlen($family) < 3 || strlen($family) > 20) {
                $errors['family'] = "Фамилия должна содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $family)) {
                $errors['family'] = "Фамилия может содержать только буквы";
            }
        }else {
            $errors ['family'] = "Поле family должно быть заполнено";
        }


        if (isset($_POST['address'])) {
            $address = $_POST['address'];
            if (empty($address)){
                $errors['address'] = "Поле Адресс не должно быть пустым";
            } elseif (strlen($address) < 3 || strlen($address) > 60) {
                $errors['address'] = "Адресс должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
            }
        }else {
            $errors ['address'] = "Поле family должно быть заполнено";
        }


        if (isset($_POST['city'])) {
            $city = $_POST['city'];
            if (empty($city)){
                $errors['city'] = "Город не должно быть пустым";
            } elseif (strlen($city) < 3 || strlen($city) > 20) {
                $errors['city'] = "Город должен содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я -]+$/u", $city)) {
                $errors['city'] = "Город может содержать только буквы";
            }
        }else {
            $errors ['city'] = "Поле должно быть заполнено";
        }


        if (isset($_POST['phone'])) {
            $phone = $_POST['phone'];
            if (empty($phone)){
                $errors['phone'] = "Номер телефона не должен быть пустым";
            } elseif (!preg_match("/^[0-9]+$/u", $phone)) {
                $errors['phone'] = "Номер телефона может содержать только цифры";
            } elseif (strlen($phone) < 3 || strlen($phone) > 15) {
                $errors['phone'] = "Номер телефона должен содержать не меньше 3 символов и не больше 15 символов";
            }
        }else {
            $errors ['phone'] = "Номер телефона должен быть заполнен";
        }


        return $errors;
    }
}
