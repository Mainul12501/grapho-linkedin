<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\UniversityName;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityNameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UniversityName::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->text(),
            'is_approved' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug(),
        ];
    }
}
