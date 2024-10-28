<?php
namespace Request;

class LoginRequest extends Request {
    public function getEmail(): ?string {
        return $this->data['email'] ?? null;
    }

    public function getPassword(): ?string {
        return $this->data['password'] ?? null;
    }

    public function validate(): array {
        $errors = [];
        if (isset($this->data['login'])) {
            $login = $this->data['login'];
            if (empty($login)) {
                $errors['login'] = 'Поле login должно быть заполнено';
            }
        } else {
            $errors['login'] = 'Поле login должно быть заполнено';
        }

        if (isset($this->data['password'])) {
            $password = $this->data['password'];
            if (empty($password)) {
                $errors['password'] = 'Поле password должно быть заполнено';
            }
        } else {
            $errors['password'] = 'Поле password должно быть заполнено';
        }

        return $errors;
    }
}
