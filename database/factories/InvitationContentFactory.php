<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invitation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvitationContent>
 */
class InvitationContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invitation_ids = Invitation::pluck('id')->toArray();
        return [
          'header' => ,
          'content' => ,
          'invitation_id' => fake()->randomElement($invitation_ids)
        ];
    }
}
