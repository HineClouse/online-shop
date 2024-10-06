<?php


function validate(): array
{
    $errors = [];

    if (isset($_POST['product-id'])){
        $product_id = $_POST['product-id'];

        if (empty($product_id)) {
            $errors['product-id'] = "product-id не должно быть пустым.";
        } elseif (strlen($product_id) < 1) {
            $errors['product-id'] = "product-id не должно быть меньше 1.";
        }
    } else {
        $errors['product-id'] = 'Поле product-id должно быть заполнено';
    }

    if (isset($_POST['amount'])){
        $amount = $_POST['amount'];

        if (empty($amount)) {
            $errors['amount'] = "amount не должно быть пустым.";
        } elseif (strlen($amount) < 1) {
            $errors['amount'] = "amount не должно быть меньше 1.";
        }
    } else {
        $errors['amount'] = 'Поле amount должно быть заполнено';
    }
    return $errors;
}

$errors = validate();

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    $product_id = $_POST['product-id'];
    $amount = $_POST['amount'];
    session_start();
    $user_id = $_SESSION['user_id'];

    $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

    header("Location:/catalog");
}

require_once './registration';
?>