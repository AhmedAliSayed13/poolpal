<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $guarded = [];
    protected $fillable = ['user_id', 'title', 'body', 'data', 'view'];

    protected $casts = [
    'data' => 'array',
];
}
