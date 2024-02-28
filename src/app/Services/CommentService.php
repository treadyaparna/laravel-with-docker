<?php

namespace App\Services;


use App\Repositories\CommentRepository;

class CommentService
{

    /**
     * @var CommentRepository
     */
    private $commentRepo;


    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function getComments($articleId)
    {
        return $this->commentRepo->getComments($articleId)->toArray();
    }

    public function addComment($commentTitle, $commentContent, $userId, $articleId): bool
    {
        return $this->commentRepo->addComment($commentTitle, $commentContent, $userId, $articleId);
    }

    public function deleteComment($commentId, $articleId)
    {
        return $this->commentRepo->deleteComment($commentId, $articleId);
    }

}
