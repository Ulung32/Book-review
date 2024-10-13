<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create();

        if (User::where('email', env('ADMIN_EMAIL'))->exists()) {
            return; // Prevent duplicate admin user
        }

        // Create the admin user
        User::create([
            'name' => 'Admin User',
            'email' => env('ADMIN_EMAIL', 'admin@example.com'), 
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')), 
            'role' => 'admin', 
        ]);

    }
}
