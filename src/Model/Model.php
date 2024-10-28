<?php

namespace Model;

use PDO;

class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
    }

    protected function hydrate(array $data, object $object): void {
        foreach ($data as $property => $value) {
            if (property_exists($object, $property)) {
                $object->$property = $value;
            }
        }
    }

}