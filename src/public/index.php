<?php

use Core\App;

$autoloadCommon = function ($className) {
    $path = str_replace('\\', '/', $className);
    $path = './../' . $path . '.php';
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};

spl_autoload_register($autoloadCommon);

$app = new App();

$app->addRoute('/login', 'GET', '\Controller\UserController', 'getLoginForm');
$app->addRoute('/login', 'POST', '\Controller\UserController', 'login');
$app->addRoute('/registration', 'GET', '\Controller\UserController', 'getRegistrationForm');
$app->addRoute('/registration', 'POST', '\Controller\UserController', 'registrate');

$app->addRoute('/catalog', 'GET', '\Controller\ProductController', 'catalog');
$app->addRoute('/add-product', 'POST', '\Controller\ProductController', 'addProduct');

$app->addRoute('/cart', 'GET', '\Controller\ProductController', 'showCart');
$app->addRoute('/deleteFromCart', 'POST', '\Controller\ProductController', 'deleteProductFromCart');

$app->addRoute('/order', 'GET', '\Controller\OrderController', 'getOrderForm');
$app->addRoute('/create-order', 'POST', '\Controller\OrderController', 'createOrder');

$app->addRoute('/add-to-favourites', 'POST', '\Controller\FavouritesController', 'addProductToFavourites');
$app->addRoute('/favourites', 'GET', '\Controller\FavouritesController', 'getFavourites');
$app->addRoute('/deleteFromFavourites', 'POST', '\Controller\FavouritesController', 'deleteProductFromFavourites');

$app->run();
