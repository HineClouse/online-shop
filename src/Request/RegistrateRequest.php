<?php
namespace Request;

class RegistrateRequest extends Request {
    public function getName(): ?string {
        return $this->data['name'] ?? null;
    }

    public function getEmail(): ?string {
        return $this->data['email'] ?? null;
    }

    public function getPassword(): ?string {
        return $this->data['password'] ?? null;
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->data['name'])) {
            $errors['name'] = 'Поле name должно быть заполнено';
        } elseif (strlen($this->data['name']) < 2) {
            $errors['name'] = 'Имя не должно быть короче 2 букв.';
        }

        if (empty($this->data['email'])) {
            $errors['email'] = 'Поле email должно быть заполнено';
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неверный формат email.';
        }

        if (empty($this->data['password'])) {
            $errors['password'] = 'Пароль не должен быть пустым.';
        } elseif (strlen($this->data['password']) < 6) {
            $errors['password'] = 'Пароль должен быть не менее 6 символов.';
        }

        if (empty($this->data['password_confirmation'])) {
            $errors['password_confirmation'] = 'Повтор пароля не должен быть пустым.';
        } elseif ($this->data['password'] !== $this->data['password_confirmation']) {
            $errors['password_confirmation'] = 'Пароли не совпадают.';
        }

        return $errors;
    }
}
