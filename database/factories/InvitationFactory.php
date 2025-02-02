<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Theme;
use App\Models\InvitationCategory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{

    private $INVITATION_PUBLISH_STATUS = ['draft','published'];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch all related models 
        $invitation_categories_ids = InvitationCategory::pluck('id')->toArray();
        $theme_ids = Theme::pluck('id')->toArray();
        $user_ids = User::pluck('id')->toArray();
        
        return [
            'event_date' => fake()->dateTimeInInterval('+1 week', '+3 years')->format('Y-m-d H:i:s'),
            'publish_status' => fake()->randomElement($this->INVITATION_PUBLISH_STATUS), // draft, published
            'created_by' => fake()->randomElement($user_ids),
            'invitation_category_id' => fake()->randomElement($invitation_categories_ids),
            'theme_id' => fake()->randomElement($theme_ids),
            'slug'  => strtolower(str_replace(" ","-",fake()->firstNameMale() . ' ' . fake()->firstNameFemale()))
        ];
    }
}
