<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Requests\ArticleRequest;
use App\Response\ApiResponse;
use App\Services\ArticleService;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\ValidationHttpException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Number of articles per page
     */
    const ARTICLE_PER_PAGE = 2;

    /**
     * @var ArticleService
     */
    private $articleService;

    public function __construct(ArticleService $articleService) {
        $this->articleService = $articleService;
    }

    /**
     * @OA\Get(
     *   path="/api/articles",
     *   summary="All the articles",
     *   tags={"articles"},
     *   operationId="getArticles",
     *   @OA\Response(
     *     response=200,
     *     description="User's blog articles",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Article")
     *     )
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="errors", type="object")
     *     )
     *   )
     * )
     */
    public function getArticles (): JsonResponse|array
    {
        try {
            return $this->articleService->getArticles(self::ARTICLE_PER_PAGE);
        } catch (ValidationHttpException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_VALIDATION, $e->getMessage());
        } catch (ResourceException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, $e->getMessage());
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *   path="/api/articles/{articleId}",
     *   summary="Get a single article",
     *   tags={"articles"},
     *   operationId="getArticle",
     *   @OA\Parameter(
     *     name="articleId",
     *     description="Article ID",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Article fetched successfully",
     *     @OA\JsonContent(ref="#/components/schemas/Article")
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="errors", type="object")
     *     )
     *   )
     * )
     */
    public function getArticle(int $articleId): JsonResponse|array
    {
        try {
            $article = $this->articleService->getArticle($articleId);
        } catch (ValidationHttpException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_VALIDATION, $e->getMessage());
        } catch (ResourceException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, $e->getMessage());
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }

        return $article;
    }

    /**
     * @OA\Post(
     *   path="/api/articles",
     *   summary="Add a new article",
     *   tags={"articles"},
     *   operationId="addArticle",
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       ref="#/components/schemas/Article",
     *       example={
     *         "articleTitle": "Article Title",
     *         "articleContent": "This is a sample article content"
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Article created successfully",
     *     @OA\JsonContent(ref="#/components/schemas/Article")
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="errors", type="object")
     *     )
     *   ),
     *     security={{ "apiAuth": {} }}
     * )
     *
     */
    public function addArticle(ArticleRequest $request): JsonResponse|array
    {
        $articleTitle = $request->input('articleTitle');
        $articleContent = $request->input('articleContent');
        $userId = auth()->user()->id;

        try {
            return $this->articleService->addArticle($articleTitle, $articleContent, $userId) ?
                ApiResponse::response(HttpStatus::HTTP_CREATED, 'Article created successfully') :
                ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, 'Article not created');
        } catch (ResourceException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, $e->getMessage());
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *   path="/api/articles/{articleId}",
     *   summary="Edit an article",
     *   tags={"articles"},
     *   operationId="editArticle",
     *   @OA\Parameter(
     *     name="articleId",
     *     description="Article ID",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       ref="#/components/schemas/Article",
     *       example={
     *         "articleTitle": "Updated Article Title",
     *         "articleContent": "Updated article content"
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Article updated successfully",
     *     @OA\JsonContent(ref="#/components/schemas/Article")
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="errors", type="object")
     *     )
     *   ),
     * security={{ "apiAuth": {} }}
     * )
     */
    public function editArticle(int $articleId, ArticleRequest $request): JsonResponse|array
    {
        $articleTitle = $request->input('articleTitle');
        $articleContent = $request->input('articleContent');
        $userId = auth()->user()->id;

        try {
            return $this->articleService->editArticle($articleId, $articleTitle, $articleContent, $userId) ?
                ApiResponse::response(HttpStatus::HTTP_OK, 'Article updated successfully') :
                ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, 'Article not found');
        } catch (ResourceException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, $e->getMessage());
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/articles/{articleId}",
     *   summary="Delete an article",
     *   tags={"articles"},
     *   operationId="deleteArticle",
     *   @OA\Parameter(
     *     name="articleId",
     *     description="Article ID",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Article deleted successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Article deleted successfully")
     *     )
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Internal server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="errors", type="object")
     *     )
     *   ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function deleteArticle(int $articleId): JsonResponse|bool
    {
        if (!$articleId) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_VALIDATION, 'Article ID is required');
        }

        try {
            return $this->articleService->deleteArticle($articleId);
        } catch (ResourceException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, $e->getMessage());
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage());
        }
    }

}
