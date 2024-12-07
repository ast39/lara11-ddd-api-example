<?php

namespace App\Modules\Comment\Providers;

use App\Modules\Comment\Domain\Repositories\CommentRepositoryInterface;
use App\Modules\Comment\Infrastructure\Persistence\Repositories\CommentRepository;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
