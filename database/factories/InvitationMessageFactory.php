<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invitation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvitationMessage>
 */
class InvitationMessageFactory extends Factory
{

    private $ATTENDANCE_STATUS = [true,false];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invitation_ids = Invitation::pluck('id')->toArray();
        return [
            'sender_name' => fake()->name(),
            'sender_messages' => fake()->realText(70),
            'attendance_status' => fake()->randomElement($this->ATTENDANCE_STATUS),
            'number_of_attendance' => fake()->numberBetween(1,3),
            'invitation_id' => fake()->randomElement($invitation_ids)
        ];
    }
}
