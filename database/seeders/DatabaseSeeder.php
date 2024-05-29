<?php

namespace Database\Seeders;

use DOMDocument;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                'url' => $this->getSelfie(),
            ]);
            $teacher = Teacher::factory()->create();
            $teacher->photos()->create([
                'url' => $this->getSelfie(),
            ]);

            // for each teacher, create a class room
            ClassRoom::create([
                'name' => $i,
                'teacher_id' => $teacher->id,
                'student_capacity' => $faker->numberBetween(10, 50),
                'description' => $faker->sentence,
                'status' => ClassRoomStatusEnum::ACTIVE,
            ]);
        }
    }

    public function getSelfie()
    {
        $domain = 'https://this-person-does-not-exist.com/';
        $html = $this->getHtmlFromUrl($domain . 'en');
        $avatarSrc = $this->getAvatarSrc($html);
        return $domain . $avatarSrc;
    }

    /**
     * Get HTML content from a URL
     *
     * @param string $url
     * @return string
     */
    private function getHtmlFromUrl($url)
    {
        return file_get_contents($url);
    }

    /**
     * Get the 'src' attribute of the avatar image from the HTML
     *
     * @param string $html
     * @return string
     */
    private function getAvatarSrc($html)
    {
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $avatar = $dom->getElementById('avatar');
        if ($avatar) {
            return $avatar->getAttribute('src');
        }
        return '';
    }
}
