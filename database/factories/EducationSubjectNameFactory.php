<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EducationSubjectName;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationSubjectNameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EducationSubjectName::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_name' => $this->faker->text(255),
            'note' => $this->faker->text(),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug(),
            'field_of_study_id' => \App\Models\FieldOfStudy::factory(),
        ];
    }
}
