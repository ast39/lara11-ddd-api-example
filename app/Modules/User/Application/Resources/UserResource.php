<?php

namespace App\Modules\User\Application\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   type="object",
 *   schema="UserResource",
 *   title="Карточка пользователя",
 *
 *   @OA\Property(title="ID", property="id", type="integer", format="int64", example=1234),
 *   @OA\Property(title="Имя", property="firstName", type="string", example="Иван"),
 *   @OA\Property(title="Отчество", property="secondName", type="string", example="Иванович"),
 *   @OA\Property(title="Фамилия", property="surname", type="string", example="Иванов"),
 *   @OA\Property(title="Должность", property="position", type="string", example="Директор"),
 *   @OA\Property(title="Логин", property="login", type="string", example="user@mail.ru"),
 *   @OA\Property(title="Заблокирован>", property="isBlocked", type="boolean", example=true),
 *   @OA\Property(title="Создан", property="created_at", type="datetime", example="2023-12-01 12:00:00"),
 * )
 */
class UserResource extends JsonResource
{
    public static $wrap = 'data';

    public function toArray($request): array
    {
        return [

            'id' => $this->resource->id ?? null,
            'firstName'  => $this->resource->first_name ?? null,
            'secondName' => $this->resource->second_name ?? null,
            'surname' => $this->resource->surname ?? null,
            'position' => $this->resource->position ?? null,
            'login' => $this->resource->login ?? null,
            'isBlocked' => $this->resource->is_blocked ?? null,
        ];
    }
}
