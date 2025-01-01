<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Package::create([
            'name_en' => 'Faster package',
            'name_ar' => 'باقة فاستر',
            // 'basic_price_eg' => '1500',
            // 'multi_branches_price_eg' => '1800',
            // 'basic_price' => '150',
            // 'multi_branches_price' => '180',
            'type' => 'store',
        ]);
        Package::create([
            'name_en' => 'Super Faster package',
            'name_ar' => 'باقة سوبر فاستر',
            // 'basic_price_eg' => '2500',
            // 'multi_branches_price_eg' => '2800',
            // 'basic_price' => '250',
            // 'multi_branches_price' => '280',
            'type' => 'store',
        ]);
        Package::create([
            'name_en' => 'Multi Faster package',
            'name_ar' => 'باقة مالتي فاستر',
            // 'basic_price_eg' => '3500',
            // 'multi_branches_price_eg' => '3800',
            // 'basic_price' => '350',
            // 'multi_branches_price' => '380',
            'type' => 'mall',
        ]);
    }
}
