<?php

use App\controllers\CommentController;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\Doctrine\CommentRepository as DoctrineCommentRepository;
use App\Repositories\Native\CommentRepository as NativeCommentRepository;
use App\Services\CommentService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$isDevMode = true; // Или устанавливайте true для режима разработки, false для production

$proxyDir = null;
if ($isDevMode) {
    $proxyDir = __DIR__ . '/../var/cache/proxy';
}

$paths = [__DIR__ . '/../src/models'];
$config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir);

$connection = [
    'driver' => 'pdo_mysql',
    'host' => getenv('DB_HOST') ?: 'mysql', // Используем переменную окружения DB_HOST или значение по умолчанию 'mysql'
    'dbname' => 'my_db',
    'user' => 'root',
    'password' => 'secret', // Пароль для MySQL, определенный в docker-compose.yml
];

$entityManager = EntityManager::create($connection, $config);

return [
    CommentService::class => \DI\create(CommentService::class)
        ->constructor(\DI\get(CommentRepositoryInterface::class)),

    CommentRepositoryInterface::class => \DI\get(NativeCommentRepository::class),

    NativeCommentRepository::class => \DI\create(NativeCommentRepository::class)
        ->constructor(\DI\get(PDO::class)),

    DoctrineCommentRepository::class => \DI\create(DoctrineCommentRepository::class)
        ->constructor(\DI\get(EntityManager::class)),

    PDO::class => \DI\create()
        ->constructor(
            'mysql:host=mysql;dbname=my_db',
            'root',
            'secret'
        ),

    EntityManager::class => \DI\get($entityManager),

    CommentController::class => \DI\create(CommentController::class)
        ->constructor(\DI\get(CommentService::class)),
];