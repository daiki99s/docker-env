<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'image', 'description',
    ];
    public function likes(){
        return $this->hasMany('App\Like');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id'); 
    }
}
