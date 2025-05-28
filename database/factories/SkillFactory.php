<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'skill_name' => $this->faker->text(255),
            'note' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->numberBetween(0, 127),
            'skills_category_id' => \App\Models\SkillsCategory::factory(),
        ];
    }
}
