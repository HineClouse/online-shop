<?php

$errors = [];

if (isset($_POST['login'])) {
    $login = $_POST['login'];
} else {
    $errors['login'] = 'Пользователь с указанными данными не существует';
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $errors['password'] = 'Пользователь с указанными данными не существует';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login");
    $stmt->execute(['login' => $login]);
    $data = $stmt->fetch();

    if ($data === false) {
        $errors['login'] = 'Пользователь с указанными данными не существует';
    } else {
        $passwordFromDb = $data['password'];
        if (password_verify($password, $passwordFromDb)) {
            setcookie('user_id', $data['id']);
        } else {
            $errors['password'] = 'Пользователь с указанными данными не существует';
        }
    }
}

require_once './get_login.php';
?>