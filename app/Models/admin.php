<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class admin extends Authenticatable
{
    use HasFactory, HasApiTokens;
    public $incrementing = false;
    protected $table = 'admins';

    protected $fillable = [
        'id',
        'name',
        'email',
        'username',
        'password',
        'phone',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
