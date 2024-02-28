<?php

namespace App\Repositories;

use App\Models\Comment;
use Dingo\Api\Exception\ResourceException;

class CommentRepository
{
    public function getComments($articleId)
    {
        $comments = Comment::where('articleId', $articleId)->get();

        // If the comment doesn't exist, throw an exception
        if (!$comments  || count($comments) === 0) {
            throw new ResourceException('Comment not found');
        }

        return $comments;
    }

    public function addComment($commentTitle, $commentContent, $userId, $articleId)
    {
        $comment = new Comment();
        $comment->title = $commentTitle;
        $comment->content = $commentContent;
        $comment->userId = $userId;
        $comment->articleId = $articleId;

        try {
            return $comment->save();
        } catch (\Exception $e) {
            throw new ResourceException('Comment not added');
        }
    }

    public function deleteComment($commentId, $articleId)
    {
        $comment = Comment::find($commentId);

        // If the comment doesn't exist, throw an exception
        if (!$comment) {
            throw new ResourceException('Comment not found');
        }

        return $comment->delete();
    }
}
