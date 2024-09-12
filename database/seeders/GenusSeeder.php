<?php

namespace Database\Seeders;

use App\Models\Genus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genus::factory()->create(
            [
                'name' => 'Non Spécifié',
                'slug' => 'non_specifie'
            ]
        );
    }
}
