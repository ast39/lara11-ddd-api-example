<?php

namespace App\Modules\Comment\Application\Enums;

enum CommentStatusEnum: string
{
    case ON_MODERATION = 'on_moderation';
    case REJECTED = 'rejected';
    case BLOCKED = 'blocked';
    case PUBLISHED = 'published';

    /**
     * Получить название статуса
     */
    public function label(): string
    {
        return match ($this) {
            self::ON_MODERATION => 'На модерации',
            self::REJECTED => 'Отклонен',
            self::BLOCKED => 'Заблокирован',
            self::PUBLISHED => 'Опубликован',
        };
    }
}
