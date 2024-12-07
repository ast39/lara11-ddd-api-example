<?php

namespace App\Modules\Post\Infrastructure\Persistence\Scopes;

use App\Models\Scopes\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PostModelScope extends AbstractFilter
{
    public const QUERY = 'query';
    public const AUTHOR = 'author_id';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::QUERY => [$this, 'q'],
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

    public function author(Builder $builder, mixed $value = null): void
    {
        $builder->where('author_id', $value);
    }
}
