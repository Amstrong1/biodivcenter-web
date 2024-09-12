<?php

namespace Database\Seeders;

use App\Models\Ong;
use Illuminate\Database\Seeder;

class OngSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ong::factory()->create(
            [
                'name' => 'MdT',
                'slug' => 'mdt',
                'country' => 'Benin',
                'siege_social' => 'Natitingou',
                'mdt_membership' => true,
            ]
        );
    }
}
