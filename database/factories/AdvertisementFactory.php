<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Advertisement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(),
            'content' => $this->faker->text(),
            'banner' => $this->faker->text(255),
            'redirect_url' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
