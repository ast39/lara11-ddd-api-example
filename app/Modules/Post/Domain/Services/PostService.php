<?php

namespace App\Modules\Post\Domain\Services;

use App\Modules\Post\Application\DTO\PostCreateDto;
use App\Modules\Post\Application\DTO\PostQueryDto;
use App\Modules\Post\Application\DTO\PostUpdateDto;
use App\Modules\Post\Domain\Exceptions\PostException;
use App\Modules\Post\Domain\Models\PostModel;
use App\Modules\Post\Domain\Repositories\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    /**
     * @var PostRepositoryInterface
     */
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Получить список постов
     *
     * @param PostQueryDto $dto
     * @return Collection|LengthAwarePaginator
     */
    public function postList(PostQueryDto $dto): Collection|LengthAwarePaginator
    {
        return $this->postRepository->getList($dto);
    }

    /**
     * Получить пост по ID
     *
     * @param int $id
     * @return PostModel
     * @throws PostException
     */
    public function postById(int $id): PostModel
    {
        $Post = $this->postRepository->getById($id);

        if (!$Post) {
            throw PostException::notFound();
        }

        return $Post;
    }

    /**
     * Создать пост
     *
     * @param PostCreateDto $dto
     * @return PostModel
     * @throws PostException
     */
    public function store(PostCreateDto $dto): PostModel
    {
        if ($this->postRepository->doublePostCheck($dto)) {
            throw PostException::doublePost();
        }

        return $this->postRepository->create($dto);
    }

    /**
     * Обновить пост
     *
     * @param PostUpdateDto $dto
     * @return PostModel
     * @throws PostException
     */
    public function update(PostUpdateDto $dto): PostModel
    {
        $Post = $this->postById($dto->id);

        $this->postRepository->update($Post, $dto);

        return $this->postRepository->getById($dto->id);
    }

    /**
     * Удалить пост
     *
     * @param int $id
     * @return void
     * @throws PostException
     */
    public function destroy(int $id): void
    {
        $Post = $this->postById($id);

        $this->postRepository->delete($Post);
    }
}
