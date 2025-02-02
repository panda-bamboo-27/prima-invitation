<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Theme;
use App\Models\ThemeCategory;
use App\Models\InvitationCategory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Theme>
 */
class ThemeFactory extends Factory
{
    protected $model = Theme::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch all related models 
        $invitation_categories_ids = InvitationCategory::pluck('id')->toArray();
        $theme_categories_ids = ThemeCategory::pluck('id')->toArray();
        $user_ids = User::pluck('id')->toArray();

        return [
            'theme_name' => fake()->unique()->word(),
            'theme_description' => fake()->sentence(2, true),
            'theme_price' => fake()->randomNumber(5,true),
            'theme_category_id' => fake()->randomElement($theme_categories_ids),
            'invitation_category_id' => fake()->randomElement($invitation_categories_ids),
            'theme_author_id'  => fake()->randomElement($user_ids),
        ];
    }

    public function activeTheme(): Factory
    {
        return $this->state(fn (array $attributes) => [
                'is_active' => true,
        ]);
    }

    public function inactiveTheme(): Factory
    {
        return $this->state(fn (array $attributes) => [
                'is_active' => false,
        ]);
    }
}
