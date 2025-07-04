<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
protected $fillable = [
'task_id', 'user_id', 'name', 'description', 'priority', 'status', 'due_date',
];

public function task()
{
return $this->belongsTo(Task::class);
}
}
