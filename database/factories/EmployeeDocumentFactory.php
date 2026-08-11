<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmployeeDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'file_thumb' => $this->faker->text(255),
            'file_type' => $this->faker->text(255),
            'file_size' => $this->faker->randomNumber(0),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
