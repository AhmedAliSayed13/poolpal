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

    protected static function booted()
{
    static::saving(function ($test) {
        $status='hardness_status';
        $code='hardness_code';
    $status_small = strtolower($test->$status);

    $test->$code = match($status_small) {
        'very high' => '#FF0000',
        'high'      => '#FFA500',
        'ideal'     => '#008000',
        'ok'        => '#008000',
        'low'       => '#FFA500',
        'very low'  => '#FF0000',
        default     => '#008000',
        };
    });

    static::saving(function ($test) {
        $status='chlorine_status';
        $code='chlorine_code';
    $status_small = strtolower($test->$status);

    $test->$code = match($status_small) {
        'very high' => '#FF0000',
        'high'      => '#FFA500',
        'ideal'     => '#008000',
        'ok'        => '#008000',
        'low'       => '#FFA500',
        'very low'  => '#FF0000',
        default     => '#008000',
        };
    });

    static::saving(function ($test) {
        $status='free_chlorine_status';
        $code='free_chlorine_code';
    $status_small = strtolower($test->$status);

    $test->$code = match($status_small) {
        'very high' => '#FF0000',
        'high'      => '#FFA500',
        'ideal'     => '#008000',
        'ok'        => '#008000',
        'low'       => '#FFA500',
        'very low'  => '#FF0000',
        default     => '#008000',
        };
    });

    static::saving(function ($test) {
        $status='ph_status';
        $code='ph_code';
    $status_small = strtolower($test->$status);

    $test->$code = match($status_small) {
        'very high' => '#FF0000',
        'high'      => '#FFA500',
        'ideal'     => '#008000',
        'ok'        => '#008000',
        'low'       => '#FFA500',
        'very low'  => '#FF0000',
        default     => '#008000',
        };
    });


    static::saving(function ($test) {
        $status='alkalinity_status';
        $code='alkalinity_code';
    $status_small = strtolower($test->$status);

    $test->$code = match($status_small) {
        'very high' => '#FF0000',
        'high'      => '#FFA500',
        'ideal'     => '#008000',
        'ok'        => '#008000',
        'low'       => '#FFA500',
        'very low'  => '#FF0000',
        default     => '#008000',
        };
    });



    static::saving(function ($test) {
        $status='stabilizer_status';
        $code='stabilizer_code';
    $status_small = strtolower($test->$status);

    $test->$code = match($status_small) {
        'very high' => '#FF0000',
        'high'      => '#FFA500',
        'ideal'     => '#008000',
        'ok'        => '#008000',
        'low'       => '#FFA500',
        'very low'  => '#FF0000',
        default     => '#008000',
        };
    });



}

}
