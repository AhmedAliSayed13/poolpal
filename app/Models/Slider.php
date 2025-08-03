<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'title',
        'link',
        'status',

    ];
    protected $cats=[
        'status'=>'boolean'
    ];
}
