<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function getArticles()
    {
        return Article::all();
    }

    public function addArticle($articleTitle, $articleContent, $userId)
    {
        $article = new Article();
        $article->title = $articleTitle;
        $article->content = $articleContent;
        $article->userId = $userId;
        return $article->save();
    }

    public function editArticle($articleId, $articleTitle, $articleContent, $userId)
    {
        $article = Article::find($articleId);
        $article->title = $articleTitle;
        $article->content = $articleContent;
        $article->userId = $userId;
        return $article->save();
    }

    public function deleteArticle(int $articleId)
    {
        $article = Article::find($articleId);
        return $article->delete();
    }

}
