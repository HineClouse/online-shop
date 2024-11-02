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

        if (empty($this->data['email'])) {
            $errors['email'] = 'Поле email должно быть заполнено';
        }

        if (empty($this->data['password'])) {
            $errors['password'] = 'Поле password должно быть заполнено';
        }

        return $errors;
    }
}
