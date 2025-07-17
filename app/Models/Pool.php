<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\Models\Test;
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
    protected $appends = ['look_like'];
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
public function getLookLikeAttribute()
{
    $test=Test::with('poolWaterStatus')->where('pool_id','=',$this->id)->latest()->first();
    if($test){
        return isset($test->poolWaterStatus->name)?$test->poolWaterStatus->name:null;
    }
    return null;
}
public function latestTest()
{
    return $this->hasOne(Test::class)->latestOfMany(); // Uses created_at by default
}

}
