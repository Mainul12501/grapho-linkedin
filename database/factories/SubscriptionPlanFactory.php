<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubscriptionPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'price' => $this->faker->randomNumber(2),
            'duration_in_days' => $this->faker->randomNumber(0),
            'plan_features' => $this->faker->text(),
            'note' => $this->faker->text(),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug(),
        ];
    }
}
