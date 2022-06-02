<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseHasSkill>
 */
class CourseHasSkillFactory extends Factory
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
            'skill_id' => $this->faker->numberBetween($min = 1, $max = 30),
        ];
    }
}
