<?php

namespace DDD\Post\Providers;

use App\Modules\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Persistence\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
