<?php

namespace App\Modules\User\Infrastructure\Persistence\Repositories;

use App\Modules\User\Application\DTO\UserCreateDto;
use App\Modules\User\Application\DTO\UserQueryDto;
use App\Modules\User\Application\DTO\UserUpdateDto;
use App\Modules\User\Domain\Models\UserModel;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;
use App\Modules\User\Infrastructure\Persistence\Scopes\UserModelScope;
use Illuminate\Contracts\Container\BindingResolutionException;

class UserRepository implements UserRepositoryInterface
{
    protected UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Список юзеров
     *
     * @param UserQueryDto $dto
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getList(UserQueryDto $dto): mixed
    {
        $filter = app()->make(UserModelScope::class, [
            'queryParams' => array_filter($dto->toArray())
        ]);

        $query = $this->userModel::query()
            ->filter($filter);

        $gradeList = $query->orderBy('created_at', 'DESC');

        return is_null($dto->limit ?? null)
            ? $gradeList->get()
            : $gradeList->paginate($dto->limit);
    }

    /**
     * Получить юзера по ID
     *
     * @param int $id
     * @return UserModel|null
     */
    public function getById(int $id): ?UserModel
    {
        $grade = $this->userModel::query()
            ->where('id', $id)
            ->first();

        return $grade instanceof UserModel ? $grade : null;
    }

    /**
     * Добавить юзера
     *
     * @param UserCreateDto $dto
     * @return UserModel
     */
    public function create(UserCreateDto $dto): UserModel
    {
        return $this->userModel->create($dto->toArray());
    }

    /**
     * Обновить юзера
     *
     * @param UserModel $user
     * @param UserUpdateDto $dto
     * @return bool
     */
    public function update(UserModel $user, UserUpdateDto $dto): bool
    {
        $updateData = collect($dto)->except(['gradeId']);
        $updateData = array_filter($updateData->toArray(), function ($e) {
            return !is_null($e);
        });

        return $user->update($updateData);
    }

    /**
     * Удалить юзера
     *
     * @param UserModel $user
     * @return void
     */
    public function delete(UserModel $user): void
    {
        $user->delete();
    }

    /**
     * Проверить юзера на дубль
     *
     * @param UserCreateDto $dto
     * @return bool
     */
    public function doubleGradeCheck(UserCreateDto $dto): bool
    {
        return $this->userModel::query()
            ->where('login', $dto->login)
            ->count() > 0;
    }
}
