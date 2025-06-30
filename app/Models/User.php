<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $connection = 'mysql';  // نفس الكونكشن بتاع WordPress DB

    protected $table = 'lubpo8jc8_users';    // هنا التغيير الأساسي ✅

    protected $primaryKey = 'ID';      // WordPress uses "ID" not "id"

    public $timestamps = false;        // جدول wp_users مفيهوش timestamps بشكل Laravel

    protected $fillable = [
        'user_login',
        'user_pass',
        'user_email',
        'display_name',
        'user_nicename',
        'user_registered',
        'user_url',
    ];

    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    public function getPasswordAttribute()
    {
        return $this->user_pass;
    }



}
