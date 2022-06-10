<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'img' => 'images/certificate/certificate_educo.png',
            'title' => $this->faker->word(),
            'skill_id' => $this->faker->numberBetween($min = 1, $max = 30),
            'date_acquired' => $this->faker->date($format = 'Y-m-d', $max = 'now')
        ];
    }
}
