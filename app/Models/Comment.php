<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    // a comment belongsTo a thread (thread_id)
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // a comment belongsTo a user (user_id)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
