<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmployeeEducation;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeEducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeEducation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'starting_date' => $this->faker->text(255),
            'ending_date' => $this->faker->text(255),
            'passing_year' => $this->faker->text(255),
            'cgpa' => $this->faker->randomNumber(2),
            'address' => $this->faker->text(),
            'status' => $this->faker->numberBetween(0, 127),
            'user_id' => \App\Models\User::factory(),
            'education_degree_name_id' => \App\Models\EducationDegreeName::factory(),
            'university_name_id' => \App\Models\UniversityName::factory(),
            'field_of_study_id' => \App\Models\FieldOfStudy::factory(),
            'main_subject_id' => \App\Models\EducationSubjectName::factory(),
        ];
    }
}
