<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // a user hasMany threads
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    // a user hasMany comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // a user belongsToMany followers
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follow_id');
    }

    public function follow($userId)
    {
        return $this->followers()->attach($userId);
    }
    public function unfollow($userId)
    {
        return $this->followers()->detach($userId);
    }
    public function alreadyFollowed($user)
    {
        return $this->followers->contains('id', $user->id);
    }
}
