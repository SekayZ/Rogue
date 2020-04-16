<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'caption', 'image',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function score(){
        return $this->votes()->where('post_id', '=', $this->id)->sum('vote');
    }

}
