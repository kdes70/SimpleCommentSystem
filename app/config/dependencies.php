<?php

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Slim\Views\PhpRenderer;
use Valitron\Validator;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    RouteCollector::class => fn() => new RouteCollector(
        new \FastRoute\cachedDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', ['App\Controllers\BlogController', 'index']);
            $r->addRoute('POST', '/comments', ['App\Controllers\CommentController', 'store']);
        }),
        []
    ),
    PhpRenderer::class => fn(ContainerInterface $c) => new PhpRenderer(__DIR__ . '/../views'),
    Validator::class => fn() => new Validator([
        'name' => 'required|string',
        'email' => 'required|email',
        'title' => 'required|string',
        'text' => 'required|string',
    ]),
    RequestForm::class => fn(ContainerInterface $c) => $c->get(Validator::class),
    LoggerInterface::class => \DI\create(Logger::class)
        ->constructor('app', [
            new StreamHandler(__DIR__ . '/../storage/logs/app.log', Logger::DEBUG)
        ]),
    Handler::class => \DI\create(Handler::class)
        ->constructor(
            \DI\get(LoggerInterface::class),
            \DI\get(Environment::class)
        ),


    ///
    CommentRepositoryInterface::class => \DI\create(CommentDoctrineRepository::class)
        ->constructor(DriverManager::getConnection($databaseConfig)),
    CommentService::class => \DI\create(CommentService::class)
        ->constructor(\DI\get(CommentDoctrineRepository::class)),
    CommentController::class => \DI\create(CommentController::class)
        ->constructor(\DI\get(CommentService::class)),
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        return new Environment($loader);
    },
    Dispatcher::class => fn() => (new Router())->getDispatcher(),
    LoggerInterface::class => \DI\create(Logger::class)
        ->constructor('app', [
            new StreamHandler(__DIR__ . '/../storage/logs/app.log', Logger::DEBUG)
        ]),
    Handler::class => \DI\create(Handler::class)
        ->constructor(
            \DI\get(LoggerInterface::class),
            \DI\get(Environment::class)
        ),
]);
