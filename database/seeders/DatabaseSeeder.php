<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\App;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (App::isLocal()) {
            \App\Models\User::factory(5)->create();

        }

        if (env('APP_ENV')=='testing') {
            \App\Models\User::factory(35)->create();

        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
