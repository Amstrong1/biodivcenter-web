<?php

namespace Database\Seeders;

use App\Models\Reign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reign::factory()->create(
            [
                'name' => 'Non Spécifié',
                'slug' => 'non_specifie'
            ]
        );
    }
}
