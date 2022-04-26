<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Todo::factory(10)->create();
        User::create([
            'name' => 'Ahmed',
            'email' => 'phpcodertop@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
