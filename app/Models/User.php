<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



protected $connection = 'mysql';
    protected $table = 'Lubpo8Jc8_users';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $hidden = [
        'user_pass',
        'remember_token',
    ];
    protected $fillable = [
        'ID',
        'user_login',
        'user_pass',
        'user_email',
        'display_name',
        'user_nicename',
        'user_registered',
        'user_url',
    ];

    protected $appends = [
        'id',
        'phone',
        'email',
        'name',
    ];

    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    public function getPasswordAttribute()
    {
        return $this->user_pass;
    }


public function getIdAttribute()
{
    return $this->attributes['ID'];
}
    public function getPhoneAttribute()
    {
        $phone = DB::table('Lubpo8Jc8_usermeta')
    ->where('user_id', $this->attributes['ID'])
    ->where('meta_key', 'billing_phone')
    ->value('meta_value');
        return $phone;
    }

    public function getEmailAttribute()
    {
        return $this->user_email;
    }

    public function getNameAttribute()
    {
        return $this->display_name;
    }



}
