<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $passwordStandar = Hash::make('password123');

        User::create([
            'name' => 'Muhammad Ali Mubaraq', 
            'email' => 'operator1@smpn4.com', 
            'password' => $passwordStandar, 
            'role' => 'operator', 
            'is_active' => 1
        ]);
        
        User::create([
            'name' => 'Operator Utama 2', 
            'email' => 'operator2@smpn4.com', 
            'password' => $passwordStandar, 
            'role' => 'operator', 
            'is_active' => 1
        ]);
    }
}