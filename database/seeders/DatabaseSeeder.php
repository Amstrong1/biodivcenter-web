<?php

namespace Database\Seeders;

use App\Models\Ong;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Str;
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
            OngSeeder::class,
        ]);

        $ong = Ong::first();

        User::factory()->create([
            'id' => 1,
            'ong_id' => $ong->id,
            'slug' => Str::ulid(),
            'name' => 'Mdt Admin',
            'email' => 'test@example.com',
            'contact' => '00000000',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}
