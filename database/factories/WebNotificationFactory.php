<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\WebNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'msg' => $this->faker->text(),
            'is_seen' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'user_id' => \App\Models\User::factory(),
            'role_id' => \App\Models\Role::factory(),
        ];
    }
}
