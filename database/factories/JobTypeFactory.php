<?php

namespace Database\Factories;

use App\Models\JobType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'note' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
