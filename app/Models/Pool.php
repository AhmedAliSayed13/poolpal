<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;

class Pool extends Model
{
    use HasFactory,Filterable;
     protected $table = 'pools';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'user_id',
        'name',
        'size',
        'siding_id',
        'media_id',
    ];
    private static $whiteListFilter = ['*'];

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
