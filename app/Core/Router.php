<?php

namespace App\Core;

use App\Controllers\CommentController;
use App\Controllers\HomeController;
use App\Exceptions\Handler;
use Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;
    private ControllerResolver $controllerResolver;

    public function __construct(callable $controllerResolverFactory)
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('GET', '/', [HomeController::class, 'index']);
            $r->addRoute('POST', '/comments', [CommentController::class, 'store']);
            $r->addRoute('GET', '/comments', [CommentController::class, 'index']);
        });

        $container = Container::getInstance();
        $this->controllerResolver = $controllerResolverFactory($container->get(\DI\Container::class));
    }

    public function resolve(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        try {
            switch ($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    http_response_code(404);
                    echo "404 Not Found";
                    break;
                case Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    http_response_code(405);
                    echo "405 Method Not Allowed";
                    break;
                case Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];

                    $controller = $this->controllerResolver->resolve($handler);
                    $method = $this->getMethod($handler);

                    call_user_func_array([$controller, $method], $vars);
                    break;
            }
        } catch (Exception $e) {
            /** @var Handler $handler */
            $handler = \DI\get(Handler::class);
            $handler->report($e);
            echo $handler->render($e);
        }
    }

    private function getMethod(string $handler): string
    {
        return explode('@', $handler, 2)[1];
    }

    public function getDispatcher(): Dispatcher
    {
        return $this->dispatcher;
    }
}
