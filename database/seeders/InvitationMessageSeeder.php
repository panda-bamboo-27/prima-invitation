<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvitationMessage;

class InvitationMessageSeeder extends Seeder
{
    private $NUM_OF_INVITATION_MESSAGES = 30;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvitationMessage::factory()->count($this->NUM_OF_INVITATION_MESSAGES)->create();
    }
}
