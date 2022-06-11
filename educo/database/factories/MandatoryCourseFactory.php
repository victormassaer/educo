<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MandatoryCourse>
 */
class MandatoryCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'course_id' => $this->faker->numberBetween($min = 1, $max = 30),
            'profile_id' => $this->faker->numberBetween($min = 1, $max = 15),
            'company_id' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }
}
