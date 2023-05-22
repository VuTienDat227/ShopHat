<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLogin extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'UserLogin';
    protected $fillable = [
        'id',
        'UserName',
        'PasswordUser',
        'FullName',
        'Email',
        'PhoneNumber',
        'Address',
        'RoleId',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
