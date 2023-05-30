<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'profile_bgp', 'icon', 'bio',
    ];
    
    public function likes(){
        return $this->hasMany('App\Like');
    }

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
      /**
  * パスワードリセット通知の送信
  *
  * @param string $token
  * @return void
  */
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function follows()
  {
      return $this->belongsToMany(User::class, 'followings', 'followed_id', 'follow_id');
  }

  public function followers()
  {
      return $this->belongsToMany(User::class, 'followings', 'follow_id', 'followed_id');
  }
  public function reports()
  {
    return $this->hasMany('App\Report');
  }
  public function posts()
  {
    return $this->hasMany('App\Post'); 
  }
}
