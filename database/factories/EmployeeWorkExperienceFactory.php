<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmployeeWorkExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeWorkExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeWorkExperience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(),
            'company_name' => $this->faker->text(255),
            'position' => $this->faker->text(255),
            'job_responsibilities' => $this->faker->text(),
            'start_date' => $this->faker->text(255),
            'end_date' => $this->faker->text(255),
            'office_address' => $this->faker->text(),
            'duration' => $this->faker->text(255),
            'is_working_currently' => $this->faker->numberBetween(0, 127),
            'job_type' => 'full_time',
            'status' => $this->faker->numberBetween(0, 127),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
