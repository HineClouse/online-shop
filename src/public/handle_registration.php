<?php

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRep = $_GET['psw-repeat'];

//print_r($name . "\n" . $email . "\n" . $password);

$pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');

$pdo->exec("INSERT INTO users (name, email,password) VALUES ('$name', '$email', '$password')");

$result = $pdo->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");

echo "\n";

print_r($result->fetch());