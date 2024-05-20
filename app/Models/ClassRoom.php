<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enum\API\V1\ClassRoomStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_capacity',
        'description',
        'status',
        'teacher_id',
    ];

    protected $casts = [
        'status' => ClassRoomStatusEnum::class,
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
