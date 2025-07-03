<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Pola do masowego przypisywania (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Ukryte pola przy serializacji (np. do JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Typy pól do automatycznego castowania
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relacja: użytkownik ma wiele zadań
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
