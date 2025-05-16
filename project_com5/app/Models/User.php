<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Authenticatable implements AuthenticatableContract
{
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'login', 'email', 'password', 'first_name', 'last_name', 'who_created', 'who_modify'
    ];

    protected $hidden = [
        'password',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id_user', 'role_id_role');
    }
}


