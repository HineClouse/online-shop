<?php
namespace Controller;

use \Model\Product;

class ProductController {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function getCatalogForm() {
        require_once './../View/catalog.php';
    }

    public function catalog() {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location:/login");
        }
        $products = $this->productModel->getAllProducts();
        require_once './../View/catalog.php';
    }
}
