<?php

namespace App\Services;


use App\Repositories\ArticleRepository;

class ArticleService
{

    /**
     * @var ArticleRepository
     */
    private $articleRepo;


    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    /**
     * Get balance position
     *
     * @return array
     */
    public function getArticles($articlePerPage): array
    {
        $articles = $this->articleRepo->getArticles($articlePerPage);
        if (is_object($articles) && method_exists($articles, 'toArray')) {
            return $articles->toArray();
        }
        return $articles;
    }

    public function addArticle($articleTitle, $articleContent, $userId): bool
    {
        return $this->articleRepo->addArticle($articleTitle, $articleContent, $userId);
    }

    public function editArticle($articleId, $articleTitle, $articleContent, $userId)
    {
        return $this->articleRepo->editArticle($articleId, $articleTitle, $articleContent, $userId);
    }

    public function deleteArticle(int $articleId)
    {
        return $this->articleRepo->deleteArticle($articleId);
    }

    public function getArticle(int $articleId)
    {
        $article = $this->articleRepo->getArticle($articleId);
        if (is_object($article) && method_exists($article, 'toArray')) {
            return $article->toArray();
        }
        return $article;
    }
}
