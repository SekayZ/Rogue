<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();
        static::created(function ($user){
            $user->profile()->create([
                'title' => $user->username,
                'photo' => '/images/profile/default.png',
            ]);
        });
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function posts(){
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function followers(){
        return $this->belongsToMany('App\User', 'follows', 'followed', 'user_id');
    }

    public function follows(){
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'followed');
    }

    public function numFollowers(){
        return $this->followers()->count();
    }

    public function numFollowing(){
        return $this->follows()->count();
    }

    public function numPosts(){
        return $this->posts()->count();
    }

}
