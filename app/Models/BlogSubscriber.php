<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogSubscriber extends Model
{
    /** @use HasFactory<\Database\Factories\BlogSubscriberFactory> */
    use HasFactory;

    protected $table = 'blog_subscribers';
    protected $fillable = ['email'];
}
