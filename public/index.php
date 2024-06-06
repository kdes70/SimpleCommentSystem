<?php

use App\Core\Container;
use App\Core\Request\Request;
use App\Core\Router;
use App\Core\View\ViewFactory;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = Container::getInstance();

$router = $container->get(Router::class);
$request = new Request();
$view = $container->get(ViewFactory::class);
$router->resolve();
