<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@liceopaz.edu.ar'],
            [
                'name' => 'Administrador LMGP',
                'password' => Hash::make('LiceoPaz2026!Admin'),
                'email_verified_at' => now(),
            ]
        );
    }
}