<?php

namespace App\Modules\Comment\Domain\Repositories;

use App\Modules\Comment\Application\DTO\CommentCreateDto;
use App\Modules\Comment\Application\DTO\CommentQueryDto;
use App\Modules\Comment\Application\DTO\CommentUpdateDto;
use App\Modules\Comment\Domain\Models\CommentModel;

interface CommentRepositoryInterface
{
    /**
     * @param CommentQueryDto $dto
     * @return mixed
     */
    public function getList(CommentQueryDto $dto): mixed;

    /**
     * @param int $id
     * @return CommentModel|null
     */
    public function getById(int $id): ?CommentModel;

    /**
     * @param CommentCreateDto $dto
     * @return CommentModel
     */
    public function create(CommentCreateDto $dto): CommentModel;

    /**
     * @param CommentModel $comment
     * @param CommentUpdateDto $dto
     * @return bool
     */
    public function update(CommentModel $comment, CommentUpdateDto $dto): bool;

    /**
     * @param CommentModel $comment
     * @return void
     */
    public function delete(CommentModel $comment): void;

    /**
     * @param CommentCreateDto $dto
     * @return bool
     */
    public function doubleCommentCheck(CommentCreateDto $dto): bool;
}
