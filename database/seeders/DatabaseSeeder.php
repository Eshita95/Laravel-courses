<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Course;
use App\Models\Platform;
use App\Models\Review;
use App\Models\Series;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // create admin user

        User::create([
            'name' => 'admin',
            'email' => 'hi@eshita.me',
            'password' => bcrypt('password'),
            'type' => 1,
        ]);




        $series = [
            [
                'name' => 'PHP',
                'image' => 'https://laravel-courses.com/storage/series/c9cb9b3c-4d8c-4df6-a7b7-54047ce907ad.png'
            ],
            [
                'name' => 'JavaScript',
                'image' => 'https://laravel-courses.com/storage/series/c9cb9b3c-4d8c-4df6-a7b7-54047ce907ad.png'
            ],
            [
                'name' => 'WordPress',
                'image' => 'https://laravel-courses.com/storage/series/c9cb9b3c-4d8c-4df6-a7b7-54047ce907ad.png'
            ],
            [
                'name' => 'Laravel',
                'image' => 'https://laravel-courses.com/storage/series/c9cb9b3c-4d8c-4df6-a7b7-54047ce907ad.png'
            ]
        ];
        foreach ($series as $item) {
            Series::create([
                'name' => $item['name'],
                'image' => $item['image'],
            ]);
        }

        $topics = ['Eloquent', 'Validation', 'Authentication', 'Refactoring', 'Testing'];
        foreach ($topics as $item) {
            $slug = strtolower(str_replace('', '-', $item));
            Topic::create([
                'name' => $item,
                'slug' => $slug,
            ]);
        }

        $platforms = ['Laracats', 'Laravel.oi', 'Larajobs', 'Laravel News', 'Laracasts Forum'];
        foreach ($platforms as $item) {
            Platform::create([
                'name' => $item,
            ]);
        }


        $authors = ['Eshita', 'Raka', 'Fariya'];
        foreach ($authors as $item) {
            Author::create([
                'name' => $item,
            ]);
        }

        Author::factory(10)->create();

        // create 50 user
        User::factory(50)->create();

        // create 100 course
        Course::factory(100)->create();


        $courses = Course::all();
        foreach ($courses as $course) {
            $topics = Topic::all()->random(rand(1, 5))->pluck('id')->toArray();
            $course->topics()->attach($topics);


            $authors = Author::all()->random(rand(1, 3))->pluck('id')->toArray();
            $course->authors()->attach($authors);


            $series = Series::all()->random(rand(1, 4))->pluck('id')->toArray();
            $course->series()->attach($series);
        }

        Review::factory(100)->create();
    }
}
