<?php

namespace App\Modules\Post\Domain\Repositories;

use App\Modules\Post\Application\DTO\PostCreateDto;
use App\Modules\Post\Application\DTO\PostQueryDto;
use App\Modules\Post\Application\DTO\PostUpdateDto;
use App\Modules\Post\Domain\Models\PostModel;

interface PostRepositoryInterface
{
    /**
     * @param PostQueryDto $dto
     * @return mixed
     */
    public function getList(PostQueryDto $dto): mixed;

    /**
     * @param int $id
     * @return PostModel|null
     */
    public function getById(int $id): ?PostModel;

    /**
     * @param PostCreateDto $dto
     * @return PostModel
     */
    public function create(PostCreateDto $dto): PostModel;

    /**
     * @param PostModel $post
     * @param PostUpdateDto $dto
     * @return bool
     */
    public function update(PostModel $post, PostUpdateDto $dto): bool;

    /**
     * @param PostModel $post
     * @return void
     */
    public function delete(PostModel $post): void;

    /**
     * @param PostCreateDto $dto
     * @return bool
     */
    public function doublePostCheck(PostCreateDto $dto): bool;
}
