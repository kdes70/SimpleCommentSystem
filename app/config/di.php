<?php

use App\Core\Database;
use App\Repositories\CommentDoctrineRepository;
use App\Repositories\CommentRepository;
use App\Controllers\CommentController;
use App\Repositories\CommentRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    Database::class => fn(ContainerInterface $c) => new Database(require __DIR__ . '/database.php'),
    Router::class => \DI\create(Router::class),
    LoggerInterface::class => \DI\create(Logger::class)
        ->constructor('app', [
            new StreamHandler(__DIR__ . '/../storage/logs/app.log', Logger::DEBUG)
        ]),
    Handler::class => \DI\create(Handler::class)
        ->constructor(
            \DI\get(LoggerInterface::class),
            \DI\get(Environment::class)
        ),

    CommentRepositoryInterface::class => \DI\create(CommentDoctrineRepository::class)
        ->constructor(function (ContainerInterface $c) {
            return new CommentDoctrineRepository($c->get(Database::class));
        }),
    CommentDoctrineRepository::class => fn(ContainerInterface $c) => new EntityManagerInterface(
        $c->get(Database::class)
    ),

    CommentService::class => \DI\create(CommentService::class)
        ->constructor(\DI\get(CommentDoctrineRepository::class)),
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        return new Environment($loader);
    },
    Dispatcher::class => fn(ContainerInterface $c) => ($c->get(Router::class)),
    CommentRepository::class => fn (ContainerInterface $c) => new CommentRepository($c->get(Database::class),
    CommentController::class => fn(ContainerInterface $c) => new CommentController($c->get(CommentService::class))
];
