<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Pool;
use App\Models\PoolWaterStatus;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;

class Test extends Model
{
    use HasFactory,Filterable;
    protected $fillable = [
        'id',
        'user_id',
        'pool_id',
        'pool_water_status_id',
        'hardness_value',
        'hardness_code',
        'hardness_status',
        'chlorine_value',
        'chlorine_code',
        'chlorine_status',
        'free_chlorine_value',
        'free_chlorine_code',
        'free_chlorine_status',
        'ph_value',
        'ph_code',
        'ph_status',
        'alkalinity_value',
        'alkalinity_code',
        'alkalinity_status',
        'stabilizer_value',
        'stabilizer_code',
        'stabilizer_status',
        'image',
        'action_items'
    ];

    protected $casts = [
    'action_items' => 'array',
];
private static $whiteListFilter = ['*'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function poolWaterStatus()
    {
        return $this->belongsTo(PoolWaterStatus::class);
    }
}
