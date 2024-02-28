<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Requests\CommentRequest;
use App\Response\ApiResponse;
use App\Services\CommentService;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\ValidationHttpException;
use Exception;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{

    /**
     * @var CommentService
     */
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    /**
     * @OA\Get(
     *   path="/api/articles/{articleId}/comments",
     *   summary="All the comments of an article",
     *   tags={"comments"},
     *   operationId="getComments",
     *   @OA\Response(
     *     response=200,
     *     description="Get all the Comments of a blog articles",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Comment")
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
    public function getComments($articleId): JsonResponse|array
    {
        $userId = auth()->user()->id;
        try {
            return $this->commentService->getComments($articleId, $userId);
        } catch (ValidationHttpException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_VALIDATION, $e->getMessage(), $e->getErrors());
        } catch (ResourceException $e) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, $e->getMessage(), $e->getErrors());
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage(), $e->getErrors());
        }
    }

    /**
     * @OA\Post(
     *   path="/api/articles/{articleId}/comments",
     *   summary="Add a new comment on an article",
     *   tags={"comments"},
     *   operationId="addAComment",
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       ref="#/components/schemas/Comment",
     *       example={
     *         "commentTitle": "Comment Title",
     *         "commentContent": "This is a sample comment content"
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Comment created successfully",
     *     @OA\JsonContent(ref="#/components/schemas/Comment")
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
    public function addComment(CommentRequest $request): JsonResponse|array
    {
        $commentTitle = $request->input('commentTitle');
        $commentContent = $request->input('commentContent');
        $articleId = $request->input('articleId');
        $userId = auth()->user()->id;

        try {
            return $this->commentService->addComment($commentTitle, $commentContent, $userId, $articleId) ?
                ApiResponse::response(HttpStatus::HTTP_CREATED, 'Comment created successfully') :
                ApiResponse::response(HttpStatus::CANT_COMPLETE_REQUEST, 'Comment not created');
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage(), $e->getErrors());
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/articles/{articleId}/comments/{commentId}",
     *   summary="Delete a comment of an article",
     *   tags={"comments"},
     *   operationId="deleteComment",
     *   @OA\Parameter(
     *     name="articleId",
     *     description="Article ID",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *    @OA\Parameter(
     *     name="commentId",
     *     description="Comment ID",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Comment deleted successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Comment deleted successfully")
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
    public function deleteComment($articleId, $commentId): JsonResponse|bool
    {
        if (!$commentId) {
            return ApiResponse::response(HttpStatus::CANT_COMPLETE_VALIDATION, 'Comment ID is required');
        }

        try {
            return $this->commentService->deleteComment($commentId);
        } catch (Exception $e) {
            return ApiResponse::response($e->getCode(), $e->getMessage(), $e->getErrors());
        }
    }

}
