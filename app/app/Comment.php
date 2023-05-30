<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id', 'user_id', 'comment',
    ];
    public function posts(){
        return $this->hasMany('App\Post');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id'); 
    }
}
