<?php

use App\Controllers\CommentController;
use App\Core\ControllerContract;
use App\Core\ControllerResolver;
use App\Core\Database;
use App\Core\Router;
use App\Core\Validation\Validation;
use App\Core\Validation\ValidationInterface;
use App\Core\View\TemplateEngineInterface;
use App\Core\View\TwigEngine;
use App\Core\View\ViewFactory;
use App\Exceptions\Handler;
use App\Repositories\CommentDoctrineRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Services\CommentService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Routing\Dispatcher;

use function DI\get;

return [
    LoggerInterface::class => \DI\create(Logger::class)
        ->constructor('app', [
            new StreamHandler(__DIR__ . '/../storage/logs/app.log', \Monolog\Level::Debug)
        ]),
    Handler::class => \DI\create(Handler::class)
        ->constructor(
            get(LoggerInterface::class),
            get(\Twig\Environment::class)
        ),
    ControllerContract::class => \DI\create(CommentController::class)
        ->constructor(get(CommentService::class)),
    CommentService::class => \DI\create()
        ->constructor(
            get(CommentRepositoryInterface::class),
        ),
    CommentRepositoryInterface::class => \DI\create(CommentDoctrineRepository::class)
        ->constructor(function (ContainerInterface $c) {
            return new CommentDoctrineRepository($c->get(Database::class));
        }),

    ValidationInterface::class => \DI\create(Validation::class),
    'controllerResolverFactory' => fn(\DI\Container $container) => new ControllerResolver($container),
    Router::class => \DI\create(Router::class)->constructor(get('controllerResolverFactory')),
    TemplateEngineInterface::class => fn() => new TwigEngine(__DIR__ . '/views'),
    ViewFactory::class => \DI\create(ViewFactory::class),
    Dispatcher::class => fn(ContainerInterface $c) => ($c->get(Router::class)),
];
