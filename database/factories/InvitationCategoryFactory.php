<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InvitationCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvitationCategory>
 */
class InvitationCategoryFactory extends Factory
{
    protected $model = InvitationCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->domainWord(),
            'description' => fake()->sentence(2, true),
        ];
    }


    public function nullDescription(): Factory
    {
        return $this->state(fn (array $attributes) => [
                'description' => null,
        ]);
    }
}
