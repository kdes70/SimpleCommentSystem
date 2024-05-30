<?php

namespace App\Controllers;

use App\core\RequestForm;
use App\Models\Comment;
use App\Services\CommentService;

readonly class CommentController
{
    public function __construct(private CommentService $commentService)
    {
    }

    public function index(): string
    {
        $comments = $this->commentService->getAllComments();
        $commentsHtml = '';

        foreach ($comments as $comment) {
            $commentsHtml .= $this->renderCommentHtml($comment);
        }

        return $this->renderPageHtml($commentsHtml);
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
            return $this->renderCommentHtml($comment);
        }

        return 'Error creating comment';
    }

    private function renderCommentHtml(Comment $comment): string
    {
        // Генерация HTML-кода для отображения комментария
    }

    private function renderPageHtml(string $commentsHtml): string
    {
        // Генерация HTML-кода для всей страницы, включая header, footer и содержимое
    }
}