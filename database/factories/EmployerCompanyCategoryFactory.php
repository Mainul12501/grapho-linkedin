<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmployerCompanyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployerCompanyCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployerCompanyCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => $this->faker->text(255),
            'note' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
