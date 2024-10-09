<?php

class User
{
    public function registrate()
    {
        $errors = $this->validateReg();

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
            if ($pdo) {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

                header("Location:/login");
            } else {
                echo "Ошибка подключения к базе данных.";
            }
        }

        require_once './get_registration.php';
    }

    private function validateReg(): array
    {
        $errors = [];

        if (isset($_POST['name'])) {
            $name = $_POST['name'];

            if (empty($name)) {
                $errors['name'] = "Имя не должно быть пустым.";
            } elseif (strlen($name) < 2) {
                $errors['name'] = "Имя не должно быть короче 2 букв.";
            }
        } else {
            $errors['name'] = 'Поле name должно быть заполнено';
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            if (empty($email)) {
                $errors['email'] = "Email не должен быть пустым.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Неверный формат email.";
            }
        } else {
            $errors['email'] = 'Поле email должно быть заполнено';
        }

        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];

            if (empty($password)) {
                $errors['psw'] = "Пароль не должен быть пустым.";
            } elseif (strlen($password) < 6) {
                $errors['psw'] = "Пароль должен быть не менее 6 символов.";
            }
        }

        if (isset($_POST['psw-repeat'])) {
            $passwordRep = $_POST['psw-repeat'];

            if (empty($passwordRep)) {
                $errors['psw-repeat'] = "Повтор пароля не должен быть пустым.";
            } elseif ($password !== $passwordRep) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        }

        return $errors;
    }

    private function validateLogin(): array
    {
        $errors = [];

        if (isset($_POST['login'])) {
            $login = $_POST['login'];
            if (empty($login)) {
                $errors['login'] = 'Поле login должно быть заполнено';
            }
        } else {
            $errors['login'] = 'Поле login должно быть заполнено';
        }

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            if (empty($password)) {
                $errors['password'] = 'Поле password должно быть заполнено';
            }
        } else {
            $errors['password'] = 'Поле password должно быть заполнено';
        }

        return $errors;
    }

    public function login()
    {
        $errors = $this->validateLogin();
        if (empty($errors)) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
            if ($pdo) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login");
                $stmt->execute(['login' => $login]);
                $data = $stmt->fetch();
                if ($data === false) {
                    $errors['login'] = 'Пользователь с указанными данными не существует';
                } else {
                    $passwordFromDb = $data['password'];
                    if (password_verify($password, $passwordFromDb)) {
                        session_start();
                        $_SESSION['userId'] = $data['id'];
                        header("Location:/catalog");
                    } else {
                        $errors['password'] = 'Пользователь с указанными данными не существует';
                    }
                }
            } else {
                echo "Ошибка подключения к базе данных.";
            }
        }

        require_once './get_login.php';
    }
}