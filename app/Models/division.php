<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class division extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'divisions';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public static function booted()
    {

        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    public function employee()
    {
        return $this->hasMany(employee::class);
    }
}
