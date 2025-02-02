<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    private $NUM_OF_THEME = 15;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Theme::factory()->count($this->NUM_OF_THEME)->create();
    }
}
