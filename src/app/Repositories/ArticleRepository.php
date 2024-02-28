<?php

namespace App\Repositories;

use App\Models\Article;
use Dingo\Api\Exception\ResourceException;

class ArticleRepository
{
    public function getArticles($articlePerPage)
    {
        try {
            return Article::paginate($articlePerPage);
        } catch (\Exception $e) {
            throw new ResourceException('No article found');
        }
    }

    public function addArticle($articleTitle, $articleContent, $userId)
    {
        $article = new Article();
        $article->title = $articleTitle;
        $article->content = $articleContent;
        $article->userId = $userId;

        try {
            return $article->save();
        } catch (\Exception $e) {
            throw new ResourceException('Article not added');
        }
    }

    public function editArticle($articleId, $articleTitle, $articleContent, $userId)
    {
        $article = Article::find($articleId);

        // If the article doesn't exist, throw an exception
        if (!$article) {
            throw new ResourceException('Article not found');
        }

        $article->title = $articleTitle;
        $article->content = $articleContent;
        $article->userId = $userId;

        try {
            return $article->save();
        } catch (\Exception $e) {
            throw new ResourceException('Article not updated');
        }
    }

    public function deleteArticle(int $articleId)
    {
        $article = Article::find($articleId);

        // If the article doesn't exist, throw an exception
        if (!$article) {
            throw new ResourceException('Article not found');
        }

        try {
            return $article->delete();
        } catch (\Exception $e) {
            throw new ResourceException('Article not deleted');
        }
    }

    public function getArticle(int $articleId)
    {
        $article = Article::find($articleId);

        if (!$article) {
            throw new ResourceException('Article not found');
        }

        return $article;
    }

}
