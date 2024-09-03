<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone',
        'cep',
        'state',
        'city',
        'neighborhood',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => UserStatus::class,
    ];
}
