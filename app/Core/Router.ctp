<?php

namespace App\Core;

use App\Controllers\CommentController;
use App\Controllers\HomeController;

class Router
{
    private \FastRoute\Dispatcher $dispatcher;

    public function __construct()
    {
        $this->dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', [HomeController::class, 'index']);
            $r->addRoute('POST', '/comments', [CommentController::class, 'store']);
            $r->addRoute('GET', '/comments', [CommentController::class, 'index']);
        });
    }

    public function getDispatcher(): \FastRoute\Dispatcher
    {
        return $this->dispatcher;
    }

}
