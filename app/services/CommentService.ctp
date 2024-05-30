<?php

namespace App\services;

use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;

readonly class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    public function getAllComments(): array
    {
        return $this->commentRepository->getAll();
    }

    public function getCommentById(int $id): ?Comment
    {
        return $this->commentRepository->getById($id);
    }

    public function createComment(string $name, string $email, string $title, string $content): bool
    {
        $comment = new Comment($name, $email, $title, $content);
        return $this->commentRepository->create($comment);
    }
}