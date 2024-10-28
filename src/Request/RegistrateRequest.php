<?php

namespace Request;

class RegistrateRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }
    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->data['password'] ?? null;
    }

    public function validate(): array {

        $errors = [];

        if (isset($data['name'])) {
            $name = $_POST['name'];
            if (empty($name)) {
                $errors['name'] = "Имя не должно быть пустым.";
            } elseif (strlen($name) < 2) {
                $errors['name'] = "Имя не должно быть короче 2 букв.";
            }
        } else {
            $errors['name'] = 'Поле name должно быть заполнено';
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            if (empty($email)) {
                $errors['email'] = "Email не должен быть пустым.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Неверный формат email.";
            }
        } else {
            $errors['email'] = 'Поле email должно быть заполнено';
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            if (empty($password)) {
                $errors['psw'] = "Пароль не должен быть пустым.";
            } elseif (strlen($password) < 6) {
                $errors['psw'] = "Пароль должен быть не менее 6 символов.";
            }
        }

        if (isset($this->data['psw-repeat'])) {
            $passwordRep = $this->data['psw-repeat'];
            if (empty($passwordRep)) {
                $errors['psw-repeat'] = "Повтор пароля не должен быть пустым.";
            } elseif ($this->data['psw'] !== $passwordRep) {
                $errors['psw-repeat'] = "Пароли не совпадают.";
            }
        }

        return $errors;
    }
}