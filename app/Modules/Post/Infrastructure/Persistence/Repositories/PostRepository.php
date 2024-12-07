<?php

namespace App\Modules\Post\Infrastructure\Persistence\Repositories;

use App\Modules\Post\Application\DTO\PostCreateDto;
use App\Modules\Post\Application\DTO\PostQueryDto;
use App\Modules\Post\Application\DTO\PostUpdateDto;
use App\Modules\Post\Domain\Models\PostModel;
use App\Modules\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Persistence\Scopes\PostModelScope;
use Illuminate\Contracts\Container\BindingResolutionException;

class PostRepository implements PostRepositoryInterface
{
    protected PostModel $postModel;

    public function __construct(PostModel $postModel)
    {
        $this->postModel = $postModel;
    }

    /**
     * Список постов
     *
     * @param PostQueryDto $dto
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getList(PostQueryDto $dto): mixed
    {
        $filter = app()->make(PostModelScope::class, [
            'queryParams' => array_filter($dto->toArray())
        ]);

        $query = $this->postModel::query()
            ->filter($filter);

        $gradeList = $query->orderBy('created_at', 'DESC');

        return is_null($dto->limit ?? null)
            ? $gradeList->get()
            : $gradeList->paginate($dto->limit);
    }

    /**
     * Получить пост по ID
     *
     * @param int $id
     * @return PostModel|null
     */
    public function getById(int $id): ?PostModel
    {
        $grade = $this->postModel::query()
            ->where('id', $id)
            ->first();

        return $grade instanceof PostModel ? $grade : null;
    }

    /**
     * Добавить пост
     *
     * @param PostCreateDto $dto
     * @return PostModel
     */
    public function create(PostCreateDto $dto): PostModel
    {
        return $this->postModel->create($dto->toArray());
    }

    /**
     * Обновить пост
     *
     * @param PostModel $post
     * @param PostUpdateDto $dto
     * @return bool
     */
    public function update(PostModel $post, PostUpdateDto $dto): bool
    {
        $updateData = collect($dto)->except(['id']);
        $updateData = array_filter($updateData->toArray(), function ($e) {
            return !is_null($e);
        });

        return $post->update($updateData);
    }

    /**
     * Удалить пост
     *
     * @param PostModel $post
     * @return void
     */
    public function delete(PostModel $post): void
    {
        $post->delete();
    }

    /**
     * Проверить поста на дубль
     *
     * @param PostCreateDto $dto
     * @return bool
     */
    public function doublePostCheck(PostCreateDto $dto): bool
    {
        return $this->postModel::query()
            ->where('title', $dto->title)
            ->count() > 0;
    }
}
