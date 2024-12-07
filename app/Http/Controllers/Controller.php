<?php

namespace App\Http\Controllers;

use App\Dto\ServerErrorDto;
use App\Http\Resources\Api\ErrorResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

# php artisan l5-swagger:generate


/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Rest Api DDD - Laravel 11",
 *   description="Example of Rest Api DDD by Laravel 11 platform",
 *   @OA\Contact(
 *     email="alexandr.statut@gmail.com",
 *     name="ASt"
 *   ),
 * )
 *
 * @OA\Server(
 *   url=L5_SWAGGER_DEV_HOST,
 *   description="Dev API server"
 * )
 * @OA\Server(
 *   url=L5_SWAGGER_PROD_HOST,
 *   description="Prod API server"
 * )
 *
 * @OA\SecurityScheme(
 *   type="http",
 *   description="Your token providing after auth in Api",
 *   name="Api Client",
 *   in="header",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 *   securityScheme="apiAuth",
 * )
 *
 * @OA\ExternalDocumentation(
 *   description="Api Docs",
 *   url="https://127.0.0.1:8000/api/docs",
 * )
 *
 * @OA\Tag(
 *   name="Авторизация",
 *   description="Блок авторизации"
 * ),
 * @OA\Tag(
 *   name="Пользователи",
 *   description="Блок пользователей"
 * )
 */
abstract class Controller {

    use AuthorizesRequests;

    /**
     * Общий интерфейс выполнения эндпоинтов через try catch с логированием и возвратом ошибок
     *
     * @param callable $callback
     * @param bool $useTransaction
     * @return JsonResponse
     */
    protected function execute(callable $callback, bool $useTransaction = false): JsonResponse
    {
        try {
            if ($useTransaction) {
                DB::beginTransaction();
            }

            $response = $callback();

            if ($useTransaction) {
                DB::commit();
            }

            return $response;
        } catch (\Exception $e) {
            if ($useTransaction) {
                DB::rollBack();
            }

            // Здесь не нужно использовать ??, просто передаем $e->getFile()
            Log::error($e->getFile(), ['msg' => $e->getMessage()]);

            return ErrorResource::make(new ServerErrorDto($e->getMessage(), $e->getCode()))
                ->response()
                ->setStatusCode(is_int($e->getCode()) ? ($e->getCode() > 0 ? $e->getCode() : 500) : 500);
        }
    }
}
