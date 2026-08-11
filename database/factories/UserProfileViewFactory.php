<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\UserProfileView;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileViewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfileView::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'viewed_by' => 'employer',
            'employee_id' => \App\Models\User::factory(),
            'employer_id' => \App\Models\User::factory(),
            'employer_company_id' => \App\Models\EmployerCompany::factory(),
        ];
    }
}
