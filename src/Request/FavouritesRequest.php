<?php
namespace Request;

class FavouritesRequest extends Request {
    public function getUserId(): ?int {
        return $this->data['user_id'] ?? null;
    }

    public function getItemId(): ?int {
        return $this->data['item_id'] ?? null;
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->data['user_id'])) {
            $errors['user_id'] = 'Поле user_id должно быть заполнено';
        } elseif (!is_numeric($this->data['user_id'])) {
            $errors['user_id'] = 'user_id должно быть числом';
        }

        if (empty($this->data['item_id'])) {
            $errors['item_id'] = 'Поле item_id должно быть заполнено';
        } elseif (!is_numeric($this->data['item_id'])) {
            $errors['item_id'] = 'item_id должно быть числом';
        }

        return $errors;
    }
}
