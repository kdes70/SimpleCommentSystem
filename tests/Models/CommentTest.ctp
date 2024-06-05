<?php

namespace Tests\Models;

use App\Models\Comment;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testCanCreateComment(): void
    {
        $name = 'John Doe';
        $email = 'john@example.com';
        $title = 'Test Comment';
        $content = 'This is a test comment.';
        $createdAt = new DateTimeImmutable();

        $comment = new Comment($name, $email, $title, $content, $createdAt);

        $this->assertEquals($name, $comment->getName());
        $this->assertEquals($email, $comment->getEmail());
        $this->assertEquals($title, $comment->getTitle());
        $this->assertEquals($content, $comment->getContent());
        $this->assertEquals($createdAt, $comment->getCreatedAt());
    }
}