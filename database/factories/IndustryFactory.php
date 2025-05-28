<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndustryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Industry::class;

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
