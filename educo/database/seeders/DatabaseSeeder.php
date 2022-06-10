<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory(2)->create();
        \App\Models\Certificate::factory(30)->create();
        \App\Models\Company::factory(3)->create();
        \App\Models\Course::factory(30)->create();
        \App\Models\CourseHasSkill::factory(60)->create();
        \App\Models\Participation::factory(18)->create();
        \App\Models\Profile::factory(15)->create();
        \App\Models\Skill::factory(30)->create();
        \App\Models\UserHasSkill::factory(21)->create();
        \App\Models\UserHasCertificate::factory(12)->create();
        \App\Models\MandatoryCourse::factory(15)->create();
    }
}
