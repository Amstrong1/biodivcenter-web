<?php

namespace Database\Seeders;

use App\Models\Ong;
use Illuminate\Support\Str;
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
                'id' => (string) Str::ulid(),
                'name' => 'MdT',
                'country' => 'Benin',
                'siege_social' => 'Natitingou',
                'mdt_membership' => true,
            ]
        );
    }
}
