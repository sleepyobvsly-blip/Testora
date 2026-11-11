<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'itsalal2004@gmail.com'],
            [
                'name' => 'Al Francis Bert Tinio',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'must_change_password' => false,
            ]
        );

        $admin->assignRole($adminRole);
    }
}
