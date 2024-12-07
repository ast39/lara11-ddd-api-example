<?php

use App\Modules\Post\Application\Enums\PostStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {

    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('author_id')
                ->nullable(false)
                ->comment('ID автора');

            $table->string('title')
                ->nullable(false)
                ->comment('Название');

            $table->string('content')
                ->nullable(false)
                ->comment('Контент');

            $table->enum('status', [
                PostStatusEnum::ON_MODERATION->value,
                PostStatusEnum::REJECTED->value,
                PostStatusEnum::BLOCKED->value,
                PostStatusEnum::PUBLISHED->value,
            ])
                ->default(PostStatusEnum::ON_MODERATION->value)
                ->comment('Статус');

            $table->timestamps();

            $table->comment('Посты');

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
        Schema::dropIfExists('posts');
    }
};
