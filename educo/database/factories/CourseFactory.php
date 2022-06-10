<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'img' => 'images/course_thumbnails/php_course_thumbnail.png',
            'instructor_id' => $this->faker->randomDigit(),
            'duration' => $this->faker->numberBetween($min = 6, $max = 20),
            'number_of_chapters' => 10,
            'description' => $this->faker->realText(200, 2),
            'difficulty' => $this->faker->shuffle('easy, medium, hard'),
        ];
    }
}
