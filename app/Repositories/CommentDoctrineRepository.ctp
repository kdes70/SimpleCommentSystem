<?php

namespace App\Repositories;

use App\Models\Comment;
use EntityManagerInterface;

class CommentDoctrineRepository implements CommentRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Comment::class)->findAll();
    }


    public function getById(int $id): ?Comment
    {
        return $this->entityManager->getRepository(Comment::class)->find($id);
    }


    public function create(Comment $comment): bool
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return true;
    }
}
