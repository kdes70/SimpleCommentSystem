<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request\RequestForm;
use App\Core\Response;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {
    }

    public function index(): string
    {
        $comments = $this->commentService->getAllComments();
        return $this->view->render('page.twig', ['comments' => $comments]);
        }

    public function create(RequestForm $request): string
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if ($data['status'] === 'error') {
            return new Response($data, 422);
        }

        $success = $this->commentService->createComment( $data['name'], $data['email'], $data['title'] , $data['content']);

        if ($success) {
            $comment = $this->commentService->getCommentById(0); // Получаем только что созданный комментарий
            return $this->view->render('comment.twig', ['comment' => $comment]);
        }

        return 'Error creating comment';
    }
}
