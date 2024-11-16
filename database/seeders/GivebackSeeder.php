<?php

namespace Database\Seeders;

use App\Models\Giveback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GivebackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Giveback::factory()->count(1000)->create();

    }
}
