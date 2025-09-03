<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '0985674123',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'is_admin' => true
        ]);
        User::factory(5)->create();
    }
}
