<?php

namespace App\Modules\User\Infrastructure\Persistence\Scopes;

use App\Models\Scopes\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class UserModelScope extends AbstractFilter
{
    public const QUERY = 'query';
    public const IS_BLOCKED = 'is_blocked';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::QUERY => [$this, 'q'],
            self::IS_BLOCKED => [$this, 'isBlocked'],
        ];
    }

    public function q(Builder $builder, $value): void
    {
        $builder->where(function ($q) use ($value) {
            $q->where('first_name', 'like', '%' . $value . '%')
                ->orWhere('second_name', 'like', '%' . $value . '%')
                ->orWhere('surname', 'like', '%' . $value . '%')
                ->orWhere('position', 'like', '%' . $value . '%')
                ->orWhere('login', 'like', '%' . $value . '%');
        });
    }

    public function isBlocked(Builder $builder, mixed $value = null): void
    {
        if (!is_null($value)) {
            $builder->where('is_blocked', $value);
        }
    }
}
