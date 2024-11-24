<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCommentFactory> */
    use HasFactory;

    protected $table = 'blog_comments';
    protected $fillable = [
        'name',
        'user_id',
        'post_id',
        'comment',
        'subject',
    ];


    public function blog_post(): BelongsTo
    {
        return $this->belongsTo(Blogpost::class, 'post_id');
    }
}
