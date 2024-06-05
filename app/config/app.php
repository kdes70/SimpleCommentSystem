<?php

use Psr\Container\ContainerInterface;

return [
    'router' => \DI\get(FastRoute\RouteCollector::class),
    'view' => \DI\get(Slim\Views\PhpRenderer::class),
    'db' => \DI\get(Doctrine\DBAL\DriverManager::class)->getConnection(require __DIR__ . '/database.php'),
    'validator' => \DI\get(Valitron\Validator::class),
];
