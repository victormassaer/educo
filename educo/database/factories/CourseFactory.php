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
            'img' => $this->faker->imageUrl($width = 288, $height = 177),
            'instructor_id' => $this->faker->randomDigit(),
            'duration' => $this->faker->numberBetween($min = 6, $max = 20),
            'number_of_chapters' => $this->faker->numberBetween($min = 3, $max = 20),
            'description' => $this->faker->numberBetween($min = 3, $max = 20),
            'difficulty' => $this->faker->numberBetween($min = 3, $max = 20),
        ];
    }
}
