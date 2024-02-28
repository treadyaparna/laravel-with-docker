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

    public function getComments($articleId, $userId)
    {
        return $this->commentRepo->getComments($articleId, $userId)->toArray();
    }

    public function addComment($commentTitle, $commentContent, $userId, $articleId): bool
    {
        return $this->commentRepo->addComment($commentTitle, $commentContent, $userId, $articleId);
    }

    public function deleteComment($commentId)
    {
        return $this->commentRepo->deleteComment($commentId);
    }

}
