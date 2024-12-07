<?php

namespace App\Modules\User\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MessageResource;
use App\Modules\User\Application\DTO\UserCreateDto;
use App\Modules\User\Application\DTO\UserQueryDto;
use App\Modules\User\Application\DTO\UserUpdateDto;
use App\Modules\User\Application\Requests\UserCreateRequest;
use App\Modules\User\Application\Requests\UserQueryRequest;
use App\Modules\User\Application\Requests\UserUpdateRequest;
use App\Modules\User\Application\Resources\UserResource;
use App\Modules\User\Domain\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    public function __constructor(UserService $userService): void
    {
        $this->userService = $userService;
    }

    /**
     * Список пользователей
     *
     * @param UserQueryRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *   path="/v1/user",
     *   operationId="v1.user.getList",
     *   tags={"Пользователи"},
     *   summary="Список пользователей",
     *   description="Список пользователей",
     *   security={{"apiKey": {} }},
     *
     *   @OA\Parameter(name="query", description="Поиск по совпадению", example="Test", in="query", required=false, @OA\Schema(type="string")),
     *   @OA\Parameter(name="page", description="Номер страницы", in="query", required=false, example="1", @OA\Schema(type="integer", format="int32")),
     *   @OA\Parameter(name="limit", description="Записей на страницу", in="query", required=false, example="10", @OA\Schema(type="integer", format="int32")),
     *   @OA\Parameter(name="order", description="Соротировка по полю", in="query", required=false, allowEmptyValue=true, schema={"type": "string", "enum": {"title", "status", "created"}, "default": "title"}),
     *   @OA\Parameter(name="reverse", description="Реверс сортировки", in="query", required=false, allowEmptyValue=true, schema={"type": "string", "enum": {"asc", "desc"}, "default": "asc"}),
     *
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Список пользователей", type="array", @OA\Items(ref="#/components/schemas/UserResource"))
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad Request",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=404, description="Not found",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=500, description="server not available",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     * )
     */
    public function index(UserQueryRequest $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $data = $request->validated();
            $list = $this->userService->userList(new UserQueryDto($data));

            return UserResource::collection($list)
                ->response()
                ->setStatusCode(200);
        });
    }

    /**
     * Получить пользователя
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get(
     *   path="/v1/user/{id}",
     *   operationId="v1.user.show",
     *   tags={"Пользователи"},
     *   summary="Просмотр отдельного пользователя",
     *   description="Просмотр отдельного пользователя",
     *   security={{"apiAuth": {} }},
     *
     *   @OA\Parameter(name="id", description="ID пользователя", in="path", required=true, example="1", @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Пользлователь", ref="#/components/schemas/UserResource"),
     *       examples={
     *         @OA\Examples(example="Пример должности", summary="Пример пользователя",
     *           value={"id":1, "title":"CEO", "description":"Директор", "created_at": "2024-03-01 11:00:00"}
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad Request",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=404, description="Not found",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=500, description="server not available",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     * )
     */
    public function show(int $id): JsonResponse
    {
        return $this->execute(function () use ($id) {
            $grade = $this->userService->userById($id);

            return UserResource::make($grade)
                ->response()
                ->setStatusCode(200);
        });
    }

    /**
     * Добавить пользователя
     *
     * @param UserCreateRequest $request
     * @return JsonResponse
     *
     * @OA\User(
     *   path="/v1/user",
     *   operationId="v1.user.store",
     *   tags={"Пользователи"},
     *   summary="Добавить пользователя",
     *   description="Добавить пользователя",
     *   security={{"apiKey": {} }},
     *
     *   @OA\RequestBody(
     *     required=true,
     *     description="Данные нового пользователя",
     *     @OA\JsonContent(
     *       required={"first_name", "position", "login"},
     *       @OA\Property(property="login", title="Логин", nullable="false", example="user@mail.ru", type="string"),
     *       @OA\Property(property="password", title="Пароль", nullable="true", example="uqwerty12", type="string"),
     *       @OA\Property(property="first_name", title="Имя", nullable="false", example="Иван", type="string"),
     *       @OA\Property(property="second_name", title="Отчество", nullable="true", example="Иванович", type="string"),
     *       @OA\Property(property="surname", title="Фамилия", nullable="true", example="Иванов", type="string"),
     *       @OA\Property(property="position", title="Должность", nullable="false", example="Директор", type="string"),
     *       @OA\Property(property="is_blocked", title="Блокировка", nullable="true", example=false, type="boolean"),
     *       examples={
     *         @OA\Examples(example="Минимум данных", summary="Минимум данных", value={"login":"user@mail.ru", "first_name":"Иван", "position":"Директор"}),
     *       }
     *     ),
     *   ),
     *   @OA\Response(response=201, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Должность", ref="#/components/schemas/UserResource")
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad Request",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=404, description="Not found",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=500, description="server not available",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     * ),
     */
    public function store(UserCreateRequest $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $data = $request->validated();
            $grade = $this->userService->store(new UserCreateDto($data));

            return UserResource::make($grade)
                ->response()
                ->setStatusCode(201);
        }, true);
    }

    /**
     * Обновить пользователя
     *
     * @param UserUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Put(
     *   path="/v1/user/{id}",
     *   operationId="v1.user.update",
     *   tags={"Пользователи"},
     *   summary="Обновить пользователя",
     *   description="Обновить пользователя",
     *   security={{"apiKey": {} }},
     *
     *   @OA\Parameter(name="id", description="ID пользователя", in="path", required=true, example="1", @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     description="Обновленные данные пользователя",
     *     @OA\JsonContent(
     *       @OA\Property(property="password", title="Пароль", nullable="true", example="qwerty12", type="string"),
     *       @OA\Property(property="first_name", title="Имя", nullable="true", example="Иван", type="string"),
     *       @OA\Property(property="second_name", title="Отчество", nullable="true", example="Иванович", type="string"),
     *       @OA\Property(property="surname", title="Фамилия", nullable="true", example="Иванов", type="string"),
     *       @OA\Property(property="position", title="Должность", nullable="true", example="Директор", type="string"),
     *       @OA\Property(property="is_blocked", title="Блокировка", nullable="true", example=false, type="boolean"),
     *     ),
     *   ),
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Категория", ref="#/components/schemas/UserResource")
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad Request",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=404, description="Not found",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=500, description="server not available",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     * ),
     */
    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        return $this->execute(function () use ($request, $id) {
            $data = $request->validated();
            $data['gradeId'] = $id;

            $grade = $this->userService->update(new UserUpdateDto($data));

            return UserResource::make($grade)
                ->response()
                ->setStatusCode(200);
        }, true);
    }

    /**
     * Удалить должность
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Delete(
     *   path="/v1/user/{id}",
     *   operationId="v1.user.destroy",
     *   summary="Удаление пользователя",
     *   description="Удаление пользователя",
     *   tags={"Пользователи"},
     *   security={{"apiKey": {} }},
     *
     *   @OA\Parameter(name="id", description="ID пользователя", in="path", required=true, example="1", @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Простой ответ", ref="#/components/schemas/MessageResource")
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad Request",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=404, description="Not found",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     *   @OA\Response(response=500, description="server not available",
     *     @OA\JsonContent(@OA\Property(property="data", title="Ответ с ошибкой", ref="#/components/schemas/ErrorResource"))
     *   ),
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->execute(function () use ($id) {
            $this->userService->destroy($id);

            return MessageResource::make(true)
                ->additional(['data' => ['msg' => 'Пользователь удален']])
                ->response()
                ->setStatusCode(200);
        }, true);
    }
}
