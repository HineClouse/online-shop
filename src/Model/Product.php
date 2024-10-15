<?php

namespace Model;
class Product {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
    }

    public function getAllProducts() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        return $products;
    }
}
