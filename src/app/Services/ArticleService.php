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
    public function getArticles(): array
    {
        return $this->articleRepo->getArticles()->toArray();
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
}
