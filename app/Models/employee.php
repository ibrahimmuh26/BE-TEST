<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class employee extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'employees';
    public $incrementing = false;
    protected $fillable = [
        'image',
        'name',
        'password',
        'phone',
        'email',
        'division_id',
        'position',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    public function division()
    {
        return $this->belongsTo(division::class, 'division_id');
    }
}
