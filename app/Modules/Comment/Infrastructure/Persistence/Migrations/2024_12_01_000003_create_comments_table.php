<?php

use App\Modules\Comment\Application\Enums\CommentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('post_id')
                ->nullable(false)
                ->comment('ID поста');

            $table->unsignedBigInteger('author_id')
                ->nullable(false)
                ->comment('ID автора');

            $table->string('content')
                ->nullable(false)
                ->comment('Контент');

            $table->enum('status', [
                CommentStatusEnum::ON_MODERATION->value,
                CommentStatusEnum::REJECTED->value,
                CommentStatusEnum::BLOCKED->value,
                CommentStatusEnum::PUBLISHED->value,
            ])
                ->default(CommentStatusEnum::ON_MODERATION->value)
                ->comment('Статус');

            $table->timestamps();

            $table->comment('Комментарии');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->cascadeOnDelete();

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
