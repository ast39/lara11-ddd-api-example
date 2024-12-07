<?php

namespace App\Modules\Comment\Infrastructure\Persistence\Scopes;

use App\Models\Scopes\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class CommentModelScope extends AbstractFilter
{
    public const QUERY = 'query';
    public const POST = 'post_id';
    public const AUTHOR = 'author_id';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::QUERY => [$this, 'q'],
            self::POST => [$this, 'post'],
            self::AUTHOR => [$this, 'author'],
        ];
    }

    public function q(Builder $builder, $value): void
    {
        $builder->where(function ($q) use ($value) {
            $q->where('title', 'like', '%' . $value . '%')
                ->orWhere('content', 'like', '%' . $value . '%');
        });
    }

    public function post(Builder $builder, mixed $value = null): void
    {
        $builder->where('post_id', $value);
    }

    public function author(Builder $builder, mixed $value = null): void
    {
        $builder->where('author_id', $value);
    }
}
