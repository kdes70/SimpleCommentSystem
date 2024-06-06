<?php

use App\Controllers\CommentController;
use App\Core\ControllerContract;
use App\Core\ControllerResolver;
use App\Core\Database;
use App\Core\Router;
use App\Core\Validation\Validation;
use App\Core\Validation\ValidationInterface;
use App\Core\View\TemplateEngineInterface;
use App\Core\View\TwigView;
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

use function DI\create;
use function DI\get;

return [
    LoggerInterface::class => create(Logger::class)
        ->constructor('app', [
            new StreamHandler(__DIR__ . '/../storage/logs/app.log', \Monolog\Level::Debug)
        ]),
    Handler::class => create(Handler::class)
        ->constructor(
            get(LoggerInterface::class),
            get(\Twig\Environment::class)
        ),
    ControllerContract::class => create(CommentController::class)
        ->constructor(get(CommentService::class)),
    CommentService::class => create()
        ->constructor(
            get(CommentRepositoryInterface::class),
        ),
    CommentRepositoryInterface::class => create(CommentDoctrineRepository::class)
        ->constructor(function (ContainerInterface $c) {
            return new CommentDoctrineRepository($c->get(Database::class));
        }),

    ControllerResolver::class => create(ControllerResolver::class),
    ValidationInterface::class => create(Validation::class),
//    Router::class => create(Router::class)->constructor(get(ControllerResolver::class)),
    TemplateEngineInterface::class => fn() => new TwigView(__DIR__ . '/../app/views'),
    ViewFactory::class => create(ViewFactory::class),
    Dispatcher::class => fn(ContainerInterface $c) => ($c->get(Router::class)),
];
