<?php

namespace App\Modules\User\Domain\Services;

use App\Modules\User\Application\DTO\UserCreateDto;
use App\Modules\User\Application\DTO\UserQueryDto;
use App\Modules\User\Application\DTO\UserUpdateDto;
use App\Modules\User\Domain\Exceptions\UserException;
use App\Modules\User\Domain\Models\UserModel;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Получить список юзеров
     *
     * @param UserQueryDto $dto
     * @return Collection|LengthAwarePaginator
     */
    public function userList(UserQueryDto $dto): Collection|LengthAwarePaginator
    {
        return $this->userRepository->getList($dto);
    }

    /**
     * Получить юзера по ID
     *
     * @param int $id
     * @return UserModel
     * @throws UserException
     */
    public function userById(int $id): UserModel
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            throw UserException::notFound();
        }

        return $user;
    }

    /**
     * Создать юзера
     *
     * @param UserCreateDto $dto
     * @return UserModel
     * @throws UserException
     */
    public function store(UserCreateDto $dto): UserModel
    {
        if ($this->userRepository->doubleGradeCheck($dto)) {
            throw UserException::doubleLogin();
        }

        return $this->userRepository->create($dto);
    }

    /**
     * Обновить юзера
     *
     * @param UserUpdateDto $dto
     * @return UserModel
     * @throws UserException
     */
    public function update(UserUpdateDto $dto): UserModel
    {
        $user = $this->userById($dto->id);

        $this->userRepository->update($user, $dto);

        return $this->userRepository->getById($dto->id);
    }

    /**
     * Удалить юзера
     *
     * @param int $id
     * @return void
     * @throws UserException
     */
    public function destroy(int $id): void
    {
        $user = $this->userById($id);

        $this->userRepository->delete($user);
    }
}
