<?php

namespace Model;

use PDO;

class Model
{
    private static PDO $pdo;

    public static function getPDO(): PDO
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
        }

        return self::$pdo;
    }

    protected static function hydrate(array $data, object $object): void
    {
        foreach ($data as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }
    }
}