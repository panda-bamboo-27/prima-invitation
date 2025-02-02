<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invitation;
use Faker\Factory as Faker;

class UpdateInvitationSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invitations = Invitation::all();
        $faker = Faker::create();

        foreach($invitations as $invitation) {
            $slug = $faker->firstNameMale() . ' ' . $faker->firstNameFemale();
            $slug = strtolower(str_replace(" ","-",$slug));
            $invitation->slug = $slug;
            $invitation->save();
        }
    }
}
