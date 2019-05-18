<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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



    public function gravatar($size='100')
    {
	 $hash=md5(strtolower(trim($this->attributes['email'])));
	 return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


    public static function boot()
    {
	    parent::boot();
            /*creating 用于监听模型被创建之前的事件*/
	    static::creating(function ($user){
		    $user->activation_token = Str::random(10);
	    });
    }

    //指明一个用户拥有多条微博
    public function statuses()
    {
	    return $this->hasMany(Status::class);
    }

    //微博动态流模型
    public function feed()
    {
	    return $this->statuses()
		        ->orderBy('created_at','desc');
    }
}
