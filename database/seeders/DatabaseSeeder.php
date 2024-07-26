<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        # create admin users
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt("admin123"),
            'role' => 'admin'
        ]);

        # test post
        Posts::create([
            'title' => 'hello world',
            "content" => "hello, world!",
            "author" => 1
        ]);
    }
}
