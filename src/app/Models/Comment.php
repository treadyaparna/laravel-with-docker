<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Comment\Comment
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property integer|null $userId
 * @property integer|null $articleId
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Comment extends Model
{
    protected $table = 'comments';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'userId',
        'articleId'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'userId' => 'integer',
        'articleId' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'articleId');
    }
}
