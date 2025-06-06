<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PermissionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PermissionCategory::class;

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
            'is_default' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
