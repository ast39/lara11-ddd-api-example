<?php

namespace DDD\User\Providers;

use App\Modules\Sso\Domain\Repositories\UserRepositoryInterface;
use App\Modules\Sso\Infrastructure\Persistence\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
