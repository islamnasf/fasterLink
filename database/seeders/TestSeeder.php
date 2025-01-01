<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User',
            'phone' => '0123456789',
            'email' => 'user@user.com',
            'role' => 'store',
            'country_id' => '1',
            'password' => 'password',
            'phone_verified_at' => '2024-11-20 21:48:56',
            'email_verified_at' => '2024-11-20 21:48:56',
        ]);
        Category::create([
            'name_ar' => 'test category',
            'name_en' => 'تيست كاتجوري',
            'image' => 'storage/categories/png',
        ]);
    }
}
