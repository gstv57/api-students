<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course',
        'email',
        'phone',
    ];

    protected $casts = [
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
