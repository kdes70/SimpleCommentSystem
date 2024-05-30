<?php

use App\controllers\CommentController;
use FastRoute\RouteCollector;

$routes = [];

$dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) use (&$routes) {
    // Маршрут для отображения списка комментариев
    $r->addRoute('GET', '/', [CommentController::class, 'index']);

    // Маршрут для создания нового комментария
    $r->addRoute('POST', '/comments', [CommentController::class, 'create']);

    // Добавляем другие необходимые маршруты здесь...

    $routes = $r->getData();
});