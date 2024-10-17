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

    public function getOrderForm() {
        require_once './../View/order.php';
    }

    public function createOrder() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
            exit();
        }

        $userId = $_SESSION['userId'];
        $products = $this->productModel->getProductsByUserId($userId);

        $totalSum = 0;
        foreach ($products as $product) {
            $totalSum += intval($product['sumProduct']);
        }

        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_phone' => $_POST['contact_phone'],
            'city' => $_POST['city'],
            'street' => $_POST['street'],
            'number_house' => $_POST['number_house'],
            'stage' => $_POST['stage'],
            'apartment' => $_POST['apartment'],
            'comment' => $_POST['comment'],
            'total_sum' => $totalSum,
            'user_id' => $userId
        ];

        $orderId = $this->orderModel->createOrder($data);

        foreach ($products as $product) {
            $this->orderModel->addOrderProduct($orderId, $product['id'], $product['amount'], $product['price']);
        }

        header("Location:/order/$orderId");
        exit();
    }

    public function viewOrder($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $products = $this->orderModel->getOrderProducts($orderId);

        require_once './../View/order.php';
    }
}
