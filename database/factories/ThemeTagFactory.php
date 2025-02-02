<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ThemeTag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThemeTag>
 */
class ThemeTagFactory extends Factory
{
    protected $model = ThemeTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_name' => fake()->unique()->word(),
            'tag_description' => fake()->sentence(2, true),
        ];
    }


    public function nullDescription(): Factory
    {
        return $this->state(fn (array $attributes) => [
                'tag_description' => null,
        ]);
    }

}
