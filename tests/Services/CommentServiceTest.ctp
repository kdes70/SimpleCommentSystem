<?php

namespace Tests\Services;

use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;
use App\Services\CommentService;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CommentServiceTest extends TestCase
{
    private CommentRepositoryInterface|MockObject $mockRepository;
    private CommentService $commentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = $this->createMock(CommentRepositoryInterface::class);
        $this->commentService = new CommentService($this->mockRepository);
    }

    public function testCanCreateComment(): void
    {
        $name = 'John Doe';
        $email = 'john@example.com';
        $title = 'Test Comment';
        $content = 'This is a test comment.';

        $this->mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Comment::class))
            ->willReturn(true);

        $result = $this->commentService->createComment($name, $email, $title, $content);

        $this->assertTrue($result);
    }
}