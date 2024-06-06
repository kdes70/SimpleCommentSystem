<?php

namespace App\Repositories;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    /**
     * Get all comments
     *
     * @return Comment[]
     */
    public function getAll(): array;

    /**
     * Create a new comment
     *
     * @param Comment $comment
     * @return bool
     */
    public function create(Comment $comment): bool;
}
