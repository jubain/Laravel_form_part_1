<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Role;
use App\Models\Photo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasOne(Post::class, 'user_id',);
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    // make relationship
    public function roles()
    {
        return $this->belongsToMany(Role::class);
        // To customize table names and column
    }  //return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }


    // accessor
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
    // mutator
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
