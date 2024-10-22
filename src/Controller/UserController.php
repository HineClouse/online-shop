<?php
namespace Controller;

use Model\User;

class UserController {
    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function getRegistrationForm() {
        require_once './../View/registration.php';
    }

    public function registrate() {
        $errors = $this->validateRegistration();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];

            if ($this->user->emailExists($email)) {
                echo "Пользователь с таким email уже существует.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                if ($this->user->addUser($name, $email, $hash)) {
                    header("Location:/login");
                    exit();
                } else {
                    echo "Ошибка при добавлении пользователя.";
                }
            }
        }
        require_once './../View/registration.php';
    }

    private function validateRegistration(): array {
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
            } elseif ($_POST['psw'] !== $passwordRep) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        }

        return $errors;
    }

    public function getLoginForm() {
        require_once './../View/login.php';
    }

    public function login() {
        $errors = $this->validateLogin();
        if (empty($errors)) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $data = $this->user->getUserByEmail($login);
            if (empty($data)) {
                $errors['login'] = 'Пользователь с указанными данными не существует';
            } else {
                $passwordFromDb = $data->getPassword();
                if (password_verify($password, $passwordFromDb)) {
                    session_start();
                    $_SESSION['userId'] = $data->getId();
                    header("Location:/catalog");
                    exit();
                } else {
                    $errors['password'] = 'Неверный пароль';
                }
            }
        }
        require_once './../View/login.php';
    }

    private function validateLogin(): array {
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
}
