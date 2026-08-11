<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmployerCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployerCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployerCompany::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->text(),
            'website' => $this->faker->text(255),
            'company_overview' => $this->faker->text(),
            'founded_on' => $this->faker->text(255),
            'total_employees' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug(),
            'logo' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'industry_id' => \App\Models\Industry::factory(),
            'employer_company_category_id' => \App\Models\EmployerCompanyCategory::factory(),
        ];
    }
}
