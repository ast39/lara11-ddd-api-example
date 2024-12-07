<?php

namespace App\Modules\Comment\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MessageResource;
use App\Modules\Post\Application\DTO\PostCreateDto;
use App\Modules\Post\Application\DTO\PostQueryDto;
use App\Modules\Post\Application\DTO\PostUpdateDto;
use App\Modules\Post\Application\Requests\PostCreateRequest;
use App\Modules\Post\Application\Requests\PostQueryRequest;
use App\Modules\Post\Application\Requests\PostUpdateRequest;
use App\Modules\Post\Application\Resources\PostResource;
use App\Modules\Post\Domain\Services\PostService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class CommentController extends Controller
{
    /**
     * @var PostService
     */
    protected PostService $postService;

    public function __constructor(PostService $postService): void
    {
        $this->postService = $postService;
    }

    /**
     * Список комментариев
     *
     * @param PostQueryRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *   path="/v1/comment",
     *   operationId="v1.comment.getList",
     *   tags={"Комментарии"},
     *   summary="Список комментариев",
     *   description="Список комментариев",
     *   security={{"apiKey": {} }},
     *
     *   @OA\Parameter(name="query", description="Поиск по совпадению", example="Test", in="query", required=false, @OA\Schema(type="string")),
     *   @OA\Parameter(name="post_id", description="Поиск по посту", example=1, in="query", required=false, @OA\Schema(type="integer", format="int32")),
     *   @OA\Parameter(name="author_id", description="Поиск по автору", example=1, in="query", required=false, @OA\Schema(type="integer", format="int32")),
     *   @OA\Parameter(name="page", description="Номер страницы", in="query", required=false, example="1", @OA\Schema(type="integer", format="int32")),
     *   @OA\Parameter(name="limit", description="Записей на страницу", in="query", required=false, example="10", @OA\Schema(type="integer", format="int32")),
     *   @OA\Parameter(name="order", description="Соротировка по полю", in="query", required=false, allowEmptyValue=true, schema={"type": "string", "enum": {"title", "status", "created"}, "default": "title"}),
     *   @OA\Parameter(name="reverse", description="Реверс сортировки", in="query", required=false, allowEmptyValue=true, schema={"type": "string", "enum": {"asc", "desc"}, "default": "asc"}),
     *
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Список комментариев", type="array", @OA\Items(ref="#/components/schemas/CommentResource"))
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
    public function index(PostQueryRequest $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $data = $request->validated();
            $list = $this->postService->postList(new PostQueryDto($data));

            return PostResource::collection($list)
                ->response()
                ->setStatusCode(200);
        });
    }

    /**
     * Получить комментарий
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get(
     *   path="/v1/comment/{id}",
     *   operationId="v1.comment.show",
     *   tags={"Комментарии"},
     *   summary="Просмотр отдельного комментария",
     *   description="Просмотр отдельного комментария",
     *   security={{"apiAuth": {} }},
     *
     *   @OA\Parameter(name="id", description="ID комментария", in="path", required=true, example="1", @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Пост", ref="#/components/schemas/CommentResource"),
     *       examples={
     *         @OA\Examples(example="Пример комментария", summary="Пример комментария",
     *           value={"id":1, "content":"Комментарий 1", "author_id": 1, "post_id": 1, "status": "published"}
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
            $grade = $this->postService->postById($id);

            return PostResource::make($grade)
                ->response()
                ->setStatusCode(200);
        });
    }

    /**
     * Добавить комментарий
     *
     * @param PostCreateRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *   path="/v1/comment",
     *   operationId="v1.comment.store",
     *   tags={"Комментарии"},
     *   summary="Добавить комментарий",
     *   description="Добавить пользователя",
     *   security={{"apiKey": {} }},
     *
     *   @OA\RequestBody(
     *     required=true,
     *     description="Данные нового пользователя",
     *     @OA\JsonContent(
     *       required={"title", "description"},
     *       @OA\Property(property="post_id", title="Пост", nullable="false", example=1, type="integer", format="int32"),
     *       @OA\Property(property="content", title="Контент", nullable="false", example="Комментарий 1", type="string"),
     *       @OA\Property(property="status", title="Статус", nullable="true", example="published", type="string", enum={"on_moderation","rejected","blocked","published"}),
     *       examples={
     *         @OA\Examples(example="Новый комментарий", summary="Новый комментарий", value={"content":"Контент 1", "author_id": 1, "post_id": 1}),
     *       }
     *     ),
     *   ),
     *   @OA\Response(response=201, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Должность", ref="#/components/schemas/PostResource")
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
    public function store(PostCreateRequest $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $data = $request->validated();
            $grade = $this->postService->store(new PostCreateDto($data));

            return PostResource::make($grade)
                ->response()
                ->setStatusCode(201);
        }, true);
    }

    /**
     * Обновить комментарий
     *
     * @param PostUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Put(
     *   path="/v1/comment/{id}",
     *   operationId="v1.comment.update",
     *   tags={"Комментарии"},
     *   summary="Обновить комментарий",
     *   description="Обновить комментарий",
     *   security={{"apiKey": {} }},
     *
     *   @OA\Parameter(name="id", description="ID комментария", in="path", required=true, example="1", @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     description="Обновленные данные колмментария",
     *     @OA\JsonContent(
     *       @OA\Property(property="author_id", title="Автор", nullable="true", example=1, type="integer", format="int32"),
     *       @OA\Property(property="post_id", title="Пост", nullable="true", example=1, type="integer", format="int32"),
     *       @OA\Property(property="content", title="Контент", nullable="true", example="Комментарий 1", type="string"),
     *       @OA\Property(property="status", title="Статус", nullable="true", example="published", type="string", enum={"on_moderation","rejected","blocked","published"}),
     *     ),
     *   ),
     *   @OA\Response(response=200, description="successful operation",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", title="Пост", ref="#/components/schemas/PostResource")
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
    public function update(PostUpdateRequest $request, int $id): JsonResponse
    {
        return $this->execute(function () use ($request, $id) {
            $data = $request->validated();
            $data['id'] = $id;

            $grade = $this->postService->update(new PostUpdateDto($data));

            return PostResource::make($grade)
                ->response()
                ->setStatusCode(200);
        }, true);
    }

    /**
     * Удалить комментарий
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Delete(
     *   path="/v1/comment/{id}",
     *   operationId="v1.comment.destroy",
     *   summary="Удаление комментария",
     *   description="Удаление комментария",
     *   tags={"Комментарии"},
     *   security={{"apiKey": {} }},
     *
     *   @OA\Parameter(name="id", description="ID комментария", in="path", required=true, example="1", @OA\Schema(type="integer")),
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
            $this->postService->destroy($id);

            return MessageResource::make(true)
                ->additional(['data' => ['msg' => 'Пост удален']])
                ->response()
                ->setStatusCode(200);
        }, true);
    }
}
