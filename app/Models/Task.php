<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use App\Models\Test;
use App\Models\Pool;
use App\Models\Step;
use App\Models\User;

class Task extends Model
{
    use HasFactory, Filterable;
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['user_id', 'pool_id','test_id', 'description', 'processed'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }


}
