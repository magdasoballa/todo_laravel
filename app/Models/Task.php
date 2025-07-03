<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
use HasFactory;

protected $fillable = [
'user_id',
'name',
'description',
'priority',
'status',
'due_date',
'access_token',
'token_expires_at',
];

protected $dates = [
'due_date',
'token_expires_at',
];

public function user()
{
return $this->belongsTo(User::class);
}

    protected $casts = [
        'due_date' => 'date',
        'token_expires_at' => 'datetime',
    ];

}
