<?php

namespace Core;

class App
{
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

                $requestClass = "\\Request\\" . ucfirst($method) . "Request";
                if (class_exists($requestClass)) {
                    $request = new $requestClass($requestUri, $requestMethod, $_POST);
                    $controller->$method($request);
                } else {
                    $controller->$method();
                }
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
