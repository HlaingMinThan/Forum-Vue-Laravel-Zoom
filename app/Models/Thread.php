<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /** @use HasFactory<\Database\Factories\ForumFactory> */
    use HasFactory;

    // a thread belongsto a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // a thread belongsTo a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // a thread belongsToMany tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_thread');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                return $query->where('slug', $category);
            });
        });

        $query->when($filters['tag'] ?? null, function ($query, $tag) {
            $query->whereHas('tags', function ($query) use ($tag) {
                return $query->where('slug', $tag);
            });
        });

        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
