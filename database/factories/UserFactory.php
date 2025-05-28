<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique->email(),
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => Str::random(10),
            'mobile' => $this->faker->unique->phoneNumber(),
            'user_type' => 'employee',
            'provider' => $this->faker->text(255),
            'provider_id' => $this->faker->text(),
            'google_id' => $this->faker->text(),
            'organization_name' => $this->faker->text(255),
            'subscription_started_from' => $this->faker->text(255),
            'profile_image' => $this->faker->text(255),
            'profile_title' => $this->faker->text(255),
            'address' => $this->faker->text(),
            'website' => $this->faker->text(255),
            'fb_link' => $this->faker->text(),
            'linkedin_link' => $this->faker->text(),
            'x_link' => $this->faker->text(),
            'gender' => \Arr::random(['male', 'female', 'other']),
            'user_slug' => $this->faker->text(255),
            'dob' => $this->faker->text(255),
            'language' => $this->faker->text(255),
            'is_open_for_hire' => $this->faker->numberBetween(0, 127),
            'user_id' => function () {
                return \App\Models\User::factory()->create([
                    'user_id' => null,
                ])->id;
            },
            'subscription_plan_id' => \App\Models\SubscriptionPlan::factory(),
            // Commented to avoid recursive database call... please check the
            // relationship, or set the foreign as nullable, or fix the factory
            // if necessary
            //'employer_company_id' => \App\Models\EmployerCompany::factory(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
