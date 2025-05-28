<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmployeeAppliedJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeAppliedJobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeAppliedJob::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 'pending',
            'user_id' => \App\Models\User::factory(),
            'job_task_id' => \App\Models\JobTask::factory(),
        ];
    }
}
