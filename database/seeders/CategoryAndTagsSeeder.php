<?php

namespace Database\Seeders;

use App\Models\ThemeTag;
use App\Models\InvitationCategory;
use App\Models\ThemeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryAndTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThemeTag::factory()->count(10)->create();
        ThemeTag::factory()->count(2)->nullDescription()->create();
        InvitationCategory::factory()->count(10)->create();
        InvitationCategory::factory()->count(2)->nullDescription()->create();
        ThemeCategory::factory()->count(3)->create();
        ThemeCategory::factory()->count(2)->nullDescription()->create();
    }
}
