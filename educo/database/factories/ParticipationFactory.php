<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participation>
 */
class ParticipationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'course_id' => $this->faker->numberBetween($min = 1, $max = 30),
            'start_time' => $this->faker->dateTime($max = 'now'),
            'total_completed' => $this->faker->numberBetween($min = 1, $max = 10),
            'mandatory' => $this->faker->numberBetween($min = 0, $max = 1),
        ];
    }
}
