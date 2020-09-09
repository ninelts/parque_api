<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements  JWTSubject 
{
    protected $connection = 'mysql2';
    protected $table ='users';
    public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'password', 'celular', 'direccion', 
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public  function  getJWTIdentifier() {
        return  $this->getKey();
    }

    public  function  getJWTCustomClaims() {
        return [];
    }
}