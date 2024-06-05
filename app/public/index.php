<?php

use App\Core\Container;
use App\Core\Request\Request;
use App\Core\Router;
use App\Exceptions\Handler;
use FastRoute\Dispatcher;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

$container = Container::getInstance();
$router = $container->get(Router::class);
$twig = $container->get(Environment::class);

$request = new Request();

$dispatcher = $container->get('FastRoute\RouteCollector')->getData();
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());

try {
    switch ($routeInfo[0]) {
        case Dispatcher::NOT_FOUND:
            $response = $twig->render('errors/404.html.twig');
            break;
        case Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            $response = 'Метод не разрешен';
            break;
        case Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];

            [$controller, $method] = explode('@', $handler);
            $controller = $container->get($controller);
            $response = $controller->$method($vars, $request);
            break;
    }
} catch (Exception $e) {
    $handler = $container->get(Handler::class);
    $handler->report($e);
    $response = $handler->render($e);
}

echo $response;
