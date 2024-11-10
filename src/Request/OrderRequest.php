<?php

namespace Request;

class OrderRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getFamily(): ?string
    {
        return $this->data['family'] ?? null;
    }

    public function getCity(): ?string
    {
        return $this->data['city'] ?? null;
    }

    public function getAddress(): ?string
    {
        return $this->data['address'] ?? null;
    }

    public function getPhone(): ?string
    {
        return $this->data['phone'] ?? null;
    }

    public function getSum(): ?float
    {
        return isset($this->data['sum']) ? (float)$this->data['sum'] : null;
    }

    public function getUserId(): ?int
    {
        return isset($this->data['user_id']) ? (int)$this->data['user_id'] : null;
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->data['name'])) {
            $errors['name'] = 'Поле name должно быть заполнено';
        }

        if (empty($this->data['family'])) {
            $errors['family'] = 'Поле family должно быть заполнено';
        }

        if (empty($this->data['city'])) {
            $errors['city'] = 'Поле city должно быть заполнено';
        }

        if (empty($this->data['address'])) {
            $errors['address'] = 'Поле address должно быть заполнено';
        }

        if (empty($this->data['phone'])) {
            $errors['phone'] = 'Поле phone должно быть заполнено';
        } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $this->data['phone'])) {
            $errors['phone'] = 'Неверный формат номера телефона';
        }

        if (!isset($this->data['sum']) || $this->data['sum'] <= 0) {
            $errors['sum'] = 'Поле sum должно быть положительным числом';
        }

        if (empty($this->data['user_id'])) {
            $errors['user_id'] = 'Поле user_id должно быть заполнено';
        }

        return $errors;
    }
}
