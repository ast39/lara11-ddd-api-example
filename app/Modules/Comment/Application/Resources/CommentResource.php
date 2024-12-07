<?php

namespace App\Modules\Comment\Application\Resources;

use App\Modules\User\Application\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   type="object",
 *   schema="CommentResource",
 *   title="Карточка комментария",
 *
 *   @OA\Property(title="ID", property="id", type="integer", format="int64", example=1234),
 *   @OA\Property(title="Контент", property="content", type="string", example="Контент 1"),
 *   @OA\Property(title="ID поста", property="post_id", type="integer", format="int64", example="1),
 *   @OA\Property(title="ID автора", property="author_id", type="integer", format="int64", example="1),
 *   @OA\Property(title="Статус", property="status", type="string", example="published"),
 *   @OA\Property(title="Создан", property="created_at", type="datetime", example="2023-12-01 12:00:00"),
 *
 *   @OA\Property(title="Автор комментрия", property="author", ref="#/components/schemas/UserResource")),
 * )
 */
class CommentResource extends JsonResource
{
    public static $wrap = 'data';

    public function toArray($request): array
    {
        return [

            'id' => $this->resource->id ?? null,
            'content' => $this->resource->content ?? null,
            'post_id' => $this->resource->post_id ?? null,
            'author_id' => $this->resource->author_id ?? null,
            'status' => $this->resource->status ?? null,
            'created_at' => $this->resource->created_at ?? null,

            'author' => UserResource::make($this->author),
        ];
    }
}
