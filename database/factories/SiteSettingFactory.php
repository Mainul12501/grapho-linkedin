<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_title' => $this->faker->text(255),
            'site_description' => $this->faker->text(),
            'logo' => $this->faker->text(255),
            'site_icon' => $this->faker->text(255),
            'favicon' => $this->faker->text(255),
            'meta_header' => $this->faker->text(),
            'meta_footer' => $this->faker->text(),
            'meta_title' => $this->faker->text(),
            'meta_description' => $this->faker->text(),
            'banner' => $this->faker->text(255),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
            'fb' => $this->faker->text(),
            'x_link' => $this->faker->text(),
            'youtube' => $this->faker->text(),
            'insta' => $this->faker->text(),
            'tiktalk' => $this->faker->text(),
            'apk_link' => $this->faker->text(),
            'ios_link' => $this->faker->text(),
            'apk_latest_version' => $this->faker->text(255),
            'ios_latest_version' => $this->faker->text(255),
            'office_address' => $this->faker->text(),
            'country' => $this->faker->country(),
            'country_code' => $this->faker->countryCode(),
            'site_name' => $this->faker->text(255),
        ];
    }
}
