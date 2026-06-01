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
            'name' => 'Ali',
            'email' => 'ali@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Rifaldi',
            'email' => 'rifaldi@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_active' => true,
        ]);

        // Akun Guru untuk testing
        User::create([
            'name' => 'Diyowansyah',
            'email' => 'diyo@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Hafizh',
            'email' => 'hafizh@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Sofia',
            'email' => 'sofia@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Sifa',
            'email' => 'sifa@smpn4palu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'pimpinan',
            'is_active' => true,
        ]);
    }
}
