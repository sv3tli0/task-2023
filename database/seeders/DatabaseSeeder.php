<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Product::factory(30)->create();

        \App\Models\User::factory()->create([
            'name' => 'The User',
            'email' => 'test@example.com',
        ]);
    }
}
