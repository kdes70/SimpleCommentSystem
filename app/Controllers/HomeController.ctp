<?php

namespace App\Controllers;

use App\Services\CommentService;
use DI\DependencyException;
use DI\NotFoundException;

class HomeController  extends Controller
{
    public function __construct(private readonly CommentService $commentService)
    {
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function index(): mixed
    {
        $comments = $this->commentService->getAllComments();

       return $this->render('blog.php', [
            'comments' => $comments,
        ]);
    }
}
