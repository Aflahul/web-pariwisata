<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Cek jika super admin sudah ada
        if (!User::where('role', 'super_admin')->exists()) {

            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => 'admin123', // auto hash oleh model
                'role' => 'super_admin',
            ]);
        }
    }
}
