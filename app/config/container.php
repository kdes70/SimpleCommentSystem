<?php

use App\Controllers\CommentController;
use App\Core\Router;
use App\Exceptions\Handler;
use App\Repositories\CommentDoctrineRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Services\CommentService;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use FastRoute\Dispatcher;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$containerBuilder = new ContainerBuilder();

$databaseConfig = require __DIR__ . '/database.php';

$containerBuilder->addDefinitions(__DIR__ . '/../config/di.php');

$containerBuilder->addDefinitions([
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

return $containerBuilder->build();
