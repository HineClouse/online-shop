<?php

require_once "./../Core/Autoload.php";

use Core\App;
use Core\Autoload;
use Controller\FavouritesController;
use Controller\UserController;
use Controller\ProductController;
use Controller\OrderController;
use Request\LoginRequest;
use Request\RegistrateRequest;

Autoload::autoload("/var/www/html/src/");

$app = new App();

$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', UserController::class, 'login', LoginRequest::class);

$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrationForm');
$app->addRoute('/registration', UserController::class, 'registrate', RegistrateRequest::class);

$app->addRoute('/catalog', 'GET', ProductController::class, 'catalog');
$app->addRoute('/add-product', ProductController::class, 'addProduct', ProductRequest::class);

$app->addRoute('/cart', 'GET', ProductController::class, 'showCart');
$app->addRoute('/delete-from-cart',ProductController::class, 'deleteProductFromCart', ProductRequest::class);

$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/create-order', OrderController::class, 'createOrder', OrderRequest::class);

$app->addRoute('/add-to-favourites', FavouritesController::class, 'addProductToFavourites', FavouritesRequest::class);
$app->addRoute('/favourites', 'GET', FavouritesController::class, 'getFavourites');
$app->addRoute('/deleteFromFavourites',  FavouritesController::class, 'deleteProductFromFavourites', FavouritesRequest::class);

$app->run();
