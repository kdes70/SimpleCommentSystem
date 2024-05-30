<?php

namespace App\repositories;

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
        $stmt = $this->pdo->query('SELECT * FROM comments');
        return $stmt->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Comment
    {
        $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Comment::class);
    }

    /**
     * @inheritDoc
     */
    public function create(Comment $comment): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO comments (name, email, title, content, created_at) VALUES (:name, :email, :title, :content, :created_at)'
        );
        $stmt->execute([
            'name' => $comment->getName(),
            'email' => $comment->getEmail(),
            'title' => $comment->getTitle(),
            'content' => $comment->getContent(),
            'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        return true;
    }
}