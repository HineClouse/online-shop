<?php

class Product
{
    public function catalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])){
            header("Location:/login");
        }

        $products = [];

        $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');

        $stmt = $pdo->query("SELECT * FROM products" );
        $products = $stmt->fetchAll();
    }
}