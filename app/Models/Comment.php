<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'creator_id',
        'reply_to_id',
        'content',
    ];

    // @section relations

    public function post()
    {
        return $this->hasOne(
            Post::class,
            'id',
            'post_id'
        );
    }

    public function creator_post()
    {
        return $this->hasOneThrough(
            User::class,
            Post::class,
            'id',
            'id',
            'post_id',
            'creator_id'
        );
    }

    public function creator()
    {
        return $this->hasOne(
            User::class,
            'id',
            'creator_id'
        );
    }

    public function reply_to()
    {
        return $this->hasOne(
            Comment::class,
            'id',
            'reply_to_id'
        );
    }

    public function replied_by()
    {
        return $this->hasMany(
            Comment::class,
            'reply_to_id',
            'id'
        );
    }
}
