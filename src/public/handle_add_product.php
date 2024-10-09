<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:/login");
}

function validateProduct (): array
{
    $errors = [];

    if (isset($_POST['product-id'])) {
        $product_id = $_POST['product-id'];

        if (empty($product_id)) {
            $errors['product-id'] = "product-id не должно быть пустым.";
        } elseif (!ctype_digit($product_id)) {
            $errors['product-id'] = "product-id должно содержать только цифры.";
        } elseif ($product_id < 1) {
            $errors['product-id'] = "product-id не может быть меньше 1";
        } else {
            $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');

            $stmt = $pdo->query("SELECT MAX(id) FROM products");
            $res = $stmt->fetch();
            //print_r($res['max']);

            if (isset($res['max'])) {
                $idMax = $res['max'];

                if ($product_id > $idMax) {
                    $errors['product-id'] = "product-id не должно превышать $idMax.";
                }
            }
        }
    } else {
        $errors['product-id'] = 'Поле product-id должно быть заполнено';
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

$errors = validateProduct();

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    $product_id = $_POST['product-id'];
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];

    $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');

    $stmt = $pdo->prepare("SELECT amount FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $result = $stmt->fetch();

    if ($result) {
        $sumAmount = $result['amount'] + $amount;
        $updateAmount = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $updateAmount->execute(['amount' => $sumAmount, 'user_id' => $user_id, 'product_id' => $product_id]);
    } else {
        $insertProduct = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $insertProduct->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    header("Location:/catalog");
}

require_once './get_add_product.php';