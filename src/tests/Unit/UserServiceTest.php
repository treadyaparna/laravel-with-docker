<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Services\CommentService;
use App\Services\UserService;
use PHPUnit\Framework\TestCase;
use Mockery;

class UserServiceTest extends TestCase
{
    protected $userService;
    protected $userRepoMock;

    public function setUp(): void
    {
        $this->userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $this->userService = new UserService($this->userRepoMock);
    }

    public function testAddUser()
    {
        $this->userRepoMock->shouldReceive('addUser')
            ->with('Test User', 'test@user.com', 'password', 1)
            ->andReturn(true);

        $result = $this->userService->addUser('Test User', 'test@user.com', 'password', 1);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
