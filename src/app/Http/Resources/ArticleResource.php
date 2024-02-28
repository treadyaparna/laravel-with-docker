<?php

namespace App\Http\Resources;


use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @package App\Http\Resources\Article
 * @OA\Schema(schema="Article", type="object")
 */
class ArticleResource extends JsonResource
{

    /**
     * @OA\Property(
     *   property="id",
     *   type="integer"
     * )
     */

    /**
     * @OA\Property(
     *     property="articleTitle",
     *     type="string"
     * )
     */

    /**
     * @OA\Property(
     *     property="content",
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
     * Transform the resource into an array.
     *
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        /** @var Article $article */
        $article = clone $this;

        return array('id' => $article->id,
            'articleTitle' => $article->articleTitle,
            'articleContent' => $article->articleContent,
        );
    }
}
