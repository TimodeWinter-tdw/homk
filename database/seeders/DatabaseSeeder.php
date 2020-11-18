<?php

namespace Database\Seeders;

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
         // Create some random users
         User::factory()->count(5)->create();

         User::factory()->create([
             'name' => 'Timo de Winter',
             'email' => 'info@timodw.nl',
             'password' => '$2y$10$aEZMg.dyux/0wBqSQBMVXeWXSZ0sNV21kPCoDcSRwY2CNIHA6qUEy'
         ]);
    }
}
