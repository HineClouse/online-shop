<?php


namespace Request;

class ProductRequest extends Request
{

    // Получение названия продукта
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    // Получение описания продукта
    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    // Получение изображения продукта
    public function getImage(): ?string
    {
        return $this->data['image'] ?? null;
    }

    // Получение цены продукта
    public function getPrice(): ?float
    {
        return $this->data['price'] ?? null;
    }

    // Получение количества продукта
    public function getAmount(): ?int
    {
        return $this->data['amount'] ?? null;
    }

    // Валидация данных о продукте
    public function validate(): array
    {
        $errors = [];

        if (empty($this->data['name'])) {
            $errors['name'] = 'Поле name должно быть заполнено';
        } elseif (strlen($this->data['name']) < 2) {
            $errors['name'] = 'Название продукта должно быть не короче 2 символов';
        }

        if (empty($this->data['description'])) {
            $errors['description'] = 'Поле description должно быть заполнено';
        } elseif (strlen($this->data['description']) < 5) {
            $errors['description'] = 'Описание продукта должно быть не короче 5 символов';
        }

        if (empty($this->data['image'])) {
            $errors['image'] = 'Поле image должно быть заполнено';
        }

        if (empty($this->data['price'])) {
            $errors['price'] = 'Поле price должно быть заполнено';
        } elseif (!is_numeric($this->data['price']) || $this->data['price'] <= 0) {
            $errors['price'] = 'Цена продукта должна быть положительным числом';
        }

        if (empty($this->data['amount'])) {
            $errors['amount'] = 'Поле amount должно быть заполнено';
        } elseif (!is_numeric($this->data['amount']) || $this->data['amount'] <= 0) {
            $errors['amount'] = 'Количество продукта должно быть положительным числом';
        }

        return $errors;
    }
}
