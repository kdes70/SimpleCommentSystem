<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentMysqlRepository implements CommentRepositoryInterface
{

    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM comments');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Comment
    {
        $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject(Comment::class);
    }

    /**
     * @inheritDoc
     */
    public function create(Comment $comment): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO comments (name, email, title, content, created_at) VALUES (:name, :email, :title, :content, :created_at)');
        $stmt->bindValue(':name', $comment->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $comment->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $comment->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
        $stmt->bindValue(':created_at', $comment->getCreatedAt()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        return $stmt->execute();
    }
}
