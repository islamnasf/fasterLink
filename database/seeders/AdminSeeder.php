<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@admin.com'], // الشرط لتحديد السجل الموجود
            [
                'name' => 'Admin',
                'email' => 'admin_faster@link.com',
                'password' => Hash::make('fasterlink14789@'), // سيتم تحديث هذه القيم أو إضافتها
            ]
        );
    }
    
}
