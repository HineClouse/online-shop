<?php
function validate(): array
{
    $errors = [];

    if (isset($_POST['name'])){
        $name = $_POST['name'];

        if (empty($name)) {
            $errors['name'] = "Имя не должно быть пустым.";
        } elseif (strlen($name) < 2) {
            $errors['name'] = "Имя не должно быть короче 2 букв.";
        }
    } else {
        $errors['name'] = 'Поле name должно быть заполнено';
    }

    if (isset($_POST['email'])){
        $email = $_POST['email'];

        if (empty($email)) {
            $errors['email'] = "Email не должен быть пустым.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Неверный формат email.";
        }
    } else {
        $errors['email'] = 'Поле email должно быть заполнено';
    }

    if (isset($_POST['psw'])){
        $password = $_POST['psw'];

        if (empty($password)) {
            $errors['pws'] = "Пароль не должен быть пустым.";
        } elseif (strlen($password) < 6) {
            $errors['psw'] = "Пароль должен быть не менее 6 символов.";
        }
    }

    if (isset($_POST['psw-repeat'])){
        $passwordRep = $_POST['psw-repeat'];

        if (empty($passwordRep)) {
            $errors['psw-repeat'] = "Повтор пароля не должен быть пустым.";
        } elseif ($password !== $passwordRep) {
            $errors['psw-repeat'] = "Пароли не совпадают.";
        }
    }

    return $errors;
}

$errors = validate();

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordRep = $_POST['psw-repeat'];
    $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $hash = password_hash($_POST['psw'], PASSWORD_DEFAULT);
    $stmt->execute(['name' => $_POST['name'], 'email' => $_POST['email'], 'password' => $hash]);

    header("Location:/login");
}

require_once './get_registration.php';

?>


