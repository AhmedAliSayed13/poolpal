<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'size',
        'siding_id',
        'media_id',
    ];

    // app/Models/Pool.php
public function media()
{
    return $this->belongsTo(Media::class);
}

public function siding()
{
    return $this->belongsTo(Siding::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
