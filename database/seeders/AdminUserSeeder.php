<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pemdes@gmail.com'],
            [
                'name' => 'Pemdes Admin',
                'username' => 'pemdes',
                'password' => Hash::make('pemdes123'),
                'role' => 'admin',
                'status_akun' => 'aktif',
            ]
        );
    }
}
