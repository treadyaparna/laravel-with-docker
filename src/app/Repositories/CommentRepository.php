<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function getComments($articleId, $userId)
    {
        return Comment::whereUserId($userId)->whereArticleId($articleId);
    }

    public function addComment($commentTitle, $commentContent, $userId, $articleId)
    {
        $comment = new Comment();
        $comment->title = $commentTitle;
        $comment->content = $commentContent;
        $comment->userId = $userId;
        $comment->articleId = $articleId;
        return $comment->save();
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        return $comment->delete();
    }
}
