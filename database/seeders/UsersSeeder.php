<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin user
        User::factory([
            'name' => 'Admin Michael',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin-password'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ])->create();

        User::factory()->times(100)->create();
    }
}
