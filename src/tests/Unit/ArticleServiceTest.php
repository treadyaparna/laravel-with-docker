<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Services\ArticleService;
use App\Repositories\ArticleRepository;
use PHPUnit\Framework\TestCase;
use Mockery;

class ArticleServiceTest extends TestCase
{
    protected $articleService;
    protected $articleRepoMock;
    protected $mockArticle; // Declare the property here

    public function setUp(): void
    {
        parent::setUp();

        $this->articleRepoMock = $this->createMock(ArticleRepository::class);
        $this->articleService = new ArticleService($this->articleRepoMock);

        // Mock data
        $this->mockArticle = [
            'id' => 1,
            'title' => 'Test Article',
            'content' => 'This is a test article content',
            'user_id' => 1
        ];
    }

    public function testAddArticle()
    {
        $this->articleRepoMock->expects($this->once())
            ->method('addArticle')
            ->with($this->mockArticle['title'], $this->mockArticle['content'], $this->mockArticle['user_id'])
            ->willReturn(true);

        $result = $this->articleService->addArticle($this->mockArticle['title'], $this->mockArticle['content'], $this->mockArticle['user_id']);

        $this->assertTrue($result);
    }

    public function testEditArticle()
    {
        $this->articleRepoMock->expects($this->once())
            ->method('editArticle')
            ->with($this->mockArticle['id'], $this->mockArticle['title'], $this->mockArticle['content'], $this->mockArticle['user_id'])
            ->willReturn(true);

        $result = $this->articleService->editArticle($this->mockArticle['id'], $this->mockArticle['title'], $this->mockArticle['content'], $this->mockArticle['user_id']);

        $this->assertTrue($result);
    }

    public function testDeleteArticle()
    {
        $this->articleRepoMock->expects($this->once())
            ->method('deleteArticle')
            ->with($this->mockArticle['id'])
            ->willReturn(true);

        $result = $this->articleService->deleteArticle($this->mockArticle['id']);

        $this->assertTrue($result);
    }

    public function testGetArticle()
    {
        $this->articleRepoMock->expects($this->once())
            ->method('getArticle')
            ->with($this->mockArticle['id'])
            ->willReturn($this->mockArticle);

        $result = $this->articleService->getArticle($this->mockArticle['id']);

        $this->assertEquals($this->mockArticle, $result);
    }

    public function testGetArticles()
    {
        $articlePerPage = 10;
        $this->articleRepoMock->expects($this->once())
            ->method('getArticles')
            ->with($articlePerPage)
            ->willReturn([$this->mockArticle]);

        $result = $this->articleService->getArticles($articlePerPage);

        $this->assertEquals([$this->mockArticle], $result);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
