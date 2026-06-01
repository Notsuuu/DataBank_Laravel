<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Operator Utama (Admin)
        User::create([
            'name' => 'Muhammad Ali Mubaraq',
            'email' => 'operator@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_active' => true,
        ]);

        // Akun Guru untuk testing
        User::create([
            'name' => 'Teguh Praditya',
            'email' => 'teguh@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Syahril Fitrawan Abadi',
            'email' => 'syahril@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Muhammad Rifky',
            'email' => 'rifky@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => true,
        ]);
    }
}
