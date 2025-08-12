<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    // a tag belongsToMany threads
    public function threads()
    {
        return $this->belongsToMany(Thread::class, 'tag_thread');
    }
}
