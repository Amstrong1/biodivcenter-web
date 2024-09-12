<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Family::factory()->create(
            [
                'name' => 'Non Spécifié',
                'slug' => 'non_specifie'
            ]
        );
    }
}
