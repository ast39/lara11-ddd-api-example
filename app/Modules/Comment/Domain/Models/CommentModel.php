<?php

namespace App\Modules\Comment\Domain\Models;

use App\Models\Scopes\Filter\Filterable;
use App\Modules\Post\Domain\Models\PostModel;
use App\Modules\Sso\Domain\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentModel extends Model
{
    use Filterable;

    protected $table         = 'comments';

    protected $primaryKey    = 'id';

    protected $keyType       = 'int';

    public $incrementing  = true;

    public $timestamps    = true;


    public function post(): BelongsTo
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'author_id', 'id');
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
        'id', 'post_id', 'author_id', 'content', 'status',
        'created_at', 'updated_at',
    ];

    protected $hidden = [
        'is_deleted',
    ];
}
