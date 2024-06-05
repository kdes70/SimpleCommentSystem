<?php

namespace App\Controllers;

use App\Services\CommentService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class HomeController
{
    public function __construct(private PhpRenderer $renderer, private CommentService $commentService)
    {
    }

    public function index(Request $request, Response $response, $args)
    {
        $comments = $this->commentService->getAll();

        $response->getBody()->write(
            $this->renderer->render('blog.php', [
                'comments' => $comments,
            ])
        );

        return $response;
    }
}
