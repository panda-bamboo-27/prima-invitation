<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ThemeCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThemeCategory>
 */
class ThemeCategoryFactory extends Factory
{
    protected $model = ThemeCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => fake()->unique()->domainName(),
            'category_description' => fake()->sentence(2, true),
        ];
    }

    public function nullDescription(): Factory
    {
        return $this->state(fn (array $attributes) => [
                'category_description' => null,
        ]);
    }
}
