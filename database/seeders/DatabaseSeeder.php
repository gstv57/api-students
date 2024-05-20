<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enum\API\V1\ClassRoomStatusEnum;
use App\Models\{ClassRoom, Student, Teacher};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $student = Student::factory()->create();

            $student->photos()->create([
                'url' => $faker->imageUrl(),
            ]);
            $teacher = Teacher::factory()->create();

            $teacher->photos()->create([
                'url' => $faker->imageUrl(),
            ]);

            // for each teacher, create a class room
            ClassRoom::create([
                'name' => $faker->numberBetween(1, 10),
                'teacher_id' => $teacher->id,
                'student_capacity' => $faker->numberBetween(10, 50),
                'description' => $faker->sentence,
                'status' => ClassRoomStatusEnum::ACTIVE,
            ]);
        }
    }
}
