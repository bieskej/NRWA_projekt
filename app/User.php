<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Group;
use App\Profile;
use App\Post;
use App\Comment;
use App\Invitation; // Dodano

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'github_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // SVE POTREBNE RELACIJE NA JEDNOM MJESTU

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function memberOfGroups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function ownedGroups()
    {
        return $this->hasMany('App\Group', 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }

    public function invitations()
    {
        return $this->hasMany('App\Invitation');
    }
}