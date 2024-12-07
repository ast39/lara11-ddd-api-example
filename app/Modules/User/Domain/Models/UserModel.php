<?php

namespace App\Modules\User\Domain\Models;

use App\Models\Scopes\Filter\Filterable;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use Filterable;

    protected $table         = 'users';

    protected $primaryKey    = 'id';

    protected $keyType       = 'int';

    public $incrementing  = true;

    public $timestamps    = true;


    protected $with = [
        //
    ];

    protected $appends = [
        //
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'id', 'first_name', 'second_name', 'surname', 'position',
        'login', 'password', 'refresh_token', 'refresh_token_expired_at',
        'is_root', 'is_blocked',
        'created_at', 'updated_at',
    ];

    protected $hidden = [
        'is_deleted',
    ];
}
