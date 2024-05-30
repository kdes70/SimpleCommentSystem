<?php

use FastRoute\Dispatcher;
use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';
require_once __DIR__ . '/../config/dependencies.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions($dependencies);
$container = $containerBuilder->build();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

header('Content-Type: application/json');

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        $controllerInstance = $container->get($controller);

        if ($httpMethod === 'GET') {
            echo $controllerInstance->$method();
        } else {
            $data = json_decode(file_get_contents('php://input'), true);
            echo $controllerInstance->$method($data);
        }
        break;
}