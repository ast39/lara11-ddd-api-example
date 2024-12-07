<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->string('first_name')
                ->unique()
                ->nullable(false)
                ->comment('Имя');

            $table->string('second_name')
                ->nullable()
                ->default(null)
                ->comment('Отчество');

            $table->string('surname')
                ->nullable()
                ->default(null)
                ->comment('Фамилия');

            $table->string('position')
                ->nullable(false)
                ->comment('Должность');

            $table->string('login')
                ->nullable(false)
                ->comment('Логин');

            $table->string('password')
                ->nullable(false)
                ->comment('Пароль');

            $table->string('refresh_token')
                ->nullable()
                ->comment('Refresh токен');

            $table->timestamp('refresh_token_expired_at')
                ->nullable(false)
                ->comment('Время жизни Refresh токена');

            $table->boolean('is_root')
                ->nullable(false)
                ->default(false)
                ->comment('Метка Root пользователя');

            $table->boolean('is_blocked')
                ->nullable(false)
                ->default(false)
                ->comment('Метка блокировки');

            $table->timestamps();

            $table->comment('Пользователи');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
