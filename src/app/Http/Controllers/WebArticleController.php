<?php

namespace App\Http\Controllers;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Http;


class WebArticleController extends Controller
{
    public function __construct(ArticleService $articleService) {
        $this->articleService = $articleService;
    }

    public function getArticles()
    {
        $data = $this->articleService->getArticles();

        return view('articles.index', ['data' =>$data]);
    }
}
