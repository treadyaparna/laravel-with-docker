<?php

namespace App\Http\Resources;


use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @package App\Http\Resources\Comment
 * @OA\Schema(schema="Comment", type="object")
 */
class CommentResource extends JsonResource
{
    /**
     * @OA\Property(
     *   property="id",
     *   type="integer"
     * )
     */

    /**
     * @OA\Property(
     *     property="commentTitle",
     *     type="string"
     * )
     */

    /**
     * @OA\Property(
     *     property="commentContent",
     *     type="string"
     * )
     */

    /**
     * @OA\Property(
     *   property="user",
     *   ref="#/components/schemas/User",
     * )
     */

    /**
     * @OA\Property(
     *   property="article",
     *   ref="#/components/schemas/Article",
     * )
     */

    /**
     * Transform the resource into an array
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        /** @var Comment $comment */
        $comment = clone $this;

        return array(
            'id' => $comment->id,
            'commentTitle' => $comment->commentTitle,
            'commentContent' => $comment->commentContent,
            'userId' => $comment->userId,
            'articleId' => $comment->articleId,
        );
    }
}
