<?php

use Core\App;

$autoloadCommon = function ($className) {
};

$autoloader = function (string $className) {
    $path = str_replace('\\', '/', $className);
    $path = './../' . $path . '.php';
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};

spl_autoload_register($autoloader);


$app = new App();
$app->run();