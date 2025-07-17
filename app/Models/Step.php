<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Task;
class Step extends Model
{
    use HasFactory;
protected $table = 'steps';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['task_id', 'title', 'created_at', 'updated_at'];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
