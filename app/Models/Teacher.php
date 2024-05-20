<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "matery",
    ];

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

}
