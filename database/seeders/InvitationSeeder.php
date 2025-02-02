<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invitation;

class InvitationSeeder extends Seeder
{
    private $NUM_OF_INVITATION = 15;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invitation::factory()->count($this->NUM_OF_INVITATION)->create();
    }
}
