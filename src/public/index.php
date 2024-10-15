<?php

use Controller\UserController;
use Controller\ProductController;

$autoloadCommon = function ($className) {};

$autoloadController = function (string $className){
    $path = str_replace('\\', '/', $className);
    $path ="./../Controller/$className.php";
    if(file_exists($path)){
        require_once $path;
        return true;
    }
    return false;
};

$autoloadModel = function (string $className){
    $path = "./../Model/$className.php";
    if(file_exists($path)){
        require_once $path;
        return true;
    }
    return false;
};
spl_autoload_register($autoloadController);
spl_autoload_register($autoloadModel);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/login':
        $userController = new UserController();
        if ($requestMethod === 'GET') {
            $userController->getLoginForm();
        } elseif ($requestMethod === 'POST') {
            $userController->login();
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
        break;
    case '/registration':
        $userController = new UserController();
        if ($requestMethod === 'GET') {
            $userController->getRegistrationForm();
        } elseif ($requestMethod === 'POST') {
            $userController->registrate();
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
        break;
    case '/catalog':
        $productController = new ProductController();
        if ($requestMethod === 'GET') {
            $productController->Catalog();
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
        break;
    case '/add-product':
        if ($requestMethod === 'GET') {
            require_once '../View/addProduct.php';
        } elseif ($requestMethod === 'POST') {
            require_once '../View/handle_add_product.php';
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
        break;
    case '/cart':
        if ($requestMethod === 'GET') {
            require_once '../View/cart.php';
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
        break;
    default:
        http_response_code(404);
        require_once '../View/404.php';
        break;
};
