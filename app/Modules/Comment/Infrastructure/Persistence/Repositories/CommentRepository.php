<?php

namespace App\Modules\Comment\Infrastructure\Persistence\Repositories;

use App\Modules\Comment\Application\DTO\CommentCreateDto;
use App\Modules\Comment\Application\DTO\CommentQueryDto;
use App\Modules\Comment\Application\DTO\CommentUpdateDto;
use App\Modules\Comment\Domain\Models\CommentModel;
use App\Modules\Comment\Domain\Repositories\CommentRepositoryInterface;
use App\Modules\Comment\Infrastructure\Persistence\Scopes\CommentModelScope;
use Illuminate\Contracts\Container\BindingResolutionException;

class CommentRepository implements CommentRepositoryInterface
{
    protected CommentModel $commentModel;

    public function __construct(CommentModel $commentModel)
    {
        $this->commentModel = $commentModel;
    }

    /**
     * Список комментариев
     *
     * @param CommentQueryDto $dto
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getList(CommentQueryDto $dto): mixed
    {
        $filter = app()->make(CommentModelScope::class, [
            'queryParams' => array_filter($dto->toArray())
        ]);

        $query = $this->commentModel::query()
            ->filter($filter);

        $gradeList = $query->orderBy('created_at', 'DESC');

        return is_null($dto->limit ?? null)
            ? $gradeList->get()
            : $gradeList->paginate($dto->limit);
    }

    /**
     * Получить комментарий по ID
     *
     * @param int $id
     * @return CommentModel|null
     */
    public function getById(int $id): ?CommentModel
    {
        $grade = $this->commentModel::query()
            ->where('id', $id)
            ->first();

        return $grade instanceof CommentModel ? $grade : null;
    }

    /**
     * Добавить комментарий
     *
     * @param CommentCreateDto $dto
     * @return CommentModel
     */
    public function create(CommentCreateDto $dto): CommentModel
    {
        return $this->commentModel->create($dto->toArray());
    }

    /**
     * Обновить комментарий
     *
     * @param CommentModel $comment
     * @param CommentUpdateDto $dto
     * @return bool
     */
    public function update(CommentModel $comment, CommentUpdateDto $dto): bool
    {
        $updateData = collect($dto)->except(['id']);
        $updateData = array_filter($updateData->toArray(), function ($e) {
            return !is_null($e);
        });

        return $comment->update($updateData);
    }

    /**
     * Удалить комментарий
     *
     * @param CommentModel $comment
     * @return void
     */
    public function delete(CommentModel $comment): void
    {
        $comment->delete();
    }

    /**
     * Проверить комментарий на дубль
     *
     * @param CommentCreateDto $dto
     * @return bool
     */
    public function doubleCommentCheck(CommentCreateDto $dto): bool
    {
        return $this->commentModel::query()
            ->where('content', $dto->content)
            ->count() > 0;
    }
}
