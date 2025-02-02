<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ThemeTag;
use App\Models\Theme;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = Theme::all();
        $theme_tags = ThemeTag::pluck('id')->toArray();

        $faker = Faker::create();

        foreach ($themes as $theme) {
            $theme->tags()->sync($faker->randomElements($theme_tags));
        }
    }
}
