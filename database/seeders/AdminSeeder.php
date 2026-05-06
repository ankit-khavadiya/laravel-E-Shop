<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = Admin::where('email', 'admin@gmail.com')->first();
        if (!$admin_user) {
            $admin = new Admin();
            $admin->name = 'Admin';
            $admin->email = 'admin@gmail.com';
            $admin->phone = '9054430598';
            $admin->password = Hash::make('Admin@123');
            $admin->role = 'ADMIN';
            $admin->save();
        }
    }
}
