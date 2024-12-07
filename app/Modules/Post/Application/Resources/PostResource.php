<?php

namespace App\Modules\Post\Application\Resources;

use App\Modules\Comment\Application\Resources\CommentResource;
use App\Modules\User\Application\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   type="object",
 *   schema="PostResource",
 *   title="Карточка поста",
 *
 *   @OA\Property(title="ID", property="id", type="integer", format="int64", example=1234),
 *   @OA\Property(title="Заголовок", property="title", type="string", example="Заголовок 1"),
 *   @OA\Property(title="Контент", property="content", type="string", example="Контент 1"),
 *   @OA\Property(title="ID автора", property="author_id", type="integer", format="int64", example="1),
 *   @OA\Property(title="Статус", property="status", type="string", example="published"),
 *   @OA\Property(title="Создан", property="created_at", type="datetime", example="2023-12-01 12:00:00"),
 *
 *   @OA\Property(title="Автор поста", property="author", ref="#/components/schemas/UserResource")),
 *   @OA\Property(title="Комментарии поста", property="comments", type="Array", @OA\Items(ref="#/components/schemas/UserResource")),
 * )
 */
class PostResource extends JsonResource
{
    public static $wrap = 'data';

    public function toArray($request): array
    {
        return [

            'id' => $this->resource->id ?? null,
            'title'  => $this->resource->title ?? null,
            'content' => $this->resource->content ?? null,
            'author_id' => $this->resource->author_id ?? null,
            'status' => $this->resource->status ?? null,
            'created_at' => $this->resource->created_at ?? null,

            'author' => UserResource::make($this->author),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
