<?php

namespace App\Modules\User\Domain\Repositories;

use App\Modules\User\Application\DTO\UserCreateDto;
use App\Modules\User\Application\DTO\UserQueryDto;
use App\Modules\User\Application\DTO\UserUpdateDto;
use App\Modules\User\Domain\Models\UserModel;

interface UserRepositoryInterface
{
    /**
     * @param UserQueryDto $dto
     * @return mixed
     */
    public function getList(UserQueryDto $dto): mixed;

    /**
     * @param int $id
     * @return UserModel|null
     */
    public function getById(int $id): ?UserModel;

    /**
     * @param UserCreateDto $dto
     * @return UserModel
     */
    public function create(UserCreateDto $dto): UserModel;

    /**
     * @param UserModel $user
     * @param UserUpdateDto $dto
     * @return bool
     */
    public function update(UserModel $user, UserUpdateDto $dto): bool;

    /**
     * @param UserModel $user
     * @return void
     */
    public function delete(UserModel $user): void;

    /**
     * @param UserCreateDto $dto
     * @return bool
     */
    public function doubleGradeCheck(UserCreateDto $dto): bool;
}
