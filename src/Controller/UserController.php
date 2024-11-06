<?php
namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController {
    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function getRegistrationForm() {
        require_once './../View/registration.php';
    }

    public function registrate(RegistrateRequest $request) {

            $errors = $request->validate();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            } else {
                $name = $request->getName();
                $email = $request->getEmail();
                $password = $request->getPassword();
                if (User::emailExists($email)) {
                    echo "Пользователь с таким email уже существует.";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    if (User::addUser($name, $email, $hash)) {
                        header("Location:/login");
                        exit();
                    } else {
                        echo "Ошибка при добавлении пользователя.";
                    }
                }
            }
        require_once './../View/registration.php';
    }

    public function getLoginForm() {
        require_once './../View/login.php';
    }

    public function login(LoginRequest $request) {
            $errors = $request->validate();
            if (empty($errors)) {
                $login = $request->getEmail();
                $password = $request->getPassword();
                $data = User::getUserByEmail($login);
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
}
