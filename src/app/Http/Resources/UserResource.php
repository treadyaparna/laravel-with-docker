<?php

namespace App\Http\Resources;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @package App\Http\Resources\User
 * @OA\Schema(schema="User", type="object")
 */
class UserResource extends JsonResource
{

    /**
     * @OA\Property(
     *   property="id",
     *   type="integer",
     *   nullable=false,
     * )
     */

    /**
     * @OA\Property(
     *   property="name",
     *   type="string",
     *   nullable=false,
     * )
     */

    /**
     * @OA\Property(
     *   property="email",
     *   type="string",
     *   nullable=true,
     * )
     */

    /**
     * @OA\Property(
     *   property="amount",
     *   type="double",
     *   nullable=true,
     * )
     */

    /**
     * Transform the resource into an array.
     *
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var User $user */
        $user = clone $this;

        return array('id'     => $user->id,
                     'name'   => $user->name,
                     'email'  => $user->email,
        );
    }
}
