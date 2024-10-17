<?php

namespace Core;

class App
{
    private array $routes = [];
//    private array $routes = [
//        '/login' => [
//            'GET' => [
//                'class' => '\Controller\UserController',
//                'method' => 'getLoginForm'
//            ],
//            'POST' => [
//                'class' => '\Controller\UserController',
//                'method' => 'login'
//            ]
//        ],
//        '/registration' => [
//            'GET' => [
//                'class' => '\Controller\UserController',
//                'method' => 'getRegistrationForm'
//            ],
//            'POST' => [
//                'class' => '\Controller\UserController',
//                'method' => 'registrate'
//            ]
//        ],
//        '/catalog' => [
//            'GET' => [
//                'class' => '\Controller\ProductController',
//                'method' => 'catalog'
//            ]
//        ],
//        '/add-product' => [
//            'POST' => [
//                'class' => '\Controller\ProductController',
//                'method' => 'addProduct'
//            ]
//        ],
//        '/cart' => [
//            'GET' => [
//                'class' => '\Controller\ProductController',
//                'method' => 'showCart'
//            ]
//        ],
//    ];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$requestUri])) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $routeMethod = $this->routes[$requestUri];
            if (isset($routeMethod[$requestMethod])) {
                $handler = $routeMethod[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once "./../View/404.php";
        }
    }

    public function addRoute(string $path, string $method, string $class, string $function)
    {
        $this->routes[$path][$method] = [
            'class' => $class,
            'method' => $function
        ];
    }
}
