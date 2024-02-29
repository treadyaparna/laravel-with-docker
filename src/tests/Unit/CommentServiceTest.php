<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Services\CommentService;
use PHPUnit\Framework\TestCase;
use Mockery;

class CommentServiceTest extends TestCase
{
    protected $commentService;
    protected $commentRepoMock;
    protected $mockArticle; // Declare the property here

    public function setUp(): void
    {
        $this->commentRepoMock = Mockery::mock('App\Repositories\CommentRepository');
        $this->commentService = new CommentService($this->commentRepoMock);
        $this->mockArticle = Mockery::mock(Article::class); // Instantiate the mock here
    }

    public function testAddComment()
    {
        $this->commentRepoMock->shouldReceive('addComment')
            ->with('Test Comment', 'This is a test comment content', 1, 1)
            ->andReturn(true);

        $result = $this->commentService->addComment('Test Comment', 'This is a test comment content', 1, 1);

        $this->assertTrue($result);
    }

    public function testGetComments()
    {
        $this->commentRepoMock->shouldReceive('getComments')
            ->with(1)
            ->andReturn([
                [
                    'id' => 1,
                    'title' => 'Test Comment',
                    'content' => 'This is a test comment content',
                    'user_id' => 1,
                    'article_id' => 1
                ]
            ]);

        $result = $this->commentService->getComments(1);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    public function testDeleteComment()
    {
        $this->commentRepoMock->shouldReceive('deleteComment')
            ->with(1, 1)
            ->andReturn(true);

        $result = $this->commentService->deleteComment(1, 1);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
