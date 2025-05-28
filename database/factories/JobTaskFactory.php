<?php

namespace Database\Factories;

use App\Models\JobTask;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobTask::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_title' => $this->faker->text(255),
            'required_experience' => $this->faker->text(255),
            'job_pref_salary_payment_type' => 'monthly',
            'salary_amount' => $this->faker->text(255),
            'salary_range_start' => $this->faker->randomNumber(2),
            'salary_range_end' => $this->faker->randomNumber(2),
            'description' => $this->faker->text(),
            'deadline' => $this->faker->text(255),
            'require_sector_looking_for' => $this->faker->text(255),
            'slug' => $this->faker->text(),
            'status' => $this->faker->numberBetween(0, 127),
            'banner_image' => $this->faker->text(255),
            'cgpa' => $this->faker->text(255),
            'job_type_id' => \App\Models\JobType::factory(),
            'job_location_type_id' => \App\Models\JobLocationType::factory(),
            'user_id' => \App\Models\User::factory(),
            'employer_company_id' => \App\Models\EmployerCompany::factory(),
        ];
    }
}
