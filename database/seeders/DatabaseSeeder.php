<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            BranchSeeder::class,
            OrderSeeder::class,
            FamilySeeder::class,
            ReignSeeder::class,
            GenusSeeder::class,
            ClassificationSeeder::class,
            OngSeeder::class,
        ]);

        User::factory()->create([
            'ong_id' => '1',
            'name' => 'Mdt Admin',
            'email' => 'test@example.com',
            'contact' => '00000000',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'slug' => 'user',
        ]);
    }
}
