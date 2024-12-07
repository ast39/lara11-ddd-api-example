<?php

namespace App\Modules\Post\Domain\Models;

use App\Models\Scopes\Filter\Filterable;
use App\Modules\Comment\Domain\Models\CommentModel;
use App\Modules\Sso\Domain\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostModel extends Model
{
    use Filterable;

    protected $table         = 'posts';

    protected $primaryKey    = 'id';

    protected $keyType       = 'int';

    public $incrementing  = true;

    public $timestamps    = true;


    public function author(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'author_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CommentModel::class, 'post_id', 'id');
    }


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
        'id', 'author_id', 'title', 'content', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [
        'is_deleted',
    ];
}
