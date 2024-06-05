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
     * Get a comment by ID
     *
     * @param int $id
     * @return Comment|null
     */
    public function getById(int $id): ?Comment;

    /**
     * Create a new comment
     *
     * @param Comment $comment
     * @return bool
     */
    public function create(Comment $comment): bool;
}
