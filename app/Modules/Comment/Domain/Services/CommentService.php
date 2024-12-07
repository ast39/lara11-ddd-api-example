<?php

namespace App\Modules\Comment\Domain\Services;

use App\Modules\Comment\Application\DTO\CommentCreateDto;
use App\Modules\Comment\Application\DTO\CommentQueryDto;
use App\Modules\Comment\Application\DTO\CommentUpdateDto;
use App\Modules\Comment\Domain\Exceptions\CommentException;
use App\Modules\Comment\Domain\Models\CommentModel;
use App\Modules\Comment\Domain\Repositories\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentService
{
    /**
     * @var CommentRepositoryInterface
     */
    protected CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Получить список комментариев
     *
     * @param CommentQueryDto $dto
     * @return Collection|LengthAwarePaginator
     */
    public function commentList(CommentQueryDto $dto): Collection|LengthAwarePaginator
    {
        return $this->commentRepository->getList($dto);
    }

    /**
     * Получить комментарий по ID
     *
     * @param int $id
     * @return CommentModel
     * @throws CommentException
     */
    public function commentById(int $id): CommentModel
    {
        $Comment = $this->commentRepository->getById($id);

        if (!$Comment) {
            throw CommentException::notFound();
        }

        return $Comment;
    }

    /**
     * Создать комментарий
     *
     * @param CommentCreateDto $dto
     * @return CommentModel
     * @throws CommentException
     */
    public function store(CommentCreateDto $dto): CommentModel
    {
        if ($this->commentRepository->doubleCommentCheck($dto)) {
            throw CommentException::doubleComment();
        }

        return $this->commentRepository->create($dto);
    }

    /**
     * Обновить комментарий
     *
     * @param CommentUpdateDto $dto
     * @return CommentModel
     * @throws CommentException
     */
    public function update(CommentUpdateDto $dto): CommentModel
    {
        $Comment = $this->commentById($dto->id);

        $this->commentRepository->update($Comment, $dto);

        return $this->commentRepository->getById($dto->id);
    }

    /**
     * Удалить комментарий
     *
     * @param int $id
     * @return void
     * @throws CommentException
     */
    public function destroy(int $id): void
    {
        $Comment = $this->commentById($id);

        $this->commentRepository->delete($Comment);
    }
}
