<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Обработка маршрута /login
if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}
// Обработка маршрута /registration
elseif ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}
// Обработка маршрута /catalog
elseif ($requestUri === '/catalog') {
    require_once './catalog.php';
}
// Обработка всех остальных маршрутов
else {
    http_response_code(404);
    require_once './404.php';
}

?>