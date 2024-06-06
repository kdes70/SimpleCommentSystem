<?php

namespace App\Controllers;

use App\Core\ControllerContract;
use App\Core\Request\RequestForm;
use App\Services\CommentService;
use DI\DependencyException;
use DI\NotFoundException;

class CommentController extends Controller implements ControllerContract
{
    public function __construct(private readonly CommentService $commentService)
    {
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function index(): string
    {
        $comments = $this->commentService->getAllComments();
        return $this->render('page.twig', ['comments' => $comments]);
    }

    /**
     * @throws \Exception
     */
    public function create(RequestForm $requestForm): string
    {
        $validate = $requestForm->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        if (!$validate->validate()) {
            throw new \Exception('Ошибка валидации: ' . implode(', ', $validate->errors()), 422);
        }

        $success = $this->commentService->createComment(
            $requestForm['name'],
            $requestForm['email'],
            $requestForm['title'],
            $requestForm['content']
        );

        if ($success) {
            $comment = $this->commentService->getCommentById(0); // Получаем только что созданный комментарий
            return $this->render('comment.twig', ['comment' => $comment]);
        }

        return 'Error creating comment';
    }
}
